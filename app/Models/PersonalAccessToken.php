<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * Relasi ke tabel tokens (child).
     */
    public function tokens()
    {
        return $this->hasMany(Token::class, 'pat_id');
    }
}
