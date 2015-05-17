<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $this->_core->getModel('Page/Collection')->getCurrentPage()->get('menutitle') . ' '; $this->displayBlock('title'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php $this->displayBlock('metakeys', false); ?>">
<meta name="description" content="<?php $this->displayBlock('metadescription', false); ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $this->templateDir; ?>css/screen.css" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo $this->templateDir; ?>css/print.css" media="print" />
<link type="text/css" href="<?php echo $this->templateDir; ?>css/jquery-ui.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?php echo $this->templateDir; ?>css/my-box.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?php echo $this->templateDir; ?>css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?php echo $this->templateDir; ?>css/jplayer.blue.monday.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?php echo $this->templateDir; ?>css/lightbox.css" rel="stylesheet" media="all" />

<script type="text/javascript">
var templateDir = '<?php echo $this->templateDir; ?>';
var siteUrl = '<?php echo $this->topFolder; ?>';
</script>
<script src="<?php echo $this->templateDir; ?>js/main.js"></script>
<script src="<?php echo $this->templateDir; ?>js/jquery.all.js"></script>
<script src="<?php echo $this->templateDir; ?>js/jquery.smooth-scroll.min.js"></script>
<script src="<?php echo $this->templateDir; ?>js/jquery.tmpl.js"></script>
<script src="<?php echo $this->templateDir; ?>js/jquery.crypt.js"></script>
<script src="<?php echo $this->templateDir; ?>js/jquery.jplayer.min.js"></script>
<script src="<?php echo $this->templateDir; ?>js/jquery.jscrollpane.min.js"></script>
<script src="<?php echo $this->templateDir; ?>js/lightbox.js"></script>
<script src="<?php echo $this->templateDir; ?>js/shoppingCart.js"></script>
<?php if(!$this->_core->getSingleton('Config')->offline) { ?><script src="http://maps.google.com/maps/api/js?sensor=true&libraries=places"></script><?php } else { ?>
<script type="text/javascript">
google = false;
</script>
<?php } ?>
<?php $this->displayBlock('header', false); ?>
<!--
<style type="text/css">
img { behavior: url('<?php echo $this->templateDir; ?>css/iepngfix/iepngfix.htc'); }
</style>
-->
<script type="text/javascript">
var TMPL = new Object();
var allowDisplayDialog = 0;

var myObject = function() {
	this.data = new Array();
	this.push = function(key, val) {
		this.data[key] = val;
		return this;
	}
	this.get = function(key) {
		return this.data[key];
	}
}
var Settings = new myObject();
var Translate = new myObject();
$(document).ready(function() {
	$.fn.loadSettings = function() {
		$.ajax({
			url:siteUrl+'setting/list?doctype=xml',
			dataType: 'xml',
			success: function(data) {
				$(data).find('settings setting').each(function() {
					Settings.push($(this).find('key').text(), $(this).find('value').text());
				});
			}
		});
	};
	$.fn.loadTranslation = function() {
		$.ajax({
			url:siteUrl+'translate/list?doctype=xml',
			dataType: 'xml',
			success: function(data) {
				$(data).find('translate item').each(function() {
					Translate.push($(this).find('key').text(), $(this).find('value').text());
				});
			}
		});
	};
	$('document').loadSettings();
	$('document').loadTranslation();
	$.fn.getUrlVars = function(url){
	    var vars = [], hash;
	    var hashes = url.slice(url.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	      hash = hashes[i].split('=');
	      vars.push(hash[0]);
	      vars[hash[0]] = hash[1];
	    }
	    return vars;
	  }
	$.fn.getUrlVar = function(url, name){
	    return $(this).getUrlVars(url)[name];
	  }
	$('#dialog').css({ height: $(document).height()+'px' });
//	$('.fancy').fancybox();
//    $(".mybox-view").myBox({
//        prevEffect	: 'none',
//        nextEffect	: 'none',
//        helpers	: {
//            thumbs	: {
//                width	: 50,
//                height	: 50
//            }
//        }
//    });
	$.fn.fillDialog = function(data, options){
		if(allowDisplayDialog>0) {
			$('#dialog-box').empty();
			$.tmpl(TMPL['dialog'], data, options).appendTo('#dialog-box');
			if(options.action) {
				$('#dialog-form').attr('action', options.action);
			}
			$('#dialog .btn-close').unbind('click');
			$('#dialog .btn-close').bind('click', function() {
				$(this).hideDialog();
				return false;
			});
		}
	}
	$.fn.fillDialogSimple = function(data, options){
		if(allowDisplayDialog>0) {
			$('#dialog-box').empty();
			$.tmpl(TMPL['simple'], data, options).appendTo('#dialog-box');
			
			$('#dialog .btn-close').unbind('click');
			$('#dialog .btn-close').bind('click', function() {
				$(this).hideDialog();
				return false;
			});
		}
	}
	$.fn.showDialog = function() {
		$('#dialog-box').css({ marginTop: (150+$(window).scrollTop())+'px' });
		$('#dialog').show();
	}
	$.fn.hideDialog = function() {
		$('#dialog').hide();
	}
	$.fn.displayError = function(message) {
		if(typeof message != "string") {
			var txt = '';
			$(message).find('messages').find('message').each(function() {
				txt += '<div class="error">'+$(this).find('content').text()+'</div>\n';
			});
			$(this).fillDialogSimple({content:txt});
		} else {
			$(this).fillDialogSimple({content:message});
		}
		$(this).showDialog();
		$('#dialog .btn-close').unbind('click');
		$('#dialog .btn-close').bind('click', function() {
			$(this).hideDialog();
			return false;
		});
	}
	$.ajax({
		url:templateDir+'pages/dialog/dialog.html',
		dataType: ($.browser.msie) ? "text" : 'html',
		success: function(data) {
			TMPL['dialog'] = data;
			allowDisplayDialog++;
		}
	});
	$.ajax({
		url:templateDir+'pages/dialog/simple.html',
		dataType: ($.browser.msie) ? "text" : 'html',
		success: function(data) {
			TMPL['simple'] = data;
			allowDisplayDialog++;
		}
	});
//	/$( ".date" ).datepicker();
	
	$.fn.addLoading = function() {
		$('#dialog-form .content').append('<div class="loading"></div>');
	}
	$.fn.removeLoading = function() {
		$('#dialog-form .content .loading').remove();
	}
	if($('ul.box-slider li').length>0) {
		$('ul.box-slider li').hide();
		$('ul.box-slider li:first').show();
		$('ul.box-slider').each(function() {
			var sz = $(this).find('li').length;
			var ul = $('<ul class="pick"></ul>')
			for(var k=0; k<sz; k++) {
				ul.append('<li><a href="javascript:;"><img src="'+templateDir+'css/images/pixel-trans.gif" width="8" height="7" border="1" /></a></li>')
			}
			$(this).parent().append(ul);
			$(this).parent().find('ul.pick li:first').addClass('active');
			$(this).parent().find('ul.pick li').bind('click', function() {
				$(this).parent().find('li.active').removeClass('active');
				$(this).addClass('active');
				$(this).parent().parent().find('.box-slider li').hide();
				$(this).parent().parent().find('.box-slider li:eq('+$(this).index()+')').show();
			});

			var arrows = $('<div class="arrows"><div class="arrow arrow-left"></div><div class="arrow arrow-right"></div></div>');
			$(this).parent().append(arrows);
			arrows.find('.arrow').bind('click', function() {
				var curr = $(this).parents('.arrows').parent().find('.pick li.active');
				var el = $(this).parents('.arrows').parent().find('.box-slider');
				if($(this).hasClass('arrow-left')) {
					if(curr.prev()[0]) {
						curr.removeClass('active');
						curr.prev().addClass('active');
						$(el).find('li.tr').hide();
						$(el).find('li.tr').eq(curr.prev().index()).show('slow');
					} else {
						curr.removeClass('active');
						curr.parent().find('li:last').addClass('active');
						$(el).find('li.tr').hide();
						$(el).find('li.tr:last').show('slow');
					}
				} else {
					if(curr.next()[0]) {
						curr.removeClass('active');
						curr.next().addClass('active');
						$(el).find('li.tr').hide();
						$(el).find('li.tr').eq(curr.next().index()).show('slow');
					} else {
						curr.removeClass('active');
						curr.parent().find('li:first').addClass('active');
						$(el).find('li.tr').hide();
						$(el).find('li.tr:first').show('slow');
					}
				}
			});
			arrows.css({opacity: 0.0});
			$(this).parent().hover(function() {
				$(this).find('.arrows').animate({opacity: 1.0}, 'fast');
			}, function() {
				$(this).find('.arrows').animate({opacity: 0.0}, 'fast');
			});
		});
	}
	if($('.box-slider')[0]) {
		var intervals = new Array();
	        	$.fn.roll = function(id) {
	        		var el = $('#'+id);
	        		var curr = $(el).parent().find('.pick li.active');
	        		if(curr.next()[0]) {
	        			curr.removeClass('active');
	        			curr.next().addClass('active');
	        			$(el).find('li.tr').hide();
	        			$(el).find('li.tr').eq(curr.next().index()).show('slow');
	        		} else {
	        			curr.removeClass('active');
	        			curr.parent().find('li:first').addClass('active');
	        			$(el).find('li.tr').hide();
	        			$(el).find('li.tr:first').show('slow');
	        		}
	        	}
	        	$.fn.startRoll = function(id) {
	        		intervals[id] = setInterval('$(this).roll(\''+id+'\')', <?php echo $this->_core->getModel('Setting/Collection')->get('BOX_SLIDER_SPEED_MILISEC')->get('value'); ?>);
	        	}
	        	$.fn.stopRoll = function(id) {
	        		clearInterval(intervals[id]);
	        	}
	        	$('.box-slider').hover(function() {
	        			$(this).stopRoll($(this).attr('id'));
	        		},function() {
	        			$(this).startRoll($(this).attr('id'));
	        		}
	        	);
	        	$('.pick').hover(function() {
	        			$(this).stopRoll($(this).parent().find('.box-slider').attr('id'));
	        		},function() {
	        			$(this).startRoll($(this).parent().find('.box-slider').attr('id'));
	        		}
	        	);
	        	$('.box-slider').each(function(i) {
	        		$(this).attr('id', 'box-slider-'+i)
	        		$(this).startRoll($(this).attr('id'));
	      });
	}
});
//a custom format option callback
		var addressFormatting = function(text){
			var newText = text;
			//array of find replaces
			var findreps = [
				{find:/^([^\-]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
				{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
				{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
				{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
				{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
			];
			
			for(var i in findreps){
				newText = newText.replace(findreps[i].find, findreps[i].rep);
			}
			return newText;
		}
</script>
</head>
<body>
<div id="dialog">
	<div id="dialog-box"></div>
</div>
<?php $this->displayBlock('menuregistration', true); ?>
<div id="main-body">
	<div id="top-strip">
		<div class="main-wrapper-nobg"><div class="inner-wrapper-nobg">

		</div></div>
		<div class="clear"></div>
	</div>
	<div class="main-wrapper"><div class="inner-wrapper">
		<div id="header">
			<div id="logo"><a href="<?php echo $this->topFolder; ?>"><img src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif" width="100%" height="100%" /></a></div>
			<div id="menu-header"><?php $this->displayBlock('menuheader', true); ?></div>
			<div id="login-area">
				<span class="icon"></span>
				<?php if(!$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) { ?>
				<a class="login" href="/customer/login"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN', 'value')->get('value'); ?></a>/<a class="register" href="/customer/register"><?php echo $this->_core->getModel('Translate/Collection')->get('BOX_LOGIN_REGISTRATION', 'value')->get('value'); ?></a>
				<?php } else { ?>
				<a class="view" href="/customer/view"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_PROFILE', 'value')->get('value'); ?></a>/<a class="register" href="/customer/view#my-orders"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_VIEW_MY_ORDERS', 'value')->get('value'); ?></a>/<a class="logout" href="/customer/logout"><?php echo $this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGOUT', 'value')->get('value'); ?></a>
				<?php } ?>
			</div>
			<div class="search"><form action="<?php echo $this->topFolder; ?>search" method="get">
				<div class="text"><?php echo $this->_core->getModel('Translate/Collection')->get('HEADER_TEXT', 'value')->get('value'); ?></div>
				<div class="input">
					<table height="100%" width="98%" cellspacing="0" cellpadding="0" align="right">
						<tr>
							<td><input type="text" name="search" value="<?php echo htmlspecialchars($this->_core->getRequestGet('search')); ?>" /></td>
							<td width="52" align="right"><input type="submit" src="<?php echo $this->templateDir; ?>css/images/pixel-trans.gif" width="52" height="30" value="пошук" /></td>
						</tr>
					</table>
				</div>
				<div class="text"><?php echo $this->_core->getModel('Translate/Collection')->get('HEADER_TEXT2', 'value')->get('value'); ?></div>
			</form></div><?php $this->displayBlock('languagebar', true);	?><?php $this->displayBlock('cartbox', true); ?>
		</div>
		<div class="clear"></div>
	</div></div>
	<div class="main-wrapper"><div class="inner-wrapper">
		<div id="main-top">
				<?php $this->displayBlock('menutop', true);	?>
		</div>
		<div class="clear"></div>
	</div></div>
	<div class="clear"></div>
	<div class="main-wrapper"><div class="inner-wrapper"><?php $this->displayBlock('error', true); ?></div></div>
	<div class="clear"></div>
	<div class="main-wrapper"><div class="inner-wrapper">
		<?php $withleft = ''; if($this->getOutput('contentleft')) {?>
			<div id="content-left">
			<?php $this->displayBlock('contentleft', true); ?>
			</div>
		<?php $withleft = 'withleft'; } ?>
		<div id="content-main" class="<?php echo $withleft.($this->getOutput('contentright')?' withright':''); ?>"><?php $this->displayBlock('content', true); ?></div>
		<?php if($this->getOutput('contentright')) { ?>
			<div id="content-right">
			<?php $this->displayBlock('contentright', true); ?>
			</div>
		<?php } else { ?>
			<?php //$this->displayBlock('error', true);	?>
		<?php } ?>
		<div class="clear"></div>
	</div></div>
	<div id="searchdescription"><?php $this->displayBlock('searchdescription', true); ?></div>
	<div id="main-footer">
		<div class="clip"></div>
		<div class="main-wrapper clip"><div class="inner-wrapper">
			<div id="footer">
				<?php $this->displayBlock('footer', true); ?>
			</div>
		</div></div>
	</div>
<?php if($this->getOutput('debug')) { ?>
	<div id="debug">
		<div class="title">Debug</div>
		<div class="content">
		<?php $this->displayBlock('debug', true); ?>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#debug .title').bind('click', function() {
			var el = $('#debug .content');
			if(el.is(':visible')) {
				el.hide();
			} else {
				el.show();
			}
		});
	});

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41458480-1', 'panda.lviv.ua');
  ga('send', 'pageview');


</script>
	<?php } ?>
</div>
</body>
</html>