<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Events\SiteCreated;

class Site extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => SiteCreated::class
        //saved
    ];

    protected $fillable = [
        'production_id',
        'url',
        'title',
        'description',
        'body',
        'vibrant',
        'dark_vibrant',
        'light_vibrant',
        'muted',
        'dark_muted',
        'light_muted',
        // 'mode_color',
        // 'second_color',
        // 'third_color',
        // 'darkest_color',
        // 'brightest_color',
    ];

    protected function domain(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => parse_url($attributes['url'])['host'],
        );
    }
    protected function imgsrc(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => rawurlencode(str_replace('=', '', str_replace('?', '', str_replace(':', '', str_replace('/', '_', $attributes['url'])))). ".webp"),
        );
    }
    public function site_colors() {
        return $this->hasMany('App\Models\SiteColor', 'site_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'site_tag', 'site_id', 'tag_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'site_user', 'site_id', 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'site_id', 'id');
    }

    public function production()
    {
        return $this->belongsTo('App\Models\Production', 'production_id', 'id');
    }

    public function inquiries()
    {
        return $this->hasMany('App\Models\Inquiry', 'site_id', 'id');
    }
}
