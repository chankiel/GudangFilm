<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'balance' => '1000000',
            'password' => 'admin123',
        ]);
        
        User::factory()->count(10)->withPassword("IkanBakar3$")->create();
        $users = User::all();
        $films = Film::all();

        $filmsPerUser = 4;
        foreach($users as $user){
            $filmsBought = $films->random($filmsPerUser);
            foreach($filmsBought as $film){
                $user->bought()->attach($film->id);
            }

            $filmsWished = $films->random($filmsPerUser);
            foreach($filmsBought as $film){
                $user->wishlist()->attach($film->id);
            }
        }
    }
}
