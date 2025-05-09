

<?php $__env->startSection('title', 'Product Search Results'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Search Results</h5>
                    <a href="<?php echo e(route('ams.product-query.index')); ?>" class="btn btn-sm btn-light">Back to Categories</a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('ams.product-query.search')); ?>" method="GET" id="product-search-form">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search by ID, Item No, or Product Name" value="<?php echo e($query); ?>">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="search_type" class="form-select">
                                    <option value="all" <?php echo e($searchType == 'all' ? 'selected' : ''); ?>>All Fields</option>
                                    <option value="id" <?php echo e($searchType == 'id' ? 'selected' : ''); ?>>Product ID</option>
                                    <option value="item_no" <?php echo e($searchType == 'item_no' ? 'selected' : ''); ?>>Item Number</option>
                                    <option value="name" <?php echo e($searchType == 'name' ? 'selected' : ''); ?>>Product Name</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Found <?php echo e($products->total()); ?> products for "<?php echo e($query); ?>"</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($products->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Item No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Enabled</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($product->id); ?></td>
                                            <td>
                                                <?php if($product->img_small): ?>
                                                    <img src="<?php echo e(url('storage/products/' . $product->img_small)); ?>" 
                                                         alt="<?php echo e($product->product_name); ?>" 
                                                         class="img-thumbnail" style="max-width: 50px;">
                                                <?php else: ?>
                                                    <div class="no-image text-center text-muted">No Image</div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($product->item_no); ?></td>
                                            <td><?php echo e($product->product_name); ?></td>
                                            <td><?php echo e($product->category_name ?? 'Uncategorized'); ?></td>
                                            <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                                            <td>
                                                <span class="badge <?php echo e($product->web_enabled ? 'bg-success' : 'bg-danger'); ?>">
                                                    <?php echo e($product->web_enabled ? 'Yes' : 'No'); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('ams.product-query.edit', $product->id)); ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="<?php echo e(route('ams.product-query.duplicate', $product->id)); ?>" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="bi bi-files"></i> Duplicate
                                                </a>
                                                <a href="<?php echo e(route('product.show', $product->id)); ?>" 
                                                   class="btn btn-sm btn-info" target="_blank">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($products->appends(request()->query())->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-info m-3">
                            No products found matching your search criteria.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .no-image {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 4px;
        font-size: 0.7rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/product-query/search-results.blade.php ENDPATH**/ ?>