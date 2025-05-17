<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
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
        .table-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .form-section {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-white text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
        <a href="{{ route('admin.product') }}">Products</a>
        <a href="{{ route('admin.orders') }}" class="active">Orders</a>
        <a href="{{ route('admin.reports') }}">Reports</a>
        <form style="margin-left: 15px" action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
    <div class="main-content">
        <!-- Session Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1>Order Details - {{ $orders->first()->order_code }}</h1>

        <h5>👤 Customer: <strong>{{ $user->customer_name }}</strong> | 📞 Contact: {{ $user->customer_contact ?? 'N/A' }}</h5>
        <p><strong>Way:</strong> {{ ucfirst($orders->first()->way) }}</p>

        <div class="table-container mt-4">
            <table class="table table-striped table-bordered">
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
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->product_name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($order->product_price ?? 0, 2) }}</td>
                            <td>{{ ucfirst($order->way) }}</td>
                            <td>
                                {{ $order->product_price > 0 
                                    ? number_format($order->price / $order->product_price, 0)
                                    : '1' 
                                }}
                            </td>
                            <td>₱{{ number_format($order->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="mt-3">💰 Total Price: <strong>₱{{ number_format($totalPrice, 2) }}</strong></h5>
        </div>

        @if ($orders->first()->payment_method === 'gcash')
            <div class="mt-4">
                <h4>📷 GCash Payment Details</h4>

                @if ($orders->first()->gcash_picture)
                    <p><strong>Receipt:</strong></p>
                    <img src="{{ asset('storage/' . $orders->first()->gcash_picture) }}" 
                         alt="GCash Receipt" 
                         style="max-width: 300px; border: 1px solid #ccc;">
                @else
                    <p>No receipt uploaded.</p>
                @endif

                <p class="mt-2"><strong>Reference Number:</strong> {{ $orders->first()->gcash_reference_number }}</p>
            </div>
        @endif

        <div class="form-section">
            <form action="{{ route('admin.orders.update', $orders->first()->order_code) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="payment_status" class="form-label">Payment Status:</label>
                    <select name="payment_status" id="payment_status" class="form-select">
                        <option value="paid" {{ $orders->first()->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ $orders->first()->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tracking" class="form-label">Delivery Status:</label>
                    <select name="tracking" id="tracking" class="form-select">
                        <option value="on the way" {{ $orders->first()->tracking === 'on the way' ? 'selected' : '' }}>On the Way</option>
                        <option value="completed" {{ $orders->first()->tracking === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary ms-2">← Back to Orders</a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (necessary for the dismiss alert functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
