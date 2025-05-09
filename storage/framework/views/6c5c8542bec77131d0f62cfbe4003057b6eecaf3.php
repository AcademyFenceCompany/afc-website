

<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        body {
            background-color: #C1BFD8;
        }

        .login-header {
            background-color: #4E4C67;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .login-card {
            background-color: #C1BFD8;
            padding: 20px;
            max-width: 400px;
            margin: 30px auto;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .form-control {
            background-color: white;
            border: 1px solid #4E4C67;
            border-radius: 5px;
        }

        .btn-login {
            background-color: #4E4C67;
            color: white;
            font-weight: bold;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .footer-gate {
            background-image: url('/resources/images/gates.png');
            background-repeat: no-repeat;
            background-position: center bottom;
            background-size: contain;
            height: 150px;
        }
    </style>
    <div>
        <div class="login-header">
            ACADEMY FENCE COMPANY AMS
        </div>
        <div class="card login-card">
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">USER NAME</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username"
                        value="<?php echo e(old('username')); ?>" required autofocus>
                    <?php if($errors->has('username')): ?>
                        <div class="text-danger mt-2">
                            <?php echo e($errors->first('username')); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">PASSWORD</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" required>
                    <?php if($errors->has('password')): ?>
                        <div class="text-danger mt-2">
                            <?php echo e($errors->first('password')); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-login">LOG IN</button>
                </div>
            </form>
        </div>

        <div class="footer-gate"></div>
    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\afc-website\resources\views/auth/login.blade.php ENDPATH**/ ?>