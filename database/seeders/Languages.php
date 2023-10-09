<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Astrotomic\Translatable\Translatable;

class Languages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meal = new Meal();
        $meal->translateOrNew('en')->name = 'English Name';
        $meal->translateOrNew('hr')->name = 'Croatian Name';
    }
}
