<?php

namespace App\Http\Controllers;

use App\Models\JoinCode;
use App\Models\Party;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PartyController extends Controller
{
    /**
     * Delete the party the user leads
     * @return RedirectResponse
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
     * @param Request $request
     *
     * Join a party based on the given party code
     *
     * @return RedirectResponse
     */
    public static function joinWithCode(Request $request)
    {
        // get the join code from the request
        $partyJoinCode = $request->input('party_join_code');

        // search for this party
        $joinCodeInDB = JoinCode::query()->where('code', '=', $partyJoinCode)->first();

        // only look for the party if the join code is valid
        if($joinCodeInDB) {
            // get the party based on the join code id
            $usersParty = Party::where('joinCode', '=', $joinCodeInDB->id)->with('users')->get();

            if ($usersParty) {
                // add user to party
                $userArray = array(Auth::user());

                foreach ($usersParty as $party) {
                    if ($party->partyOpen == false) {
                        return back()->withInput();
                    }
                    $party->users()->saveMany($userArray);
                }

                // show the party page
                return back()->withInput();
            }
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

    /**
     * Create a party for the user
     *
     * @return RedirectResponse
     */
    public function createParty()
    {
        // create a party
        $party = Party::updateOrCreate([
            'partyCreator' => Auth::user()->id,
            'partyOpen' => true,
            'kickEnabled' => false,
        ]);
        $userArray = array(Auth::user());

        $party->users()->saveMany($userArray);


        // show the party page
        return back()->withInput();
    }

    /**
     * Show the user's party page
     * @return Application|Factory|View|RedirectResponse
     */
    public function show()
    {
        // retrieve user's party
        $usersParty = Party::where('id', '=', Auth::user()->party_id)->with('users')->get()->toArray();

        if (config('app.dusk_testing') != "true") {
            // retrieve user's spotify token
            $spotify_login_token = DB::table('connected_accounts')->where('user_id', '=', Auth::user()->id)->value('token');

            if (!$spotify_login_token) {
                return redirect()->route('profile.show')->with('error', 'Please connect your spotify premium account to use the party feature.');
            }
        }

        // show the party page
        return view('/party', ['party' => $usersParty]);
    }

    /**
     * Enable kick functionality
     *
     * @return RedirectResponse
     */
    public static function enableKick($party_id)
    {
        $usersParty = Party::where('id', '=', Auth::user()->party_id)->with('users')->first();
        $usersParty->kickEnabled = true;
        $usersParty->save();
        return back()->withInput();
    }

    /**
     * Disable kick functionality
     *
     * @return RedirectResponse
     */
    public static function disableKick($party_id)
    {
        $usersParty = Party::where('id', '=', Auth::user()->party_id)->with('users')->first();
        $usersParty->kickEnabled = false;
        $usersParty->save();
        return back()->withInput();
    }

    /**
     * Remove user from party
     *
     * @return RedirectResponse
     */
    public static function kickUser($user_id)
    {
        // remove party id from the user in the database
        $user = User::where('id', '=', $user_id)->first();
        $user->party_id = null;
        $user->save();

        // show the party page
        return back()->withInput();
    }
}
