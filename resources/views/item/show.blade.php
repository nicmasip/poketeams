@extends('base.baseGeneral')

@section('main-content')
    <div class="row align-items-center mb-2">
        <div class="col">
          <div class="col">
              <h2 class="h3 page-title">Itemdex</h2>
          </div>
          <div class="col-4">
              <p>On this page you may view information on the item {{ $item->name }}.</p>
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
                            <th>Item</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Item name</td>
                            <td>{{ $item->name }}</td>
                          </tr>
                          <tr>
                            <td>Item description</td>
                            <td class="font-italic">{{ $item->description }}</td>
                          </tr>
                        </tbody>
                    </table>
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