<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Tag;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Response;

class DishController extends Controller
{
    public function index(Request $request)
    {
        // Dohvaćanje parametara upita za paginaciju
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $with = $request->input('with');

        $query = Meal::query();

        //if (in_array('ingredients', $with)) {
        //    $query->with('ingredients');
        //}
//
        //if (in_array('category', $with)) {
        //    $query->with('category');
        //}
//
        //if (in_array('tags', $with)) {
        //    $query->with('tags');
        //}

        $meals = Meal::with(['category', 'tags'])->paginate($perPage);

        $meta = [
            'currentPage' => $meals->currentPage(),
            'totalItems' => $meals->total(),
            'itemsPerPage' => $meals->perPage(),
            'totalPages' => $meals->lastPage(),
        ];
        
        $data = $meals->map(function ($meal) {
            $tagId = $meal->tag_id; 
            $tag = Tag::find($tagId); 

            $ingredients = $meal->ingredients;

            $formattedIngredients = $ingredients->map(function ($ingredient) {
                return [
                    'id' => $ingredient->id,
                    'title' => $ingredient->title,
                ];
            });
            
            return [
                'id' => $meal->id,
                'title' => $meal->name,
                'description' => $meal->description,
                'status' => $meal->status,
                'category' => [
                    'id' => $meal->category->id,
                    'title' => $meal->category->title,
                ],
                'tag' => [
                    'id' => $tag->id,
                    'title' => $tag->title,
                ],
                'ingredients' => $formattedIngredients->toArray(),
            ];
        });

        $links = [
            'prev' => $meals->previousPageUrl(),
            'next' => $meals->nextPageUrl(),
            'self' => $meals->url($meals->currentPage()),
        ];

        $response = [
            'meta' => $meta,
            'data' => $data,
            'links' => $links,
        ];

        $formattedResponse = Response::json($response, 200, [], JSON_PRETTY_PRINT);

        return $formattedResponse;
    }
}
