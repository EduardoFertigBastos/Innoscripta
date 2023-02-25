<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'author',
        'category',
        'url',
        'published_at',
        'source',
        'image',
    ];

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = strtolower($value);
    }

    public static function buildQueryCustomizeConditions($query, Request $request)
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

    public static function buildQueryConditions($query, Request $request)
    {
        try {
            $query = Article::buildQueryCustomizeConditions($query, $request);

            if ($request->has('keyword')) {
                $query->where(function ($query) use ($request) {
                    $query->orWhere('title', 'ilike', '%' . $request->keyword . '%');
                    $query->orWhere('description', 'ilike', '%' . $request->keyword . '%');
                });
            }

            if ($request->has('category')) {
                $query->where('category', 'ilike', '%' . $request->category . '%');
            }

            if ($request->has('source')) {
                $query->where('source', 'ilike', '%' . $request->source . '%');
            }

            if ($request->has('from')) {
                $query->where('published_at', '>=', $request->from);
            }

            return $query;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public static function authors()
    {
        return Article::groupBy('author')
            ->orderBy('author')
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->pluck('author');
    }

    public static function categories()
    {
        return Article::groupBy('category')
            ->orderBy('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category');
    }

    public static function sources()
    {
        return Article::groupBy('source')
            ->orderBy('source')
            ->whereNotNull('source')
            ->where('source', '!=', '')
            ->pluck('source');
    }
}
