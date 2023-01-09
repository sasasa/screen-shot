<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Production extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = [
        'id',
    ];
    protected $dates = [
        'deleted_at',
        'confirm_at',
        'lock_at',
    ];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public static function createWithUrl($data)
    {
        $result = array_merge($data, [
            'register_url' => uniqid('', true),
            'pass_update_date' => now(),
            'password' => Hash::make($data['password'])
        ]);
        return self::create($result);
    }
}
