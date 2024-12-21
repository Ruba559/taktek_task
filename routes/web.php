<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\AuthorItems;
use App\Http\Controllers\DashboardController;

Route::group([ 'prefix'=>'dashboard'],  function () {

   // Route::get('/authors',action:[ DashboardController::class ,'index']);
    Route::get('/authors',AuthorItems::class);
});
Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
