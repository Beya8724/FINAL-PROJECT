<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Report</title>
</head>
<body>
    <h1>Monthly Sales Report ({{ \Carbon\Carbon::now()->format('F Y') }})</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Order Code</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
                    <td>₱{{ number_format($order->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Orders: {{ $orders->count() }}</h3>
    <h3>Total Sales: ₱{{ number_format($orders->sum('total_price'), 2) }}</h3>
</body>
</html>

<script>
    window.onload = function() {
        window.print();
    }
</script>
