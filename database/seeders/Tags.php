<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\CroatianTag;

class Tags extends Seeder
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

        $tags = ['Hot', 'Healthy', 'Fast food', 'Vegetarian'];
    
        foreach (range(1, 20) as $index) {
            $randomTag = $tags[mt_rand(0, count($tags) - 1)];
    
            $slug = \Str::slug($randomTag);
    
            if (!Tag::where('slug', $slug)->exists()) {
                Tag::create([
                    'title' => $randomTag,
                    'slug' => $slug,
                ]);
            }
            $translatedTag = $translator->translate($randomTag);
            if (!CroatianTag::where('slug', $slug)->exists()) {
                CroatianTag::create([
                    'title' => $translatedTag,
                    'slug' => $slug,
                ]);
            }
        }
    }
}
