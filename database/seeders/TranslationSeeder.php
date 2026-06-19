<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 2000;
        $data = [];

        $locales = ['en', 'fr', 'es', 'de'];

        for ($i = 1; $i <= 100000; $i++) {

            $data[] = [
                't_key' => 'key_' . $i,
                'locale' => $locales[array_rand($locales)],
                'content' => 'Sample text ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($data) === $batchSize) {
                DB::table('translations')->insertOrIgnore($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('translations')->insertOrIgnore($data);
        }
    }
}
