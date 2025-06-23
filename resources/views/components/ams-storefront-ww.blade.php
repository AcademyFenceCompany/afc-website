<div class="">
    @php
    $products = [
        [
            'mesh_size' => '2"x2"',
            'gauge' => '12',
            'items' => [
                ['item_number' => 'WW-2212-01', 'size' => '48in x 50ft', 'price' => '$120.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-2212-02', 'size' => '60in x 100ft', 'price' => '$220.00', 'in_stock' => 'No'],
                ['item_number' => 'WW-2212-03', 'size' => '36in x 25ft', 'price' => '$65.00', 'in_stock' => 'Yes'],
            ],
        ],
        [
            'mesh_size' => '1"x1"',
            'gauge' => '14',
            'items' => [
                ['item_number' => 'WW-1114-01', 'size' => '36in x 50ft', 'price' => '$98.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1114-02', 'size' => '48in x 100ft', 'price' => '$185.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1114-03', 'size' => '24in x 25ft', 'price' => '$55.00', 'in_stock' => 'No'],
            ],
        ],
        [
            'mesh_size' => '1/2"x1/2"',
            'gauge' => '16',
            'items' => [
                ['item_number' => 'WW-1216-01', 'size' => '24in x 50ft', 'price' => '$75.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1216-02', 'size' => '36in x 100ft', 'price' => '$140.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1216-03', 'size' => '48in x 25ft', 'price' => '$60.00', 'in_stock' => 'No'],
            ],
        ],
        [
            'mesh_size' => '1/4"x1/4"',
            'gauge' => '23',
            'items' => [
                ['item_number' => 'WW-1423-01', 'size' => '24in x 100ft', 'price' => '$110.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1423-02', 'size' => '36in x 50ft', 'price' => '$90.00', 'in_stock' => 'No'],
                ['item_number' => 'WW-1423-03', 'size' => '48in x 25ft', 'price' => '$55.00', 'in_stock' => 'Yes'],
            ],
        ],
        [
            'mesh_size' => '1"x2"',
            'gauge' => '14',
            'items' => [
                ['item_number' => 'WW-1214-01', 'size' => '36in x 50ft', 'price' => '$105.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1214-02', 'size' => '48in x 100ft', 'price' => '$195.00', 'in_stock' => 'Yes'],
                ['item_number' => 'WW-1214-03', 'size' => '60in x 25ft', 'price' => '$75.00', 'in_stock' => 'No'],
            ],
        ],
    ];
    @endphp

    @foreach ($products as $group)
        <p class="bg-secondary text-light p-2">Mesh Size: {{ $group['mesh_size'] }}, Gauge: {{ $group['gauge'] }}</p>
        <table class="table mb-4" style="font-size: 0.85em;">
            <thead>
            <tr>
            <th>Item Number</th>
            <th>Size</th>
            <th>Price</th>
            <th>In Stock</th>
            <th>Quantity</th>
            <th>Add to Cart</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($group['items'] as $item)
            <tr>
                <td>{{ $item['item_number'] }}</td>
                <td>{{ $item['size'] }}</td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['in_stock'] }}</td>
                <td>
                <input type="number" name="quantity_{{ $item['item_number'] }}" min="1" value="1" style="width:60px;" @if($item['in_stock'] !== 'Yes') disabled @endif>
                </td>
                <td>
                <button type="button" class="btn btn-success btn-sm" @if($item['in_stock'] !== 'Yes') disabled @endif>
                   <i class="bi bi-cart-plus"></i>
                </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
</div>