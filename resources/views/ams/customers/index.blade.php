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
                        <th>#</th>
                        <th>Name / Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Total Orders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
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

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $customers->links() }}
        </div>
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
                            <td>${customer.customer_id}</td>
                            <td>${customer.name || customer.company || 'N/A'}</td>
                            <td>${customer.phone || 'N/A'}</td>
                            <td>${customer.email || 'N/A'}</td>
                            <td>${customer.orders_count || 0}</td>
                            <td>
                                <a href="{{ route('customers.show', $customer->customer_id) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="/customers/${customer.customer_id}/edit" class="btn btn-sm btn-warning">Edit</a>
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
                .catch(error => console.error('Error fetching search results:', error));
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
