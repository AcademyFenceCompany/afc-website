@php
$item = [
    'name' => '6ft Chain Link Fence Panel',
    'quantity' => 3,
    'price' => 129.99,
];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { margin: 0; padding: 0; background-color: #f9f5f1; font-family: 'Segoe UI', sans-serif; }
    table { border-collapse: collapse; width: 100%; }
    .container { max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; overflow: hidden; }

    .header { background-color: #882905; color: #fff; padding: 24px; text-align: center; }
    .header h1 { margin: 0; font-size: 24px; }

    .content { padding: 24px; color: #333; }
    .content h2 { color: #5a732c; }
    .content p { margin: 12px 0; line-height: 1.5; }

    .order-summary { background-color: #f1ebe6; padding: 16px; border-radius: 6px; }
    .order-summary table { width: 100%; font-size: 14px; }
    .order-summary th, .order-summary td { padding: 8px; text-align: left; }

    .btn { background-color: #5a732c; color: white; text-decoration: none; padding: 12px 20px; border-radius: 4px; display: inline-block; margin-top: 20px; }

    .footer { background-color: #f3f3f3; text-align: center; font-size: 12px; color: #888; padding: 16px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Thank You for Your Order!</h1>
    </div>
    <div class="content">
      <h2>Hi {{ $name ?? 'Customer' }},</h2>
      <p>Your order <strong>#{{ $orderNumber ?? '0000' }}</strong> has been successfully placed on {{ $orderDate ?? now()->format('F j, Y') }}.</p>

      <div class="order-summary">
        <h3 style="margin-top: 0;">Order Summary</h3>
        <table>
          <thead>
            <tr>
              <th>Item</th>
              <th>Qty</th>
              <th style="text-align:right;">Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items ?? [] as $item)
              <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td style="text-align:right;">${{ number_format($item['price'], 2) }}</td>
              </tr>
            @endforeach
            <tr>
              <td colspan="2"><strong>Total</strong></td>
              <td style="text-align:right;"><strong>${{ number_format($total ?? 0, 2) }}</strong></td>
            </tr>
          </tbody>
        </table>
      </div>

      <a href="{{ $dashboardUrl ?? '#' }}" class="btn">View Your Order</a>
    </div>
    <div class="footer">
      © {{ date('Y') }} Academy Fence. All rights reserved.
    </div>
  </div>
</body>
</html>
