@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Manage Users</h2>
          </div>
          <div class="col-4">
              <p>On this page you may view information on the user account with email {{ $user->email }}.</p>
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
                            <th>User</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Name</td>
                            <td>{{ $user->name }}</td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td>{{ $user->email }}</td>
                          </tr>
                          <tr>
                            <td>Verified</td>
                            <td>{{ $user->email_verified_at }}</td>
                          </tr>
                          <tr>
                            <td>Role</td>
                            <td>{{ $user->role }}</td>
                          </tr>
                        </tbody>
                    </table>
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