<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory;
    
    protected $table = 'ability';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'description', ];
    
    // protected $attributes = [];
    
    public function pokemons() {
        return $this->hasMany('App\Models\Pokemon', 'idability');
    }
}
