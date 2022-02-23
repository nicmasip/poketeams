<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->unique();
            $table->bigInteger('idability')->unsigned();
            $table->bigInteger('idprimarytype')->unsigned();
            $table->bigInteger('idsecondarytype')->unsigned()->nullable();
            
            $table->foreign('idsecondarytype')->references('id')->on('type')->onUpdate('cascade');
            $table->foreign('idprimarytype')->references('id')->on('type')->onUpdate('cascade');
            $table->foreign('idability')->references('id')->on('ability')->onUpdate('cascade');
            // $types = [
            //     'Normal',
            //     'Fighting',
            //     'Flying',
            //     'Poison',
            //     'Ground',
            //     'Rock',
            //     'Bug',
            //     'Ghost',
            //     'Steel',
            //     'Fire',
            //     'Water',
            //     'Grass',
            //     'Electric',
            //     'Psychic',
            //     'Ice',
            //     'Dragon',
            //     'Dark',
            //     'Fairy'
            // ];
            // $table->enum('primarytype', $types);
            // $table->enum('secondarytype', $types)->nullable();
            $table->decimal('height', 9, 1)->default(0);
            $table->decimal('weight', 9, 1)->default(0);
            $regions = [
                'Kanto',
                'Johto',
                'Hoenn',
                'Sinnoh',
                'Unova',
                'Kalos',
                'Alola',
                'Galar',
                'Hisui'
            ];
            $table->enum('region', $regions);
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
        Schema::dropIfExists('pokemon');
    }
}
