<!-- Search Global Component Customers -->
@if(!$customersQuery->isEmpty())
    <li>
        <h6 class="dropdown-header text-info">Customers</h6>
    </li>
    @foreach($customersQuery as $customer)
        <li class="dropdown-item">
            <a href="" class="d-flex flex-column text-decoration-none">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">{{ $customer->name }}</span>
                    @if(!empty($customer->phone))
                        <small class="text-dark ms-2"><i class="bi bi-telephone"></i> {{ $customer->phone }}</small>
                    @endif
                </div>
                @if(!empty($customer->company))
                    <small class="text-muted">{{ $customer->company }}</small>
                @endif
                <small class="text-dark">{{ $customer->address ?? '123 Main St, City, ST' }}</small>
            </a>
        </li>
    @endforeach
@endif
<!-- Search Global Component Products -->
@if(!$productsQuery->isEmpty())
    <li>
        <h6 class="dropdown-header text-info">Products</h6>
    </li>
    @foreach($productsQuery as $product)
        <li class="dropdown-item">
            <a href="" class="d-flex flex-column text-decoration-none">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">{{ $product->product_name }}</span>
                    @if(!empty($product->item_no))
                        <small class="text-dark ms-2">#{{ $product->item_no }}</small>
                    @endif
                </div>
            </a>
        </li>
    @endforeach
@endif
<!-- Orders -->
<!-- <li>
    <h6 class="dropdown-header text-primary">Orders</h6>
</li>
<li><a class="dropdown-item" href="#">Order Result 1</a></li>
<li><a class="dropdown-item" href="#">Order Result 2</a></li> -->
