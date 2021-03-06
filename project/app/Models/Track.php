<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    /**
    * Fillable for calling create([]) method
    */
    protected $fillable = [
        'name',
        'artist',
    ];

    /**
     * Validation rules for this model
     */
    public static $rules = [
        'name' => 'required',
        'artist' => 'required',
    ];
}
