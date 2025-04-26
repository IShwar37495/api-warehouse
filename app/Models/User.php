<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'google_id',
        'client_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function createToken(string $name, array $abilities = ['read'])
    // {
    //     return parent::createToken($name, $abilities);
    // }


public function roles()
{
    return $this->belongsToMany(Role::class, 'user_role');
}



  public function assignRole($role)
{
    $role = strtolower($role);
    $role = Role::where('name', $role)->first();
    if ($role) {
        $this->roles()->attach($role->id);
    }
}

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

public function chats()
{
    return $this->belongsToMany(Chat::class);
}


}
