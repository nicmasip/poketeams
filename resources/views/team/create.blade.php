@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Team Builder</h2>
          </div>
          <div class="col-4">
              <p>On this page you can create new teams. Remember: your team can have up to 6 pokémon.</p>
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
                    <form action="{{ url('team') }}" method="POST">
                      @csrf
                      <div class="form-group mb-3">
                        <label for="name">Team name</label>
                        <input type="text" id="name" name="name" placeholder="Team name" value="{{ old('name') }}" class="form-control" minlength="2" maxlength="100" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-4">
                        <label for="visibility">Team visibility</label>
                        <select id="visibility" name="visibility" required class="form-control">
                            <option value="" @if(old('visibility') == '') selected @endif disabled>&nbsp;</option>
                            @foreach($visibilities as $visibility)
                                <option value="{{ $visibility }}" @if(old('visibility') == $visibility) selected @endif>{{ $visibility }}</option>
                            @endforeach
                        </select>
                        @error('visibility')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="button" id="btnAddPokemon" class="btn my-2 mr-2 btn-primary">Add pokémon</button>
                      <button type="button" id="btnRemovePokemon" class="btn my-2 mr-2 btn-primary">Remove pokémon</button>
                      <div class="mt-3 mb-3 row">
                        <div class="col-lg-4 mb-4 col-sm-6" id="eventNode">
                          <div class="card bg-light shadow border-secondary">
                            <div class="card-body">
                              <h5 class="card-title" id="cardTitle">Pokémon #1</h5>
                                <div class="form-group mb-3">
                                  <label for="pokemon[]">Pokémon name</label>
                                  <select id="pokemon" name="pokemon[]" required class="form-control bg-light">
                                    <option value="" @if(old('pokemon[]') == '') selected @endif disabled>&nbsp;</option>
                                    @foreach($pokemons as $pokemon)
                                        <option value="{{ $pokemon->id }}" @if(old('pokemon[]') == $pokemon->id) selected @endif>{{ $pokemon->name }}</option>
                                    @endforeach
                                  </select>
                                  @error('pokemon')
                                      <div class="my-2 alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="form-group mb-3">
                                  <label for="gender[]">Gender</label>
                                  <select id="gender" name="gender[]" required class="form-control bg-light">
                                    <option value="" @if(old('gender[]') == '') selected @endif disabled>&nbsp;</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" @if(old('gender[]') == $gender) selected @endif>{{ $gender }}</option>
                                    @endforeach
                                  </select>
                                  @error('gender')
                                      <div class="my-2 alert alert-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="level[]">Level</label>
                                    <input id="level" type="number" name="level[]" placeholder="Level" value="{{ old('level[]') }}" class="form-control emptyInput bg-light" min="1" max="100" step="1" required>
                                    @error('level')
                                        <div class="my-2 alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                  <label for="item[]">Item</label>
                                  <select name="item[]" class="form-control bg-light">
                                    <option value="" @if(old('item[]') == '') selected @endif disabled>&nbsp;</option>
                                    <option value="">None</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" @if(old('item[]') == $item->id) selected @endif>{{ $item->name }}</option>
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
                      <button type="submit" class="btn my-2 btn-primary">Create team</button>
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
  <script type="text/javascript" src="{{ url('assets/js/createTeam.js') }}"></script>
@endsection