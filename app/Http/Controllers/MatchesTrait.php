<?php

namespace App\Http\Controllers;

trait MatchesTrait
{

    /**
     * Check Whether given pairs equal or not
     *
     * @param  array  $pair_1 Matched 1st Pair
     * @param  array  $pair_2 Matched 2nd Pair
     *
     * @return boolean
     */
    protected function isPairsIntersect($pair_1, $pair_2)
    {
        return $pair_1[0]->id == $pair_2[0]->id
            || $pair_1[0]->id == $pair_2[1]->id
            || $pair_1[1]->id == $pair_2[0]->id
            || $pair_1[1]->id == $pair_2[1]->id;
    }

    /**
     * Generate match result according to the
     * given team strength
     *
     * @param App\Models\Team $team_1 Team Home
     * @param App\Models\Team $team_2 Team Away
     *
     * @return array
     */
    public function generateMatchResult($team_1, $team_2)
    {
        $score_for_home = ceil(
            ($team_1->strength / $team_2->strength) *
                rand($team_1->min_goal_in_match, $team_1->max_goal_in_match)
        );

        $score_for_away = floor(
            ($team_2->strength / $team_1->strength) *
                rand($team_2->min_goal_in_match, $team_2->max_goal_in_match)
        );

        return [
            'home_team_score' => $score_for_home,
            'away_team_score' => $score_for_away
        ];
    }

    /**
     * Generate Random matches from the given teams data
     *
     * @param Collection $teams All available teams
     *
     * @return array
     */
    public function generateWeeklyRandomMatches($teams)
    {
        // Generate available all pairs
        $pairs = [];
        for ($i = 0; $i < count($teams); $i++) {
            for ($j = 0; $j < count($teams); $j++) {
                if ($teams[$i]->id != $teams[$j]->id) {
                    array_push($pairs, [$teams[$i], $teams[$j]]);
                }
            }
        }

        // Generate weekly random matches from pairs
        $matches = [];
        $week = 1;
        while (count($pairs) != 0) {
            $index_1 = array_rand($pairs);
            $pair_1 = $pairs[$index_1];
            array_splice($pairs, $index_1, 1);

            for ($j = 0; $j < count($pairs); $j++) {
                if (!$this->isPairsIntersect($pair_1, $pairs[$j])) {
                    $index_2 = $j;
                    $pair_2 = $pairs[$index_2];

                    array_splice($pairs, $index_2, 1);
                    $matches = array_merge($matches, [
                        [
                            'home_team_id' => $pair_1[0]->id,
                            'away_team_id' => $pair_1[1]->id,
                            'week' => $week,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ],
                        [
                            'home_team_id' => $pair_2[0]->id,
                            'away_team_id' => $pair_2[1]->id,
                            'week' => $week,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]
                    ]);
                    $week += 1;
                    break;
                }
            }
        }

        return $matches;
    }
}
