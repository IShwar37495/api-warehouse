<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;

class ClientUser extends Model
{
    protected $fillable=['client_id', 'email', 'password', 'name', 'phone', 'address', 'company', 'age', 'access_token','refresh_token'];


    public  function generateAccessToken($userId)
{
    $payload = [
        'sub' => $userId,
        'iat' => Carbon::now()->timestamp,
        'exp' => Carbon::now()->addMinutes(60)->timestamp,
    ];

    return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
}

public function generateRefreshToken($userId)
{
    $payload = [
        'sub' => $userId,
        'iat' => Carbon::now()->timestamp,
        'exp' => Carbon::now()->addDays(15)->timestamp,
    ];

    return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
}

}
