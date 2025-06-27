@extends('layouts.ams')

@section('title', 'Customers List')

@section('content')
    <div class="container-fluid p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center mb-2 mb-md-0">
            <h1 class="me-3">
                <i class="bi bi-people text-primary"></i> Customers List
            </h1>
            <span class="badge bg-secondary fs-6">{{ $customers->count() }} Total</span>
            </div>
            <div class="mt-2 mt-md-0 flex-grow-1">
                <p class="mb-0 text-muted">
                    Manage your customers efficiently. Use the search bar to find specific customers or browse through the list.
                </p>
            </div>
        </div>

        <!-- Search Form -->
        <form class="mb-4">
            <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
            <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search customers by name, company, email, or phone...">
            <button id="searchButton" type="button" class="btn btn-primary">
            <i class="bi bi-search"></i> Search
            </button>
            </div>
        </form>

        <div class="card">


            <div class="card-body">

                <!-- Customers Table -->
                <div id="customersTable" class="table-responsive rounded">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="">
                        <tr>
                            <th scope="col"><i class="bi bi-person-badge"></i> Name</th>
                            <th scope="col"><i class="bi bi-building"></i> Company</th>
                            <th scope="col"><i class="bi bi-person"></i> Contact</th>
                            <th scope="col"><i class="bi bi-telephone"></i> Phone</th>
                            <th scope="col"><i class="bi bi-envelope"></i> Email</th>
                            <th scope="col"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($customers as $customer)
                        <tr>
                            <td>
                            <span class="fw-semibold">
                            <i class="bi bi-person-circle text-secondary me-1"></i>
                            {{ $customer->name ?? 'N/A' }}
                            </span>
                            </td>
                            <td>
                            <i class="bi bi-building text-info me-1"></i>
                            {{ $customer->company ?? 'N/A' }}
                            </td>
                            <td>
                            <i class="bi bi-person-badge text-success me-1"></i>
                            {{ $customer->contact ?? 'N/A' }}
                            </td>
                            <td>
                            <i class="bi bi-telephone text-warning me-1"></i>
                            {{ $customer->phone ?? 'N/A' }}
                            </td>
                            <td>
                            <i class="bi bi-envelope text-danger me-1"></i>
                            {{ $customer->email ?? 'N/A' }}
                            </td>
                            <td class="">
                            <a href="{{ route('ams.get-customer', ['id' => $customer->id]) }}" class="btn btn-sm btn-success me-1" title="Create Order">
                            <i class="bi bi-plus"></i>
                            </a>
                            <a href=""
                            class="btn btn-sm btn-info me-1" title="View Details">
                            <i class="bi bi-eye"></i>
                            </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-person-x fa-2x mb-2"></i><br>
                            No customers found.
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                <p class="mb-0">
                    <i class="bi bi-info-circle-fill text-primary me-1"></i>
                    Use the search bar above to quickly find customers by name, company, email, or phone.
                </p>
            </div>
        </div>


        <!-- Custom Pagination -->
        @if(isset($pagination) && $pagination['last_page'] > 1)
        <div class="d-flex justify-content-center d-none mt-4">
            <nav>
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if($pagination['current_page'] > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ url('/ams/customers') }}?page={{ $pagination['current_page'] - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&laquo;</span>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for($i = 1; $i <= $pagination['last_page']; $i++)
                        <li class="page-item {{ $pagination['current_page'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ url('/ams/customers') }}?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if($pagination['current_page'] < $pagination['last_page'])
                        <li class="page-item">
                            <a class="page-link" href="{{ url('/ams/customers') }}?page={{ $pagination['current_page'] + 1 }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif

        @if(isset($error))
            <div class="alert alert-danger mt-4">
                {{ $error }}
            </div>
        @endif
    </div>
    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');

        function performSearch() {
            const query = searchInput.value;

            // AJAX call to fetch search results
            fetch(`/api/customers/search?query=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let tableRows = '';

                    if (data.length > 0) {
                        data.forEach(customer => {
                            tableRows += `
                        <tr>
                            <td>${customer.id || 'N/A'}</td>
                            <td>${customer.name || customer.company || 'N/A'}</td>
                            <td>${customer.contact || 'N/A'}</td>
                            <td>${customer.phone || 'N/A'}</td>
                            <td>${customer.email || 'N/A'}</td>
                            <td>
                                <a href="?customer_id=${customer.id || 0}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Create Order
                                </a>
                            </td>
                        </tr>
                    `;
                        });
                    } else {
                        tableRows = `
                    <tr>
                        <td colspan="6" class="text-center">No customers found.</td>
                    </tr>
                `;
                    }

                    // Update the table body
                    document.querySelector('#customersTable tbody').innerHTML = tableRows;
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    document.querySelector('#customersTable tbody').innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-danger">Error searching customers. Please try again.</td>
                        </tr>
                    `;
                });
        }

        // Trigger search on button click
        searchButton.addEventListener('click', performSearch);

        // Trigger search on Enter key in the input
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });
    </script>
@endsection
