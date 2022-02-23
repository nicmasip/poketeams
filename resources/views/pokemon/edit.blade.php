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
          <p>Do you wish to delete the image?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
          <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf          
            <button type="submit" class="btn mb-2 btn-primary">Delete image</button>
          </form>
        </div>
      </div>
    </div>
  </div>

    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Pokédex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may edit the information of the pokémon {{ $pokemon->name }}.</p>
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
                  <form action="{{ url('pokemon/' . $pokemon->id) }}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf
                    @method('put')
                    <div class="col-lg-6 col-md-8 col-sm-8">
                      <div class="form-group mb-3">
                        <label for="name">Pokémon name</label>
                        <input type="text" id="name" name="name" placeholder="Pokémon name" value="{{ old('name', $pokemon->name) }}" class="form-control" minlength="2" maxlength="200" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="idability">Ability</label>
                        <select id="idability" name="idability" required class="form-control">
                            <option value="" @if(old('idability', $pokemon->idability) == '') selected @endif disabled>&nbsp;</option>
                            @foreach($abilities as $ability)
                                <option value="{{ $ability->id }}" @if(old('idability', $pokemon->idability) == $ability->id) selected @endif>{{ $ability->name }}</option>
                            @endforeach
                        </select>
                        @error('idability')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="idprimarytype">Primary type</label>
                        <select id="idprimarytype" name="idprimarytype" required class="form-control">
                            <option value="" @if(old('idprimarytype', $pokemon->idprimarytype) == '') selected @endif disabled>&nbsp;</option>
                            @foreach($pokemontypes as $primarytype)
                                <option value="{{ $primarytype->id }}" @if(old('idprimarytype', $pokemon->idprimarytype) == $primarytype->id) selected @endif>{{ $primarytype->name }}</option>
                            @endforeach
                        </select>
                        @error('idprimarytype')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="idsecondarytype">Secondary type</label>
                        <select id="idsecondarytype" name="idsecondarytype" class="form-control">
                            <option value="" @if(old('idsecondarytype', $pokemon->idsecondarytype) == '') selected @endif disabled>&nbsp;</option>
                            <option value="">None</option>
                            @foreach($pokemontypes as $secondarytype)
                                <option value="{{ $secondarytype->id }}" @if(old('idsecondarytype', $pokemon->idsecondarytype) == $secondarytype->id) selected @endif>{{ $secondarytype->name }}</option>
                            @endforeach
                        </select>
                        @error('idsecondarytype')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="height">Height</label>
                        <input type="number" id="height" name="height" placeholder="Height" value="{{ old('height', $pokemon->height) }}" class="form-control" min="0.1" max="200.0" step="0.1" required>
                        @error('height')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="height">Weight</label>
                        <input type="number" id="weight" name="weight" placeholder="Weight" value="{{ old('weight', $pokemon->weight) }}" class="form-control" min="0.1" max="1000.0" step="0.1" required>
                        @error('height')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="region">Region</label>
                        <select id="region" name="region" required class="form-control">
                            <option value="" @if(old('region', $pokemon->region) == '') selected @endif disabled>&nbsp;</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}" @if(old('region', $pokemon->region) == $region) selected @endif>{{ $region }}</option>
                            @endforeach
                        </select>
                        @error('region')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="submit" class="btn my-2 btn-primary">Edit pokémon</button>
                    </div>
                    <div class="ml-4 col-lg-5 col-md-3 col-sm-3">
                      <p class="h5">Pokémon image:</p>
                      <br>
                      @php $hasImage = false @endphp
                      @forelse($pokemonimages as $pokemonimage)
                          @if($pokemon->id == $pokemonimage->idpokemon)
                            <td><img style="max-height: 300px;" src="{{ asset('storage/images/' . $pokemon->id . '/' . substr($pokemonimage->filename, 3)) }}"></td>
                            @php $hasImage = true @endphp
                          @endif
                      @empty    
                          <td><img style="max-height: 300px;" src="{{ url('assets/assets/images/substitute.png') }}"></td>
                      @endforelse
                      @if(!$hasImage)
                            <td><img style="max-height: 300px;" src="{{ url('assets/assets/images/substitute.png') }}"></td>
                      @endif
                      <div class="mb-3">
                        <label for="image" class="form-label">Upload image</label>
                        <br>
                        <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
                      </div>
                      @if($hasImage)
                      <div class="my-3">
                          <a class="btn btn-primary" href="javascript: void(0);" data-url="{{ url('pokemon/' . $pokemon->id . '/image') }}" data-toggle="modal" data-target="#modalDelete">Delete image</a>
                      </div>
                      @endif
                    </div>
                  </form>
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

@section('js')
  <script src="{{ url('assets/js/deleteImage.js') }}"></script>
@endsection