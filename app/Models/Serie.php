<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'synopsis', 'episodes', 'release_date',
        'publisher_id', 'user_id', 'active',
    ];

    protected $casts = [
        'release_date' => 'date',
        'episodes' => 'integer',
        'active' => 'boolean',
    ];

    public function publisher()
    {
        return $this->belongsTo(\App\Models\Publisher::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
