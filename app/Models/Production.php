<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;

class Production extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, MustVerifyEmail;

    protected $guarded = [
        'id',
    ];
    protected $dates = [
        'deleted_at',
        'confirm_at',
        'lock_at',
        'email_verified_at',
        'pass_update_date',
        'deleted_at',
    ];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
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
