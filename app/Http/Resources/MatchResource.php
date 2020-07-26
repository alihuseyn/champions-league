<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'home' => new TeamResource($this->home),
            'away' => new TeamResource($this->away),
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
            'week' => $this->week
        ];
    }
}
