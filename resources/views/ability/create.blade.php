@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Abilitydex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may create new abilities for our Abilitydex.</p>
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
                    <form action="{{ url('ability') }}" method="POST">
                      @csrf
                      <div class="form-group mb-3">
                        <label for="name">Ability name</label>
                        <input type="text" id="name" name="name" placeholder="Ability name" value="{{ old('name') }}" class="form-control" minlength="2" maxlength="100" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="description">Ability description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Ability description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="submit" class="btn my-2 btn-primary">Create ability</button>
                    </form>
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
@endsection