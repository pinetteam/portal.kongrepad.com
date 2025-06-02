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

        return view('portal.language.translations', compact('language', 'translations', 'groups'));
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
        $translations = $language->translations()->get()->groupBy('group');
        
        foreach ($translations as $group => $items) {
            $data = [];
            foreach ($items as $item) {
                $data[$item->key] = $item->value;
            }
            
            // Eğer dil dizini yoksa oluştur
            $langPath = resource_path('lang/' . $language->code);
            if (!File::exists($langPath)) {
                File::makeDirectory($langPath, 0755, true);
            }
            
            // Dosyayı oluştur
            $filePath = $langPath . '/' . $group . '.php';
            $content = "<?php\n\nreturn " . var_export($data, true) . ";\n";
            File::put($filePath, $content);
        }
        
        return redirect()->route('portal.language.index')
            ->with('success', __('common.language-exported-successfully'));
    }

    public function import(Language $language)
    {
        $langPath = resource_path('lang/' . $language->code);
        
        if (File::exists($langPath)) {
            $langFiles = File::files($langPath);
            
            foreach ($langFiles as $file) {
                $group = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $translations = Lang::get($group, [], $language->code);
                
                if (is_array($translations)) {
                    foreach ($translations as $key => $value) {
                        if (is_string($value)) {
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
                        }
                    }
                }
            }
            
            return redirect()->route('portal.language.index')
                ->with('success', __('common.language-imported-successfully'));
        }
        
        return redirect()->route('portal.language.index')
            ->with('error', __('common.language-files-not-found'));
    }
} 