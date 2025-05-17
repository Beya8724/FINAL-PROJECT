<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        .form-section, .table-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        img.product-img {
            width: 60px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-white text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
        <a href="{{ route('admin.product') }}" class="active">Products</a>
        <a href="{{ route('admin.orders') }}">Orders</a>
        <a href="{{ route('admin.reports') }}">Reports</a>
        <form style="margin-left: 15px" action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <div class="main-content">
        <h1 class="mb-4">Manage Products</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-section mb-5">
            <h4>Add New Product</h4>
            <form action="{{ route('admin.addproduct') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="product_category" class="form-label">Category</label>
                    <input type="text" name="product_category" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="product_image" class="form-label">Product Image</label>
                    <input type="file" name="product_image" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="product_price" class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" name="product_price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="product_stocks" class="form-label">Stock Quantity</label>
                    <input type="number" name="product_stocks" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Add Product</button>
            </form>
        </div>

        <div class="table-section">
            <h4>Product List</h4>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Added At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->product_category }}</td>
                            <td><img src="{{ asset('storage/' . $product->product_image) }}" class="product-img" alt="Image"></td>
                            <td>{{ $product->product_name }}</td>
                            <td>₱{{ number_format($product->product_price, 2) }}</td>
                            <td>{{ $product->product_stocks }}</td>
                            <td>{{ ucfirst($product->product_status) }}</td>
                            <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
