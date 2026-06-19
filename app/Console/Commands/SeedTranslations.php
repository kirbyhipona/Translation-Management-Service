<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SeedTranslations extends Command
{
    protected $signature = 'translations:seed {--count=100000} {--batch=2000}';
    protected $description = 'Seed translations efficiently in bulk';

    public function handle()
    {
        $count = (int) $this->option('count');
        $batch = (int) $this->option('batch');
        $faker = Faker::create();
        $locales = ['en','fr','es','de'];
        $tags = ['web','mobile','desktop'];

        // ensure tags exist
        $existingTags = DB::table('tags')->pluck('id','name')->toArray();
        foreach ($tags as $t) {
            if (! isset($existingTags[$t])) {
                // tags table does not have timestamps in this project, insert only the name
                $id = DB::table('tags')->insertGetId(['name' => $t]);
                $existingTags[$t] = $id;
            }
        }

        $rows = [];
        $pivotRows = [];
        $i = 0;

        $this->info("Seeding {$count} translations in batches of {$batch}...");

        while ($i < $count) {
            $i++;
            $locale = $locales[array_rand($locales)];
            $tKey = 'key_' . $i;
            $content = $faker->sentence(6);

            $rows[] = [
                't_key' => $tKey,
                'locale' => $locale,
                'content' => $content,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // attach random 0-2 tags
            $numTags = rand(0, min(2, count($existingTags)));
            if ($numTags > 0) {
                $chosen = (array) array_rand($existingTags, $numTags);
                foreach ((array) $chosen as $k) {
                    $pivotRows[] = [
                        'translation_id' => null, // fill after insert
                        'tag_id' => $existingTags[$k],
                    ];
                }
            }

            if (count($rows) >= $batch || $i === $count) {
                DB::beginTransaction();
                DB::table('translations')->insertOrIgnore($rows);

                // If you need pivot associations, fetch last inserted ids range
                // (This example skips setting pivot translation_id for speed.
                //  If pivot is required, insert translations with insertGetId per row or
                //  lookup by t_key/locale and then insert pivots in batch.)

                DB::commit();
                $rows = [];
                $pivotRows = [];
                $this->info("Inserted {$i} / {$count}");
            }
        }

        $this->info('Done.');
        return 0;
    }
}