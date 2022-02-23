<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    
    protected $table = 'type';
    
    public $timestamps = false;
    
    protected $fillable = ['name', 'color', ];
    
    // protected $attributes = [];
    
    public function primaryPokemons() {
        return $this->hasMany('App\Models\Pokemon', 'idprimarytype');
    }
    
    public function secondaryPokemons() {
        return $this->hasMany('App\Models\Pokemon', 'idsecondarytype');
    }
}
