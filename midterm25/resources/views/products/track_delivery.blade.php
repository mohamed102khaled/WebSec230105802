@extends('layouts.master')

@section('title', 'Track Delivery')

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
            @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->product->name }}</td>
                    <td>{{ $purchase->user->name }}</td>
                    <td>
                        @if ($purchase->status_message)
                            {{ $purchase->status_message }}
                        @else
                            No status message
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('update_status_message', $purchase->id) }}" method="POST">
                            @csrf
                            <input type="text" name="status_message" class="form-control mb-2" value="{{ $purchase->status_message }}">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
