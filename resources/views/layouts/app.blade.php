@extends('base.base')

@section('head')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('navbar-content')
    @include('base.navbarUser')
@endsection