<?php

use Illuminate\Database\Seeder;

use Iscapsgt09\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'name' => 'robert',
                'email' => 'robett.tan@gmail.com',
                'password' => bcrypt('iscapsgt09'),
                'birth_date' => '1994-08-01',
                'gender' => 'm',
                'weight' => 65
        ]);
    }
}
