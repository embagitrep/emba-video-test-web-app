<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DbTranslationsToFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-translations-to-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates translation file from db translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $langs = locales();
        $localesPath = base_path('lang');

        if (! is_dir($localesPath)) {
            $this->publishLocales();
        }

        foreach ($langs as $lang => $name) {
            $langdir = base_path("lang/{$lang}");
            $langFile = base_path("lang/{$lang}/translations.php");

            if (! is_dir($langdir)) {
                mkdir($langdir);
            }

            File::put($langFile, '');

            File::append($langFile, '<?php'.PHP_EOL.PHP_EOL.'return ');

            $translationData = [];

            $batchSize = 1000;

            $totalRecords = Translation::count();

            for ($offset = 0; $offset < $totalRecords; $offset += $batchSize) {
                $translations = Translation::whereHas('messages', function ($query) use ($lang) {
                    $query->where('lang', $lang);
                })->with(['messages' => function ($query) use ($lang) {
                    $query->where('lang', $lang);
                }])->skip($offset)->take($batchSize)->get();

                foreach ($translations as $translation) {
                    foreach ($translation->messages as $message) {
                        $translationData[Str::slug($translation->name)] = $message->value;
                    }
                }

            }

            File::append($langFile, var_export($translationData, true));

            File::append($langFile, ';');
        }
    }

    public function publishLocales()
    {
        Artisan::call('lang:publish');
    }
}
