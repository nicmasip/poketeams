@extends('layouts.app')

@section('main-content')
  <div class="row align-items-center h-100">
    <form method="POST" action="{{ route('login') }}" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
      @csrf
      <a class="mb-4 navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/') }}">
        <img style="width:90px;" src="{{ url('assets/assets/images/pngegg.png') }}"></img>
      </a>
      <h1 class="h6 mb-3">Log in</h1>
      <div class="form-group">
        <label for="email" class="sr-only">Email address</label>
        <input id="email" type="email" class="@error('email') is-invalid @enderror form-control form-control-lg" placeholder="Email address" required="" autofocus="" name="email" value="{{ old('email') }}" autocomplete="email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror      
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input id="password" type="password" class="@error('password') is-invalid @enderror form-control form-control-lg" placeholder="Password" name="password" required="">
      </div>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Stay logged in </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Let me in</button>
        @if (Route::has('password.request'))
            <a class="my-2 btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
      <p class="mt-5 mb-3 text-muted">PokéTeams © 2022</p>
    </form>
  </div>
@endsection