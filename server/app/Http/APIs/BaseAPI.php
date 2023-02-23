<?php

namespace App\Http\APIs;

use Illuminate\Support\Facades\Http;
use NullArray;

abstract class BaseAPI
{
    public $key;
    public $paramKey;
    public $baseUrl;
    public $url;

    public $data;

    public function buildUrl($queries)
    {
        $this->url = $this->baseUrl.'?'.http_build_query(
            array_merge(
                $queries,
                [$this->paramKey => $this->key]
            )
        );

        return $this;
    }

    public function execute()
    {
        $this->data = Http::get($this->url ?? $this->baseUrl)->json();

        return $this;
    }

}
