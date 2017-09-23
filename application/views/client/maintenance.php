<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->settings->get('windows_title');?> - <?php echo lang('maintenance_mode');?></title>
<?php echo html_css('css/maintenance.css');?>
</head>

<body>
<div id="wrapper">
	<div id="logo"></div>
	<div class="msg_box">
    	<?php echo lang('we_are_performing_maintenance');?>
	</div>
    <div class="footer">
    	Helpdesk Software Powered by <a href="http://www.deskigniter.com" target="_blank">DeskIgniter</a>
    </div>
</div>
</body>
</html>