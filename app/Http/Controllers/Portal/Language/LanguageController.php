<?php

namespace App\Http\Controllers\Portal\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Google\Cloud\Translate\V2\TranslateClient;

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

    /**
     * Otomatik çeviri yap
     */
    public function autoTranslate(Request $request, Language $language)
    {
        try {
            $baseLanguage = Language::where('is_default', true)->first();
            if (!$baseLanguage) {
                return redirect()->back()
                    ->with('error', __('common.no-base-language-found'));
            }

            $group = $request->input('group');
            $translatedCount = 0;

            // Boş çevirileri bul
            $emptyTranslations = $this->findEmptyTranslations($language->code, $baseLanguage->code);

            if ($group) {
                // Sadece belirtilen grup için çeviri yap
                if (isset($emptyTranslations[$group])) {
                    $translatedCount += $this->translateGroup($group, $emptyTranslations[$group], $language, $baseLanguage);
                }
            } else {
                // Tüm gruplar için çeviri yap
                foreach ($emptyTranslations as $groupName => $keys) {
                    $translatedCount += $this->translateGroup($groupName, $keys, $language, $baseLanguage);
                }
            }

            if ($translatedCount > 0) {
                return redirect()->back()
                    ->with('success', __('common.translation-completed') . ' (' . $translatedCount . ' ' . __('common.translations') . ')');
            } else {
                return redirect()->back()
                    ->with('info', __('common.no-empty-translations-found'));
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('common.translation-failed') . ': ' . $e->getMessage());
        }
    }

    /**
     * Boş çevirileri listele
     */
    public function listEmptyTranslations(Language $language)
    {
        try {
            \Log::info('listEmptyTranslations called for language: ' . $language->code);
            
            $baseLanguage = Language::where('is_default', true)->first();
            
            // Eğer default language yoksa, 'en' kodlu dili kullan
            if (!$baseLanguage) {
                $baseLanguage = Language::where('code', 'en')->first();
                \Log::warning('No default language found, using English as base');
            }
            
            // Hala yoksa, ilk dili kullan
            if (!$baseLanguage) {
                $baseLanguage = Language::first();
                \Log::warning('No English language found, using first available language');
            }
            
            if (!$baseLanguage) {
                \Log::error('No languages found in database');
                return redirect()->back()
                    ->with('error', 'No languages found in the system');
            }
            
            \Log::info('Base language: ' . $baseLanguage->code);
            
            // Eğer aynı dil ise, boş çeviri bulunamaz
            if ($language->code === $baseLanguage->code) {
                $emptyTranslations = [];
                $debugInfo = [
                    'language' => $language,
                    'baseLanguage' => $baseLanguage,
                    'emptyTranslationsCount' => 0,
                    'groups' => [],
                    'totalEmptyKeys' => 0,
                    'message' => 'Cannot find empty translations for the same language as base language'
                ];
                
                return view('portal.language.empty-translations', compact('language', 'emptyTranslations', 'debugInfo'));
            }
            
            $emptyTranslations = $this->findEmptyTranslations($language->code, $baseLanguage->code);
            
            \Log::info('Empty translations found: ' . count($emptyTranslations));
            \Log::info('Empty translations data: ' . json_encode($emptyTranslations));

            // Debug bilgileri ekle
            $debugInfo = [
                'language' => $language,
                'baseLanguage' => $baseLanguage,
                'emptyTranslationsCount' => count($emptyTranslations),
                'groups' => array_keys($emptyTranslations),
                'totalEmptyKeys' => array_sum(array_map('count', $emptyTranslations))
            ];

            return view('portal.language.empty-translations', compact('language', 'emptyTranslations', 'debugInfo'));
        } catch (\Exception $e) {
            \Log::error('Error in listEmptyTranslations: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Debug view'ı göster
            $debugInfo = [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'language' => $language ?? null
            ];
            
            $emptyTranslations = [];
            
            return view('portal.language.empty-translations', compact('language', 'debugInfo', 'emptyTranslations'))
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Boş çevirileri bul
     */
    private function findEmptyTranslations($targetLanguageCode, $baseLanguageCode)
    {
        $emptyTranslations = [];
        $baseLangPath = resource_path('lang/' . $baseLanguageCode);

        \Log::info('Finding empty translations for target: ' . $targetLanguageCode . ', base: ' . $baseLanguageCode);
        \Log::info('Base language path: ' . $baseLangPath);

        if (File::exists($baseLangPath)) {
            $langFiles = File::files($baseLangPath);
            \Log::info('Found ' . count($langFiles) . ' language files');

            foreach ($langFiles as $file) {
                $group = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                \Log::info('Processing group: ' . $group);
                
                // Temel dil çevirilerini al
                $baseTranslations = Lang::get($group, [], $baseLanguageCode);
                
                // Hedef dil çevirilerini al
                $targetTranslations = Lang::get($group, [], $targetLanguageCode);

                \Log::info('Base translations count for ' . $group . ': ' . (is_array($baseTranslations) ? count($baseTranslations) : 'not array'));
                \Log::info('Target translations count for ' . $group . ': ' . (is_array($targetTranslations) ? count($targetTranslations) : 'not array'));

                if (is_array($baseTranslations)) {
                    $emptyCount = 0;
                    foreach ($baseTranslations as $key => $value) {
                        if (is_string($value) && !empty($value)) {
                            $targetValue = isset($targetTranslations[$key]) ? $targetTranslations[$key] : '';
                            
                            // Boş veya eksik çeviri
                            if (empty($targetValue)) {
                                if (!isset($emptyTranslations[$group])) {
                                    $emptyTranslations[$group] = [];
                                }
                                $emptyTranslations[$group][$key] = $value;
                                $emptyCount++;
                            }
                        }
                    }
                    \Log::info('Empty translations found in ' . $group . ': ' . $emptyCount);
                }
            }
        } else {
            \Log::error('Base language path does not exist: ' . $baseLangPath);
        }

        \Log::info('Total empty translation groups: ' . count($emptyTranslations));
        return $emptyTranslations;
    }

    /**
     * Grup çevirisi yap
     */
    private function translateGroup($group, $keys, $language, $baseLanguage)
    {
        $translatedCount = 0;
        $groupTranslations = [];

        foreach ($keys as $key => $originalText) {
            $translatedText = $this->translateText($originalText, $baseLanguage->code, $language->code);
            
            if ($translatedText && $translatedText !== $originalText) {
                $groupTranslations[$key] = $translatedText;
                $translatedCount++;

                // Veritabanına kaydet
                Translation::updateOrCreate(
                    [
                        'language_id' => $language->id,
                        'key' => $key,
                        'group' => $group,
                    ],
                    [
                        'value' => $translatedText,
                    ]
                );
            }
        }

        // Dosyaya kaydet
        if (!empty($groupTranslations)) {
            $langPath = resource_path('lang/' . $language->code);
            if (!File::exists($langPath)) {
                File::makeDirectory($langPath, 0755, true);
            }

            $filePath = $langPath . '/' . $group . '.php';
            
            // Mevcut çevirileri al
            $existingTranslations = [];
            if (File::exists($filePath)) {
                $existingTranslations = include $filePath;
            }

            // Yeni çevirileri birleştir
            $mergedTranslations = array_merge($existingTranslations, $groupTranslations);
            
            // Dosyayı kaydet
            $this->saveTranslationFile($filePath, $mergedTranslations);
        }

        return $translatedCount;
    }

    /**
     * Metin çevirisi yap
     */
    private function translateText($text, $fromLang, $toLang)
    {
        try {
            // Önce akıllı anahtar çevirisi dene
            $intelligentTranslation = $this->intelligentKeyTranslation($text, $fromLang, $toLang);
            if ($intelligentTranslation && $intelligentTranslation !== $text) {
                return $intelligentTranslation;
            }

            // Önce MyMemory API'yi dene (ücretsiz)
            $myMemoryResult = $this->myMemoryTranslate($text, $fromLang, $toLang);
            if ($myMemoryResult && $myMemoryResult !== $text) {
                return $myMemoryResult;
            }

            // Google Translate API kullan (ücretli)
            if (config('google-translate.api_key')) {
                $translate = new TranslateClient([
                    'key' => config('google-translate.api_key')
                ]);

                // Dil kodlarını Google Translate formatına çevir
                $mappings = config('google-translate.language_mappings');
                $sourceLanguage = $mappings[$fromLang] ?? $fromLang;
                $targetLanguage = $mappings[$toLang] ?? $toLang;

                $result = $translate->translate($text, [
                    'source' => $sourceLanguage,
                    'target' => $targetLanguage,
                    'format' => config('google-translate.options.format', 'text'),
                    'model' => config('google-translate.options.model', 'base'),
                ]);

                return $result['text'] ?? $text;
            }
            
            // Fallback: Basit çeviri sistemi
            return $this->simpleTranslate($text, $fromLang, $toLang);
            
        } catch (\Exception $e) {
            // Hata durumunda basit çeviri dene
            return $this->simpleTranslate($text, $fromLang, $toLang);
        }
    }

    /**
     * Akıllı anahtar çevirisi - anahtar isimlerini anlamlı metne çevirir
     */
    private function intelligentKeyTranslation($key, $fromLang, $toLang)
    {
        try {
            // Eğer key bir anahtar ismi gibi görünüyorsa (tire, alt çizgi içeriyorsa)
            if (preg_match('/^[a-z0-9\-_]+$/', $key) && (strpos($key, '-') !== false || strpos($key, '_') !== false)) {
                
                // Anahtar ismini anlamlı metne çevir
                $meaningfulText = $this->convertKeyToMeaningfulText($key);
                
                // Anlamlı metni çevir
                if ($meaningfulText !== $key) {
                    return $this->translateMeaningfulText($meaningfulText, $fromLang, $toLang);
                }
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::warning('Intelligent Key Translation Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Anahtar ismini anlamlı metne çevir
     */
    private function convertKeyToMeaningfulText($key)
    {
        // Özel anahtar çevirileri
        $specialKeys = [
            'virtual-stands-management-subtitle' => 'Virtual Stands Management Subtitle',
            'participant-logs-description' => 'Participant Logs Description',
            'there-is-not-active-keypad' => 'There is no active keypad',
            'meeting-hall-management' => 'Meeting Hall Management',
            'user-management-system' => 'User Management System',
            'document-sharing-platform' => 'Document Sharing Platform',
            'live-streaming-service' => 'Live Streaming Service',
            'virtual-booth-setup' => 'Virtual Booth Setup',
            'participant-registration' => 'Participant Registration',
            'session-management' => 'Session Management',
            'speaker-management' => 'Speaker Management',
            'agenda-management' => 'Agenda Management',
            'poll-voting-system' => 'Poll Voting System',
            'qa-session-management' => 'Q&A Session Management',
            'networking-features' => 'Networking Features',
            'chat-messaging-system' => 'Chat Messaging System',
            'file-download-center' => 'File Download Center',
            'certificate-generation' => 'Certificate Generation',
            'attendance-tracking' => 'Attendance Tracking',
            'analytics-dashboard' => 'Analytics Dashboard',
            'notification-system' => 'Notification System',
            'email-integration' => 'Email Integration',
            'social-media-sharing' => 'Social Media Sharing',
            'mobile-app-support' => 'Mobile App Support',
            'multi-language-support' => 'Multi Language Support',
            'custom-branding-options' => 'Custom Branding Options',
            'security-settings' => 'Security Settings',
            'backup-restore-system' => 'Backup Restore System',
            'api-integration' => 'API Integration',
            'third-party-plugins' => 'Third Party Plugins',
        ];

        // Özel anahtar varsa onu kullan
        if (isset($specialKeys[$key])) {
            return $specialKeys[$key];
        }

        // Genel dönüşüm kuralları
        $text = $key;
        
        // Alt çizgi ve tireleri boşluğa çevir
        $text = str_replace(['_', '-'], ' ', $text);
        
        // Her kelimenin ilk harfini büyük yap
        $text = ucwords($text);
        
        // Yaygın kısaltmaları düzelt
        $abbreviations = [
            'Qa' => 'Q&A',
            'Api' => 'API',
            'Url' => 'URL',
            'Html' => 'HTML',
            'Css' => 'CSS',
            'Js' => 'JavaScript',
            'Pdf' => 'PDF',
            'Sms' => 'SMS',
            'Id' => 'ID',
            'Ui' => 'UI',
            'Ux' => 'UX',
            'Db' => 'Database',
            'Admin' => 'Administrator',
            'Config' => 'Configuration',
            'Auth' => 'Authentication',
            'Login' => 'Login',
            'Logout' => 'Logout',
            'Signup' => 'Sign Up',
            'Signin' => 'Sign In',
        ];

        foreach ($abbreviations as $abbr => $full) {
            $text = str_replace($abbr, $full, $text);
        }

        return $text;
    }

    /**
     * Anlamlı metni çevir
     */
    private function translateMeaningfulText($text, $fromLang, $toLang)
    {
        // Önce basit çeviri sözlüğünden bak
        $simpleTranslation = $this->simpleTranslate($text, $fromLang, $toLang);
        if ($simpleTranslation !== $text) {
            return $simpleTranslation;
        }

        // Kelime kelime çeviri yap
        return $this->wordByWordTranslation($text, $fromLang, $toLang);
    }

    /**
     * Kelime kelime çeviri
     */
    private function wordByWordTranslation($text, $fromLang, $toLang)
    {
        if ($fromLang !== 'en' || $toLang !== 'tr') {
            return $text; // Şimdilik sadece İngilizce -> Türkçe
        }

        $wordTranslations = [
            'virtual' => 'sanal',
            'stands' => 'standlar',
            'management' => 'yönetimi',
            'subtitle' => 'alt başlık',
            'participant' => 'katılımcı',
            'logs' => 'kayıtlar',
            'description' => 'açıklama',
            'there' => 'burada',
            'is' => '',
            'no' => 'hiç',
            'not' => 'değil',
            'active' => 'aktif',
            'keypad' => 'tuş takımı',
            'meeting' => 'toplantı',
            'hall' => 'salon',
            'user' => 'kullanıcı',
            'system' => 'sistem',
            'document' => 'belge',
            'sharing' => 'paylaşım',
            'platform' => 'platform',
            'live' => 'canlı',
            'streaming' => 'yayın',
            'service' => 'hizmet',
            'booth' => 'stand',
            'setup' => 'kurulum',
            'registration' => 'kayıt',
            'session' => 'oturum',
            'speaker' => 'konuşmacı',
            'agenda' => 'ajanda',
            'poll' => 'anket',
            'voting' => 'oylama',
            'question' => 'soru',
            'answer' => 'cevap',
            'networking' => 'ağ oluşturma',
            'features' => 'özellikler',
            'chat' => 'sohbet',
            'messaging' => 'mesajlaşma',
            'file' => 'dosya',
            'download' => 'indirme',
            'center' => 'merkez',
            'certificate' => 'sertifika',
            'generation' => 'oluşturma',
            'attendance' => 'katılım',
            'tracking' => 'takip',
            'analytics' => 'analitik',
            'dashboard' => 'kontrol paneli',
            'notification' => 'bildirim',
            'email' => 'e-posta',
            'integration' => 'entegrasyon',
            'social' => 'sosyal',
            'media' => 'medya',
            'mobile' => 'mobil',
            'app' => 'uygulama',
            'support' => 'destek',
            'multi' => 'çoklu',
            'language' => 'dil',
            'custom' => 'özel',
            'branding' => 'marka',
            'options' => 'seçenekler',
            'security' => 'güvenlik',
            'settings' => 'ayarlar',
            'backup' => 'yedekleme',
            'restore' => 'geri yükleme',
            'third' => 'üçüncü',
            'party' => 'taraf',
            'plugins' => 'eklentiler',
        ];

        $words = explode(' ', strtolower($text));
        $translatedWords = [];

        foreach ($words as $word) {
            $cleanWord = trim($word, '.,!?;:');
            if (isset($wordTranslations[$cleanWord])) {
                $translation = $wordTranslations[$cleanWord];
                if (!empty($translation)) {
                    $translatedWords[] = $translation;
                }
            } else {
                $translatedWords[] = $word;
            }
        }

        return ucfirst(implode(' ', $translatedWords));
    }

    /**
     * MyMemory API ile ücretsiz çeviri (günde 10,000 karakter)
     */
    private function myMemoryTranslate($text, $fromLang, $toLang)
    {
        try {
            $url = "https://api.mymemory.translated.net/get";
            $params = [
                'q' => $text,
                'langpair' => $fromLang . '|' . $toLang,
                'de' => 'info@kongrepad.com' // E-posta adresi daha yüksek limit için
            ];

            // cURL kullanarak daha güvenilir istek
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'KongrePad Translation System');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || !$response) {
                return null;
            }

            $data = json_decode($response, true);

            if (isset($data['responseData']['translatedText'])) {
                $translatedText = $data['responseData']['translatedText'];
                
                // Kalite kontrolü - eğer çeviri orijinal metinle aynıysa ve match düşükse reddet
                if ($translatedText === $text && isset($data['responseData']['match']) && $data['responseData']['match'] < 0.8) {
                    return null;
                }

                // Quota kontrolü
                if (isset($data['quotaFinished']) && $data['quotaFinished'] === true) {
                    \Log::warning('MyMemory API quota finished');
                    return null;
                }

                // Eğer matches varsa en iyi kaliteli çeviriyi al
                if (isset($data['matches']) && is_array($data['matches']) && count($data['matches']) > 0) {
                    $bestMatch = null;
                    $bestQuality = 0;

                    foreach ($data['matches'] as $match) {
                        $quality = is_numeric($match['quality']) ? (float)$match['quality'] : 0;
                        $matchScore = isset($match['match']) ? (float)$match['match'] : 0;
                        
                        // Kalite ve match skorunu birleştir
                        $totalScore = ($quality * 0.7) + ($matchScore * 100 * 0.3);
                        
                        if ($totalScore > $bestQuality && $match['translation'] !== $text) {
                            $bestQuality = $totalScore;
                            $bestMatch = $match['translation'];
                        }
                    }

                    if ($bestMatch && $bestQuality > 50) { // Minimum kalite eşiği
                        return $bestMatch;
                    }
                }

                // Eğer matches yoksa veya kaliteli match yoksa, ana çeviriyi kullan
                if ($translatedText !== $text) {
                    return $translatedText;
                }
            }

            return null;
        } catch (\Exception $e) {
            \Log::warning('MyMemory API Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * LibreTranslate API ile ücretsiz çeviri (kendi sunucunuzda)
     */
    private function libreTranslate($text, $fromLang, $toLang)
    {
        try {
            $url = config('google-translate.libre_translate_url', 'https://libretranslate.de/translate');
            
            $data = [
                'q' => $text,
                'source' => $fromLang,
                'target' => $toLang,
                'format' => 'text'
            ];

            $options = [
                'http' => [
                    'header' => "Content-type: application/json\r\n",
                    'method' => 'POST',
                    'content' => json_encode($data)
                ]
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $result = json_decode($response, true);

            if (isset($result['translatedText'])) {
                return $result['translatedText'];
            }

            return null;
        } catch (\Exception $e) {
            \Log::warning('LibreTranslate API Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Basit çeviri sistemi (fallback)
     */
    private function simpleTranslate($text, $fromLang, $toLang)
    {
        // Konfigürasyon dosyasından çeviri sözlüğünü al
        $translations = config('google-translate.fallback_translations');

        if (isset($translations[$fromLang][$toLang][$text])) {
            return $translations[$fromLang][$toLang][$text];
        }

        // Çeviri bulunamazsa orijinal metni döndür
        return $text;
    }

    /**
     * AJAX: Original metni kaydet
     */
    public function saveOriginalText(Request $request, Language $language)
    {
        try {
            $request->validate([
                'group' => 'required|string',
                'key' => 'required|string',
                'value' => 'required|string',
            ]);

            $group = $request->input('group');
            $key = $request->input('key');
            $value = $request->input('value');

            // Temel dil dosyasını güncelle
            $baseLanguage = Language::where('is_default', true)->first();
            if (!$baseLanguage) {
                return response()->json(['message' => 'No base language found'], 400);
            }

            $baseLangPath = resource_path('lang/' . $baseLanguage->code . '/' . $group . '.php');
            
            // Mevcut çevirileri al
            $translations = [];
            if (File::exists($baseLangPath)) {
                $translations = include $baseLangPath;
            }

            // Yeni değeri ekle/güncelle
            $translations[$key] = $value;

            // Dosyayı kaydet
            $this->saveTranslationFile($baseLangPath, $translations);

            return response()->json([
                'success' => true,
                'message' => 'Original text saved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving original text: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * AJAX: Tek anahtar için otomatik çeviri
     */
    public function autoTranslateKey(Request $request, Language $language)
    {
        try {
            $request->validate([
                'group' => 'required|string',
                'key' => 'required|string',
                'original_text' => 'required|string',
            ]);

            $baseLanguage = Language::where('is_default', true)->first();
            if (!$baseLanguage) {
                return response()->json(['message' => 'No base language found'], 400);
            }

            $originalText = $request->input('original_text');
            $translatedText = $this->translateText($originalText, $baseLanguage->code, $language->code);

            if ($translatedText && $translatedText !== $originalText) {
                return response()->json([
                    'success' => true,
                    'translation' => $translatedText,
                    'message' => 'Translation generated successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not generate translation'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating translation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * AJAX: Çeviri anahtarını sil
     */
    public function deleteKey(Request $request, Language $language)
    {
        try {
            $request->validate([
                'group' => 'required|string',
                'key' => 'required|string',
            ]);

            $group = $request->input('group');
            $key = $request->input('key');

            // Veritabanından sil
            Translation::where('language_id', $language->id)
                ->where('group', $group)
                ->where('key', $key)
                ->delete();

            // Dosyadan da sil
            $langPath = resource_path('lang/' . $language->code . '/' . $group . '.php');
            if (File::exists($langPath)) {
                $translations = include $langPath;
                if (isset($translations[$key])) {
                    unset($translations[$key]);
                    $this->saveTranslationFile($langPath, $translations);
                }
            }

            // Temel dil dosyasından da sil (isteğe bağlı)
            $baseLanguage = Language::where('is_default', true)->first();
            if ($baseLanguage) {
                $baseLangPath = resource_path('lang/' . $baseLanguage->code . '/' . $group . '.php');
                if (File::exists($baseLangPath)) {
                    $baseTranslations = include $baseLangPath;
                    if (isset($baseTranslations[$key])) {
                        unset($baseTranslations[$key]);
                        $this->saveTranslationFile($baseLangPath, $baseTranslations);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Translation key deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting key: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * AJAX: Çeviri güncelle (JSON response)
     */
    public function updateTranslationAjax(Request $request, Language $language)
    {
        try {
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

            // Dosyaya da kaydet
            $langPath = resource_path('lang/' . $language->code);
            if (!File::exists($langPath)) {
                File::makeDirectory($langPath, 0755, true);
            }

            $filePath = $langPath . '/' . $request->group . '.php';
            
            // Mevcut çevirileri al
            $existingTranslations = [];
            if (File::exists($filePath)) {
                $existingTranslations = include $filePath;
            }

            // Yeni çeviriyi ekle
            $existingTranslations[$request->key] = $request->value;
            
            // Dosyayı kaydet
            $this->saveTranslationFile($filePath, $existingTranslations);

            return response()->json([
                'success' => true,
                'message' => 'Translation updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating translation: ' . $e->getMessage()
            ], 500);
        }
    }
} 