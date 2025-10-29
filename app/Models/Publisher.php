<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publisher extends Model
{
    use HasFactory;

    // Als je mass assignment gebruikt:
    protected $fillable = ['name', 'active'];

    // Relaties
    public function series()
    {
        return $this->hasMany(Serie::class);
    }
}
