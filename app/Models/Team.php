<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
    protected $table = 'team';
    
    // public $timestamps = false;
    
    //protected $fillable = ['name', 'iduser', 'favorite', ];
    
    protected $fillable = ['name', 'iduser', 'visibility', ];
    
    //protected $attributes = [];
    
    public function users() {
        return $this->belongsTo('App\Models\User', 'iduser');
    }
    
    public function team_pokemons() {
        return $this->hasMany('App\Models\TeamPokemon', 'idteam');
    }
}
