@extends('layouts.master')
@section('title', 'Insufficient Credit')
@section('content')

<div class="container mt-5 text-center">
    <h2>Insufficient Credit</h2>
    <p>Sorry, you do not have enough credits to purchase <strong>{{ $product->name }}</strong>.</p>
    <p>Your Current Credit: <strong>${{ number_format($user->credit, 2) }}</strong></p>
    <p>Required Amount: <strong>${{ number_format($product->price, 2) }}</strong></p>

    <a href="{{ route('products_list') }}" class="btn btn-primary">Back to Products</a>
</div>

@endsection
