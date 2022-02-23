@extends('base.base')

@section('navbar-content')
    @include('base.navbarUser')
@endsection

@section('main-content')
    <div class="row align-items-center h-100">
        <div class="col-lg-6 col-md-8 col-10 mx-auto text-center">
        @csrf
        <a class="mb-4 navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/') }}">
            <img style="width:120px;" src="{{ url('assets/assets/images/pngegg.png') }}"></img>
        </a>
        <div class="card mt-2 p-3">
            <div class="card-header">
                <h1 class="mb-3 mb-3">PokéTeams</h1>
            </div>
            <div class="card-body text-left">
                <p class="h3">Welcome to PokéTeams!</p>
                <p style="font-size: 16px">
                    If you're looking for somewhere to planify and organize your pokémon strategies, this app is for you!
                    Here at PokéTeams, you can create and modify as many pokémon teams as you wish. And as you may well know,
                    pokémon trainers can carry up to 6 pokémon per team. 
                </p>
                <p style="font-size: 16px">
                    You'll have access to view our Pokédex, Abilitydex and
                    Itemdex to decide which pokémon you want on your team. We hope you enjoy the app and find it useful!
                </p>
                <a href="{{ route('login') }}" class="mt-5 btn btn-lg btn-primary btn-block" type="submit" value="Login">Login</a>
                <a href="{{ route('register') }}" class="mt-4 btn btn-lg btn-primary btn-block" type="submit" value="Register">Register</a>
            </div>
        </div>
        <p class="mt-5 mb-3 text-muted">PokéTeams © 2022</p>
        </div>
    </div>
@endsection

