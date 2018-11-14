<?php $__env->startComponent('mail::message'); ?>
# Change password Request

Click on the button below.

<?php $__env->startComponent('mail::button', ['url' => 'http://localhost:4200/response-pass-reset?token='.$token]); ?>
Reset Password
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
