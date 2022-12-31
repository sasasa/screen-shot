<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sites()
    {
        return $this->belongsToMany('App\Models\Site', 'site_tag', 'tag_id', 'site_id');
    }
}
