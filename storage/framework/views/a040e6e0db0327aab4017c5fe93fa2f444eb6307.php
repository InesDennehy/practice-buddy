<?php $__env->startSection('content'); ?>
    <window username=<?php echo e(Auth::user()->name); ?> logout_route=<?php echo e(route('logout')); ?>></window>
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/pieces.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/categories.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>