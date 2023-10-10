<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Ingredient;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\CroatianIngredient;

class Ingredients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

        $translator = new GoogleTranslate();
        $translator->setSource('en');
        $translator->setTarget('hr'); 

        foreach (range(1, 20) as $index) {
            $numIngredients = mt_rand(2, 5);
            $ingredients = [];
            $slug = ''; 
            $ingredientsHR = [];
        
            for ($i = 0; $i < $numIngredients; $i++) {
                $ingredientName = $faker->randomElement([
                    $faker->dairyName(),
                    $faker->vegetableName(),
                    $faker->meatName(),
                    $faker->sauceName(),
                ]);
        
                $translatedIngredientName = $translator->translate($ingredientName);

                $ingredients[] = $ingredientName;

                $ingredientsHR[] = $translatedIngredientName;

        
                if ($i > 0) {
                    $slug .= '-';
                }
                $slug .= Str::slug($ingredientName);
            }
        

            Ingredient::create([
                'title' => implode(', ', $ingredients),
                'slug' => $slug,
            ]);
            CroatianIngredient::create([
                'title' => implode(', ', $ingredientsHR),
                'slug' => $slug,
            ]);
        }
    }
}
