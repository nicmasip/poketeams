<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamPokemon;
use App\Models\User;
use App\Models\Pokemon;
use App\Models\PokemonImage;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamEditRequest;
use DB;

class TeamController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('userverified');
        //$this->middleware('teambuilder', ['except' => ['index', 'create', 'store']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['teams'] = Team::all();
        $data['teampokemons'] = TeamPokemon::all();
        //$data['users'] = User::all();
        return view('team.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['teams'] = Team::all();
        $data['teampokemons'] = TeamPokemon::all();
        $data['pokemons'] = Pokemon::all();
        $data['items'] = Item::all();
        $data['visibilities'] = ['public', 'private'];
        $data['genders'] = ['Male', 'Female', 'Unknown'];
        return view('team.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamCreateRequest $request)
    {
        $data = [];
        $data['message'] = 'A new team has been created successfully.';
        $data['type'] = 'success';
        $team = new Team($request->all());
        $team->iduser = auth()->user()->id;
        DB::beginTransaction();
        try {
            $result = $team->save();
            if($request->input('pokemon') != null){
                $size = count($request->input('pokemon'));
            }
            else{
                $size = 0;
            }
            if($size <= 6 && $size >= 0){
                for($i = 0; $i < $size; $i++) {
                    $teamPokemon = new TeamPokemon();
                    $teamPokemon->idteam = $team->id;
                    $teamPokemon->idpokemon = $request->input('pokemon')[$i];
                    if($request->input('item') != [] && isset($request->input('item')[$i])){
                        $teamPokemon->iditem = $request->input('item')[$i];
                    }
                    $teamPokemon->gender = $request->input('gender')[$i];
                    $teamPokemon->level = $request->input('level')[$i];
                    $result = $teamPokemon->save();
                }
            }
            else{
                DB::rollBack();
                $result = false;
            }
        } catch(Exception $e) {
            DB::rollBack();
            $result = false;
        }
        if(!$result) {
            $data['message'] = 'The team cannot be created.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        DB::commit();
        return redirect('team')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        if($team->iduser == auth()->user()->id){
            $data = [];
            $data['team'] = $team;
            $data['teampokemons'] = TeamPokemon::all();
            $data['pokemons'] = Pokemon::all();
            $data['pokemonimages'] = PokemonImage::all();
            $data['items'] = Item::all();
            $data['visibilities'] = ['public', 'private'];
            $data['genders'] = ['Male', 'Female', 'Unknown'];
            return view('team.show')->with($data);
        }
        else{
            return redirect('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        if($team->iduser == auth()->user()->id){
            $data = [];
            $data['team'] = $team;
            $data['teampokemons'] = TeamPokemon::all();
            $data['pokemons'] = Pokemon::all();
            $data['pokemonimages'] = PokemonImage::all();
            $data['items'] = Item::all();
            $data['visibilities'] = ['public', 'private'];
            $data['genders'] = ['Male', 'Female', 'Unknown'];
            return view('team.edit')->with($data);
        }
        else{
            return redirect('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamEditRequest $request, Team $team)
    {
        if($team->iduser == auth()->user()->id){
            $data = [];
            $data['message'] = 'The team ' . $team->name . ' has been edited successfully.';
            $data['type'] = 'success';
            DB::beginTransaction();
            try {
                $result = $team->update($request->all());
                $previouslyExistingPokemon = TeamPokemon::where('idteam', $team->id)->count();
                if($request->input('pokemon') != null){
                    $newlyAddedPokemon = count($request->input('pokemon'));
                }
                else{
                    $newlyAddedPokemon = 0;
                }
                $size = $previouslyExistingPokemon + $newlyAddedPokemon;
                //dd($size);
                if($size <= 6 && $size >= 0){
                    for($i = 0; $i < $size - $previouslyExistingPokemon; $i++) {
                        $teamPokemon = new TeamPokemon();
                        $teamPokemon->idteam = $team->id;
                        $teamPokemon->idpokemon = $request->input('pokemon')[$i];
                        if($request->input('item') != [] && isset($request->input('item')[$i])){
                            $teamPokemon->iditem = $request->input('item')[$i];
                        }
                        $teamPokemon->gender = $request->input('gender')[$i];
                        $teamPokemon->level = $request->input('level')[$i];
                        $result = $teamPokemon->save();
                    }
                }
                else{
                    DB::rollBack();
                    $result = false;
                }
            } catch(Exception $e) {
                DB::rollBack();
                $result = false;
            }
            if(!$result) {
                $data['message'] = 'The team ' . $team->name . ' cannot be edited.';
                $data['type'] = 'danger';
                return back()->withInput()->with($data);
            }
            DB::commit();
            return redirect('team')->with($data);
        }
        else{
            return redirect('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if($team->iduser == auth()->user()->id){
            $data = [];
            $data['message'] = 'The team ' . $team->name . ' has been deleted successfully.';
            $data['type'] = 'success';
            try {
                $team->delete();
            } catch(\Exception $e) {
                $data['message'] = 'The team ' . $team->name . ' has NOT been deleted.';
                $data['type'] = 'danger';
            }
            return redirect('team')->with($data);
        }
        else{
            return redirect('home');
        }
    }

    public function destroyTeamPokemon($id){ // No funcionaba pasando TeamPokemon $teampokemon
        $teampokemons = TeamPokemon::all();
        $teampokemon = null;
        foreach($teampokemons as $tp){
            if($id == $tp->id){
                $teampokemon = $tp;
            }
        }
        $teams = Team::all();
        $team = null;
        foreach($teams as $t){
            if($t->id == $teampokemon->idteam){
                $team = $t;
            }
        }

        if($team->iduser == auth()->user()->id){
            $data = [];
            $data['message'] = 'The pokémon has been deleted successfully.';
            $data['type'] = 'success';
            try {
                $teampokemon->delete();
            } catch(\Exception $e) {
                $data['message'] = 'The pokémon has NOT been deleted.';
                $data['type'] = 'danger';
            }
            $data['team'] = $team;
            $data['teampokemons'] = $teampokemons;
            $data['pokemons'] = Pokemon::all();
            $data['pokemonimages'] = PokemonImage::all();
            $data['items'] = Item::all();
            $data['visibilities'] = ['public', 'private'];
            $data['genders'] = ['Male', 'Female', 'Unknown'];
            return back()->withInput()->with($data);
        }
        else{
            return redirect('home');
        }
    }
}
