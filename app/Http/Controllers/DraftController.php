<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Events\CardPicked;
use App\Player;
use App\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DraftController extends Controller
{
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

    public function create()
    {
        return view('draft.create', ['sets' => Set::all()]);
    }

    public function store(Request $request)
    {
        $request->session()->remove('draft');
        $request->session()->remove('player');
        $set = Set::find($request->get('set'));

        if ($set === null) {
            // TODO message: set not found
            return  response()->redirectTo('draft/create');
        }

        $draft = Draft::create([
            'set_id' => $set->id,
            'code' => Str::random(6),
            'password' => Hash::make($request->get('password')),
        ]);

        $player = Player::create([
            'name' => $request->get('name'),
            'draft_id' => $draft->id,
            'admin' => true,
        ]);

        $request->session()->put('draft', $draft->id);
        $request->session()->put('player', $player->id);

        return response()->redirectTo('drafts/' . $draft->id);
    }

    public function update(Request $request, Draft $draft)
    {
        $player = Player::find($request->session()->get('player'));

        if ($player->draft->id !== $draft->id) {
            return null;
        }

        if (!$player->admin) {
            return null;
        }

        $draft->started = true;
        $draft->save();

        event(new CardPicked($draft));
    }

    public function delete(Request $request)
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
        event(new CardPicked($draft));
    }
}
