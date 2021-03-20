<?php

namespace App\Http\Controllers;

use App\Models\JoinCode;
use App\Models\Party;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class JoinCodeController extends Controller
{
    /**
     * Create a party for the user
     *
     * @return RedirectResponse
     */
    public function createJoinCode(): RedirectResponse
    {
        $joinCode = JoinCode::create([
            'code' => $this->createCode()
        ]);

        // retrieve the user's party
        $usersParty = Party::where('partyCreator', Auth::user()->id)->get()[0];
        $usersParty->joinCode = $joinCode->id;
        $usersParty->save();
        $usersParty = Party::where('partyCreator', Auth::user()->id)->get()->toArray();

        // show the party page
        return back()->withInput();
    }

    /**
     * Create a random uppercase code of length 8
     *
     * @return string
     */
    public function createCode(): string
    {
        return Str::upper(Str::random(8));
    }
}
