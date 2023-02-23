<?php

namespace App\Http\APIs;

use App\Models\Article;
use App\Helpers\AppHelper;
use Illuminate\Support\Arr;

class NewYorkTimesAPI extends BaseAPI
{
    public $key = 'xe3GGcowzJEAsZhAN6fekG65WDCAr60A';
    public $paramKey = 'api-key';
    public $baseUrl = 'https://api.nytimes.com/svc/search/v2/articlesearch.json';

    public function getArticles()
    {
        return $this->data['response']['docs'];
    }

    public static function correctingImage($image)
    {
        return 'https://www.nytimes.com/'.$image;
    }

    public static function createArticle($art)
    {
        $art = Arr::dot($art);

        return Article::create([
            'title'         => AppHelper::getArrayValue($art, 'headline.main'),
            'description'   => AppHelper::getArrayValue($art, 'abstract'),
            'author'        => AppHelper::getArrayValue($art, 'byline.original'),
            'url'           => AppHelper::getArrayValue($art, 'web_url'),
            'published_at'  => AppHelper::getArrayValue($art, 'pub_date'),
            'category'      => AppHelper::getArrayValue($art, 'section_name'),
            'source'        => AppHelper::getArrayValue($art, 'source'),
            'image'         => self::correctingImage(
                AppHelper::getArrayValue($art, 'multimidia.0.type') === 'image'
                    ? AppHelper::getArrayValue($art, 'multimidia.0.url')
                    : null
            ),
        ]);
    }
}
