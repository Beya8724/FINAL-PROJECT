<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        .login-container .form-label {
            font-weight: 600;
            color: #495057;
        }

        .alert {
            text-align: center;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }

        .form-control {
            height: 45px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-container">
            <h2>User Login</h2>
            
            <!-- Login Form -->
            <form action="{{ route('users.login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <!-- Error message alert -->
                @if(session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <div class="text-center mt-3">
                <p>Don't have an account? <a href="{{ route('users.register') }}">Register here</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
