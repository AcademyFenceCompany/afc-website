@props(['cardHeader' => 'Customer Search', 'cardname' => 'default'])
<div class="card mb-4">
    <div class="card-header">
        Customer Search
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('ams.search-customer') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control customer-search" placeholder="Search customers..." aria-label="Search customers">
                <button class="btn btn-secondary" type="submit">Search Accounts</button>
            </div>
        </form>
        <div class="mt-3">


            <ul class="list-group search-results">

                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Jane Smith</div>
                        456 Oak Ave, Lincoln, NE
                    </div>
                    <span class="badge text-bg-primary rounded-pill">8</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Michael Johnson</div>
                        789 Pine Rd, Madison, WI
                    </div>
                    <span class="badge text-bg-primary rounded-pill">21</span>
                </li>
            </ul>


        </div>
    </div>
</div>
