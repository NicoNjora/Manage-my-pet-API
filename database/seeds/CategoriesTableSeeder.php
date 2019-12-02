<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Dog'],
            ['name' => 'Cat'],
            ['name' => 'Parrot'],
            ['name' => 'Hamster']
        ];
        DB::table('categories')->insert($categories);
    }
}
