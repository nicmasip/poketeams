<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'idability', 'idprimarytype', 'idsecondarytype', 'height', 'weight', 'region', ];
    
    protected $attributes = ['height' => 0, 'weight' => 0, ];
    
    
    /*
    $table->foreign('idsecondarytype')->references('id')->on('type')->onUpdate('cascade');
    $table->foreign('idprimarytype')->references('id')->on('type')->onUpdate('cascade');
    $table->foreign('idability')->references('id')->on('ability')->onUpdate('cascade');
    */

    public function pokemon_image() {
        return $this->hasOne('App\Models\Pokemon', 'idpokemon');
    }
    
    public function team_pokemons() {
        return $this->hasMany('App\Models\TeamPokemon', 'idpokemon');
    }
    
    public function ability() {
        return $this->belongsTo('App\Models\Ability', 'idability');
    }
    
    public function primaryType() {
        return $this->belongsTo('App\Models\Type', 'idprimarytype');
    }
    
    public function secondaryType() {
        return $this->belongsTo('App\Models\Type', 'idsecondarytype');
    }
    
}
