<?php
/**
 * @var $this CI_Model
 */
?>
        </div>
    </div>
</div>

<div id="footer" class="text-white">
    <div class="container">
        &copy; 2017 <?php echo $this->settings->get('site_name');?>
        <div class="text-right">
            Powered by DeskIgniter
        </div>
    </div>
</div>
<?php
echo html_script([
    'assets/jquery/jquery.min.js',
    'assets/popper/popper.min.js',
    'assets/bootstrap/js/bootstrap.min.js',
]).getOutput('script');
?>
</body>
</html>