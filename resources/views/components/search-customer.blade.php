@foreach($customers as $customer)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <div class="fw-bold">{{$customer->name}}</div>
            123 Main St, Springfield, IL
        </div>
        <span class="badge text-bg-primary rounded-pill">14</span>
    </li>
@endforeach
