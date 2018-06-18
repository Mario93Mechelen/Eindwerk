<?php

use Illuminate\Database\Seeder;

class InterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interests')->insert([
            'name' => 'architecture'
        ]);
        DB::table('interests')->insert([
            'name' => 'art'
        ]);
        DB::table('interests')->insert([
            'name' => 'cooking'
        ]);
        DB::table('interests')->insert([
            'name' => 'dancing'
        ]);
        DB::table('interests')->insert([
            'name' => 'literature'
        ]);
        DB::table('interests')->insert([
            'name' => 'history'
        ]);
        DB::table('interests')->insert([
            'name' => 'martial arts'
        ]);
        DB::table('interests')->insert([
            'name' => 'movies'
        ]);
        DB::table('interests')->insert([
            'name' => 'music'
        ]);
        DB::table('interests')->insert([
            'name' => 'photography'
        ]);
        DB::table('interests')->insert([
            'name' => 'politics'
        ]);
        DB::table('interests')->insert([
            'name' => 'sports'
        ]);
        DB::table('interests')->insert([
            'name' => 'television'
        ]);
        DB::table('interests')->insert([
            'name' => 'theatre'
        ]);
    }
}
