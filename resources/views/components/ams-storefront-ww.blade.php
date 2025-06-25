<div class="">
    <div  class="row">
        <div class="col-md-12">
        @php
            // Group products by size2 and size3
            $groupedProducts = collect($products)->groupBy(function($item) {
                return ($item->size2 ?? '') . ' / ' . ($item->size3 ?? '');
            });
        @endphp

        @foreach ($groupedProducts as $groupLabel => $items)
            <p class="text-dark p-2 m-0 text-center" style="font-size: 0.85em;background-color:rgb(219, 219, 219);">
                Mesh size and Gauge <strong>{{ $groupLabel }}</strong>
            </p>
            <table class="table m-0 align-middle" style="font-size: {{ auth()->user()->username === 'neal' ? '0.85em' : '' }};">
                <thead>
                    <tr>
                        <th class="align-middle">Item Number</th>
                        <th class="align-middle">Roll</th>
                        <th class="align-middle">Mesh</th>
                        <th class="align-middle">Gauge</th>
                        <th class="align-middle">Price</th>
                        <th class="align-middle">
                            {{ auth()->user()->firstname == 'colin' ? 'In Stock' : 'Inv' }}
                        </th>
                        <th class="align-middle">Quantity</th>
                        <th class="align-middle"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="align-middle">
                            <td>
                                {{ $item->item_no ?? '' }}
                                @if(isset($item->color))
                                    @php
                                        $colorClass = match(strtolower($item->color)) {
                                            'black' => 'bg-dark text-light',
                                            'green' => 'bg-success text-light',
                                            'brown' => 'bg-brown text-light',
                                            'white' => 'bg-white text-dark border',
                                            'yellow' => 'bg-warning text-dark',
                                            'Galvanized' => 'bg-silver text-light',
                                            default => 'bg-silver text-dark',
                                        };
                                    @endphp
                                    <span class="badge badge-pill {{ $colorClass }}">{{ ucfirst($item->color) }}</span>
                                @endif
                            </td>
                            <td>{{ $item->size ?? '' }}</td>
                            <td>{{ $item->size2 ?? '' }}</td>
                            <td>{{ $item->size3 ?? '' }}</td>
                            <td>{{ $item->price ?? '' }}</td>
                            <td>
                                @if($item->in_stock > 10)
                                    <span class="badge rounded-pill bg-success">In Stock</span>
                                @elseif($item->in_stock > 0)
                                    <span class="badge rounded-pill bg-warning text-dark">Low ({{ $item->in_stock }})</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                <input
                                    type="number"
                                    class="form-control form-control-sm incre-qty"
                                    data-product-id="{{ $item->id }}"
                                    name="quantity_{{ $item->item_no ?? '' }}"
                                    min="1"
                                    value="1"
                                    style="width:60px;">
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-success text-light btn-sm add-to-cart ripple"
                                    data-product-id="{{ $item->id }}"
                                >
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
        </div>
    </div>
</div>
