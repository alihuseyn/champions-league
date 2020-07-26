<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PointResource extends JsonResource
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
            'points' => $this->points,
            'played' => $this->played,
            'won'   => $this->won,
            'draw'  => $this->draw,
            'lose'  => $this->lose,
            'goal_difference' => $this->goal_difference,
            'team' => new TeamResource($this->team)
        ];
    }
}
