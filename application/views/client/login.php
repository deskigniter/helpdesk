<?php
/**
 * @var $this CI_Model
 */

include 'header.php';
?>
<!-- Login Box -->
<div class="row justify-content-between">
    <div class="col-lg-6">
        <h2 class="mb-4"><?php echo lang_replace('sign_in_to_site', ['%site_name%' => $this->settings->get('site_name')]);?></h2>
        <?php echo form_open('auth/login',['id' => 'loginForm']);?>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" placeholder="<?php echo lang('email');?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" placeholder="<?php echo lang('password');?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="remember" value="1" checked />
                    <?php echo lang('stay_signed_in');?>
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <button class="btn btn-dark btn-block"><?php echo lang('sign_in');?></button>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <a href="<?php echo site_url('auth/forgot');?>"><?php echo lang('forgot_password');?></a>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
    <div class="col-lg-6">
        <div class="signin-container">
            <?php if($this->settings->get('googleoauth') == 1 && $this->settings->get('facebookoauth') == 1):?>
                <div class="signin-bottom mb-4">
                    <div class="ml-4 mb-5">
                        <h3 class="mb-4">..or login with</h3>
                        <?php if($this->settings->get('googleoauth') != 1):?>
                            <a class="btn btn-dark text-white pointer"><i class="fa fa-google fa-2x"></i></a>
                        <?php endif;?>
                        <?php if($this->settings->get('facebookoauth') == 1):?>
                            <a class="btn btn-dark text-white pointer"><i class="fa fa-facebook fa-2x"></i></a>
                        <?php endif;?>
                        <?php if($this->settings->get('facebookoauth') == 1):?>
                            <a class="btn btn-dark text-white pointer"><i class="fa fa-twitter fa-2x"></i></a>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
            <div class="pl-4">
                <h2 class="mb-4"><?php echo lang('sign_up');?></h2>
                <p><?php echo lang('sign_up_message');?></p>
                <a href="<?php echo site_url('auth/register');?>" class="btn btn-dark"><?php echo lang('sign_up');?></a>
            </div>
        </div>

    </div>
</div>
<!-- End Login Box -->
<?php
include 'footer.php';