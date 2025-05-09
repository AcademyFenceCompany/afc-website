<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Products in Category</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Item No</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Enabled</th>
                    <th>Stock (Orange)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($product->item_no); ?></td>
                    <td><?php echo e($product->product_name); ?></td>
                    <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                    <td><?php echo e($product->enabled ? 'Yes' : 'No'); ?></td>
                    <td><?php echo e($product->inv_orange); ?></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('ams.product-query.edit', $product->id)); ?>" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="<?php echo e(route('ams.product-query.duplicate', $product->id)); ?>" class="btn btn-success">
                                <i class="bi bi-files"></i> Duplicate
                            </a>
                            <button type="button" class="btn btn-danger delete-product" data-id="<?php echo e($product->id); ?>" data-name="<?php echo e($product->product_name); ?>">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="m-3 pagination-container">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <span id="productNameToDelete"></span>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set up delete product buttons
        document.querySelectorAll('.delete-product').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                
                document.getElementById('productNameToDelete').textContent = productName;
                document.getElementById('deleteProductForm').action = "<?php echo e(route('ams.product-query.destroy', '')); ?>/" + productId;
                
                // Show the modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
                deleteModal.show();
            });
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/product-query/_products.blade.php ENDPATH**/ ?>