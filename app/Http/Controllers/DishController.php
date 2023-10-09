<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;

class DishController extends Controller
{
    public function index(Request $request)
    {
        // Dohvaćanje parametara upita za paginaciju
        $perPage = $request->input('per_page', 10); 
        $page = $request->input('page', 1); 

        $meals = Meal::paginate($perPage);

        $meta = [
            'currentPage' => $meals->currentPage(),
            'totalItems' => $meals->total(),
            'itemsPerPage' => $meals->perPage(),
            'totalPages' => $meals->lastPage(),
        ];

        $data = $meals->map(function ($meal) {
            return [
                'id' => $meal->id,
                'title' => $meal->title,
                'description' => $meal->description,
                'status' => $meal->status,
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

        return response()->json($response);
    }
}
