<?php

namespace App\Http\Controllers;

use App\Draft;

class DraftController extends Controller
{
    public function show(Draft $draft)
    {
        return view('draft.show', ['config' => json_encode($draft->config())]);
    }
}
