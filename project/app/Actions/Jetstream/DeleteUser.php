<?php

namespace App\Actions\Jetstream;

use App\Models\Rating;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        $ratings = Rating::query()->where('user_id', '=', $user->id)->get();

        foreach($ratings as $rating) {
            $track = Track::query()->where('id', '=', $rating->track->id)->first();
            $track->rating = $track->rating - 1;
            $track->save();
            $rating->delete();
        }

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->connectedAccounts->each->delete();
        $user->delete();
    }
}
