@extends('layouts.app')

@section('main-content')
<div class="row align-items-center h-100">
    <form method="POST" action="{{ route('register') }}" class="col-lg-6 col-md-8 col-10 mx-auto">
      @csrf
      <div class="mx-auto text-center my-4">
        <a class="mb-4 navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/') }}">
          <img style="width:90px;" src="{{ url('assets/assets/images/pngegg.png') }}"></img>
        </a>
        <h2 class="my-3">Register</h2>
      </div>
      <div class="form-group">
        <label for="inputEmail4">Email</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="name">Name</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <hr class="my-4">
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="@error('password') is-invalid @enderror form-control" id="password" name="password" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
          </div>
        </div>
        <div class="col-md-6">
          <p class="mb-2">Password requirements</p>
          <p class="small text-muted mb-2"> To create a new password, you have to meet the following requirement: </p>
          <ul class="mb-2 small text-muted pl-4 mb-0">
            <li>Minimum 8 characters</li>
          </ul>
          <p class="small text-muted mb-2"> We also recommend the following guidelines: </p>
          <ul class="small text-muted pl-4 mb-0">
            <li>At least one uppercase and one lowercase letter</li>
            <li>At least one number</li>
            <li>Different from the previous password</li>
          </ul>
        </div>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      <p class="mt-5 mb-3 text-muted text-center">PokéTeams © 2022</p>
    </form>
  </div>
@endsection
