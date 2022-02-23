<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonImage extends Model
{
    use HasFactory;
    
    protected $table = 'pokemon_image';
    
    public $timestamps = false;
    
    protected $fillable = ['filename', 'mimetype', 'idpokemon', ];
    
    //protected $attributes = [];
    
    public function pokemon() {
        return $this->belongsTo('App\Models\Pokemon', 'idpokemon');
    }
}
