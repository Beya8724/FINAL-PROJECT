<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Orders</title>
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
        .table-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
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
        <h1 class="mb-4">All Orders</h1>

        <div class="table-section">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Order Code</th>
                        <th>Customer</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Way</th>
                        <th>Status</th>
                        <th>Tracking</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $orderGroup)
                        <tr>
                            <td>{{ $orderGroup->order_code }}</td>
                            <td>{{ $orderGroup->customer_name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($orderGroup->payment_method) }}</td>
                            <td>{{ ucfirst($orderGroup->payment_status) }}</td>
                            <td>{{ ucfirst($orderGroup->way) }}</td>
                            <td>{{ ucfirst($orderGroup->status) }}</td>
                            <td>{{ $orderGroup->tracking }}</td>
                            <td>
                                <a href="{{ route('admin.orders.view', $orderGroup->order_code) }}" class="btn btn-sm btn-primary">
                                    View Info
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
