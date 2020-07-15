<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        App\User::create([
          'name' => 'John Thurlby',
          'email' => 'johnrthurlby@gmail.com',
          'password' => bcrypt('password')
        ]);

    }
}
