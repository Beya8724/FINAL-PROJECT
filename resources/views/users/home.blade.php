<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
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
            background-image: url('https://via.placeholder.com/1200x400?text=Burger+Shop+Banner');
            background-size: cover;
            background-position: center;
            height: 400px;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner h1 {
            font-size: 3rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .menu-section {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .menu-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 250px;
            text-align: center;
        }

        .menu-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .menu-card h4 {
            margin: 10px 0;
            font-size: 1.2rem;
            color: #343a40;
        }

        .menu-card p {
            font-size: 1rem;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
            padding: 10px;
            color: white;
            width: 100%;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
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

    <!-- Navbar -->
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
        <h1 >Welcome to Our Shop</h1>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
