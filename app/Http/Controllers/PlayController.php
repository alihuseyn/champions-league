<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\Team;
use App\Models\Match;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Exceptions\LeagueAlreadyStarted;
use App\Exceptions\LeagueAlreadyFinished;
use App\Http\Resources\PointResource;
use App\Http\Resources\MatchResource;

class PlayController extends Controller
{
    use MatchesTrait, GameTrait;

    /**
     * Fetch all available point information
     * and return as a league table
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'points' => $this->getLeagueStand(),
            'matches' => $this->getLatestWeekMatch(),
        ];

        $predictions = $this->getPredictions();
        if (!empty($predictions)) {
            $data['predictions'] =  $predictions;
        }

        return view('play', $data);
    }

    /**
     * Return latest week match points
     *
     * @return Collection of matches
     */
    protected function getLatestWeekMatch()
    {
        $count = floor(Team::count() / 2);
        return Match::where('is_played', true)->orderBy('week', 'DESC')->limit($count)->get();
    }

    /**
     * Return league stand
     *
     * @return Collection of points
     */
    protected function getLeagueStand()
    {
        return Point::with('team')
            ->orderBy('points', 'DESC')
            ->orderBy('goal_difference', 'DESC')
            ->get();
    }

    /**
     * Return predictions
     *
     * @return array
     */
    protected function getPredictions()
    {
        $match = Match::where('is_played', true)->orderBy('week', 'DESC')->first();

        if (!empty($match) && $match->week >= 4) {
            // Prediction will retrieved for the team
            $total = Point::sum('points');
            $league = $this->getLeagueStand();
            $predictions = [];
            foreach ($league as $point) {
                array_push($predictions, [
                    'week' => $match->week,
                    'team' => $point->team->name,
                    'prediction' => number_format(($point->points / $total) * 100, 1)
                ]);
            }

            return $predictions;
        }

        return null;
    }


    /**
     * Reset all league information
     * and return league stand
     *
     * @return \Illuminate\Http\Response
     */
    public function reset()
    {
        // Reset all points
        DB::table('points')->update([
            'points' => 0,
            'played' => 0,
            'won'    => 0,
            'draw'   => 0,
            'lose'  => 0,
            'goals_for' => 0,
            'goals_againts' => 0,
            'goal_difference' => 0
        ]);

        // Remove all matches
        Match::truncate();

        return response(PointResource::collection($this->getLeagueStand()));
    }

    /**
     * Play next week game and return result
     * with league stand and match results.
     * After 4th week return predictions too
     *
     * @return \Illuminate\Http\Response
     */
    public function nextWeek()
    {
        $count = floor(Team::count() / 2);
        $matches = Match::where('is_played', false)->orderBy('week')->limit($count)->get();

        if (empty($matches) || $matches->isEmpty()) {
            throw new LeagueAlreadyFinished;
        }

        for ($i = 0; $i < $matches->count(); $i++) {
            $matches[$i] = $this->playMatch($matches[$i]);
        }

        $response = [
            'league' => PointResource::collection($this->getLeagueStand()),
            'matches' => MatchResource::collection($matches),
        ];

        if ($matches[0]->week >= 4) {
            $response['predictions'] = $this->getPredictions();
        }

        return response($response, 200);
    }

    /**
     * Generate all available matches for each week
     * and play 1st week match and return general
     * information about league and match results
     *
     * @return \Illuminate\Http\Response
     */
    public function play()
    {
        $match = Match::first();

        if (empty($match)) {
            $teams = Team::all();
            // Generate Match Week for the all week and add to database
            $matches = $this->generateWeeklyRandomMatches($teams);
            DB::table('matches')->insert($matches);

            return $this->nextWeek();
        }

        throw new LeagueAlreadyStarted;
    }
}
