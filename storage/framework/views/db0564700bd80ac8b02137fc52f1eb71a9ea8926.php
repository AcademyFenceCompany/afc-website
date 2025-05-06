<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Item No</th>
                <th>Height</th>
                <th>Color</th>
                <th>Mesh Size</th>
                <th>Weight</th>
                <th>Price</th>
                <th>Quantity</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $firstVariant = $product->color_variants->first();
                    $productName = $product->product_name;
                ?>
                <tr data-product-row="<?php echo e($product->product_id); ?>">
                    <td class="item-no"><?php echo e($firstVariant['item_no']); ?></td>
                    <td><?php echo e($product->size1); ?>'</td>
                    <td>
                        <?php
                            $variantsJson = json_encode($product->color_variants);
                        ?>
                        <select class="form-select color-select" data-variants='<?php echo e($variantsJson); ?>'
                            onchange="updateProductDetails(this)">
                            <?php $__currentLoopData = $product->available_colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($color); ?>"><?php echo e($color); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td class="mesh-size"><?php echo e($firstVariant['size2']); ?></td>
                    <td class="weight"><?php echo e($firstVariant['weight'] ?? '-'); ?> lbs</td>
                    <td class="price">$<?php echo e(number_format($product->price_per_unit, 2)); ?></td>
                    <td>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary quantity-decrease" type="button">-</button>
                            <input type="text" class="form-control text-center quantity-input" value="1"
                                data-price="<?php echo e($product->price_per_unit); ?>">
                            <button class="btn btn-outline-secondary quantity-increase" type="button">+</button>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-danger add-to-cart-btn" data-item="<?php echo e($firstVariant['item_no']); ?>"
                            data-price="<?php echo e($product->price_per_unit); ?>" data-product-name="<?php echo e($productName); ?>"
                            data-size1="<?php echo e($product->size1); ?>" data-size2="<?php echo e($firstVariant['size2']); ?>"
                            data-weight="<?php echo e($firstVariant['weight']); ?>"
                            data-family-category="<?php echo e($product->family_category_id); ?>"
                            data-shipping-length="<?php echo e($product->shipping_length); ?>"
                            data-shipping-width="<?php echo e($product->shipping_width); ?>"
                            data-shipping-height="<?php echo e($product->shipping_height); ?>"
                            data-shipping-class="<?php echo e($product->shipping_class); ?>">
                            Add to Cart
                        </button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH C:\xampp\htdocs\afc-website\resources\views/partials/product-table.blade.php ENDPATH**/ ?>