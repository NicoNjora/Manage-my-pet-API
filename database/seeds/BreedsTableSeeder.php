<?php

use Illuminate\Database\Seeder;

class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $breeds = [
            ['name' => 'German Shephard'],
            ['name' => 'Dalmatian'],
            ['name' => 'Chihuahua'],
            ['name' => 'Golden Retriever'],
            ['name' => 'Rottweiler'],
            ['name' => 'Pug']
        ];
        DB::table('breeds')->insert($breeds);
    }
}
