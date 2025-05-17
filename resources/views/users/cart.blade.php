<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Cart</title>
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

        .cart-table th, .cart-table td {
            text-align: center;
        }

        .cart-table th {
            background-color: #343a40;
            color: white;
        }

        .cart-table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .btn-danger {
            background-color: red;
            color: white;
        }

        .btn-danger:hover {
            background-color: darkred;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
            color: white;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #495057;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Burger Shop</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.page') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.page') }}">Menu</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.show') }}">My Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my_orders.page') }}">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('users.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">Logout</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.register') }}">Register</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- My Cart Section -->
    <div class="container my-5">
        <h1 class="text-center mb-4">My Cart</h1>

        <!-- Display Success or Error Messages -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Check if the cart is empty -->
        @if($cartItems->isEmpty())
        <p class="text-center">Your cart is empty.</p>
        @else
        <table class="table table-striped cart-table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $cartItem)
                <tr>
                    <td><img src="{{ asset('storage/' . $cartItem->product->product_image) }}" alt="Product Image"></td>
                    <td>{{ $cartItem->product->product_name }}</td>
                    <td>₱{{ number_format($cartItem->product->product_price, 2) }}</td>
                    <td>{{ $cartItem->quantity }}</td>
                    <td>₱{{ number_format($cartItem->product->product_price * $cartItem->quantity, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.delete', $cartItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Place Order Button -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('order.place') }}" class="btn btn-primary">Place Order</a>
            <a href="{{ route('product.page') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>
        @endif
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
