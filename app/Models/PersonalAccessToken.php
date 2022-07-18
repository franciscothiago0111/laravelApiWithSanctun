<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\PersonalAccessToken as Model;



//use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expired_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expired_at'
    ];

    protected function isValidAccessToken($accessToken): bool
{
    if (! $accessToken) {
        return false;
    }

    print_r($this->expiration);exit;

    $isValid =
        (! $this->expiration || $accessToken->created_at->gt(now()->subMinutes($this->expiration)))
        && $this->hasValidProvider($accessToken->tokenable);

    if (is_callable(Sanctum::$accessTokenAuthenticationCallback)) {
        $isValid = (bool) (Sanctum::$accessTokenAuthenticationCallback)($accessToken, $isValid);
    }

  

    return $isValid;
}
}
