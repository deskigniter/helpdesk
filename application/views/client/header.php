<?php
/**
 * @var $this CI_Model
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo (isset($site_title) ? $site_title.' - ' : '').$this->settings->get('windows_title');?></title>
    <?php
    echo html_css([
        'assets/bootstrap/css/bootstrap.min.css',
        'assets/bootstrap/css/bootstrap-grid.min.css',
        'assets/font-awesome/css/font-awesome.min.css',
        'assets/deskigniter/css/client.css'
    ]).getOutput('css');
    ?>
</head>
<body>
<div id="wrapper">
    <div id="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url();?>"><i class="fa fa-fire"></i> <?php echo $this->settings->get('site_name');?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <?php if($this->settings->get('knowledgebase') == 'yes'):?>
                            <li class="nav-item <?php if($this->uri->segment(1) == 'kb'){ echo 'active'; }?>">
                                <a class="nav-link" href="<?php echo site_url('kb');?>"><?php echo lang('knowledgebase');?></a>
                            </li>
                            <?php
                        endif;
                        if($this->settings->get('news') == 'yes'):
                            ?>
                            <li class="nav-item <?php if($this->uri->segment(1) == 'news'){ echo 'active'; }?>">
                                <a class="nav-link" href="<?php echo site_url('news');?>"><?php echo lang('news');?></a>
                            </li>
                        <?php endif;?>
                        <?php if($this->client->isOnline()):?>
                        <li class="nav-item <?php if($this->uri->segment(1) == 'tickets' && $this->uri->segment(2) == 'manage'){ echo 'active'; }?>">
                            <a class="nav-link" href="<?php echo site_url('tickets/manage');?>"><?php echo lang('tickets');?></a>
                        </li>
                        <?php else:?>
                        <li class="nav-item <?php if($this->uri->segment(1) == 'tickets' && $this->uri->segment(2) == 'new'){ echo 'active'; }?>">
                            <a class="nav-link" href="<?php echo site_url('tickets/new');?>"><?php echo lang('submit_ticket');?></a>
                        </li>
                        <?php endif;?>
                        <?php if(!$this->client->isOnline()):?>
                            <li class="nav-item <?php if($this->uri->segment(1) == 'auth' && $this->uri->segment(2) == 'login'){ echo 'active'; }?>">
                                <a class="nav-link" href="<?php echo site_url('auth/login');?>"><?php echo lang('sign_in');?></a>
                            </li>
                        <?php endif;?>
                    </ul>
                    <?php if($this->client->isOnline()):?>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user"></i> Account
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#"><?php echo lang('profile');?></a>
                                    <a class="dropdown-item" href="#"><?php echo lang('logout');?></a>
                                </div>
                            </li>
                        </ul>
                    <?php endif;?>
                </div>
            </div>
        </nav>
        <?php echo getOutput('slider');?>
        <div class="container mt-5">
