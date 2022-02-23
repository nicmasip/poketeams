@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Abilitydex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may view information on the ability {{ $ability->name }}.</p>
          </div>
        </div>
    </div>
    <div class="mb-2 align-items-center">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="row mt-1 align-items-center">
              <div class="col-12 text-left pl-4">
                <div class="align-items-center">
                  <div class="col-lg-6 col-md-12 col-sm-12">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th>Information</th>
                            <th>Ability</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Ability name</td>
                            <td>{{ $ability->name }}</td>
                          </tr>
                          <tr>
                            <td>Ability description</td>
                            <td class="font-italic">{{ $ability->description }}</td>
                          </tr>
                        </tbody>
                    </table>
                    <div class="my-3">
                        <a href="{{ url('ability') }}">
                            <i class="fe fe-corner-down-left fe-16"></i> Return to Abilitydex
                        </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    @if($pokemons != null)
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h4">Pokémon with the ability {{ $ability->name }}</h2>
          </div>
        </div>
    </div>
    <div class="mb-2 align-items-center">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="row mt-1 align-items-center">
              <div class="col-12 text-left pl-4">
                <div class="align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th>&nbsp;</th>
                            <th>Pokémon</th>
                            <th>Ability</th>
                            <th>Primary type</th>
                            <th>Secondary type</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Region</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($pokemons as $pokemon)
                              @if($pokemon->idability == $ability->id)
                                  <tr>
                                    @php $hasImage = false @endphp
                                    @forelse($pokemonimages as $pokemonimage)
                                        @if($pokemon->id == $pokemonimage->idpokemon)
                                          <td><img style="max-height: 50px;" src="{{ asset('storage/images/' . $pokemon->id . '/' . substr($pokemonimage->filename, 3)) }}"></td>
                                          @php $hasImage = true @endphp
                                        @endif
                                    @empty
                                        <td><img style="max-height: 50px;" src="{{ url('assets/assets/images/substitute.png') }}"></td>
                                    @endforelse
                                    @if(!$hasImage)
                                        <td><img style="max-height: 50px;" src="{{ url('assets/assets/images/substitute.png') }}"></td>
                                    @endif
                                    <td>{{ $pokemon->name }}</td>
                                    <td>{{ $ability->name }}</td>
                                    @foreach($pokemontypes as $pokemontype)
                                        @if($pokemontype->id == $pokemon->idprimarytype)
                                            <td><input class="mr-2" type="color" value="{{ $pokemontype->color }}" disabled>{{ $pokemontype->name }}</td>
                                        @endif
                                    @endforeach
                                    @if($pokemon->idsecondarytype == null)
                                        <td>—</td>
                                    @else
                                        @foreach($pokemontypes as $pokemontype)
                                            @if($pokemontype->id == $pokemon->idsecondarytype)
                                                <td><input class="mr-2" type="color" value="{{ $pokemontype->color }}" disabled>{{ $pokemontype->name }}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <td>{{ $pokemon->height }}m</td>
                                    <td>{{ $pokemon->weight }}kg</td>
                                    <td>{{ $pokemon->region }}</td>
                                  </tr>
                              @endif
                          @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    @endif
@endsection