@extends('layouts.ams')

@section('title', 'Product Query')

@section('content')
    @if(isset($error))
        <div class="alert alert-danger">
            <h4>Error accessing productsqry view:</h4>
            <p>{{ $error }}</p>
        </div>
    @endif

    <!-- Database Structure Section -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">DemoDB Structure</h5>
            <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#structureCollapse">
                Show/Hide
            </button>
        </div>
        <div class="collapse" id="structureCollapse">
            <div class="card-body">
                <!-- Database Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Database Connection Info</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Connection</th>
                                        <td>{{ $dbInfo['connection'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Database Name</th>
                                        <td>{{ $dbInfo['database_name'] ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Tables in Database</h6>
                        <div class="table-responsive">
                            @if(isset($dbInfo['tables']) && !empty($dbInfo['tables']))
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Table Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dbInfo['tables'] as $table)
                                            <tr>
                                                @php
                                                    $tableName = reset($table);
                                                @endphp
                                                <td>{{ $tableName }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif(isset($dbInfo['tables_error']))
                                <div class="alert alert-warning">
                                    Error: {{ $dbInfo['tables_error'] }}
                                </div>
                            @else
                                <p>No tables found</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Views in Database -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6>Views in Database</h6>
                        <div class="table-responsive">
                            @if(isset($dbInfo['views']) && !empty($dbInfo['views']))
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>View Name</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dbInfo['views'] as $view)
                                            <tr>
                                                @php
                                                    $viewInfo = (array)$view;
                                                    $keys = array_keys($viewInfo);
                                                    $viewName = $viewInfo[$keys[0]];
                                                    $viewType = isset($keys[1]) ? $viewInfo[$keys[1]] : 'VIEW';
                                                @endphp
                                                <td>{{ $viewName }}</td>
                                                <td>{{ $viewType }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif(isset($dbInfo['views_error']))
                                <div class="alert alert-warning">
                                    Error: {{ $dbInfo['views_error'] }}
                                </div>
                            @else
                                <p>No views found</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <h6>Available Columns in productsqry view:</h6>
                @if(!empty($structure))
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Column Name</th>
                                    <th>Data Type</th>
                                    <th>Mapped To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($structure as $column => $type)
                                    <tr>
                                        <td><code>{{ $column }}</code></td>
                                        <td>{{ $type }}</td>
                                        <td>
                                            @if(isset($columnMap) && in_array($column, $columnMap))
                                                <span class="badge bg-success">
                                                    {{ array_search($column, $columnMap) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Not mapped</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <p>No structure information available for productsqry view.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Tree Column -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Product Hierarchy</h5>
                </div>
                <div class="card-body p-0">
                    @if(!empty($productTree))
                        <div class="product-tree">
                            <ul class="tree-root list-unstyled">
                                @foreach($productTree as $majorCategory)
                                    <li class="major-category">
                                        <div class="tree-item" data-bs-toggle="collapse" data-bs-target="#major-{{ str_replace(' ', '-', $majorCategory['name']) }}">
                                            <i class="bi bi-folder me-2"></i>
                                            <span>{{ $majorCategory['name'] }}</span>
                                            <i class="bi bi-chevron-down float-end"></i>
                                        </div>
                                        <ul class="collapse list-unstyled ps-4" id="major-{{ str_replace(' ', '-', $majorCategory['name']) }}">
                                            @foreach($majorCategory['children'] as $category)
                                                <li class="category">
                                                    <div class="tree-item" data-bs-toggle="collapse" data-bs-target="#category-{{ str_replace(' ', '-', $category['name']) }}">
                                                        <i class="bi bi-folder me-2"></i>
                                                        <span>{{ $category['name'] }}</span>
                                                        <i class="bi bi-chevron-down float-end"></i>
                                                    </div>
                                                    <ul class="collapse list-unstyled ps-4" id="category-{{ str_replace(' ', '-', $category['name']) }}">
                                                        @foreach($category['children'] as $product)
                                                            <li class="product">
                                                                <div class="tree-item product-link" data-product="{{ json_encode($product['product']) }}">
                                                                    <i class="bi bi-file-earmark me-2"></i>
                                                                    <span>{{ $product['name'] }}</span>
                                                                    <small class="text-muted ms-2">({{ $product['item_no'] }})</small>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-info m-3">
                            <p>No product hierarchy data available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Filters & Products Column -->
        <div class="col-md-8">
            <!-- Filters Section -->
            <div class="filters mb-4">
                <form method="GET" action="{{ route('ams.product-query.index') }}" class="filters-form">
                    <input type="text" name="search" class="search-input" placeholder="Search by Product Name, Item # or Description"
                        value="{{ $search ?? '' }}" />
                    
                    @if(isset($columnMap['category']) && $columnMap['category'] && count($categories) > 0)
                        <select name="category" class="filter-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ ($category == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    @endif
                    
                    <button class="filter-btn" type="submit">Apply Filters</button>
                    <a href="{{ route('ams.product-query.index') }}" class="btn btn-outline-secondary">Reset</a>
                </form>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Products from DemoDB (productsqry view)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    @if(isset($columnMap['id']) && $columnMap['id'])
                                        <th>ID</th>
                                    @endif
                                    @if(isset($columnMap['item_no']) && $columnMap['item_no'])
                                        <th>Item #</th>
                                    @endif
                                    @if(isset($columnMap['product_name']) && $columnMap['product_name'])
                                        <th>Product Name</th>
                                    @endif
                                    @if(isset($columnMap['category']) && $columnMap['category'])
                                        <th>Category</th>
                                    @endif
                                    @if(isset($columnMap['price']) && $columnMap['price'])
                                        <th>Price</th>
                                    @endif
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        @if(isset($columnMap['id']) && $columnMap['id'])
                                            <td>{{ $product->{$columnMap['id']} ?? 'N/A' }}</td>
                                        @endif
                                        @if(isset($columnMap['item_no']) && $columnMap['item_no'])
                                            <td>{{ $product->{$columnMap['item_no']} ?? 'N/A' }}</td>
                                        @endif
                                        @if(isset($columnMap['product_name']) && $columnMap['product_name'])
                                            <td>{{ $product->{$columnMap['product_name']} ?? 'N/A' }}</td>
                                        @endif
                                        @if(isset($columnMap['category']) && $columnMap['category'])
                                            <td>{{ $product->{$columnMap['category']} ?? 'N/A' }}</td>
                                        @endif
                                        @if(isset($columnMap['price']) && $columnMap['price'])
                                            <td>${{ number_format($product->{$columnMap['price']} ?? 0, 2) }}</td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info view-details" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#productDetailsModal"
                                                    data-product="{{ json_encode($product) }}">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ 
                                            (isset($columnMap['id']) && $columnMap['id'] ? 1 : 0) + 
                                            (isset($columnMap['item_no']) && $columnMap['item_no'] ? 1 : 0) + 
                                            (isset($columnMap['product_name']) && $columnMap['product_name'] ? 1 : 0) + 
                                            (isset($columnMap['category']) && $columnMap['category'] ? 1 : 0) + 
                                            (isset($columnMap['price']) && $columnMap['price'] ? 1 : 0) + 1 
                                        }}" class="text-center">No products found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($products) > 0)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} entries
                            </div>
                            <div>
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="product-all-attributes">
                        <!-- All attributes will be displayed here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle View Details button click
        document.querySelectorAll('.view-details, .product-link').forEach(button => {
            button.addEventListener('click', function() {
                const product = JSON.parse(this.getAttribute('data-product'));
                
                // Open the modal if this is a tree item click
                if (this.classList.contains('product-link')) {
                    const modal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
                    modal.show();
                }
                
                const detailsContainer = document.getElementById('product-all-attributes');
                
                // Clear previous content
                detailsContainer.innerHTML = '';
                
                // Create a table to display all attributes
                const table = document.createElement('table');
                table.className = 'table table-striped table-bordered';
                
                // Add header
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                const th1 = document.createElement('th');
                th1.textContent = 'Attribute';
                const th2 = document.createElement('th');
                th2.textContent = 'Value';
                headerRow.appendChild(th1);
                headerRow.appendChild(th2);
                thead.appendChild(headerRow);
                table.appendChild(thead);
                
                // Add body
                const tbody = document.createElement('tbody');
                
                // Add all attributes to the table
                for (const key in product) {
                    const row = document.createElement('tr');
                    
                    const cell1 = document.createElement('td');
                    cell1.innerHTML = `<strong>${key}</strong>`;
                    
                    const cell2 = document.createElement('td');
                    let value = product[key];
                    
                    // Format if it looks like a price
                    if (key.includes('price') || key.includes('cost')) {
                        if (value !== null && !isNaN(value)) {
                            value = '$' + parseFloat(value).toFixed(2);
                        }
                    }
                    
                    cell2.textContent = value !== null ? value : 'N/A';
                    
                    row.appendChild(cell1);
                    row.appendChild(cell2);
                    tbody.appendChild(row);
                }
                
                table.appendChild(tbody);
                detailsContainer.appendChild(table);
            });
        });
        
        // Tree toggle icons
        document.querySelectorAll('.tree-item[data-bs-toggle="collapse"]').forEach(item => {
            item.addEventListener('click', function() {
                const chevron = this.querySelector('.bi-chevron-down');
                if (chevron) {
                    chevron.classList.toggle('rotate-chevron');
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    .filters-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .search-input, .filter-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        flex-grow: 1;
    }
    
    .filter-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .filter-btn:hover {
        background-color: #0056b3;
    }
    
    .pagination {
        margin: 0;
    }
    
    /* Product Tree Styles */
    .product-tree {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .tree-root {
        padding: 0;
        margin: 0;
    }
    
    .tree-item {
        padding: 8px 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }
    
    .tree-item:hover {
        background-color: #f8f9fa;
    }
    
    .major-category > .tree-item {
        font-weight: bold;
        background-color: #e9ecef;
    }
    
    .category > .tree-item {
        background-color: #f1f3f5;
    }
    
    .product > .tree-item {
        color: #007bff;
    }
    
    .rotate-chevron {
        transform: rotate(180deg);
        transition: transform 0.2s;
    }
</style>
@endsection
