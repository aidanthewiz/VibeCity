<?php

namespace App\Http\Controllers;

use App\Models\JoinCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Party;
use Illuminate\Support\Facades\Auth;


class JoinCodeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return string
     */
    public function createCode(): string
    {
        return Str::random(8);
    }
    /**
     * Create a party for the user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createJoinCode()
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
        return view('/party', ['party' => $usersParty]);
    }
}
