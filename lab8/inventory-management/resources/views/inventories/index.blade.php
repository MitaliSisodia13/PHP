@extends('layouts.app')

@section('content')
    <h1>Inventory</h1>
    <a href="{{ route('inventory.create') }}">Add New Item</a>
    <ul>
        @foreach($inventories as $item)
            <li>{{ $item->product_name }} - {{ $item->quantity }} - ${{ $item->price }}</li>
        @endforeach
    </ul>
@endsection
