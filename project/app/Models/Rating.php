<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating',
        'user_id',
        'track_id',
    ];

    /**
     * Ensures the rating is a part of a track
     *
     */
    public function track()
    {
        // ensures ratings belong to tracks
        return $this->belongsTo(Track::class);
    }

    /**
     * Ensures the rating is a part of a user
     *
     */
    public function user()
    {
        // ensures ratings belong to tracks
        return $this->belongsTo(User::class);
    }
}
