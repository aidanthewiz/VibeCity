<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Input;

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

//    /**
//     * Gives the party many users
//     *
//     */
//    public function users()
//    {
//        // ensures tracks have many ratings
//        return $this->hasMany(User::class);
//    }

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

    /**
     * @param Request $request
     * Join a party based on the given party code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function joinWithCode(Request $request)
    {
        $partyJoinCode = json_decode($request->getContent(), true);

        // search for this party
        $usersParty = Party::query()->where('joinCode', '=', $partyJoinCode)->get()->toArray();

        if($usersParty){
            return view('/party', ['party' => $usersParty]);
        }
        return back();
    }

}
