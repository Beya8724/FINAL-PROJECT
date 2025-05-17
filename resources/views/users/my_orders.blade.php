<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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

        .order-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Food order system</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home.page') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('product.page') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.show') }}">My Cart</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('my_orders.page') }}">My Orders</a></li>
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

<!-- Orders Section -->
<div class="container my-5">
    <h2 class="mb-4">Hello, {{ $user->fullname ?? $user->name }}</h2>

    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        @foreach($orders as $orderCode => $orderGroup)
            <div class="order-card">
                <h4>Order Code: {{ $orderCode }}</h4>
                <p>Status: <strong>{{ ucfirst($orderGroup->first()->status) }}</strong></p>
                <p>Payment: <strong>{{ ucfirst($orderGroup->first()->payment_status) }}</strong></p>
                <p>Tracking: <strong>{{ ucfirst($orderGroup->first()->tracking) }}</strong></p>

                <table class="table table-bordered mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Way</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderGroup as $order)
                            <tr>
                                <td>{{ $order->product->product_name ?? 'N/A' }}</td>
                                <td>₱{{ number_format($order->product->product_price ?? 0, 2) }}</td>
                                <td>{{ ucfirst($order->way) }}</td>
                                <td>{{ $order->product && $order->product->product_price > 0 
                                    ? number_format($order->price / $order->product->product_price, 0) : '1' }}</td>
                                <td>₱{{ number_format($order->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="text-end"><strong>Total:</strong> ₱{{ number_format($orderGroup->sum('price'), 2) }}</p>
            </div>
        @endforeach
    @endif

    <a href="{{ route('home.page') }}" class="btn btn-secondary mt-4">← Back to Home</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
