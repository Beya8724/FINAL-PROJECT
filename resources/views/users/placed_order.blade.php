<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar a {
            color: #fff;
        }

        .navbar a:hover {
            color: #f8f9fa;
        }

        .order-section {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .form-section {
            margin-top: 30px;
        }

        .gcash-fields, .delivery-address {
            display: none;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
        }

        .btn-primary:hover {
            background-color: #495057;
        }
    </style>
    <script>
        function toggleFields() {
            const deliveryOption = document.querySelector('input[name="delivery_method"]:checked')?.value;
            const paymentMethod = document.querySelector('select[name="payment_method"]').value;

            if (deliveryOption === 'delivery') {
                document.querySelector('.delivery-address').style.display = 'block';
            } else {
                document.querySelector('.delivery-address').style.display = 'none';
            }

            if (paymentMethod === 'gcash') {
                document.querySelector('.gcash-fields').style.display = 'block';
            } else {
                document.querySelector('.gcash-fields').style.display = 'none';
            }
        }

        window.onload = toggleFields;
    </script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Food order system</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home.page') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('product.page') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.show') }}">My Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('my_orders.page') }}">My Orders</a></li>
                <li class="nav-item">
                    <form action="{{ route('users.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Order Section -->
<div class="container order-section mt-4">
    <h2 class="mb-4">Place Your Order</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h4>Review Your Cart</h4>
<table class="table table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php $totalPay = 0; @endphp
        @foreach($cartItems as $cartItem)
            @php 
                $itemTotal = $cartItem->product->product_price * $cartItem->quantity;
                $totalPay += $itemTotal;
            @endphp
            <tr>
                <td>{{ $cartItem->product->product_name }}</td>
                <td>{{ $cartItem->quantity }}</td>
                <td>₱{{ number_format($cartItem->product->product_price, 2) }}</td>
                <td>₱{{ number_format($itemTotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-end"><strong>Total Pay:</strong></td>
            <td><strong>₱{{ number_format($totalPay, 2) }}</strong></td>
        </tr>
    </tfoot>
</table>


    <!-- Order Form -->
    <form action="{{ route('order.place') }}" method="POST" enctype="multipart/form-data" class="form-section">
        @csrf

        <!-- Delivery or Pickup -->
        <h5>Delivery or Pickup</h5>
        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input type="radio" name="delivery_method" id="delivery" value="delivery" class="form-check-input" onchange="toggleFields()" required>
                <label for="delivery" class="form-check-label">Delivery</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="delivery_method" id="pickup" value="pickup" class="form-check-input" onchange="toggleFields()" required>
                <label for="pickup" class="form-check-label">Pickup</label>
            </div>
        </div>

        <!-- Delivery Address -->
        <div class="delivery-address mb-4">
            <label for="delivery_address" class="form-label">Delivery Address</label>
            <textarea name="delivery_address" class="form-control" rows="3"></textarea>
        </div>

        <!-- Payment Method -->
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select" onchange="toggleFields()" required>
                <option value="cash">Cash</option>
                <option value="gcash">GCash</option>
            </select>
        </div>

        <!-- GCash Fields -->
        <div class="gcash-fields mb-4">
            <div class="mb-3">
                <label for="gcash_picture" class="form-label">GCash Payment Screenshot</label>
                <input type="file" name="gcash_picture" class="form-control" accept="image/*">
            </div>
            <div>
                <label for="gcash_reference_number" class="form-label">GCash Reference Number</label>
                <input type="text" name="gcash_reference_number" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
    </form>

    <a href="{{ route('cart.show') }}" class="btn btn-secondary mt-4">← Back to Cart</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
