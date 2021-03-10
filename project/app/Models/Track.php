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
        'rating'
    ];

    /**
     * Validation rules for this model
     */
    public static $rules = [
        'name' => 'required',
        'artist' => 'required',
    ];

    /**
     * Gives the track many rantings
     *
     */
    public function ratings()
    {
        // ensures tracks have many ratings
        return $this->hasMany(Rating::class);
    }

    /**
     * Calculates the sum of all the ratings for that track
     *
     */
    public function getSumRating() {
        return $this->ratings()->sum('rating');
    }
}
