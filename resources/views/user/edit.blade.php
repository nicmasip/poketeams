@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Manage Users</h2>
          </div>
          <div class="col-4">
              <p>On this page you may edit the information of the user account with email {{ $user->email }}.</p>
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
                  <div class="col-lg-8 col-md-12 col-sm-12">
                    <form action="{{ url('user/' . $user->id) }}" method="POST">
                      @csrf
                      @method('put')
                      <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Name" value="{{ old('name', $user->name) }}" class="form-control" minlength="2" maxlength="200" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" class="form-control" minlength="2" maxlength="200" required>
                        @error('email')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" value="{{ old('password') }}" class="form-control" minlength="8">
                        @error('password')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="role">Role</label>
                        <select id="role" name="role" required class="form-control">
                            <option value="" @if(old('role', $user->role) == '') selected @endif disabled>&nbsp;</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @if(old('role', $user->role) == $role) selected @endif>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="submit" class="btn my-2 btn-primary">Edit user</button>
                    </form>
                    <div class="my-3">
                        <a href="{{ url('user') }}">
                            <i class="fe fe-corner-down-left fe-16"></i> Return to Manage Users page
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