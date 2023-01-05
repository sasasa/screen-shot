<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTag extends Model
{
    use HasFactory;

    protected $table = 'site_tag';

    protected $fillable = [
        'site_id',
        'tag_id',
    ];
}
