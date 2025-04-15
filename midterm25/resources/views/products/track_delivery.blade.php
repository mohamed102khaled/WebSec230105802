@extends('layouts.master')

@section('title', 'Test Page')

@section('content')
    <h1>Track Delivery</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>User</th>
                <th>Status Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @foreach ($user->boughtProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($product->pivot->status_message)
                                {{ $product->pivot->status_message }}
                            @else
                                No status message
                            @endif
                        </td>
                        <td>
                        <form action="{{ route('update_status_message', ['product' => $product->id, 'user' => $user->id]) }}" method="POST">

                                @csrf
                                <input type="text" name="status_message" value="{{ $product->pivot->status_message }}">
                                <button type="submit" class="btn btn-primary">Update Status Message</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
