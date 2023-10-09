<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\CroatianCategory;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $translator = new GoogleTranslate();
        $translator->setSource('en');
        $translator->setTarget('hr'); 

        $categories = ['Pizza', 'Hamburger', 'Hot Dog', 'Pasta', 'Vegetables'];
    
        foreach (range(1, 20) as $index) {
            $randomCategory = $categories[mt_rand(0, count($categories) - 1)];
    
            $slug = Str::slug($randomCategory);
    
            if (!Category::where('slug', $slug)->exists()) {
                Category::create([
                    'title' => $randomCategory,
                    'slug' => $slug,
                ]);
            }

            $translatedCategory = $translator->translate($randomCategory);
            if (!CroatianCategory::where('slug', $slug)->exists()) {
                CroatianCategory::create([
                    'title' => $translatedCategory, 
                    'slug' => $slug,
                ]);
            }
        }
    }
}