<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Player;
use App\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DraftJoinController extends Controller
{
    public function create()
    {
        return view('draft.join');
    }

    public function store(Request $request)
    {
        $draft = Draft::whereCode($request->get('code'))->first();
        $player = Player::whereName($request->get('name'))->first();

        if ($draft === null || !Hash::check($request->get('password'), $draft->password)) {
            $request->session()->flash('alert-danger', 'Could not find a draft with this code / password');
            return response()->redirectTo('draft/join');
        }

        if ($draft->started) {
            $request->session()->flash('alert-danger', 'Draft already started');
            return response()->redirectTo('draft/join');
        }

        if ($player !== null) {
            $request->session()->flash('alert-danger', 'This name is already taken in this draft');
            return response()->redirectTo('draft/join');
        }

        if ($request->get('name') === null || $request->get('name') === '') {
            $request->session()->flash('alert-danger', 'Please choose a name');
            return response()->redirectTo('draft/join');
        }

        $player = Player::create([
            'name' => $request->get('name'),
            'draft_id' => $draft->id,
        ]);

        $request->session()->put('draft', $draft->id);
        $request->session()->put('player', $player->id);

        return response()->redirectTo('drafts/' . $draft->id);
    }
}
