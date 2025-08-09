<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div x-cloak>
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl card-3d p-8 card-animate smooth-all">
    <div class="mb-6 animate-fade delay-100">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome back</h2>
        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
            Sign in to access the document control system
        </p>
    </div>

    <?php if(session('status')): ?>
    <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg text-sm">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg text-sm">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="animate-fade-up delay-200">
            <label for="email" class="block text-sm font-medium text-gray-800 dark:text-gray-200">Email Address</label>
            <div class="mt-2 input-group">
                <svg class="icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206A8.959 8.959 0 0112 21"/>
                </svg>
                <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="Enter your email address">
            </div>
        </div>

        <div x-data="{ show: false }" class="animate-fade-up delay-300">
            <label for="password" class="block text-sm font-medium text-gray-800 dark:text-gray-200">Password</label>
            <div class="mt-2 input-group">
                <svg class="icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.943 0 1.809-.332 2.49-.888M15 7a3 3 0 10-6 0 3 3 0 006 0zM4 7v10a2 2 0 002 2h12a2 2 0 002-2V7"/>
                </svg>
                <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember"
                       name="remember"
                       type="checkbox"
                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-800 dark:text-gray-200">
                    Remember me
                </label>
            </div>

            <div class="text-sm">
                <a href="<?php echo e(route('password.request')); ?>"
                   class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                    Forgot password?
                </a>
            </div>
        </div>

        <div class="animate-fade-up delay-400">
            <button type="submit"
                    class="w-full py-3 px-4 text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-900 btn-elevate">
                Sign In
            </button>
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-700 dark:text-gray-300">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>"
                   class="font-medium text-primary-700 hover:text-primary-600 dark:text-primary-300 dark:hover:text-primary-200 transition-colors">
                    Register here
                </a>
            </p>
        </div>
    </form>
    </div>
</div>

<style>
.auth-input {
    @apply appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-500 rounded-lg placeholder-gray-500 dark:placeholder-gray-300 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors;
}
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\My Own Project\document-control2\resources\views/auth/login.blade.php ENDPATH**/ ?>