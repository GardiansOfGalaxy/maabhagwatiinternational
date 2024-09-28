<!--<footer class="main-footer">-->
<!--  --><?php //if (isset($layout) && $layout == 'top'): ?>
<!--  <div class="container">-->
<!--  --><?php //endif; ?>
<!--    <div class="pull-right hidden-xs">-->
<!--      <b>Version</b> 1.0.0-->
<!--    </div>-->
<!--    <strong>Copyright &copy; 2023-2024 &copy;    All rights-->
<!--    reserved.</strong>-->

<!--  --><?php //if (isset($layout) && $layout == 'top'): ?>
<!--  </div>-->
<!--  --><?php //endif; ?>
<!--</footer>-->

<footer class="main-footer">
    <?php if (isset($layout) && $layout == 'top'): ?>
    <div class="container">
        <?php endif; ?>

        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>

        <div class="footer-content">
            <strong>Copyright &copy; 2023-2024, All rights reserved.</strong>
        </div>

        <?php if (isset($layout) && $layout == 'top'): ?>
    </div>
<?php endif; ?>
</footer>

<style>
    .footer-content {
        text-align: center;
    }

</style>

