<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'name' => $this->name,
            'logo' => $this->logo,
            'strength' => $this->strength,
            'min_goal_in_match' => $this->min_goal_in_match,
            'max_goal_in_match' => $this->max_goal_in_match
        ];
    }
}
