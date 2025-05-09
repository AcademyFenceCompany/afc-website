

<?php $__env->startSection('title', 'Product Query'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product Management</h5>
                    <a href="<?php echo e(route('ams.product-query.create')); ?>" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('ams.product-query.search')); ?>" method="GET" id="product-search-form">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search by ID, Item No, or Product Name" value="<?php echo e(request('q')); ?>">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="search_type" class="form-select">
                                    <option value="all" <?php echo e(request('search_type') == 'all' ? 'selected' : ''); ?>>All Fields</option>
                                    <option value="id" <?php echo e(request('search_type') == 'id' ? 'selected' : ''); ?>>Product ID</option>
                                    <option value="item_no" <?php echo e(request('search_type') == 'item_no' ? 'selected' : ''); ?>>Item Number</option>
                                    <option value="name" <?php echo e(request('search_type') == 'name' ? 'selected' : ''); ?>>Product Name</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="category-tree">
                        <?php $__currentLoopData = $productTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major => $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="category-item">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-link toggle-btn" type="button">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                    <span class="category-link fw-bold"><?php echo e($major); ?></span>
                                </div>
                                <ul class="nested ps-3">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catName => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="javascript:void(0);" class="subcategory-link d-block py-1 px-2"
                                               data-cat-id="<?php echo e($group['category_id']); ?>">
                                                <?php echo e($catName); ?>

                                                <span class="badge bg-secondary float-end"><?php echo e($group['paginator']->total()); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Product Display -->
        <div class="col-md-9" id="product-panel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Select a category to see products</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">No category selected.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle category tree items
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const nested = btn.closest('li').querySelector('.nested');
                const icon = btn.querySelector('i');
                nested.classList.toggle('active');
                icon.classList.toggle('bi-chevron-right');
                icon.classList.toggle('bi-chevron-down');
            });
        });

        // Load category products
        document.querySelectorAll('.subcategory-link').forEach(link => {
            link.addEventListener('click', () => {
                const catId = link.getAttribute('data-cat-id');
                loadCategoryProducts(catId);
            });
        });
        
        // Handle pagination clicks using event delegation
        document.getElementById('product-panel').addEventListener('click', function(e) {
            // Check if the clicked element is a pagination link
            if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
                e.preventDefault();
                
                // Get the URL from the pagination link
                const url = e.target.getAttribute('href');
                if (!url) return;
                
                // Fetch the content via AJAX
                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('product-panel').innerHTML = html;
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Failed to load products.");
                    });
            }
        });
        
        // Function to load category products
        function loadCategoryProducts(catId, page = 1) {
            const url = `/ams/product-query/category/${catId}${page > 1 ? '?page=' + page : ''}`;
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('product-panel').innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    alert("Failed to load products.");
                });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .category-tree, .nested { list-style: none; padding-left: 0; }
    .nested { display: none; margin-top: 5px; }
    .nested.active { display: block; }
    .toggle-btn { padding: 0 5px; border: none; background: transparent; cursor: pointer; }
    .category-link, .subcategory-link {
        cursor: pointer;
        display: block;
        padding: 4px 8px;
        text-decoration: none;
    }
    .subcategory-link:hover {
        background: #f0f0f0;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/product-query/index.blade.php ENDPATH**/ ?>