<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserSetting extends Model
{
    const DEFAULT_SETTINGS_ARRAY = [
        'fav_categories' => [],
        'fav_sources' => [],
        'fav_authors' => [],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'settings',
        'user_id',
    ];

    /**
     * Get the user that owns the settings.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return default settings
     *
     * @return void
     */
    public static function defaultSettings($encoded = true)
    {
        if ($encoded) {
            return json_encode(self::DEFAULT_SETTINGS_ARRAY);
        }

        return self::DEFAULT_SETTINGS_ARRAY;
    }

    // create an acessor to return the settings as an object
    public function getSettingsFormattedAttribute()
    {
        return json_decode($this->attributes['settings']);
    }
}
