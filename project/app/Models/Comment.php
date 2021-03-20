<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'user_id',
        'track_id',
    ];

    /**
     * Ensures the comment is a part of a track
     *
     */
    public function track()
    {
        // ensures comments belong to tracks
        return $this->belongsTo(Track::class);
    }

    /**
     * Ensures the comment is a part of a user
     *
     */
    public function user()
    {
        // ensures comments belong to tracks
        return $this->belongsTo(User::class);
    }
}
