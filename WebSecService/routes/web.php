<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\ProductsController;

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

Route::get('/transcript', function () {
    return view('transcript'); //prime.blade.php
});

Route::get('products', [ProductsController::class, 'list'])->name('products_list');

Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_add');

Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');

Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('/bill', function () {
    $customer_name = 'mohamed khaled';
    $order_date = now()->toDateString();

    $items = [
        ['name' => 'tea',  'quantity' => 1, 'price' => 12.50],
        ['name' => 'jam', 'quantity' => 3, 'price' => 32.00],
        ['name' => 'banana',  'quantity' => 5, 'price' => 2.20],
        ['name' => 'rice', 'quantity' => 2, 'price' => 15.75],
    ];

    $total_amount = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $items));

    return view('bill', compact('customer_name', 'order_date', 'items', 'total_amount'));
});
Route::get('/transcript', function () {
    $student_name = 'mohamed khaled';
    $student_id = '123456';
    $semester = 'Fall 2024';

    $courses = [
        ['course' => 'Mathematics', 'code' => 'MATH101', 'credits' => 3, 'grade' => 'A'],
        ['course' => 'Physics', 'code' => 'PHYS102', 'credits' => 4, 'grade' => 'B+'],
        ['course' => 'Computer Science', 'code' => 'CS103', 'credits' => 3, 'grade' => 'A-'],
        ['course' => 'History', 'code' => 'HIST104', 'credits' => 2, 'grade' => 'B'],
    ];

    return view('transcript', compact('student_name', 'student_id', 'semester', 'courses'));
});
