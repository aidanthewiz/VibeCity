<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    /**
     * Fillable for calling create([]) method
     */
    protected $fillable = [
        'partyCreator',
        'joinCode',
        'partyOpen',
        'users',
        'kickEnabled',
    ];

    /**
     * Gives the party many users
     *
     */
    public function users()
    {
        // ensures tracks have many ratings
        return $this->hasMany(User::class);
    }
}
