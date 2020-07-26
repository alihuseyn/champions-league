<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'logo', 'strength', 'min_goal_in_match', 'max_goal_in_match'];

    /**
     * One to One relation with points
     * which will keep point detail of a team
     * in the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function point()
    {
        return $this->hasOne('App\Models\Point');
    }
}
