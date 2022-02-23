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
          <p>Do you wish to delete the user <span id="deleteUser">XXX</span>? You will also delete all their teams.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Cancel</button>
          <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf          
            <button type="submit" class="btn mb-2 btn-primary">Delete user account</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Manage Users</h2>
          </div>
          <div class="col-4">
              <p>On this page, you can manage user accounts: you can view, create, edit and delete them.</p>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Role</th>
                        <th>View information</th>
                        <th>Edit user</th>
                        <th>Delete user</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                          <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at }}</td>
                            <td class="font-italic">{{ $user->role }}</td>
                            <td><a href="{{ url('user/' . $user->id) }}">Show</a></td>
                            <td><a href="{{ url('user/' . $user->id . '/edit') }}">Edit</a></td>
                            @if(auth()->user()->id != $user->id)
                              <td><a href="javascript: void(0);" data-name="{{ $user->name }}" data-url="{{ url('user/' . $user->id) }}" data-toggle="modal" data-target="#modalDelete">Delete</a></td>
                            @else
                              <td>Cannot delete</td>
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
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
            <a href="{{ url('user/create') }}" class="btn btn-primary">Create new user account</a>
          </div>
        </div>
    </div>
@endsection

@section('js')
  <script src="{{ url('assets/js/deleteUser.js') }}"></script>
@endsection