<?php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
?>

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="<?php echo e($containerFooter); ?>">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                © <script>
                document.write(new Date().getFullYear())
                </script>, made with ❤️ by <a href="<?php echo e((!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '')); ?>" target="_blank" class="footer-link"><?php echo e((!empty(config('variables.creatorName')) ? config('variables.creatorName') : '')); ?></a>
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="<?php echo e(config('variables.adminTemplates') ? config('variables.adminTemplates') : '#'); ?>" class="footer-link me-4" target="_blank">Admin Templates</a>
                <a href="<?php echo e(config('variables.licenseUrl') ? config('variables.licenseUrl') : '#'); ?>" class="footer-link me-4" target="_blank">License</a>
                <a href="<?php echo e(config('variables.bootstrapDashboard') ? config('variables.bootstrapDashboard') : '#'); ?>" target="_blank" class="footer-link me-4">Bootstrap Dashboard</a>
                <a href="<?php echo e(config('variables.documentation') ? config('variables.documentation') . '/laravel-introduction.html' : '#'); ?>" target="_blank" class="footer-link me-4">Documentation</a>
                <a href="<?php echo e(config('variables.support') ? config('variables.support') : '#'); ?>" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer--><?php /**PATH C:\xampp\htdocs\sneat\resources\views/layouts/sections/footer/footer.blade.php ENDPATH**/ ?>