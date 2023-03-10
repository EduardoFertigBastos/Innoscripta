<?php

namespace Database\Seeders;

use App\Http\APIs\GuardianAPI;
use App\Http\APIs\NewsAPI;
use App\Http\APIs\NewYorkTimesAPI;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Article::get()->count() > 200) {
            return;
        }

        $this->runNews();
        $this->runTheGuardian();
        $this->runNewYorkTimes();
    }

    public function runNews()
    {
        $articles = (new NewsAPI())->buildUrl([
            'q' => 'bitcoin',
            'from' => '2023-02-21'
        ])->execute()->getArticles();

        foreach ($articles as $article) {
            NewsAPI::createArticle($article);
        }
    }

    public function runTheGuardian()
    {
        $articles = (new GuardianAPI())->buildUrl([
            'page-size'   => '100',
            'show-fields' => 'trailText,byline,firstPublicationDate,publication,thumbnail'
        ])->execute()->getArticles();

        foreach ($articles as $article) {
            GuardianAPI::createArticle($article);
        }
    }

    public function runNewYorkTimes()
    {
        $articles = (new NewYorkTimesAPI())->buildUrl([
            'q' => 'bitcoin',
        ])->execute()->getArticles();

        foreach ($articles as $article) {
            NewYorkTimesAPI::createArticle($article);
        }
    }
}
