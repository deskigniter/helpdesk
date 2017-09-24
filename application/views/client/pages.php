<?php setOutput(); ?>
<div class="slider-block">
    <div class="slider-content">
        <div class="container">
            <h1>How can we help you?</h1>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="input-group input-group-lg">
                        <input type="text" name="keyword" placeholder="I need help with..." class="form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
setOutput('slider');
include 'header.php';
?>
<h1 class="title_light mb-4"><?php echo $content->title;?></h1>
<div><?php echo $content->content;?></div>
<?php
include 'footer.php';