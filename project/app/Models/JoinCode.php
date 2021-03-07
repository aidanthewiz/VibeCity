<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinCode extends Model
{
    use HasFactory;
    /**
     * Fillable for calling create([]) method
     */
    protected $fillable = [
        'code',
    ];
}
