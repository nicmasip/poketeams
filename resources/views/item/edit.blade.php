@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Itemdex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may edit the name and description of the item {{ $item->name }}.</p>
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
                    <form action="{{ url('item/' . $item->id) }}" method="POST">
                      @csrf
                      @method('put')
                      <div class="form-group mb-3">
                        <label for="name">Item name</label>
                        <input type="text" id="name" name="name" placeholder="Item name" value="{{ old('name', $item->name) }}" class="form-control" minlength="2" maxlength="100" required>
                        @error('name')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="description">Item description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Item description" rows="4" required>{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <div class="my-2 alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="submit" class="btn my-2 btn-primary">Edit item</button>
                    </form>
                    <div class="my-3">
                        <a href="{{ url('item') }}">
                            <i class="fe fe-corner-down-left fe-16"></i> Return to Itemdex
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