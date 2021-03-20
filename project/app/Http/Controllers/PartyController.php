<?php

namespace App\Http\Controllers;

use App\Models\JoinCode;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

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
     * Delete a user from a party if they want to leave
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function leaveParty()
    {
        // remove party id from the user in the database
        Auth::user()->party_id = null;
        Auth::user()->save();

        // show the party page
        return back()->withInput();
    }

    /**
     * Show the user's party page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public static function show()
    {
        // retrieve user's party
        $usersParty = Party::where('id', '=', Auth::user()->party_id)->with('users')->get()->toArray();

        // ignore the spotify requirement when running dusk tests
        if(config('app.dusk_testing') != "true"){
            // retrieve user's spotify token
            $spotify_login_token = DB::table('connected_accounts')->where('user_id', '=', Auth::user()->id)->value('token');
            if ($spotify_login_token) {
                $spotify_token = (array)Socialite::driver('spotify')->scopes(["streaming", "user-read-email", "user-read-private"])->userFromToken($spotify_login_token);
            } else {
                return redirect()->route('profile.show')->with('error', 'Please connect your spotify premium account to use the party feature.');
            }
        }

        // show the party page
        return view('/party', ['party' => $usersParty, 'spotify_token' => $spotify_token['token'] ?? '']);
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
