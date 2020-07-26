<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'week',
        'is_played'
    ];


    /**
     * Many to One relation.
     * Match home belong to a team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function home()
    {
        return $this->belongsTo('App\Models\Team', 'home_team_id', 'id');
    }

    /**
     * Many to One relation.
     * Match away belong to a team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function away()
    {
        return $this->belongsTo('App\Models\Team', 'away_team_id', 'id');
    }
}
