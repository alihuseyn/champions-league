<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('home_team_id');
            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('away_team_id');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('home_team_score')->default(0);
            $table->unsignedInteger('away_team_score')->default(0);
            $table->unsignedInteger('week')->default(1);
            $table->boolean('is_played')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
