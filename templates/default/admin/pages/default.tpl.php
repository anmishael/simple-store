<?php
/*
 * Created on May 24, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<title><?php echo get_class($this); ?></title>
	<link rel="stylesheet" media="screen" href="<?php echo $this->templateDir; ?>css/screen.css" />
	<link rel="stylesheet" media="print" href="<?php echo $this->templateDir; ?>css/print.css" />
	<link rel="stylesheet" media="screen" href="<?php echo $this->templateDir; ?>css/superfish.css" />
	<script type="text/javascript">
		var templateDir = '<?php echo $this->templateDir; ?>';
		var siteUrl = '<?php echo $this->topFolder; ?>';
		var adminUrl = '<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>';
	</script>
	<script src="<?php echo $this->templateDir; ?>js/jquery-1.7.2.min.js"></script>
	<script src="<?php echo $this->templateDir; ?>js/hoverIntent.js"></script> 
	<script src="<?php echo $this->templateDir; ?>js/superfish.js"></script>
	<script src="<?php echo $this->templateDir; ?>js/webtoolkit.md5.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo $this->templateDir; ?>css/jquery.cleditor.css" />
	<script type="text/javascript" src="<?php echo $this->templateDir; ?>js/jquery.cleditor.js"></script>
	<script type="text/javascript" src="<?php echo $this->templateDir; ?>js/jquery.cleditor.table.min.js"></script>

	<!--<script src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
	<?php $this->displayBlock('header', false); ?>
	<script type="text/javascript">
		$(document).ready(function(){
	        $("ul.sf-menu").superfish();
	        $.fn.showDialog = function() {
	        	$('#dialog').show();
	        }
	        $.fn.hideDialog = function() {
	        	$('#dialog').hide();
	        }
	        $.fn.raiseInfo = function(info, tracker) {
				$('#dialog #dialog-box #content').empty();
	        	if(tracker && tracker.records) {
					$('#dialog #dialog-box #content').prepend($('<div class="percents"></div><div class="tracker"><div class="line"></div></div>'));
					var ps = parseInt(tracker.current)/parseInt(tracker.records);
					$('#dialog #dialog-box #content .tracker .line').css({ width: Math.ceil($('#dialog #dialog-box #content .tracker').width()*ps)+'px' });
					$('#dialog #dialog-box #content .percents').append($('<b>'+Math.ceil(ps*100)+'%</b>'));
				} else {
					$('#dialog #dialog-box #content').append(info);
				}
	        	$(this).showDialog();
	        };
	        $('#dialog #dialog-box .dialog-close').bind('click', function() {
	        	$(this).hideDialog();
	        });
			$("textarea.editor").cleditor({useCSS:false});
	    });
	</script>
</head>
<body>
<div id="dialog">
	<div id="dialog-box">
		<div id="content"></div>
		<a class="icon dialog-close" href="javascript:;" title="close"><span class="title">close</span></a>
	</div>
</div>
<div class="main-wrapper">
	<div id="header">
		<div id="user-details"><?php $this->displayBlock('userdetails', true); ?></div>
		<div id="logo"><a href="<?php echo $this->topFolder; ?>"><img src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif" width="100%" height="100%" /></a></div>
		<div class="clear"></div>
	</div>
	<?php if($this->blockSize('topmenu')>0) { ?>
	<div id="topmenu"><?php $this->displayBlock('topmenu', true); ?></div>
	<div class="clear"></div>
	<?php } ?>
	<?php if($this->blockSize('error')>0) { ?>
	<div class="box" id="error"><?php $this->displayBlock('error', true); ?></div>
	<?php } ?>
	<?php if($this->blockSize('content')>0) { ?>
	<div class="box" id="content"><?php $this->displayBlock('content', true); ?></div>
	<?php } ?>
</div>
<div class="main-wrapper copyright">
	<div class="clear"><p>&copy; WIDE Software</p></div>
</div>
</body>
</html>