<?php

namespace Database\Seeders;

use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Generator;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Container::getInstance()->make(Generator::class);

        // Seed languages
        DB::table('languages')->insert([
            'name' => 'English',
            'short_code' => 'eng'
        ]);
        DB::table('languages')->insert([
            'name' => 'Russian',
            'short_code' => 'rus'
        ]);

        // Seed authors
        for($c = 0; $c<10; $c++){
            DB::table('authors')->insert([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'code' => uniqid(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        // Seed books
        for($c = 0; $c<1000; $c++){
            DB::table('books')->insert([
                'name' => $faker->randomElement(['Happy ', 'Bloody ', 'Mystery '])
                    .$faker->randomElement(['wedding ', 'murder ', 'born '])
                    .'in '
                    .$faker->city(),
                'author_id' => rand(1,10),
                'published' => $faker->date(),
                'language_id' => rand(1,2),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        }
    }
}
