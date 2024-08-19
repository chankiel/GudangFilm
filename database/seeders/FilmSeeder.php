<?php

namespace Database\Seeders;

use App\Helpers\FileHelper;
use App\Models\Film;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FilmSeeder extends Seeder
{

    private function uploadAsset($path,$fileNameList,$ext){
        $dir = public_path($path);
        $files = scandir($dir);
        $i = 0;
        foreach ($files as $file) {
            if ($i >= count($fileNameList)) {
                break;
            };
            if ($file === '.' || $file === '..') {
                continue;
            }
            $oldFilePath = $dir . DIRECTORY_SEPARATOR . $file;
            $filename = $fileNameList[$i] . $ext;

            $i++;
            if (is_file($oldFilePath)) {
                $s3FilePath = $path.'/' . $filename;

                if (!Storage::disk('s3')->exists($s3FilePath)) {
                    $fileContents = file_get_contents($oldFilePath);
                    Storage::disk('s3')->put($s3FilePath, $fileContents);
                }
            }
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('seeds/tmdb_5000_movies.csv');

        $i = 0;
        if (($open = fopen($csvPath, "r")) !== false) {
            while (($data = fgetcsv($open, 4000, ",")) !== false) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                if ($i == 13) {
                    break;
                }
                $slug = FileHelper::cleanFileName($data[17]);
                $slugList[] = $slug;

                $runtime = $data[13];
                $genres = array_column(json_decode($data[1], true), 'name');
                print_r($genres);
                $desc = $data[7];
                $date = $data[11];

                $film = Film::createFilm([
                    'title' => $data[17],
                    'slug' => $slug,
                    'description' => $desc,
                    'director' => fake()->name(),
                    'release_year' => substr($date, 0, 4),
                    'price' => fake()->numberBetween(1000, 100000),
                    'genres' => $genres,
                    'duration' => ((int)$runtime) * 60,
                    'video_url' => Storage::url('videos/' . $slug . '.mp4'),
                    'cover_image_url' => Storage::url('cover_images/' . $slug . '.jpg'),
                ]);


                $i++;
            }

            fclose($open);
        }

        $this->uploadAsset('videos',$slugList,'.mp4');
        $this->uploadAsset('cover_images',$slugList,'.jpg');
    }
}
