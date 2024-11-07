@extends('layouts.app')

@section('content')
    <h1>Add New Item</h1>
    <form action="{{ route('inventories.store') }}" method="POST">
        @csrf
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="text" name="price" placeholder="Price" required>
        <button type="submit">Save</button>
    </form>
@endsection
