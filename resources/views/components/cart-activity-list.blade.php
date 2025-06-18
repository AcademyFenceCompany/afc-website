@props(['cardHeader' => null, 'cardname' => 'default'])
<div class="card p-4 mb-4 card-{{ $cardname }}">
    <h4 class="mb-3">{{ $cardHeader }}</h4>
    

        <ol class="list-group list-group-flush border-0">
            <li class="list-group-item d-flex align-items-center">
                1: A list item<span class="text-muted small ms-auto ms-3">10:30 AM</span>
            </li>
            <li class="list-group-item d-flex align-items-center">
                 A list item
                <span class="text-muted small ms-auto ms-3">10:30 AM</span>
            </li>
            <li class="list-group-item d-flex align-items-center">
                 A list item
                <span class="small ms-auto ms-3 text-danger">10:30 AM</span>
            </li>

        </ol>



</div>