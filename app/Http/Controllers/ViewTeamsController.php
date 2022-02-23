<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamPokemon;
use App\Models\User;
use App\Models\Pokemon;
use App\Models\PokemonImage;
use App\Models\Item;

class ViewTeamsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
        $this->middleware('userverified');
    }
    
    public function index(){
        $data = [];
        $data['users'] = User::all();
        $data['teams'] = Team::all();
        $data['teampokemons'] = TeamPokemon::all();
        $data['pokemons'] = Pokemon::all();
        $data['pokemonimages'] = PokemonImage::all();
        $data['items'] = Item::all();
        $data['visibilities'] = ['public', 'private'];
        $data['genders'] = ['Male', 'Female', 'Unknown'];
        return view('viewteams.index')->with($data);
    }
    
    public function selectTeam(Request $request){
        $allTeams = Team::all();
        $teamsOfUser = [];
        foreach($allTeams as $at){
            if($at->iduser == $request->iduser){
                if($at->visibility == 'public' || auth()->user()->role == 'admin' || auth()->user()->id == $request->iduser){
                    array_push($teamsOfUser, $at);
                }
            }
        }
        return response()->json(['teams' => $teamsOfUser]);
    }
    
    public function showTeam($id){
        $teams = Team::all();
        $data = [];
        $data['users'] = User::all();
        $data['teams'] = $teams;
        $data['team'] = null;
        foreach($teams as $t){
            if($t->id == $id){
                $data['team'] = $t;
            }
        }
        $data['teampokemons'] = TeamPokemon::all();
        $data['pokemons'] = Pokemon::all();
        $data['pokemonimages'] = PokemonImage::all();
        $data['items'] = Item::all();
        $data['visibilities'] = ['public', 'private'];
        $data['genders'] = ['Male', 'Female', 'Unknown'];
        return view('viewteams.showteam')->with($data);
    }
}
