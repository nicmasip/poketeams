<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPokemon extends Model
{
    use HasFactory;
        
    protected $fillable = ['idteam', 'idpokemon', 'iditem', 'gender', 'level', ];
    
    protected $attributes = ['level' => 1, ];
    
    public function team() {
        return $this->belongsTo('App\Models\Team', 'idteam');
    }
    
    public function pokemon() {
        return $this->belongsTo('App\Models\Pokemon', 'idpokemon');
    }
    
    public function item() {
        return $this->belongsTo('App\Models\Item', 'iditem');
    }
}
