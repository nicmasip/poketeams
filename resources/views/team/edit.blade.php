@extends('base.baseGeneral')

@section('main-content')
  <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"> 
          <p>Do you wish to delete <span id="deleteTeamPokemon">XXX</span>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
          <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf          
            <button type="submit" class="btn mb-2 btn-primary">Delete pokémon</button>
          </form>
        </div>
      </div>
    </div>
  </div>

    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Team Builder</h2>
          </div>
          <div class="col-4">
              <p>On this page you can edit your team {{ $team->name }}. Remember: your team can have up to 6 pokémon.</p>
          </div>
        </div>
    </div>
    <div class="mb-2 align-items-center">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="row mt-1 align-items-center">
              <div class="col-12 text-left pl-4">
                @if(Session::has('message'))
                  <div class="m-4 alert alert-{{ session()->get('type') }}" role="alert">
                    {{ session()->get('message') }}
                  </div>
                @endif
                <div class="align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <form action="{{ url('team/' . $team->id) }}" method="POST">
                      @csrf
                      @method('put')
                      <div class="form-group mb-3">
                        <label for="name">Team name</label>
                        <input type="text" id="name" name="name" placeholder="Team name" value="{{ old('name', $team->name) }}" class="form-control" minlength="2" maxlength="100" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-4">
                        <label for="visibility">Team visibility</label>
                        <select id="visibility" name="visibility" required class="form-control">
                            <option value="" @if(old('visibility', $team->visibility) == '') selected @endif disabled>&nbsp;</option>
                            @foreach($visibilities as $visibility)
                                <option value="{{ $visibility }}" @if(old('visibility', $team->visibility) == $visibility) selected @endif>{{ $visibility }}</option>
                            @endforeach
                        </select>
                        @error('visibility')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="button" id="btnAddPokemon" class="btn my-2 mr-2 btn-primary">Add pokémon</button>
                      <button type="button" id="btnRemovePokemon" class="btn my-2 mr-2 btn-primary">Remove pokémon</button>
                      <div id="mainContainer" class="mt-3 mb-3 row">
                        @foreach($teampokemons as $teampokemon)
                          @if($teampokemon->idteam == $team->id)
                            <div class="col-lg-4 col-sm-6 mb-4 teampokemonShown">
                              <div class="card bg-light text-center shadow border-secondary">
                                <div class="card-body">
                                  @foreach($pokemons as $pokemon)
                                    @if($pokemon->id == $teampokemon->idpokemon)
                                      @php $hasImage = false @endphp
                                      @forelse($pokemonimages as $pokemonimage)
                                          @if($pokemon->id == $pokemonimage->idpokemon)
                                            <img style="max-height: 200px;" src="{{ asset('storage/images/' . $pokemon->id . '/' . substr($pokemonimage->filename, 3)) }}">
                                            @php $hasImage = true @endphp
                                          @endif
                                      @empty    
                                          <img style="max-height: 200px;" src="{{ url('assets/assets/images/substitute.png') }}">
                                      @endforelse
                                      @if(!$hasImage)
                                            <img style="max-height: 200px;" src="{{ url('assets/assets/images/substitute.png') }}">
                                      @endif
                                      <p class="h5 my-3">
                                          {{ $pokemon->name }}&ensp;
                                          @if($teampokemon->gender == 'Male')
                                              <img style="max-height: 18px;" src="{{ url('assets/assets/images/male.png') }}">
                                          @elseif($teampokemon->gender == 'Female')
                                              <img style="max-height: 20px;" src="{{ url('assets/assets/images/female.png') }}">
                                          @endif
                                      </p>
                                    @endif
                                  @endforeach
                                  <p>Level: <span class="font-italic">{{ $teampokemon->level }}</span></p>
                                  @php $hasItem = false @endphp
                                  @foreach($items as $item)
                                      @if($item->id == $teampokemon->iditem)
                                          <p>Item: <span class="font-italic">{{ $item->name }}</span></p>
                                          @php $hasItem = true @endphp
                                      @endif
                                  @endforeach
                                  @if(!$hasItem)
                                      <p>Item: <span class="font-italic">None</span></p>
                                  @endif
                                  @foreach($pokemons as $pokemon)
                                    @if($pokemon->id == $teampokemon->idpokemon)
                                      <div class="my-3">
                                          <a class="btn btn-danger" href="javascript: void(0);" data-name="{{ $pokemon->name }}" data-url="{{ url('team/' . $teampokemon->id . '/teampokemon') }}" data-toggle="modal" data-target="#modalDelete">Delete pokémon</a>
                                      </div>
                                    @endif
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          @endif
                        @endforeach
                        <div class="col-lg-4 col-sm-6 mb-4 d-none" id="eventNode">
                          <div class="card bg-light shadow border-secondary">
                            <div style="height:418px;" class="card-body">
                                <h5 class="card-title" id="cardTitle">Pokémon #</h5>
                                <div class="form-group mb-3">
                                  <label for="pokemon[]">Pokémon name</label>
                                  <select id="pokemon" name="pokemon[]" class="form-control bg-light">
                                    <option value="" selected disabled>&nbsp;</option>
                                    @foreach($pokemons as $pokemon)
                                        <option value="{{ $pokemon->id }}">{{ $pokemon->name }}</option>
                                    @endforeach
                                  </select>
                                  @error('pokemon')
                                      <div class="my-2 alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="form-group mb-3">
                                  <label for="gender[]">Gender</label>
                                  <select id="gender" name="gender[]" class="form-control bg-light">
                                    <option value="" selected disabled>&nbsp;</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}">{{ $gender }}</option>
                                    @endforeach
                                  </select>
                                  @error('gender')
                                      <div class="my-2 alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label id="levelLabel" for="level">Level</label>
                                    <input id="level" type="number" name="level" placeholder="Level" class="form-control bg-light" min="1" max="100" step="1">
                                    @error('level')
                                        <div class="my-2 alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                  <label for="item[]">Item</label>
                                  <select name="item[]" class="form-control bg-light">
                                    <option value="" selected disabled>&nbsp;</option>
                                    <option value="">None</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                  </select>
                                  @error('item')
                                      <div class="my-2 alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <button id="btSubmit" type="submit" class="btn my-2 btn-primary">Edit team</button>
                    </form>
                    <div class="my-3">
                        <a href="{{ url('team') }}">
                            <i class="fe fe-corner-down-left fe-16"></i> Return to Team Builder
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

@section('js')
  <script type="text/javascript" src="{{ url('assets/js/deleteTeamPokemon.js') }}"></script>
  <script type="text/javascript" src="{{ url('assets/js/editTeam.js') }}"></script>
@endsection