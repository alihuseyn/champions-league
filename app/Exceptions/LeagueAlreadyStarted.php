<?php

namespace App\Exceptions;

use Exception;

class LeagueAlreadyStarted extends Exception
{
    public function render($request)
    {
        return response([ 'error' => trans('play.league_already_started')], 400);
    }
}
