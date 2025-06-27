@props(['cardHeader' => null, 'cardname' => 'default'])
<div class="card p-4 mb-4 card-{{ $cardname }}">
    <div class="mb-3 align-items-center justify-content-between">
        <h5 class="mb-0">
            <i class="bi bi-clock-history me-2"></i>
            {{$cardHeader}}
        </h5>
        <span class="text-muted">Review recent activity related to this cart below.</span>
    </div>
    <div class="mb-3">
        <label for="cartNotes" class="form-label">Notes</label>
        <textarea class="form-control" id="cartNotes" name="cartNotes" rows="2" placeholder="Enter your notes here"></textarea>
    </div>
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