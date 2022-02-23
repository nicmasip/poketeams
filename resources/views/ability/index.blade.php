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
          <p>Do you wish to delete the ability <span id="deleteAbility">XXX</span>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
          <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf          
            <button type="submit" class="btn mb-2 btn-primary">Delete ability</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Abilitydex</h2>
          </div>
          <div class="col-4">
              <p>This is our Abilitydex, where you can view the different abilities that pokémon may have.</p>
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
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Ability name</th>
                        <th>Ability description</th>
                        <th>View information</th>
                        @if(auth()->user()->role != 'user')
                          <th>Edit information</th>
                          <th>Delete ability</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($abilities as $ability)
                      <tr>
                        <td>{{ $ability->name }}</td>
                        <td class="font-italic">{{ $ability->description }}</td>
                        <td><a href="{{ url('ability/' . $ability->id) }}">Show</a></td>
                        @if(auth()->user()->role != 'user')
                          <td><a href="{{ url('ability/' . $ability->id . '/edit') }}">Edit</a></th>
                          <td><a href="javascript: void(0);" data-name="{{ $ability->name }}" data-url="{{ url('ability/' . $ability->id) }}" data-toggle="modal" data-target="#modalDelete">Delete</a></td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    @if(auth()->user()->role != 'user')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
            <a href="{{ url('ability/create') }}" class="btn btn-primary">Insert new ability in Abilitydex</a>
          </div>
        </div>
    </div>
    @endif
@endsection

@section('js')
  <script src="{{ url('assets/js/deleteAbility.js') }}"></script>
@endsection