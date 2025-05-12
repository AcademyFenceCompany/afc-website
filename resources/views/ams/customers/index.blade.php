@extends('layouts.ams')

@section('title', 'Customers List')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Customers List</h1>

        <!-- Search Form -->
        <div class="mb-4 d-flex">
            <input type="text" id="searchInput" class="form-control me-2"
                placeholder="Search customers by name, company, email, or phone...">
            <button id="searchButton" class="btn btn-primary">Search</button>
        </div>

        <!-- Customers Table -->
        <div id="customersTable" class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
<<<<<<< HEAD
                        <th>#</th>
                        <th>Name / Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Total Orders</th>
=======
                        <th>Name</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Email</th>
>>>>>>> origin/ready-push-main
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
<<<<<<< HEAD
                            <td>{{ $customer->customer_id }}</td>
                            <td>{{ $customer->name ?: $customer->company }}</td>
                            <td>{{ $customer->phone ?: 'N/A' }}</td>
                            <td>{{ $customer->email ?: 'N/A' }}</td>
                            <td>{{ $customer->orders_count }}</td>
                            <td>
                                <a href="{{ route('customers.show', $customer->customer_id) }}"
                                    class="btn btn-sm btn-primary">
                                    View
                                </a>
                                <a href="{{ route('customers.edit', $customer->customer_id) }}"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <a href="{{ route('ams.orders.create', ['customer_id' => $customer->customer_id]) }}"
=======
                            <td>{{ $customer->name ?? 'N/A' }}</td>
                            <td>{{ $customer->company ?? 'N/A' }}</td>
                            <td>{{ $customer->contact ?? 'N/A' }}</td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>{{ $customer->email ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('ams.orders.create') }}?customer_id={{ $customer->id ?? 0 }}"
>>>>>>> origin/ready-push-main
                                    class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Create Order
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

<<<<<<< HEAD
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $customers->links() }}
        </div>
=======
        <!-- Custom Pagination -->
        @if(isset($pagination) && $pagination['last_page'] > 1)
        <div class="d-flex justify-content-center mt-4">
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
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
                            <td>${customer.customer_id}</td>
                            <td>${customer.name || customer.company || 'N/A'}</td>
                            <td>${customer.phone || 'N/A'}</td>
                            <td>${customer.email || 'N/A'}</td>
                            <td>${customer.orders_count || 0}</td>
                            <td>
                                <a href="/ams/customers/${customer.customer_id}" class="btn btn-sm btn-primary">View</a>
                                <a href="/ams/customers/${customer.customer_id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <a href="/ams/orders/create?customer_id=${customer.customer_id}" class="btn btn-sm btn-success">
=======
                            <td>${customer.id || 'N/A'}</td>
                            <td>${customer.name || customer.company || 'N/A'}</td>
                            <td>${customer.contact || 'N/A'}</td>
                            <td>${customer.phone || 'N/A'}</td>
                            <td>${customer.email || 'N/A'}</td>
                            <td>
                                <a href="{{ route('ams.orders.create') }}?customer_id=${customer.id || 0}" class="btn btn-sm btn-success">
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
                .catch(error => console.error('Error fetching search results:', error));
=======
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    document.querySelector('#customersTable tbody').innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-danger">Error searching customers. Please try again.</td>
                        </tr>
                    `;
                });
>>>>>>> origin/ready-push-main
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
