<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartyController extends Controller
{
    /**
     * Create a party for the user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createParty()
    {
        // create a party
        Party::updateOrCreate([
            'partyCreator' => Auth::user()->id,
            'partyOpen' => true,
        ]);

        // show the party page
        return back()->withInput();
    }

    /**
     * Show the user's party page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        // retrieve user's party
        $usersParty = Party::where('partyCreator', Auth::user()->id)->get()->toArray();

        // show the party page
        return view('/party', ['party' => $usersParty]);
    }
}
