@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Team Builder</h2>
          </div>
          <div class="col-4">
              <p>On this page you can view the team {{ $team->name }}.</p>
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
                    <p class="h4">{{ $team->name }}</p>
                    <p>Visibility: <span class="font-italic">{{ $team->visibility }}</span></p>
                    <div class="mt-3 mb-3 row">
                      @foreach($teampokemons as $teampokemon)
                        @if($teampokemon->idteam == $team->id)
                          <div class="col-4 mb-4">
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
                              </div>
                            </div>
                          </div>
                        @endif
                      @endforeach
                    </div>
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