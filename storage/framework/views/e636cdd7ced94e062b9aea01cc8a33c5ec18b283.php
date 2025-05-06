
<?php $__env->startSection('title', 'Edit Category Page'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #4e4c67;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('ams.cms.pages.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.tiny.cloud/1/fqzaaogo06nq3byhp6e1ia5t3r29nvwitty5q04x54v9dgak/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 300,
            image_class_list: [{
                title: 'Responsive',
                value: 'img-fluid'
            }],
            setup: function(editor) {
                editor.on('change', function() {
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

<?php echo $__env->make('layouts.ams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/ams/cms/pages/edit.blade.php ENDPATH**/ ?>