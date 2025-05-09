

<?php $__env->startSection('title', 'Customers List'); ?>

<?php $__env->startSection('content'); ?>
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
                        <th>Name</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($customer->name ?? 'N/A'); ?></td>
                            <td><?php echo e($customer->company ?? 'N/A'); ?></td>
                            <td><?php echo e($customer->contact ?? 'N/A'); ?></td>
                            <td><?php echo e($customer->phone ?? 'N/A'); ?></td>
                            <td><?php echo e($customer->email ?? 'N/A'); ?></td>
                            <td>
                                <a href="<?php echo e(route('ams.orders.create')); ?>?customer_id=<?php echo e($customer->id ?? 0); ?>"
                                    class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Create Order
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">No customers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <?php if(isset($pagination) && $pagination['last_page'] > 1): ?>
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    <?php if($pagination['current_page'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e(url('/ams/customers')); ?>?page=<?php echo e($pagination['current_page'] - 1); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&laquo;</span>
                        </li>
                    <?php endif; ?>

                    <!-- Pagination Elements -->
                    <?php for($i = 1; $i <= $pagination['last_page']; $i++): ?>
                        <li class="page-item <?php echo e($pagination['current_page'] == $i ? 'active' : ''); ?>">
                            <a class="page-link" href="<?php echo e(url('/ams/customers')); ?>?page=<?php echo e($i); ?>"><?php echo e($i); ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Page Link -->
                    <?php if($pagination['current_page'] < $pagination['last_page']): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e(url('/ams/customers')); ?>?page=<?php echo e($pagination['current_page'] + 1); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-hidden="true">&raquo;</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger mt-4">
                <?php echo e($error); ?>

            </div>
        <?php endif; ?>
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
                                <a href="<?php echo e(route('ams.orders.create')); ?>?customer_id=${customer.id || 0}" class="btn btn-sm btn-success">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/customers/index.blade.php ENDPATH**/ ?>