<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ArticlesController extends BaseController
{

    public function index(Request $request)
    {
        try {
            $data = Article::get();

            return response()->json([
                'message' => 'Articles returned successfully',
                'user' => $data
            ], 201);
        } catch (Exception $ex) {

            return response()->json([
                'message' => 'Impossible to return the articles list',
                'error' => $ex->getMessage()
            ], 500);
        }
    }

}
