@props(['cardHeader' => 'Customer Search', 'cardname' => 'default'])
<div class="card p-4 mb-4">
        <h5 class="mb-3">
            <i class="bi me-2 bi-person"></i>
            Customer Search
        </h5>

    <div class="">
        <form method="post" action="{{ route('ams.search-customer') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control customer-search" placeholder="Search customers..." aria-label="Search customers">
                <button class="btn btn-secondary" type="submit">Search Accounts</button>
            </div>
        </form>
        <div class="mt-3">


            <ul class="list-group search-results">


            </ul>


        </div>
    </div>
</div>
