<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AbilityController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ViewTeamsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('user', UserController::class);
Route::get('useredit', [UserController::class, 'useredit'])->name('user.useredit');
Route::put('user', [UserController::class, 'userupdate'])->name('user.userupdate');

Route::resource('item', ItemController::class);
Route::resource('ability', AbilityController::class);
Route::resource('pokemon', PokemonController::class);
Route::delete('pokemon/{pokemon}/image', [PokemonController::class, 'destroyImage'])->name('pokemon.destroyimage');

Route::resource('team', TeamController::class);
Route::delete('team/{team}/teampokemon', [TeamController::class, 'destroyTeamPokemon'])->name('pokemon.destroyteampokemon');

Route::get('viewteams/index', [ViewTeamsController::class, 'index'])->name('viewteams.index');
Route::get('viewteams/selectteam', [ViewTeamsController::class, 'selectTeam'])->name('viewteams.selectteam');
Route::get('viewteams/showteam/{team}', [ViewTeamsController::class, 'showTeam'])->name('viewteams.showteam');