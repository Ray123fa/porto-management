<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pat_id',
        'token',
    ];

    /**
     * Relasi ke tabel personal_access_tokens (parent).
     */
    public function personalAccessToken()
    {
        return $this->belongsTo(PersonalAccessToken::class, 'pat_id');
    }

    public function user()
    {
        return $this->personalAccessToken->belongsTo(User::class, 'tokenable_id');
    }
}
