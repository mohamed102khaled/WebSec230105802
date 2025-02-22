<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/text', function () {
    return view('text'); //multable.blade.php
});

Route::get('/multable', function () {
    return view('multable'); //multable.blade.php
});

Route::get('/even', function () {
    return view('even'); //even.blade.php
});
    
Route::get('/prime', function () {
    return view('prime'); //prime.blade.php
});