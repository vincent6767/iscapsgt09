<?php

use Illuminate\Database\Seeder;

class TestingCyclingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('testing_cycling')->insert([
        	['id' => 1]
        ]);
    }
}
