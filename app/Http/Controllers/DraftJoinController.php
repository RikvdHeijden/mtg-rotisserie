<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Player;
use App\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DraftJoinController extends Controller
{
    public function create(Request $request)
    {
        $draft_code = null;

        if ($request->has('draft_id')) {
            $draft = Draft::where('code', $request->get('draft_id'))->first();
            if ($draft) {
                $draft_code = $draft->code;
            }
        }

        return view('draft.join', ['draft_code' => $draft_code]);
    }

    public function store(Request $request)
    {
        $draft = Draft::whereCode($request->get('code'))->first();

        if ($draft === null) {
            $request->session()->flash('alert-danger', 'Could not find a draft with this code');
            return response()->redirectTo('draft/join');
        }

        $player = $draft->players()->whereName($request->get('name'))->first();

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

        return response()->redirectTo('drafts/' . $draft->code);
    }
}
