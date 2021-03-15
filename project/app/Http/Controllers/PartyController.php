<?php

namespace App\Http\Controllers;

use App\Models\JoinCode;
use App\Models\Party;
use App\Models\User;
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
        $party = Party::updateOrCreate([
            'partyCreator' => Auth::user()->id,
            'partyOpen' => true,
        ]);
        $userArray = array(Auth::user());

        $party->users()->saveMany($userArray);



        // show the party page
        return back()->withInput();
    }

    /**
     * Delete the party the user leads
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function deleteParty($partyID)
    {
        // retrieve user's party
        $usersParty = Party::where('id', '=', $partyID)->first();
        $usersParty->delete();

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
        $usersParty = Party::where('id', '=', Auth::user()->party_id)->with('users')->get()->toArray();

        // show the party page
        return view('/party', ['party' => $usersParty]);
    }

    /**
     * @param Request $request
     *
     * Join a party based on the given party code
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function joinWithCode(Request $request)
    {
        // get the join code from the request
        $partyJoinCode = $request->input('party_join_code');

        // search for this party
        $joinCodeInDB = JoinCode::query()->where('code', '=', $partyJoinCode)->first();

        // get the party based on the join code id
        $usersParty = Party::where('joinCode', '=', $joinCodeInDB->id)->with('users')->get();

        if($usersParty){
            // add user to party
            $userArray = array(Auth::user());

            foreach($usersParty as $party){
                if($party->partyOpen == false)
                {
                    return back()->withInput();
                }
                $party->users()->saveMany($userArray);
            }

            // show the party page
            return back()->withInput();
        }

        // failed to find a party with the specified code
        return back()->withInput();

    }
    public static function openParty($party_id)
    {
        $party = Party::where('id', '=', $party_id)->first();
        $party->partyOpen = true;
        $party->save();
        return back()->withInput();

    }
    public static function closeParty($party_id)
    {
        $party = Party::where('id', '=', $party_id)->first();
        $party->partyOpen = false;
        $party->save();
        return back()->withInput();
    }
}
