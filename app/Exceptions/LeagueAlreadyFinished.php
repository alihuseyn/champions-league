<?php

namespace App\Exceptions;

use Exception;

class LeagueAlreadyFinished extends Exception
{
    public function render($request)
    {
        return response([ 'error' => trans('play.league_already_finished')], 400);
    }
}
