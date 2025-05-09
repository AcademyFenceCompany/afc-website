

<?php $__env->startSection('title', 'CMS Pages'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <a href="<?php echo e(route('ams.cms.pages.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create New Page
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($page->cat_name); ?></td>
                                    <td><?php echo e($page->title); ?></td>
                                    <td><?php echo e($page->updated_at); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('ams.cms.pages.edit', $page->id)); ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('ams.cms.pages.destroy', $page->id)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this page?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.tiny.cloud/1/fqzaaogo06nq3byhp6e1ia5t3r29nvwitty5q04x54v9dgak/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.tinymce',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        height: 300,
        image_class_list: [
            { title: 'Responsive', value: 'img-fluid' }
        ],
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        },
        images_upload_url: '/ams/upload-image',
        automatic_uploads: true,
        images_reuse_filename: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/cms/pages/index.blade.php ENDPATH**/ ?>