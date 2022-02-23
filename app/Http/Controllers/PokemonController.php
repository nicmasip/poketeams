<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Ability;
use App\Models\Type;
use App\Models\PokemonImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PokemonCreateRequest;
use App\Http\Requests\PokemonEditRequest;
use DB;

class PokemonController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('userverified');
        $this->middleware('advanced', ['except' => ['index', 'show']]);
    }
    
    private function verifyOrder($order){
        if($order == null){
            return $order;
        }elseif($order == 'desc'){
            return $order;
        }
        return 'asc';
    }
    
    
    private function verifyRpp($rpp) {
        $rpps = $this->getRpps();
        if(isset($rpps[$rpp])) {
            return $rpp;
        }
        return 5;
    }
    
    /*
    private function verifySort($sort){
        $sorts = $this->getAllAttributes(new Pokemon());
        if(isset($sorts[$sort])){
            return $sort;
        }
        return null;
    }
    */
    
    private function verifySort($sort){
        $sorts = array_flip(['pid', 'pname', 'pheight', 'pweight', 'pregion', 't1name', 'aname']);
        //dd($sort);
        if(isset($sorts[$sort])){
            return $sort;
        }
        return null;
    }
    
    // private function getAllAttributes(){
        
    // }
    
    /*
    private function getAllAttributes($model){
        $columns = $model->getFillable();
        $attributes = $model->getAttributes();
        $add = array_merge(array_flip($columns), $attributes) ;
        $add['id'] = 0;
        return $add;
    }
    */
    /*
    private function getOrderArrays($array){
        $data = [];
        $orders = ["asc", "desc"];
        $sorts = $this->getAllAttributes(new Pokemon());
          
        foreach($orders as $order){
            foreach($sorts as $sortindex => $sort){
                $data['order' . $sortindex . $order] = array_merge(['sort' => $sortindex, 'order' => $order], $array);
            }
        }
        return $data;
    }
    */
    
    private function getOrderArrays($array){
        $data = [];
        $orders = ["asc", "desc"];
        $sorts = array_flip(['pid', 'pname', 'pheight', 'pweight', 'pregion', 't1name', 'aname']);
          
        foreach($orders as $order){
            foreach($sorts as $sortindex => $sort){
                $data['order' . $sortindex . $order] = array_merge(['sort' => $sortindex, 'order' => $order], $array);
            }
        }
        return $data;
    }
    
    private function getRecordsPerPageArray($array) {
        $result = [];
        $rpps = $this->getRpps();
        foreach($rpps as $rpp => $value) {
            $result['rpps'][] = array_merge($array, ['rpp' =>  $rpp]);
        }
        return $result;
    }
        
    private function getRpps() {
        return [2 => 1, 5 => 1, 10 => 1, 20 => 1, 50 => 1, 100 => 1];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function index(Request $request){
        $data = [];
        $appendData = [];
        $filterData = [];
        $rppData = [];
        $sortData = [];
        $searchData = [];
        
        $page = $request->input('page');
        //$filter = $request->input('filter');
        $sort = $this->verifySort($request->input('sort'));
        $order = $this->verifyOrder($request->input('order'));
        //dd($request->input('sort'), $request->input('order'), $request->input('rpp'), $request->input('search'));
        $rpp = $this->verifyRpp($request->input('rpp'));
        $search = $request->input('search');
        
        if($sort != null && $order != null) {
            $sortData = ['sort' => $sort, 'order' => $order];
        }

        if($rpp != 5) {
            $rppData['rpp'] = $rpp;
        }
        
        if($search != null) {
           $searchData['search'] = $search;
        }

        $appendData = array_merge($appendData, $rppData);
        $appendData = array_merge($appendData, $sortData);
        $appendData = array_merge($appendData, $searchData);

        $data = array_merge($data, $this->getOrderArrays(array_merge($rppData, $searchData)));
        $data = array_merge($data, $this->getRecordsPerPageArray($appendData));
        $data['rpp'] = $rpp;
        
        $pokemons = DB::table('pokemon as p')
            ->leftJoin('type as t1', 't1.id', '=', 'p.idprimarytype')
            ->leftJoin('type as t2', 't2.id', '=', 'p.idsecondarytype')
            ->leftJoin('ability as a', 'a.id', '=', 'p.idability')
            ->leftJoin('pokemon_image as pi', 'p.id', '=', 'pi.idpokemon')
            ->select('p.id as pid', 'p.name as pname', 'p.height as pheight', 'p.weight as pweight', 'p.region as pregion', 't1.name as t1name', 't1.color as t1color', 't2.name as t2name', 't2.color as t2color', 'a.name as aname', 'pi.filename as pifilename');

        if($search != null){
            $pokemons = DB::table('pokemon as p')
                ->leftJoin('type as t1', 't1.id', '=', 'p.idprimarytype')
                ->leftJoin('type as t2', 't2.id', '=', 'p.idsecondarytype')
                ->leftJoin('ability as a', 'a.id', '=', 'p.idability')
                ->leftJoin('pokemon_image as pi', 'p.id', '=', 'pi.idpokemon')
                ->select('p.id as pid', 'p.name as pname', 'p.height as pheight', 'p.weight as pweight', 'p.region as pregion', 't1.name as t1name', 't1.color as t1color', 't2.name as t2name', 't2.color as t2color', 'a.name as aname', 'pi.filename as pifilename')
                ->where('p.name', 'like', '%'. $search . '%')
                ->orWhere('p.height', 'like', '%' . $search . '%')
                ->orWhere('p.weight', 'like', '%' . $search . '%')
                ->orWhere('p.region', 'like', '%' . $search . '%')
                ->orWhere('t1.name', 'like', '%' . $search . '%')
                ->orWhere('t2.name', 'like', '%' . $search . '%')
                ->orWhere('a.name', 'like', '%' . $search . '%');
        }

        if($sort != null && $order != null){
            $pokemons = $pokemons->orderby($sort, $order);
        }
        
        $pokemons = $pokemons->orderBy('pid', 'asc')->paginate($rpp)->appends($appendData);
            
        $data['pokemons'] = $pokemons;
        $data['appendData'] = $appendData;
        $data['rutaSearch'] = route('pokemon.index');
        return view('pokemon.index')->with($data);
     }
     
     /*
    public function index(Request $request)
    {
        $sql = 'select *
            from pokemon p
            left join type t1 on p.idprimarytype = t1.id
            left join type t2 on p.idsecondarytype = t2.id
            left join ability a on p.idability = a.id
            left join pokemon_image pi on p.id = pi.idpokemon
            order by ...
            limit x, y';
        //DB::select($sql);
        $pokemons = DB::table('pokemon as p')
            ->leftJoin('type as t1', 't1.id', '=', 'p.idprimarytype')
            ->leftJoin('type as t2', 't2.id', '=', 'p.idsecondarytype')
            ->leftJoin('ability as a', 'a.id', '=', 'p.idability')
            ->leftJoin('pokemon_image as pi', 'p.id', '=', 'pi.idpokemon')
            ->select('p.*', 't1.name as t1name', 't2.name as t2name', 'a.name as aname', 'pi.filename as filename')
            ->where()
            ->orderby()
            ->paginate(20);
        dd($pokemons);
        $data = [];
        $appendData = [];
        $filterData = [];
        $rppData = [];
        $sortData = [];
        $searchData = [];
        
        $page = $request->input('page');
        $filter = $request->input('filter');
        $sort = $this->verifySort($request->input('sort'));
        $order = $this->verifyOrder($request->input('order'));
        $rpp = $this->verifyRpp($request->input('rpp'));
        $search = $request->input('search');

        if($sort != null && $order != null) {
            $sortData = ['sort' => $sort, 'order' => $order];
        }

        if($rpp != 10) {
            $rppData['rpp'] = $rpp;
        }
        
        if($search != null) {
           $searchData['search'] = $search;
        }

        $appendData = array_merge($appendData, $rppData);
        $appendData = array_merge($appendData, $sortData);
        $appendData = array_merge($appendData, $searchData);

        $data = array_merge($data, $this->getOrderArrays(array_merge($rppData, $searchData)));
        $data = array_merge($data, $this->getRecordsPerPageArray($appendData));
        $data['rpp'] = $rpp;

        $pokemon = new Pokemon();
        if($search != null){
            $abilities = Ability::where('name', 'like', '%' . $search . '%')->get();
            $abilityids = [];
            foreach($abilities as $ability){
                array_push($abilityids, $ability->id);
            }
            $types = Type::where('name', 'like', '%' . $search . '%')->get();
            $typeids = [];
            foreach($types as $type){
                array_push($typeids, $type->id);
            }
            
            $pokemon = $pokemon->where('name', 'like', '%'. $search . '%')
            ->orWhere('height', 'like', '%' . $search . '%')
            ->orWhere('weight', 'like', '%' . $search . '%')
            ->orWhere('region', 'like', '%' . $search . '%')
            ->orWhere(function($query) use($abilityids){
                $query->whereIn('idability', $abilityids);
            })->orWhere(function($query) use($typeids){
                $query->whereIn('idprimarytype', $typeids);
            })->orWhere(function($query) use($typeids){
                $query->whereIn('idsecondarytype', $typeids);
            });
        }
        if($sort != null && $order != null){
            if($sort == 'idability'){
                // $sort = DB::select('select name from ability where id = (select idability from pokemon where id = :id)', ['id' => ]);
            }
            elseif($sort == 'idprimarytype'){
                    
            }
            else{
                    
            }
            $pokemon = $pokemon->orderBy($sort, $order);
            // $pokemon = $pokemon->where(function($query) use($sort, $order){
                
            // });
        }
        
        $pokemon = $pokemon->orderBy('id', 'asc')->paginate($rpp)->appends($appendData);
        $data['pokemons'] = $pokemon;
        $data['appendData'] = $appendData;
        $data['rutaSearch'] = route('pokemon.index');
        
        $data['pokemontypes'] = Type::all();
        $data['abilities'] = Ability::all();
        $data['pokemonimages'] = PokemonImage::all();
        return view('pokemon.index')->with($data);
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['abilities'] = Ability::all();
        $data['pokemontypes'] = Type::all();
        $data['regions'] = ['Kanto', 'Johto', 'Hoenn', 'Sinnoh', 'Unova', 'Kalos', 'Alola', 'Galar', 'Hisui'];
        return view('pokemon.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PokemonCreateRequest $request)
    {
        $data = [];
        $data['message'] = 'A new pokémon has been inserted successfully.';
        $data['type'] = 'success';
        $pokemon = new Pokemon($request->all());
        if($pokemon->idsecondarytype == null || $pokemon->idprimarytype != $pokemon->idsecondarytype){ 
            try {
                $result = $pokemon->save();
                if($request->hasFile('image') && $request->file('image')->isValid()) {
                    $file = $request->file('image');
                    $originalFileName = $file->getClientOriginalName();
                    
                    $pokemonImage = new PokemonImage($request->all());
                    $pokemonImage->idpokemon = $pokemon->id;
                    $pokemonImage->filename = Str::random(3) . $originalFileName;
                    $pokemonImage->mimetype = $file->getMimeType();
                    
                    try {
                        $file->storeAs('public/images/' . $pokemon->id, $originalFileName);
                        $pokemonImage->save();
                    } catch(Exception $e) {
                        $pokemon->delete();
                        $data['message'] = 'The pokémon cannot be inserted.';
                        $data['type'] = 'danger';
                        return back()->withInput()->with($data);
                    }
                }
            } catch(Exception $e) {
                $result = false;
            }
            if(!$result) {
                $data['message'] = 'The pokémon cannot be inserted.';
                $data['type'] = 'danger';
                return back()->withInput()->with($data);
            }
        }
        else{
            $data['message'] = 'The pokémon cannot have the same type twice.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        
        return redirect('pokemon')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function show(Pokemon $pokemon)
    {
        $data = [];        
        $data['pokemon'] = $pokemon;
        $data['abilities'] = Ability::all();
        $data['pokemontypes'] = Type::all();
        $data['pokemonimages'] = PokemonImage::all();
        return view('pokemon.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function edit(Pokemon $pokemon)
    {
        $data = [];
        $data['pokemon'] = $pokemon;
        $data['abilities'] = Ability::all();
        $data['pokemontypes'] = Type::all();
        $data['pokemonimages'] = PokemonImage::all();
        $data['regions'] = ['Kanto', 'Johto', 'Hoenn', 'Sinnoh', 'Unova', 'Kalos', 'Alola', 'Galar', 'Hisui'];
        return view('pokemon.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function update(PokemonEditRequest $request, Pokemon $pokemon)
    {
        $data = [];
        $data['message'] = 'The pokémon ' . $pokemon->name . ' has been updated successfully.';
        $data['type'] = 'success';
        $pokemonImage = null;
        if($pokemon->idsecondarytype == null || $pokemon->idprimarytype != $pokemon->idsecondarytype){
            if($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $originalFileName = $file->getClientOriginalName();
                
                $pokemonImage = new PokemonImage($request->all());
                $pokemonImage->idpokemon = $pokemon->id;
                $pokemonImage->filename = Str::random(3) . $originalFileName;
                $pokemonImage->mimetype = $file->getMimeType();
            }
            try {
                if($pokemonImage != null){
                    if(!Storage::exists('public/images/' . $pokemon->id)){
                        $file->storeAs('public/images/' . $pokemon->id, $originalFileName);
                        $pokemonImage->save();
                    }
                    else{
                        Storage::deleteDirectory('public/images/' . $pokemon->id);
                        $file->storeAs('public/images/' . $pokemon->id, $originalFileName);
                        $pokemonImage->update(['idpokemon' => $pokemon->id, 'filename' => Str::random(3) . $originalFileName, 'mimetype' => $file->getMimeType()]);
                    }
                }
                $result = $pokemon->update($request->all());
            } catch(Exception $e) {
                $result = false;
            }
            if(!$result) {
                $data['message'] = 'The pokémon cannot be updated.';
                $data['type'] = 'danger';
                return back()->withInput()->with($data);
            }
        }
        else{
            $data['message'] = 'The pokémon cannot have the same type twice.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('pokemon')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pokemon $pokemon)
    {
        $data = [];
        $data['message'] = 'The pokémon ' . $pokemon->name . ' has been deleted successfully.';
        $data['type'] = 'success';
        $pokemonImages = PokemonImage::all();
        $pokemonImage = null;
        foreach($pokemonImages as $pi){
            if($pi->idpokemon == $pokemon->id){
                $pokemonImage = $pi;
            }
        }
        try {
            Storage::deleteDirectory('public/images/' . $pokemon->id);
            if($pokemonImage != null){
                $pokemonImage->delete();
            }
            $pokemon->delete();
        } catch(\Exception $e) {
            $data['message'] = 'The pokémon ' . $pokemon->name . ' has NOT been deleted.';
            $data['type'] = 'danger';
        }
        return redirect('pokemon')->with($data);
    }
    
    public function destroyImage(Pokemon $pokemon){
        $data = [];
        $data['message'] = 'The image has been deleted successfully.';
        $data['type'] = 'success';
        $pokemonImages = PokemonImage::all();
        $pokemonImage = null;
        foreach($pokemonImages as $pi){
            if($pi->idpokemon == $pokemon->id){
                $pokemonImage = $pi;
            }
        }
        try {
            if($pokemonImage != null){
                Storage::deleteDirectory('public/images/' . $pokemon->id);
                $pokemonImage->delete();
            }
            else{
                $data['message'] = 'There is no image to delete.';
                $data['type'] = 'danger';
            }
        } catch(\Exception $e) {
            $data['message'] = 'The image has NOT been deleted.';
            $data['type'] = 'danger';
        }
        $data['abilities'] = Ability::all();
        $data['pokemontypes'] = Type::all();
        $data['pokemonimages'] = $pokemonImages;
        $data['regions'] = ['Kanto', 'Johto', 'Hoenn', 'Sinnoh', 'Unova', 'Kalos', 'Alola', 'Galar', 'Hisui'];
        return back()->withInput()->with($data);
    }
}
