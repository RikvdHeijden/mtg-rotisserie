<?php

namespace App\Http\Controllers;

use App\Draft;

class DraftController extends Controller
{
    public function show(Draft $draft)
    {
        return view('draft.show', ['draft' => $draft]);
    }
}
