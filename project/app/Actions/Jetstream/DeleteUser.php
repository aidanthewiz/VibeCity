<?php

namespace App\Actions\Jetstream;

use App\Models\Comment;
use App\Models\Party;
use App\Models\Rating;
use App\Models\Track;
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
        // get the users' ratings, delete them all, and adjust the track accordingly
        $ratings = Rating::query()->where('user_id', '=', $user->id)->get();
        if ($ratings != null) {
            foreach ($ratings as $rating) {
                $track = Track::query()->where('id', '=', $rating->track->id)->first();
                $track->rating = $track->rating - 1;
                $track->save();
                $rating->delete();
            }
        }

        // get the users' comments and delete them all
        $comments = Comment::query()->where('user_id', '=', $user->id)->get();
        if ($comments != null) {
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }

        // get the users' party and delete it
        $party = Party::query()->where('partyCreator', '=', $user->id)->first();
        if ($party != null) {
            $party->delete();
        }

        // delete the users' photo, tokens, accounts
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->connectedAccounts->each->delete();
        $user->delete();
    }
}
