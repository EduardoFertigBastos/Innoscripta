<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function index(Request $request)
    {
        try {
            $query = Article::query();
            $query = Article::buildQueryConditions($query, $request);

            $data = $query->paginate(
                $request->per_page ?? 20,
                ['*'],
                'page',
                $request->page ?? 1
            );

            return response()->json([
                'message' => 'Articles returned successfully',
                'data' => [
                    'current_page'  => $data->currentPage(),
                    'last_page'     => $data->lastPage(),
                    'per_page'      => $data->perPage(),
                    'total'         => $data->total(),
                    'articles'      => $data->items(),
                ]
            ], 201);
        } catch (Exception $ex) {

            return response()->json([
                'message' => 'Impossible to return the articles list',
                'error' => $ex->getMessage()
            ], 500);
        }
    }


    public function authors(Request $request)
    {
        $authors = Article::authors();

        return response()->json([
            'message' => 'Authors returned successfully',
            'data' => $authors
        ], 201);
    }

    public function categories(Request $request)
    {
        $categories = Article::categories();

        return response()->json([
            'message' => 'Categories returned successfully',
            'data' => $categories
        ], 201);
    }

    public function sources(Request $request)
    {
        $sources = Article::sources();

        return response()->json([
            'message' => 'Sources returned successfully',
            'data' => $sources
        ], 201);
    }
}
