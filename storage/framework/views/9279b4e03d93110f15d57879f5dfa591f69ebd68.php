<?php $__env->startSection('content'); ?>
    <div class="top-panel my-auto h-100 w-100 d-table">
        <div class="d-table-cell align-middle">
            <h1 class="display-3 text-center">Welcome to Practice Buddy</h1>
            <h2 class="text-center">The practice tracker everyone needs</h2>
            <div class="py-4">
                <a href="#bottom-panel" onclick="
                    // Make sure this.hash has a value before overriding default behavior
                    if (this.hash !== '') {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 100, function(){
                    });
                    } // End if
                ">
                    <button class="button center slide"></button>
                </a>
            </div>
        </div>
    </div>
    <div class="row bottom-panel h-100 w-100" id="bottom-panel">
        <div class="col md-6 login-div">
            <?php echo $__env->make('auth.login', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col md-6 register-div">
            <?php echo $__env->make('auth.register', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('css/welcome.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>