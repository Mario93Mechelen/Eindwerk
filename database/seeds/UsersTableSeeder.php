<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Amber',
            'last_name' => 'Heard',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'avatar' => 'img/profile_pic_default.jpg',
            'token' => bcrypt('secret')
        ]);
    }
}
