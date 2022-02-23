@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Pokédex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may create new pokémon for our Pokédex.</p>
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
                  <div class="col-lg-6 col-md-8 col-sm-8">
                    <form action="{{ url('pokemon') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group mb-3">
                        <label for="name">Pokémon name</label>
                        <input type="text" id="name" name="name" placeholder="Pokémon name" value="{{ old('name') }}" class="form-control" minlength="2" maxlength="100" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="idability">Ability</label>
                        <select id="idability" name="idability" required class="form-control">
                            <option value="" @if(old('idability') == '') selected @endif disabled>&nbsp;</option>
                            @foreach($abilities as $ability)
                                <option value="{{ $ability->id }}" @if(old('idability') == $ability->id) selected @endif>{{ $ability->name }}</option>
                            @endforeach
                        </select>
            
                        @error('idability')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="idprimarytype">Primary type</label>
                        <select id="idprimarytype" name="idprimarytype" required class="form-control">
                            <option value="" @if(old('idprimarytype') == '') selected @endif disabled>&nbsp;</option>
                            @foreach($pokemontypes as $primarytype)
                                <option value="{{ $primarytype->id }}" @if(old('idprimarytype') == $primarytype->id) selected @endif>{{ $primarytype->name }}</option>
                            @endforeach
                        </select>
            
                        @error('idprimarytype')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="idsecondarytype">Secondary type</label>
                        <select id="idsecondarytype" name="idsecondarytype" class="form-control">
                            <option value="" @if(old('idsecondarytype') == '') selected @endif disabled>&nbsp;</option>
                            <option value="">None</option>
                            @foreach($pokemontypes as $secondarytype)
                                <option value="{{ $secondarytype->id }}" @if(old('idsecondarytype') == $secondarytype->id) selected @endif>{{ $secondarytype->name }}</option>
                            @endforeach
                        </select>
            
                        @error('idsecondarytype')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="height">Height</label>
                        <input type="number" id="height" name="height" placeholder="Height" value="{{ old('height') }}" class="form-control" min="0.1" max="200.0" step="0.1" required>
                        @error('height')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="height">Weight</label>
                        <input type="number" id="weight" name="weight" placeholder="Weight" value="{{ old('weight') }}" class="form-control" min="0.1" max="1000.0" step="0.1" required>
                        @error('height')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="region">Region</label>
                        <select id="region" name="region" required class="form-control">
                            <option value="" @if(old('region') == '') selected @endif disabled>&nbsp;</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}" @if(old('region') == $region) selected @endif>{{ $region }}</option>
                            @endforeach
                        </select>
            
                        @error('region')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <br>
                        <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
                      </div>
                      <button type="submit" class="btn my-2 btn-primary">Create pokémon</button>
                    </form>
                  </div>
                  <div class="my-3">
                      <a href="{{ url('pokemon') }}">
                          <i class="fe fe-corner-down-left fe-16"></i> Return to Pokédex
                      </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection