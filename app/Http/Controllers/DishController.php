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
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $tags = $request->input('tag');
    $with = $request->input('with');
    $tagIds = $request->input('tag');

    $query = Meal::query();

    $withArray = explode(',', $with);
    $withData = [];

    if (in_array('ingredients', $withArray)) {
        $withData[] = 'ingredients';
    }

    if (in_array('category', $withArray)) {
        $withData[] = 'category';
    }

    if (in_array('tags', $withArray)) {
        $withData[] = 'tags';
    }

    $tags = $request->input('tag');

    if ($tags) {
        $tagIds = explode(',', $tags);

        foreach ($tagIds as $tagId) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tag_id', $tagId);
            });
        }
    }

    $meals = $query->with($withData)->paginate($perPage);

    $meta = [
        'currentPage' => $meals->currentPage(),
        'totalItems' => $meals->total(),
        'itemsPerPage' => $meals->perPage(),
        'totalPages' => $meals->lastPage(),
    ];

    $links = [
        'prev' => $meals->previousPageUrl(),
        'next' => $meals->nextPageUrl(),
        'self' => $meals->url($meals->currentPage()),
    ];

    $response = [
        'meta' => $meta,
        'links' => $links,
    ];

    $response['data'] = $meals->map(function ($meal) use ($withArray) {
        $tagId = $meal->tag_id; 
        $tag = Tag::find($tagId); 
        $data = [
            'id' => $meal->id,
            'title' => $meal->name,
            'status' => $meal->created_at,
        ];

        if (in_array('ingredients', $withArray)) {
            $data['ingredients'] = $meal->ingredients;
        }

        if (in_array('category', $withArray)) {
            $data['category'] = [
                'id' => $meal->category->id,
                'title' => $meal->category->title,
                'slug' => $meal->category->slug,
            ];
        }

        if (in_array('tags', $withArray)) {
            $data['tags'] = [
                'id' => $tag->id,
                'title' => $tag->title,
                'slug' => $tag->slug,
            ];
        }

        return $data;
    });

    $formattedResponse = Response::json($response, 200, [], JSON_PRETTY_PRINT);

    return $formattedResponse;
}
}
