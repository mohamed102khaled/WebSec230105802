@extends('layouts.master')

@section('title', 'Insufficient Credit')

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger text-center">
        <h2>Insufficient Credit</h2>
        <p>Sorry, you do not have enough credit to purchase <strong>{{ $product->name }}</strong>.</p>
        <p>Your Balance: <strong>${{ number_format($user->credit, 2) }}</strong></p>
        <p>Product Price: <strong>${{ number_format($product->price, 2) }}</strong></p>
        <a href="{{ route('products_list') }}" class="btn btn-primary">Go Back</a>
    </div>
</div>
@endsection
