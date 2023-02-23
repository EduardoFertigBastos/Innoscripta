<?php

namespace App\Http\APIs;

use App\Models\Article;
use App\Helpers\AppHelper;
use Illuminate\Support\Arr;

class GuardianAPI extends BaseAPI
{

    public $key = '6eefa2f4-a575-429e-acbf-a6c905261f71';
    public $paramKey = 'api-key';
    public $baseUrl = 'https://content.guardianapis.com/search';

    public function getArticles()
    {
        return $this->data['response']['results'];
    }

    public static function correctingSource($source)
    {
        return $source === 'theguardian.com'
            ? 'The Guardian'
            : $source;
    }

    public static function createArticle($art)
    {
        $art = Arr::dot($art);

        return Article::create([
            'title'         => AppHelper::getArrayValue($art, 'webTitle'),
            'description'   => AppHelper::getArrayValue($art, 'fields.trailText'),
            'author'        => AppHelper::getArrayValue($art, 'fields.byline'),
            'url'           => AppHelper::getArrayValue($art, 'webUrl'),
            'published_at'  => AppHelper::getArrayValue($art, 'fields.firstPublicationDate'),
            'category'      => AppHelper::getArrayValue($art, 'sectionName'),
            'image'         => AppHelper::getArrayValue($art, 'fields.thumbnail'),
            'source'        => self::correctingSource(
                AppHelper::getArrayValue($art, 'fields.publication'),
            ),
        ]);
    }
}
