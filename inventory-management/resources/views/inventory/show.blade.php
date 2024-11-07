<!-- resources/views/inventory/show.blade.php -->
<h1>Item Details</h1>

<p><strong>Product Name:</strong> {{ $item->product_name }}</p>
<p><strong>Category:</strong> {{ $item->category }}</p>
<p><strong>Quantity:</strong> {{ $item->quantity }}</p>
<p><strong>Price:</strong> {{ $item->price }}</p>

<a href="{{ route('inventory.index') }}">Back to Inventory</a>
