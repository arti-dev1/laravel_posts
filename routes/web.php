<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/allposts', function () {
    return view('allposts');
})->name('allposts');

Route::get('/addpost', function () {
    return view('addpost');
})->name('addpost');