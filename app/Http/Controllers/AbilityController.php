<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use App\Models\Pokemon;
use App\Models\PokemonImage;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Requests\AbilityCreateRequest;
use App\Http\Requests\AbilityEditRequest;

class AbilityController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('userverified');
        $this->middleware('advanced', ['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['abilities'] = Ability::all();
        return view('ability.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ability.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbilityCreateRequest $request)
    {
        $data = [];
        $data['message'] = 'A new ability has been inserted successfully.';
        $data['type'] = 'success';
        $ability = new Ability($request->all());
        try {
            $result = $ability->save();
        } catch(Exception $e) {
            $result = false;
        }
        if(!$result) {
            $data['message'] = 'The ability cannot be inserted.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('ability')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function show(Ability $ability)
    {
        $data = [];
        $data['ability'] = $ability;
        $data['pokemons'] = Pokemon::all();
        $data['pokemonimages'] = PokemonImage::all();
        $data['pokemontypes'] = Type::all();
        return view('ability.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function edit(Ability $ability)
    {
        $data = [];
        $data['ability'] = $ability;
        return view('ability.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function update(AbilityEditRequest $request, Ability $ability)
    {
        $data = [];
        $data['message'] = 'The ability ' . $ability->name . ' has been updated successfully.';
        $data['type'] = 'success';
        try {
            $result = $ability->update($request->all());
        } catch(Exception $e) {
            $result = false;
        }
        if(!$result) {
            $data['message'] = 'The ability cannot be updated.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('ability')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ability $ability)
    {
        $data = [];
        $data['message'] = 'The ability ' . $ability->name . ' has been deleted successfully.';
        $data['type'] = 'success';
        try {
            $ability->delete();
        } catch(\Exception $e) {
            $data['message'] = 'The ability ' . $ability->name . ' has NOT been deleted.';
            $data['type'] = 'danger';
        }
        return redirect('ability')->with($data);
    }
}
