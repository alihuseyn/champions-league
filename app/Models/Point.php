<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points',
        'played',
        'won',
        'draw',
        'lose',
        'goals_againts',
        'goals_for',
        'goal_difference'
    ];


    /**
     * One to One relation with teams
     * which will keep team information
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function team()
    {
        return $this->hasOne('App\Models\Team', 'id', 'team_id');
    }
}
