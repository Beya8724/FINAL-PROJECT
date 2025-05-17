<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
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

        .banner {
            background-image: url('https://via.placeholder.com/1200x400?text=Our+Menu');
            background-size: cover;
            background-position: center;
            height: 300px;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner h1 {
            font-size: 2.5rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .product-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
        }

        .product-card img {
            object-fit: cover;
            height: 200px;
            width: 100%;
            border-radius: 8px;
        }

        .product-price {
            font-weight: bold;
            color: #28a745;
        }

        .product-stock {
            color: #6c757d;
        }

        .add-to-cart-btn {
            background-color: #343a40;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
        }

        .add-to-cart-btn:hover {
            background-color: #495057;
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

    <!-- Navbar (Same as Home Page) -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Food order system</a>
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

    <!-- Banner Section -->
    <section class="banner">
        <h1>Our Products</h1>
    </section>

    <!-- Shop Page Content -->
    <div class="container my-5">
        @if($products->isEmpty())
        <p class="text-center">No products available at the moment.</p>
        @else
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}">
                    <h5 class="mt-3">{{ $product->product_name }}</h5>
                    <p class="product-price">₱{{ number_format($product->product_price, 2) }}</p>
                    <p class="product-stock">Stock: {{ $product->product_stocks }}</p>

                    @auth
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                    @endauth

                    @guest
                    <p>Please <a href="{{ route('users.login') }}">login</a> to add to cart.</p>
                    @endguest
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2500
        });
    @endif
</script>

</body>

</html>
