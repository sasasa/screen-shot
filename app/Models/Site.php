<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Site extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'url',
        'title',
        'description',
        'mode_color',
        'second_color',
        'third_color',
        'darkest_color',
        'brightest_color',
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
            get: fn($value, $attributes) => parse_url($attributes['url'])['host']. ".jpeg",
        );
    }
}
