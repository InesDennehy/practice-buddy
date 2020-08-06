<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card register-card border-0 shadow">
                <div class="card-header"><h4 class="text-center"><?php echo e(__('Register')); ?></h4></div>

                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Name')); ?></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('E-Mail Address')); ?></label>

                            <div class="col-md-6">
                                <input id="register-email" type="email" class="form-control<?php echo e($errors->has('register-email') ? ' is-invalid' : ''); ?>" name="register-email" value="<?php echo e(old('register-email')); ?>" required>

                                <?php if($errors->has('register-email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('register-email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('password')); ?></label>

                            <div class="col-md-6">
                                <input id="register-password" type="password" class="form-control<?php echo e($errors->has('register-password') ? ' is-invalid' : ''); ?>" name="register-password" required>

                                <?php if($errors->has('register-password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('register-password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirm password')); ?></label>

                            <div class="col-md-6">
                                <input id="register-password-confirm" type="password" class="form-control" name="register-password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <span><?php echo e(__('Register')); ?></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
