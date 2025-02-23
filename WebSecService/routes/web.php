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

Route::get('/bill', function () {
    return view('bill'); //prime.blade.php
});



Route::get('/bill', function () {
    $customer_name = 'John Doe';
    $order_date = now()->toDateString();

    $items = [
        ['name' => 'Apple', 'description' => 'Fresh Red Apple', 'quantity' => 3, 'price' => 1.50],
        ['name' => 'Bread', 'description' => 'Whole Wheat Bread', 'quantity' => 2, 'price' => 2.00],
        ['name' => 'Milk', 'description' => '1L Skimmed Milk', 'quantity' => 1, 'price' => 3.00],
        ['name' => 'Eggs', 'description' => 'Pack of 12 Eggs', 'quantity' => 1, 'price' => 4.50],
    ];

    $total_amount = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $items));

    return view('bill', compact('customer_name', 'order_date', 'items', 'total_amount'));
});

