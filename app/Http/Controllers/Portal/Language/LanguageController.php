<?php

namespace App\Http\Controllers\Portal\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('portal.language.index', compact('languages'));
    }

    public function create()
    {
        return view('portal.language.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:5|unique:languages,code',
        ]);

        $language = Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => $request->has('is_active'),
            'is_default' => false,
        ]);

        return redirect()->route('portal.language.index')
            ->with('success', __('common.created-successfully'));
    }

    public function edit(Language $language)
    {
        return view('portal.language.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:5|unique:languages,code,' . $language->id,
        ]);

        // Eğer varsayılan dil olarak ayarlanıyorsa, diğer dillerin varsayılan ayarını kaldır
        if ($request->has('is_default') && $request->is_default) {
            Language::where('id', '!=', $language->id)
                ->update(['is_default' => false]);
        }

        $language->update([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => $request->has('is_active'),
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('portal.language.index')
            ->with('success', __('common.edited-successfully'));
    }

    public function destroy(Language $language)
    {
        // Varsayılan dili silmeye izin verme
        if ($language->is_default) {
            return redirect()->route('portal.language.index')
                ->with('error', __('common.cannot-delete-default-language'));
        }

        $language->delete();

        return redirect()->route('portal.language.index')
            ->with('success', __('common.deleted-successfully'));
    }

    public function translations(Language $language)
    {
        // Mevcut dil çevirilerini ve eksik çevirileri gösterelim
        $baseLanguage = Language::where('is_default', true)->first();
        $translations = [];
        
        // Tüm dil gruplarını bulalım
        $langPath = resource_path('lang/' . $baseLanguage->code);
        $langFiles = File::files($langPath);
        $groups = [];
        
        foreach ($langFiles as $file) {
            $group = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $groups[] = $group;
            
            // Temel dilden tüm çevirileri alalım
            $baseTranslations = Lang::get($group, [], $baseLanguage->code);
            
            if (is_array($baseTranslations)) {
                foreach ($baseTranslations as $key => $value) {
                    if (is_string($value)) {
                        // Mevcut dildeki çeviriyi veritabanından bulalım
                        $translation = Translation::where('language_id', $language->id)
                            ->where('key', $key)
                            ->where('group', $group)
                            ->first();
                        
                        // Eğer veritabanında yoksa, dil dosyasından kontrol edelim
                        $translatedValue = '';
                        if ($translation) {
                            $translatedValue = $translation->value;
                        } else {
                            // Dil dosyasından çeviriyi al
                            $langTranslations = Lang::get($group, [], $language->code);
                            if (is_array($langTranslations) && isset($langTranslations[$key])) {
                                $translatedValue = $langTranslations[$key];
                            }
                        }
                        
                        $translations[$group][$key] = [
                            'id' => $translation->id ?? null,
                            'key' => $key,
                            'original' => $value,
                            'translated' => $translatedValue,
                            'exists' => !empty($translatedValue)
                        ];
                    }
                }
            }
        }

        // Kodda kullanılan ama tanımlanmamış anahtarları bulalım
        $missingKeys = $this->findMissingTranslationKeys($baseLanguage->code);
        
        // Eksik anahtarları translations array'ine ekleyelim
        foreach ($missingKeys as $group => $keys) {
            if (!isset($translations[$group])) {
                $translations[$group] = [];
                if (!in_array($group, $groups)) {
                    $groups[] = $group;
                }
            }
            
            foreach ($keys as $key) {
                if (!isset($translations[$group][$key])) {
                    $translations[$group][$key] = [
                        'id' => null,
                        'key' => $key,
                        'original' => '', // Boş çünkü henüz tanımlanmamış
                        'translated' => '',
                        'exists' => false,
                        'is_missing' => true // Eksik anahtar olduğunu belirtmek için
                    ];
                }
            }
        }

        return view('portal.language.translations', compact('language', 'translations', 'groups', 'missingKeys'));
    }

    public function updateTranslation(Request $request, Language $language)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string',
            'group' => 'required|string',
        ]);

        Translation::updateOrCreate(
            [
                'language_id' => $language->id,
                'key' => $request->key,
                'group' => $request->group,
            ],
            [
                'value' => $request->value,
            ]
        );

        return redirect()->back()
            ->with('success', __('common.translation-updated-successfully'));
    }

    public function export(Language $language)
    {
        // Tüm çeviri dosyalarını al
        $langPath = resource_path('lang/' . $language->code);
        $allTranslations = [];
        
        if (File::exists($langPath)) {
            $langFiles = File::files($langPath);
            
            foreach ($langFiles as $file) {
                $group = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $translations = Lang::get($group, [], $language->code);
                
                if (is_array($translations)) {
                    $allTranslations[$group] = $translations;
                }
            }
        }
        
        // Veritabanından da çevirileri al ve birleştir
        $dbTranslations = $language->translations()->get()->groupBy('group');
        foreach ($dbTranslations as $group => $items) {
            if (!isset($allTranslations[$group])) {
                $allTranslations[$group] = [];
            }
            
            foreach ($items as $item) {
                $allTranslations[$group][$item->key] = $item->value;
            }
        }
        
        // JSON formatında export et
        $exportData = [
            'language' => [
                'name' => $language->name,
                'code' => $language->code,
                'is_active' => $language->is_active,
                'is_default' => $language->is_default,
            ],
            'translations' => $allTranslations,
            'exported_at' => now()->toISOString(),
            'exported_by' => auth()->user()->name ?? 'System'
        ];
        
        $fileName = 'translations_' . $language->code . '_' . date('Y-m-d_H-i-s') . '.json';
        
        return response()->json($exportData)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function import(Request $request, Language $language)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:json|max:10240', // 10MB max
        ]);
        
        try {
            $file = $request->file('import_file');
            $content = file_get_contents($file->getPathname());
            $data = json_decode($content, true);
            
            if (!$data || !isset($data['translations'])) {
                return redirect()->back()
                    ->with('error', __('common.invalid-import-file-format'));
            }
            
            $importedCount = 0;
            
            // Çevirileri dosyalara kaydet
            foreach ($data['translations'] as $group => $translations) {
                if (is_array($translations)) {
                    // Dil dosyası yolu
                    $langPath = resource_path('lang/' . $language->code);
                    if (!File::exists($langPath)) {
                        File::makeDirectory($langPath, 0755, true);
                    }
                    
                    $filePath = $langPath . '/' . $group . '.php';
                    
                    // Mevcut dosyayı al (varsa)
                    $existingTranslations = [];
                    if (File::exists($filePath)) {
                        $existingTranslations = include $filePath;
                    }
                    
                    // Yeni çevirileri birleştir
                    $mergedTranslations = array_merge($existingTranslations, $translations);
                    
                    // Dosyayı kaydet
                    $this->saveTranslationFile($filePath, $mergedTranslations);
                    
                    // Veritabanına da kaydet
                    foreach ($translations as $key => $value) {
                        if (is_string($value) && !empty($value)) {
                            Translation::updateOrCreate(
                                [
                                    'language_id' => $language->id,
                                    'key' => $key,
                                    'group' => $group,
                                ],
                                [
                                    'value' => $value,
                                ]
                            );
                            $importedCount++;
                        }
                    }
                }
            }
            
            return redirect()->back()
                ->with('success', __('common.translations-imported-successfully', ['count' => $importedCount]));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('common.import-failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Excel formatında export et
     */
    public function exportExcel(Language $language)
    {
        // Tüm çeviri dosyalarını al
        $langPath = resource_path('lang/' . $language->code);
        $baseLanguage = Language::where('is_default', true)->first();
        $baseLangPath = resource_path('lang/' . $baseLanguage->code);
        
        $exportData = [];
        $exportData[] = ['Group', 'Key', 'Original (' . $baseLanguage->code . ')', 'Translation (' . $language->code . ')'];
        
        if (File::exists($baseLangPath)) {
            $langFiles = File::files($baseLangPath);
            
            foreach ($langFiles as $file) {
                $group = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                
                // Temel dil çevirilerini al
                $baseTranslations = Lang::get($group, [], $baseLanguage->code);
                
                // Hedef dil çevirilerini al
                $targetTranslations = Lang::get($group, [], $language->code);
                
                if (is_array($baseTranslations)) {
                    foreach ($baseTranslations as $key => $originalValue) {
                        if (is_string($originalValue)) {
                            $translatedValue = isset($targetTranslations[$key]) ? $targetTranslations[$key] : '';
                            $exportData[] = [$group, $key, $originalValue, $translatedValue];
                        }
                    }
                }
            }
        }
        
        // CSV formatında oluştur
        $fileName = 'translations_' . $language->code . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $callback = function() use ($exportData) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM ekle (Excel için)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            foreach ($exportData as $row) {
                fputcsv($file, $row, ';'); // Excel için noktalı virgül kullan
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * CSV dosyasından import et
     */
    public function importCsv(Request $request, Language $language)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);
        
        try {
            $file = $request->file('csv_file');
            $handle = fopen($file->getPathname(), 'r');
            
            // İlk satırı atla (başlık)
            fgetcsv($handle, 1000, ';');
            
            $importedCount = 0;
            $groupedTranslations = [];
            
            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                if (count($data) >= 4) {
                    $group = trim($data[0]);
                    $key = trim($data[1]);
                    $translation = trim($data[3]); // 4. sütun çeviri
                    
                    if (!empty($group) && !empty($key) && !empty($translation)) {
                        if (!isset($groupedTranslations[$group])) {
                            $groupedTranslations[$group] = [];
                        }
                        $groupedTranslations[$group][$key] = $translation;
                    }
                }
            }
            
            fclose($handle);
            
            // Çevirileri kaydet
            foreach ($groupedTranslations as $group => $translations) {
                // Dil dosyası yolu
                $langPath = resource_path('lang/' . $language->code);
                if (!File::exists($langPath)) {
                    File::makeDirectory($langPath, 0755, true);
                }
                
                $filePath = $langPath . '/' . $group . '.php';
                
                // Mevcut dosyayı al (varsa)
                $existingTranslations = [];
                if (File::exists($filePath)) {
                    $existingTranslations = include $filePath;
                }
                
                // Yeni çevirileri birleştir
                $mergedTranslations = array_merge($existingTranslations, $translations);
                
                // Dosyayı kaydet
                $this->saveTranslationFile($filePath, $mergedTranslations);
                
                // Veritabanına da kaydet
                foreach ($translations as $key => $value) {
                    Translation::updateOrCreate(
                        [
                            'language_id' => $language->id,
                            'key' => $key,
                            'group' => $group,
                        ],
                        [
                            'value' => $value,
                        ]
                    );
                    $importedCount++;
                }
            }
            
            return redirect()->back()
                ->with('success', __('common.csv-imported-successfully', ['count' => $importedCount]));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('common.csv-import-failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Kodda kullanılan ama çeviri dosyalarında tanımlanmamış anahtarları bulur
     */
    private function findMissingTranslationKeys($baseLanguageCode)
    {
        $usedKeys = $this->extractTranslationKeysFromCode();
        $existingKeys = $this->getExistingTranslationKeys($baseLanguageCode);
        
        $missingKeys = [];
        
        foreach ($usedKeys as $group => $keys) {
            foreach ($keys as $key) {
                if (!isset($existingKeys[$group]) || !in_array($key, $existingKeys[$group])) {
                    if (!isset($missingKeys[$group])) {
                        $missingKeys[$group] = [];
                    }
                    $missingKeys[$group][] = $key;
                }
            }
        }
        
        return $missingKeys;
    }

    /**
     * Tüm kod dosyalarından çeviri anahtarlarını çıkarır
     */
    private function extractTranslationKeysFromCode()
    {
        $keys = [];
        $directories = [
            app_path(),
            resource_path('views'),
            resource_path('js')
        ];
        
        foreach ($directories as $directory) {
            $this->scanDirectoryForTranslationKeys($directory, $keys);
        }
        
        return $keys;
    }

    /**
     * Belirtilen dizini tarayarak çeviri anahtarlarını bulur
     */
    private function scanDirectoryForTranslationKeys($directory, &$keys)
    {
        if (!File::exists($directory)) {
            return;
        }
        
        $files = File::allFiles($directory);
        
        foreach ($files as $file) {
            $extension = $file->getExtension();
            
            // Sadece PHP, Blade ve JS dosyalarını tara
            if (!in_array($extension, ['php', 'js', 'vue', 'ts'])) {
                continue;
            }
            
            $content = File::get($file->getPathname());
            
            // __('group.key') pattern'ini bul
            preg_match_all('/__\([\'"]([^\'"\)]+)[\'"]\)/', $content, $matches);
            foreach ($matches[1] as $match) {
                $this->parseTranslationKey($match, $keys);
            }
            
            // trans('group.key') pattern'ini bul
            preg_match_all('/trans\([\'"]([^\'"\)]+)[\'"]\)/', $content, $matches);
            foreach ($matches[1] as $match) {
                $this->parseTranslationKey($match, $keys);
            }
            
            // @lang('group.key') pattern'ini bul (Blade için)
            preg_match_all('/@lang\([\'"]([^\'"\)]+)[\'"]\)/', $content, $matches);
            foreach ($matches[1] as $match) {
                $this->parseTranslationKey($match, $keys);
            }
            
            // {{ __('group.key') }} pattern'ini bul (Blade için)
            preg_match_all('/\{\{\s*__\([\'"]([^\'"\)]+)[\'"]\)\s*\}\}/', $content, $matches);
            foreach ($matches[1] as $match) {
                $this->parseTranslationKey($match, $keys);
            }
        }
    }

    /**
     * Çeviri anahtarını parse eder ve grup/anahtar olarak ayırır
     */
    private function parseTranslationKey($key, &$keys)
    {
        if (strpos($key, '.') !== false) {
            $parts = explode('.', $key, 2);
            $group = $parts[0];
            $keyName = $parts[1];
            
            if (!isset($keys[$group])) {
                $keys[$group] = [];
            }
            
            if (!in_array($keyName, $keys[$group])) {
                $keys[$group][] = $keyName;
            }
        }
    }

    /**
     * Mevcut çeviri dosyalarından tüm anahtarları alır
     */
    private function getExistingTranslationKeys($languageCode)
    {
        $keys = [];
        $langPath = resource_path('lang/' . $languageCode);
        
        if (!File::exists($langPath)) {
            return $keys;
        }
        
        $langFiles = File::files($langPath);
        
        foreach ($langFiles as $file) {
            $group = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $translations = Lang::get($group, [], $languageCode);
            
            if (is_array($translations)) {
                $keys[$group] = array_keys($translations);
            }
        }
        
        return $keys;
    }

    /**
     * Eksik anahtarları otomatik olarak çeviri dosyalarına ekler
     */
    public function addMissingKeys(Request $request, Language $language)
    {
        $baseLanguage = Language::where('is_default', true)->first();
        $missingKeys = $this->findMissingTranslationKeys($baseLanguage->code);
        
        $addedCount = 0;
        
        foreach ($missingKeys as $group => $keys) {
            // Temel dil dosyasını güncelle
            $baseLangPath = resource_path('lang/' . $baseLanguage->code . '/' . $group . '.php');
            $baseTranslations = [];
            
            if (File::exists($baseLangPath)) {
                $baseTranslations = include $baseLangPath;
            }
            
            // Hedef dil dosyasını güncelle
            $targetLangPath = resource_path('lang/' . $language->code . '/' . $group . '.php');
            $targetTranslations = [];
            
            if (File::exists($targetLangPath)) {
                $targetTranslations = include $targetLangPath;
            }
            
            foreach ($keys as $key) {
                // Temel dile ekle (boş değer ile)
                if (!isset($baseTranslations[$key])) {
                    $baseTranslations[$key] = $key; // Anahtar adını varsayılan değer olarak kullan
                    $addedCount++;
                }
                
                // Hedef dile ekle (boş değer ile)
                if (!isset($targetTranslations[$key])) {
                    $targetTranslations[$key] = '';
                }
            }
            
            // Dosyaları kaydet
            if (!empty($baseTranslations)) {
                $this->saveTranslationFile($baseLangPath, $baseTranslations);
            }
            
            if (!empty($targetTranslations)) {
                // Hedef dil dizini yoksa oluştur
                $targetLangDir = dirname($targetLangPath);
                if (!File::exists($targetLangDir)) {
                    File::makeDirectory($targetLangDir, 0755, true);
                }
                $this->saveTranslationFile($targetLangPath, $targetTranslations);
            }
        }
        
        return redirect()->back()
            ->with('success', __('common.missing-keys-added-successfully', ['count' => $addedCount]));
    }

    /**
     * Çeviri dosyasını kaydet
     */
    private function saveTranslationFile($filePath, $translations)
    {
        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        File::put($filePath, $content);
    }
} 