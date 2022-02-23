<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamPokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_pokemon', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idteam')->unsigned();
            $table->foreign('idteam')->references('id')->on('team')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('idpokemon')->unsigned();
            $table->foreign('idpokemon')->references('id')->on('pokemon')->onUpdate('cascade');
            $table->bigInteger('iditem')->unsigned()->nullable();
            $table->foreign('iditem')->references('id')->on('item')->onUpdate('cascade');
            $gender = [
                'Male', 
                'Female', 
                'Unknown'
            ];
            $table->enum('gender', $gender);
            $table->tinyInteger('level');
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
        Schema::dropIfExists('team_pokemon');
    }
}
