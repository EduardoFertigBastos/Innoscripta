<?php

namespace App\Http\APIs;

use App\Helpers\AppHelper;
use App\Models\Article;
use Illuminate\Support\Arr;

class NewsAPI extends BaseAPI
{
    public $key = '2efdd45513e04ca7bff2d258882a7d02';
    public $paramKey = 'apiKey';
    public $baseUrl = 'https://newsapi.org/v2/everything';

    public function getArticles()
    {
        return $this->data['articles'];
    }

    public static function createArticle($art)
    {
        $art = Arr::dot($art);

        return Article::create([
            'title'         => AppHelper::getArrayValue($art, 'title'),
            'description'   => AppHelper::getArrayValue($art, 'description'),
            'author'        => AppHelper::getArrayValue($art, 'author'),
            'url'           => AppHelper::getArrayValue($art, 'url'),
            'published_at'  => AppHelper::getArrayValue($art, 'publishedAt'),
            'category'      => 'crypto',
            'image'         => AppHelper::getArrayValue($art, 'urlToImage'),
            'source'        => AppHelper::getArrayValue($art, 'source.name'),
        ]);
    }
}
