<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Meal; 
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

        foreach (range(1, 20) as $index) {
            $numberOfSentences = mt_rand(1, 2);
            $sentences = [];

            $foodName = $faker->foodName();

            for ($i = 0; $i < $numberOfSentences; $i++) {
                $sentence = $faker->sentence(mt_rand(2, 6));
                $sentence = str_replace(['a food', 'food item'], [$foodName, $foodName], $sentence);
                $sentences[] = $sentence;
            }

            $nameHr = $translator->translate($foodName);

            Meal::create([
                'name' => $foodName,
                'description' => implode(' ', $sentences),
                'price' => $faker->randomFloat(2, 5, 50),
            ]);

            CroatianMeal::create([
                'name' => $nameHr,
                'description' => implode(' ', $sentences),
                'price' => $faker->randomFloat(2, 5, 50),
            ]);
        }
    }
}
