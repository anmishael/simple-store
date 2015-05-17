<?php
/**
* Created on 21 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/
$_p_start = $this->_current_page - 2;
if($_p_start <= 0) {
	$_p_start = 1;
}
$_p_end = $this->_current_page + 2;
if($_p_end > $this->_totalpages) {
	$_p_end = $this->_totalpages;
}
?><div id="product-new">
<h2>Нові товари</h2>
<div class="separator"></div>
<ul class="products">
<?php $i=0; foreach($this->_items as $item) { ?>
<?php $images = $item->fetchImages()->get('images'); $image = $images['image'][100]; ?>
<li class="col<?php echo $i; ?>">
<div class="product">
	<div class="inner">
		<div class="image"><a href="<?php echo $this->topFolder; ?>product/view?id=<?php echo $item->get('id'); ?>"><img src="<?php echo $image[0]; ?>" border="0" /></a></div>
		<div class="description">
			<div class="name"><?php echo $item->get('name'); ?></div>
			<div class="brand"><?php echo $item->get('brand'); ?></div>
			<div class="price"><?php echo $item->get('price'); ?></div>
			<a class="button" href="/product/view?id=<?php echo $item->get('id'); ?>"><span>Go</span></a>
		</div>
		<div class="clear"></div>
	</div>
</div>
</li>
<?php $i++; if($i == $this->_params['rowlength']) { $i=0; ?><li class="clear separator"></li><?php }?>
<?php } ?>
</ul>
<div class="clear"></div>
<table width="100%"><tr><td align="center">
<div class="product-list"><form action="<?php echo $this->_url; ?>">
	<div class="pagination">
		<div class="pages"><?php if($this->_totalpages>1) { ?>
			<ul>
			<?php if($_p_start>1) { ?>
			<li><a href="?_p=<?php echo ($this->_current_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_PREV')->get('value'); ?></a></li>
			<?php } ?>
			<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
			<li><a<?php if($k == $this->_current_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a></li>
			<?php }?>
			<?php if($_p_end<$this->_totalpages) { ?>
			<li><a href="?_p=<?php echo ($this->_current_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_NEXT')->get('value'); ?></a></li>
			<?php } ?>
			<?php if($this->_totalpages>1) { ?>
			<!--<li>&nbsp;</li>
			<li><select name="_p" onchange="this.form.submit();">
			<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
				<option value="<?php echo $k; ?>"<?php if($k == $this->_current_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
			<?php } ?>
			</select></li>-->
			<?php } ?>
			<li class="clear"></li>
		</ul><?php } ?>
		</div>
	</div></form>
</div></td></tr></table>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#product-new .pagination .pages li a').unbind('click').bind('click', function() {
		var el = $(this);
		el.parent().siblings().find('a').removeClass('selected');
		el.addClass('selected');
		$.ajax({
			url: siteUrl+'product/list'+el.attr('href')+'&doctype=xml&block=New&exclude=<?php echo $this->_params['exclude']; ?>',
			type: 'xml',
			success: function(data) {
				$('#product-new .products').empty();
				var _i = 0;
				$(data).find('products').find('product').each(function() {
					$('#product-new .products').append(
								'<li class="col'+_i+'">'+
								'<div class="product">'+
								'<div class="inner">'+
								'<div class="image"><img src="'+$(this).find('image').text()+'" /></div>'+
								'<div class="description">'+
								'<div class="name">'+$(this).find('name').text()+'</div>'+
								'<div class="brand"></div>'+
								'<div class="price">'+$(this).find('price').text()+'</div>'+
								'<a class="button" href="/product/view?id="'+$(this).find('image').text()+'"><span>Go</span></a>'+
								'</div>'+
								'<div class="clear"></div>'+
								'</div>'+
								'</div>'+
								'</li>'
							);
					if(_i == <?php echo $this->_params['rowlength']?$this->_params['rowlength']:2; ?>) {
						$('#product-new .products').append('<li class="clear separator"></li>');
						_i = -1;
					}
					_i++;
				});
			}
		});
		return false;
	});
});
</script>