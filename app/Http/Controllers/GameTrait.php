<?php

namespace App\Http\Controllers;

trait GameTrait
{
    /**
     * Play a match update all points and return match back
     *
     * @param App\Models\Match $match
     *
     * @return App\Models\Match
     */
    public function playMatch($match)
    {
        $result = $this->generateMatchResult($match->home, $match->away);
        $match->home_team_score = $result['home_team_score'];
        $match->away_team_score = $result['away_team_score'];
        $match->is_played = true;

        // Update Points
        $home_point = $match->home->point;
        $away_point = $match->away->point;

        $home_point->played += 1;
        $away_point->played += 1;

        $home_point->goals_againts += $result['home_team_score'];
        $home_point->goals_for += $result['away_team_score'];
        $home_point->goal_difference = $home_point->goals_againts - $home_point->goals_for;

        $away_point->goals_againts += $result['away_team_score'];
        $away_point->goals_for += $result['home_team_score'];
        $away_point->goal_difference = $away_point->goals_againts - $away_point->goals_for;



        if ($result['home_team_score'] > $result['away_team_score']) {
            $home_point->won += 1;
            $home_point->points += 3;
            $away_point->lose += 1;
        } elseif ($result['home_team_score'] < $result['away_team_score']) {
            $home_point->lose += 1;
            $away_point->won += 1;
            $away_point->points += 3;
        } else {
            $home_point->draw += 1;
            $home_point->points += 1;
            $away_point->points += 1;
            $away_point->draw += 1;
        }

        $home_point->save();
        $away_point->save();
        $match->save();

        return $match;
    }
}
