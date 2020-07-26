<?php

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Point;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [ 'name' => 'Arsenal' ],
            [ 'name' => 'Chelsea' ],
            [ 'name' => 'Manchester United'],
            [ 'name' => 'Liverpool']
        ];

        foreach ($teams as $detail) {
            $team = factory(Team::class)->make(['name' => $detail['name']]);
            $team->save();
            $team->point()->save(new Point);
        }
    }
}
