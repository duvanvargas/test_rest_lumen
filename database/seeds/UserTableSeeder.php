<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Duvan Vargas',
            'email' => 'davs3029@gmail.com',
            'password' => app('hash')->make('miclave'),
            'remember_token' => str_random(10),
        ]);
    }
}
