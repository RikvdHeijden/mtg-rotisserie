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

        if ($draft === null) {
            // TODO error message: no such draft
            return response()->redirectTo('draft/join');
        }

        if ($draft->started) {
            // TODO error message: cannot join a draft that already started
            return response()->redirectTo('draft/join');
        }

        if (!Hash::check($request->get('password'), $draft->password)) {
            // TODO error message: wrong password
            return response()->redirectTo('draft/join');
        }

        if ($player !== null) {
            // TODO error message: player with this name already exists in draft
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
