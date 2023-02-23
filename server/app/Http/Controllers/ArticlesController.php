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
            $query = $this->buildQueryConditions($query, $request);

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

    public function buildQueryConditions($query, Request $request)
    {
        if ($request->has('fav_categories')) {
            $query->whereIn('category', $request->fav_categories);
        }

        if ($request->has('fav_sources')) {
            $query->whereIn('source', $request->fav_sources);
        }

        if ($request->has('fav_authors')) {
            $query->whereIn('author', $request->fav_authors);
        }

        if ($request->has('from')) {
            $query->where('published_at', '>=', $request->from);
        }

        return $query;
    }
}
