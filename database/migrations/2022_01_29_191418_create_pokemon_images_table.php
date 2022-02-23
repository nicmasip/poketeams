<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon_image', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 200);
            $table->string('mimetype', 200);
            $table->bigInteger('idpokemon')->unsigned();
            $table->foreign('idpokemon')->references('id')->on('pokemon')->onUpdate('cascade')->onDelete('cascade');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon_image');
    }
}
