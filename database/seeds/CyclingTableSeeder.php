<?php

use Illuminate\Database\Seeder;

use Iscapsgt09\Models\Cycling;

class CyclingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cycling::create([
        	'id' => 1
        ]);
    }
}
