<!-- resources/views/inventory/edit.blade.php -->
<h1>Edit Item</h1>

<form action="{{ route('inventory.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Product Name:</label>
    <input type="text" name="product_name" value="{{ $item->product_name }}" required>

    <label>Category:</label>
    <input type="text" name="category" value="{{ $item->category }}" required>

    <label>Quantity:</label>
    <input type="number" name="quantity" value="{{ $item->quantity }}" required>

    <label>Price:</label>
    <input type="text" name="price" value="{{ $item->price }}" required>

    <button type="submit">Update Item</button>
</form>
