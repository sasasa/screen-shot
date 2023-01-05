<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'site_id',
        'subject',
        'message',
    ];

    public function site()
    {
        return $this->belongsTo('App\Models\Site', 'site_id', 'id');
    }
}
