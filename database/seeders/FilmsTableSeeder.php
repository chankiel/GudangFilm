<?php

namespace Database\Seeders;

use App\Helpers\FileHelper;
use App\Models\Film;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('seeds/tmdb_5000_movies.csv');

        $i = 0;
        if (($open = fopen($csvPath, "r")) !== false) {
            while (($data = fgetcsv($open, 4000, ",")) !== false) {
                if($i==0){
                    $i++;
                    continue;
                }
                if($i==100){
                    break;
                }
                $slug = FileHelper::cleanFileName($data[17]);
                $slugList[] = $slug;

                $runtime = $data[13];
                $genres = array_column(json_decode($data[1],true),'name');
                print_r($genres);
                $desc = $data[7];
                $date = $data[11];

                $film = Film::createFilm([
                    'title' => $data[17],
                    'slug' => $slug,
                    'description' => $desc,
                    'director' => fake()->name(),
                    'release_year' => substr($date,0,4),
                    'price' => fake()->numberBetween(1000,100000),
                    'genres' => $genres,
                    'duration' => ((int)$runtime)*60,
                    'cover_image_url' => 'cover_images/'.$slug.'.jpg',
                ]);


                $i++;
            }
         
            fclose($open);
        }

        $dir = public_path('cover_images');
        $files = scandir($dir);
        $i = 0;
        foreach($files as $file){
            if($i>=count($slugList)){
                break;
            };
            if ($file === '.' || $file === '..') {
                continue;
            }
            $oldFilePath = $dir . DIRECTORY_SEPARATOR . $file;
            $newFilePath = $dir . DIRECTORY_SEPARATOR . $slugList[$i].'.jpg';

            $i++;
            if(is_file($newFilePath)){
                continue;
            }
            if(is_file($oldFilePath)){
                rename($oldFilePath,$newFilePath);
            }
        }
    }
}
