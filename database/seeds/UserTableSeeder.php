<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder {

    public function run()
    {

        User::create([
        	'name' => 'Demo Person',
        	'email' => 'demo@example.com',
        	'password' => bcrypt('abc123'),
        ]);
    }

}