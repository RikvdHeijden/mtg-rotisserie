<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Player;
use App\Set;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function index()
    {
        $sets = Set::all();
        return view('draft.join', ['sets' => $sets]);
    }

    public function show(Request $request, Draft $draft)
    {
        $code_draft = Draft::find($request->session()->get('draft'));
        if ($code_draft === null || $code_draft->id !== $draft->id) {
            // TODO error message
            return response()->redirectTo('draft/join');
        }

        $player = Player::find($request->session()->get('player'));
        if ($player === null) {
            // TODO error message
            return response()->redirectTo('draft/join');
        }

        if ($request->acceptsJson() && !$request->acceptsHtml()) {
            return json_encode([
                'config' => $draft->config(),
                'player' => $player->config()
            ]);
        }

        return view('draft.show', [
            'config' => json_encode($draft->config()),
            'player' => json_encode($player->config())
        ]);
    }

    public function store(Request $request)
    {
        $draft = Draft::whereCode($request->get('code'))->first();
        $set = Set::find($request->get('set'));
        $player = Player::whereName($request->get('name'))->first();

        if ($player !== null) {
            // TODO error message
            // TODO is this an attempt to rejoin?
            //return response()->redirectTo('draft/join');
        }

        if ($draft === null) {
            if ($set === null) {
                // TODO error message
                return response()->redirectTo('draft/join');
            }

            $draft = Draft::create([
                'code' => $request->get('code'),
                'set_id' => $set->id,
            ]);
        }

        if ($set !== null && $draft->set->id !== $set->id) {
            // TODO error message
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

    public function update(Request $request)
    {
        $player = Player::find($request->session()->get('player'));
        $draft = Draft::whereCode($request->get('code'))->first();

        if ($player) {
            if ($draft && $draft->currentPlayer()->id === $player->id) {
                $draft->proceedToNextPlayer();
            }

            $player->active = false;
            $player->save();
        }

        $request->session()->remove('draft');
        $request->session()->remove('player');
    }
}
