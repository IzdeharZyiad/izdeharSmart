<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('Dashboard');
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/users' , 'Users')->name('users');

});

Volt::route('/users/addUser' , 'users.addUser')->name('users.addUser');


