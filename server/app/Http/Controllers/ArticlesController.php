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

    public function buildQueryCustomizeConditions($query, Request $request)
    {
        $query->where(function ($query) use ($request) {
            if ($request->has('fav_authors')) {
                $query->orWhereIn('author', $request->fav_authors);
            }

            if ($request->has('fav_categories')) {
                $query->orWhereIn('category', $request->fav_categories);
            }

            if ($request->has('fav_sources')) {
                $query->orWhereIn('source', $request->fav_sources);
            }
        });

        return $query;
    }
    public function buildQueryConditions($query, Request $request)
    {
        try {
            $query = $this->buildQueryCustomizeConditions($query, $request);
            
            if ($request->has('keyword')) {
                $query->where(function ($query) use ($request) {
                    $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                    $query->orWhere('description', 'like', '%' . $request->keyword . '%');
                });
            }

            if ($request->has('category')) {
                $query->orWhere('category', 'like', '%' . $request->category . '%');
            }

            if ($request->has('source')) {
                $query->where('source', 'like', '%' . $request->source . '%');
            }

            if ($request->has('from')) {
                $query->where('published_at', '>=', $request->from);
            }

            return $query;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function authors(Request $request)
    {
        $authors = Article::groupBy('author')
            ->orderBy('author')
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->pluck('author');

        return response()->json([
            'message' => 'Authors returned successfully',
            'data' => $authors
        ], 201);
    }

    public function categories(Request $request)
    {
        $categories = Article::groupBy('category')
            ->orderBy('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category');

        return response()->json([
            'message' => 'Categories returned successfully',
            'data' => $categories
        ], 201);
    }

    public function sources(Request $request)
    {
        $sources = Article::groupBy('source')
            ->orderBy('source')
            ->whereNotNull('source')
            ->where('source', '!=', '')
            ->pluck('source');

        return response()->json([
            'message' => 'Sources returned successfully',
            'data' => $sources
        ], 201);
    }
}
