<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Pick;
use Illuminate\Http\Request;

class PickController extends Controller
{
    public function store(Request $request, Draft $draft)
    {
        Pick::create([
            'card_id' => $request->get('id'),
            'player_id' => $draft->currentPlayer()->id,
            'draft_id' => $draft->id,
        ]);

        $draft->proceedToNextPlayer();
        return $draft->config();
    }
}
