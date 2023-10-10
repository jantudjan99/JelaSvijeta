<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Meal; 
use App\Models\Category; 
use App\Models\Tag; 
use App\Models\Ingredient; 
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\CroatianMeal;

class DishSeeder extends Seeder
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

        $ingredients = Ingredient::all();
        $categories = Category::all();
        $tags = Tag::all();

        foreach (range(1, 20) as $index) {
            $numberOfSentences = mt_rand(1, 2);
            $sentences = [];

            $foodName = $faker->foodName();

            for ($i = 0; $i < $numberOfSentences; $i++) {
                $sentence = $faker->sentence(mt_rand(2, 6));
                //$sentence = str_replace(['a food', 'food item'], [$foodName, $foodName], $sentence);
                $sentences[] = $sentence;
            }

            $nameHr = $translator->translate($foodName);

            $meal = Meal::create([
                'name' => $foodName,
                'description' => implode(' ', $sentences),
                'price' => $faker->randomFloat(2, 5, 50),
            ]);

            $croatianMeal = CroatianMeal::create([
                'name' => $nameHr,
                'description' => implode(' ', $sentences),
                'price' => $faker->randomFloat(2, 5, 50),
            ]);

            $ingredient = $ingredients->random(); // Nasumično odabire sastojak iz dostupnih sastojaka
            $meal->ingredient_id = $ingredient ? $ingredient->id : null;
            $meal->save();


            $randomCategory = $categories->random();
            $meal->category()->associate($randomCategory);
            
            $randomTag = $tags->random(); 
            $meal->tag_id = $randomTag->id;
            $meal->save();

            //$croatianMeal->category()->associate($randomCategory);
            //$croatianMeal>save();
        }
    }
}
