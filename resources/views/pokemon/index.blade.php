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
          <p>Do you wish to delete the pokémon <span id="deletePokemon">XXX</span>?</p>
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
              <h2 class="h3 page-title">Pokédex</h2>
          </div>
          <div class="col-4">
              <p>This is our Pokédex, where you can look up information about pokémon.</p>
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
                  <div class="navbar-search-block mb-3">
                      <form class="form-inline" action="{{ $rutaSearch ?? '' }}" method="get">
                        <div class="form-group">
                          <label class="font-italic" for="search">Search... </label>
                          <input class="ml-4 form-control" type="search" placeholder="Search" aria-label="Search" name="search" value="{{ $appendData['search'] ?? '' }}">
                          @isset($appendData)
                              @foreach($appendData as $name => $value)
                                  @if($name != 'search')
                                      <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                                  @endif
                              @endforeach
                          @endisset
                          <button class="btn" type="submit"><i class="fe fe-search fe-16"></i></button>
                        </div>
                      </form>
                  </div>
                  <div class="mb-4">
                      <span class="mr-4">
                        <span class="font-italic mr-3">Order by name:</span>
                        <a href="{{ route('pokemon.index', $orderpnameasc) }}" class="font btn btn-primary mr-2">A-Z</a>
                        <a href="{{ route('pokemon.index', $orderpnamedesc) }}" class="btn btn-primary">Z-A</a>
                      </span>
                      <span class="mr-4">
                        <span class="font-italic mr-3">Order by height:</span>
                        <a href="{{ route('pokemon.index', $orderpheightasc) }}" class="btn btn-primary mr-2">Min-Max</a>
                        <a href="{{ route('pokemon.index', $orderpheightdesc) }}" class="btn btn-primary">Max-Min</a>
                      </span>
                      <span class="mr-4">
                        <span class="font-italic mr-3">Order by weight:</span>
                        <a href="{{ route('pokemon.index', $orderpweightasc) }}" class="btn btn-primary mr-2">Min-Max</a>
                        <a href="{{ route('pokemon.index', $orderpweightdesc) }}" class="btn btn-primary">Max-Min</a>
                      </span>
                  </div>
                  <div class="mb-4">
                      <span class="mr-4">
                        <span class="font-italic mr-3">Order by ability:</span>
                        <a href="{{ route('pokemon.index', $orderanameasc) }}" class="font btn btn-primary mr-2">A-Z</a>
                        <a href="{{ route('pokemon.index', $orderanamedesc) }}" class="btn btn-primary">Z-A</a>
                      </span>
                      <span class="mr-4">
                        <span class="font-italic mr-3">Order by primary type:</span>
                        <a href="{{ route('pokemon.index', $ordert1nameasc) }}" class="btn btn-primary mr-2">A-Z</a>
                        <a href="{{ route('pokemon.index', $ordert1namedesc) }}" class="btn btn-primary">Z-A</a>
                      </span>
                      <span class="mr-4">
                        <span class="font-italic mr-3">Order by region:</span>
                        <a href="{{ route('pokemon.index', $orderpregionasc) }}" class="btn btn-primary mr-2">A-Z</a>
                        <a href="{{ route('pokemon.index', $orderpregiondesc) }}" class="btn btn-primary">Z-A</a>
                      </span>
                      <a href="{{ route('pokemon.index', $orderpidasc) }}" class="ml-3 btn btn-secondary">Reset Order</a>
                  </div>
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
                        <th>View information</th>
                        @if(auth()->user()->role != 'user')
                          <th>Edit information</th>
                          <th>Delete pokémon</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pokemons as $pokemon)
                          <tr>
                            @if($pokemon->pifilename != null)
                                <td><img style="max-height: 50px;" src="{{ asset('storage/images/' . $pokemon->pid . '/' . substr($pokemon->pifilename, 3)) }}"></td>
                            @else
                                <td><img style="max-height: 50px;" src="{{ url('assets/assets/images/substitute.png') }}"></td>
                            @endif
                            <td>{{ $pokemon->pname }}</td>
                            <!--<td>{{-- $pokemon->ability->name --}}</td> --> <!-- sql -->
                            <td>{{ $pokemon->aname }}</td>
                            <td><input class="mr-2" type="color" value="{{ $pokemon->t1color }}" disabled>{{ $pokemon->t1name }}</td>
                            @if($pokemon->t2name == null)
                                <td>—</td>
                            @else
                                <td><input class="mr-2" type="color" value="{{ $pokemon->t2color }}" disabled>{{ $pokemon->t2name }}</td>
                            @endif
                            <td>{{ $pokemon->pheight }}m</td>
                            <td>{{ $pokemon->pweight }}kg</td>
                            <td>{{ $pokemon->pregion }}</td>
                            <td><a href="{{ url('pokemon/' . $pokemon->pid) }}">Show</a></td>
                            @if(auth()->user()->role != 'user')
                              <td><a href="{{ url('pokemon/' . $pokemon->pid . '/edit') }}">Edit</a></td>
                              <td><a href="javascript: void(0);" data-name="{{ $pokemon->pname }}" data-url="{{ url('pokemon/' . $pokemon->pid) }}" data-toggle="modal" data-target="#modalDelete">Delete</a></td>
                            @endif
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
            <nav>
              {{ $pokemons->onEachSide(1)->links() }}
              <ul class="pagination">
                  @foreach ($rpps as $linkData)
                      <li class="page-item @if($rpp == $linkData['rpp']) active @endif">
                          <a href="{{ route('pokemon.index', $linkData) }}" class="page-link">{{ $linkData['rpp'] }}</a>
                      </li>
                  @endforeach
                  <li class="page-item">
                      <a class="page-link">Per page</a>
                  </li>
              </ul>
          </nav>
          </div>
        </div>
    </div>
    @if(auth()->user()->role != 'user')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
            <a href="{{ url('pokemon/create') }}" class="btn btn-primary">Insert new pokémon in Pokédex</a>
          </div>
        </div>
    </div>
    @endif
@endsection

@section('js')
  <script src="{{ url('assets/js/deletePokemon.js') }}"></script>
@endsection