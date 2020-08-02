<?php

namespace App\Http\Controllers;

use App\Draft;
use Illuminate\Http\Request;

class PickController extends Controller
{
    public function store(Request $request, Draft $draft)
    {
        $draft->proceedToNextPlayer();
        return $draft->config();
    }
}
