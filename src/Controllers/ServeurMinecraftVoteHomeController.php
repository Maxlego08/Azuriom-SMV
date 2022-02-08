<?php

namespace Azuriom\Plugin\ServeurMinecraftVote\Controllers;

use Azuriom\Http\Controllers\Controller;

class ServeurMinecraftVoteHomeController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('serveurminecraftvote::index');
    }
}
