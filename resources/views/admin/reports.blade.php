<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Reports</title>
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
        .report-links a {
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-white text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard')}}">Dashboard</a>
        <a href="{{ route('admin.product') }}">Products</a>
        <a href="{{ route('admin.orders') }}">Orders</a>
        <a href="{{ route('admin.reports') }}" class="active">Reports</a>
        <form style="margin-left: 15px" action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <div class="main-content">
        <h1 class="mb-4">📊 Order Reports</h1>

        <div class="report-links">
            <h4 class="mb-3">🗂 Completed Orders Summary</h4>

            <a href="{{ route('admin.reports.daily') }}" class="btn btn-outline-primary" target="_blank">🖨 Print Daily Report</a>
            <a href="{{ route('admin.reports.weekly') }}" class="btn btn-outline-success" target="_blank">🖨 Print Weekly Report</a>
            <a href="{{ route('admin.reports.monthly') }}" class="btn btn-outline-warning" target="_blank">🖨 Print Monthly Report</a>
        </div>
    </div>

</body>
</html>
