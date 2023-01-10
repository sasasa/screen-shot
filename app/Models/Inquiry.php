<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Inquiry extends Model
{
    use HasFactory;

    public const PHONE = 1;
    public const MAIL = 2;

    public const TYPES = [
        self::PHONE => '電話',
        self::MAIL => 'メール',
    ];

    protected $fillable = [
        'site_id',
        'production_id',
        'type',
    ];

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }

    public function production()
    {
        return $this->belongsTo('App\Models\Production');
    }

    protected function typeName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => self::TYPES[$attributes['type']],
        );
    }
}
