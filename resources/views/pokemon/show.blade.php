@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Pokédex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may view information on the pokémon {{ $pokemon->name }}.</p>
          </div>
        </div>
    </div>
    <div class="mb-2 align-items-center">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="row mt-1 align-items-center">
              <div class="col-12 text-left pl-4 row">
                <div class="col-lg-6 col-md-8 col-sm-8">
                  <table class="table table-hover">
                      <thead class="thead-dark">
                        <tr>
                          <th>Information</th>
                          <th>Pokémon</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Pokémon name</td>
                          <td>{{ $pokemon->name }}</td>
                        </tr>
                        <tr>
                          <td>Ability</td>
                          @foreach($abilities as $ability)
                            @if($ability->id == $pokemon->idability)
                              <td>{{ $ability->name }}</td>
                            @endif
                          @endforeach
                        </tr>
                        <tr>
                          <td>Primary type</td>
                          @foreach($pokemontypes as $pokemontype)
                            @if($pokemontype->id == $pokemon->idprimarytype)
                              <td><input class="mr-2" type="color" value="{{ $pokemontype->color }}" disabled>{{ $pokemontype->name }}</td>
                            @endif
                          @endforeach
                        </tr>
                        <tr>
                          <td>Secondary type</td>
                          @if($pokemon->idsecondarytype == null)
                              <td>—</td>
                          @else
                            @foreach($pokemontypes as $pokemontype)
                              @if($pokemontype->id == $pokemon->idsecondarytype)
                                <td><input class="mr-2" type="color" value="{{ $pokemontype->color }}" disabled>{{ $pokemontype->name }}</td>
                              @endif
                            @endforeach
                          @endif
                        </tr>
                        <tr>
                          <td>Height</td>
                          <td>{{ $pokemon->height }}</td>
                        </tr>
                        <tr>
                          <td>Weight</td>
                          <td>{{ $pokemon->weight }}</td>
                        </tr>
                        <tr>
                          <td>Region</td>
                          <td>{{ $pokemon->region }}</td>
                        </tr>
                      </tbody>
                  </table>
                  <div class="my-3">
                      <a href="{{ url('pokemon') }}">
                          <i class="fe fe-corner-down-left fe-16"></i> Return to Pokédex
                      </a>
                  </div>
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
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection