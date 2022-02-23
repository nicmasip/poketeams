@extends('base.baseGeneral')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <div class="card-header h5">{{ __('You are logged in!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if(auth()->user()->role == 'admin')
                        <p>As an admin, you can do everything basic and advanced users can do, and more.</p>
                    @elseif(auth()->user()->role == 'advanced')
                        <p>As an advanced user, you can do everything basic users can do, and more.</p>
                    @else
                        <p>As a basic user, you can:</p>
                        <ul>
                            <li>Build pokémon your own pokémon teams and view them.</li>
                            <li>View other users' teams, as long as they are public.</li>
                            <li>View our Pokédex, Abilitydex and Itemdex.</li>
                        </ul>
                    @endif
                    
                    @if(auth()->user()->role != 'user')
                        <p class="font-italic">Basic user:</p>
                        <ul>
                            <li>You can build your own pokémon teams and view them.</li>
                            <li>You can view other users' public teams.</li>
                            <li>You can view our Pokédex, Abilitydex and Itemdex.</li>
                        </ul>
                        <p class="font-italic">Advanced user:</p>
                        <ul>
                            <li>You can create, edit and delete pokémon, abilities and items in our Dexes.</li>
                        </ul>
                        @if(auth()->user()->role == 'admin')
                        <p class="font-italic">Admin:</p>
                        <ul>
                            <li>You can create and delete user accounts.</li>
                            <li>You can grant or revoke priviliges and edit account information.</li>
                            <li>You can view other users' teams, even if they're private.</li>
                        </ul>
                        @endif
                        <br>
                    @endif
                    
                    <a href="{{ route('user.useredit') }}" class="btn btn-primary">Edit profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
