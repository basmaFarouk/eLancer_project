<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    protected $hidden=['password']; //عشان اظهر التوكين

    protected $fillable=[
        'name','token','abilities','ip_address','fcm_token'
    ];
}
