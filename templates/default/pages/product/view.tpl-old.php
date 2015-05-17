<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php $images = $this->_item->get('images');$images = $images['image'];?>
<div id="product-view">
	<div id="image-area">
		<div id="main-image" class="box-rounded table">
			<div class="tr">
				<?php foreach($images['large'] as $k => $image) { ?>
				<div class="td mybox-row">
					<a class="mybox-thumb large" href="<?php echo $image ?>" rel="<?php echo $images['60'][$k] ?>"><img src="<?php echo $images['280'][$k] ?>" border="0" /></a>
                </div><?php } ?>
			</div>
		</div>
		<div class="thumbnails">
			<ul class="table">
			<?php foreach($images[60] as $k=>$image) { ?>
				<li class="box-rounded tr mybox-row"><a class="td mybox-thumb thumb" href="<?php echo $images['large'][$k]; ?>" rel="lightbox[small]"><img src="<?php echo $image; ?>" border="0" /></a></li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<div id="description-area">
		<h1><?php echo $this->_item->get('name')?></h1>
		<div class="sku">
			<div class="subtitle"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_CODE')->get('value'); ?>: <strong><?php echo $this->_item->get('code'); ?></strong></div>
		</div>
		<div class="sku">
			<div class="subtitle"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_SKU')->get('value'); ?>: <strong><?php echo $this->_item->get('sku'); ?></strong></div>
		</div>
		<br />
		<?php foreach($this->_filter_types as $url=>$type) { ?>
			<?php if($url == 'brand') { ?>
			<div class="brand">
			<?php foreach($type['filters'] as $id) { ?>
				<a class="title" class="fancybox" rel="lightbox[small]" href="<?php echo $this->_filters[$id]->get('url'); ?>"><?php echo $this->_filters[$id]->get('name'); ?></a>
			<?php } ?>
			</div>
			<?php } else { ?>
			<div class="filter <?php echo $url; ?>">
				<div class="subtitle"><?php echo $type['name']; ?>:</div>
				<ul>
				<?php foreach($type['filters'] as $id) { ?>
					<li><?php echo $this->_filters[$id]->get('name'); ?></li>
				<?php } ?>
				</ul>
			</div>
			<?php } ?>
		<?php } ?>
		<div class="subtitle"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_DESCRIPTION')->get('value'); ?></div>
		<div class="description"><?php echo $this->_item->get('description'); ?></div>
		<div class="price"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_PRICE')->get('value'); ?> <?php echo $this->_item->get('price') . ' ' . $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?></div>
		<div class="buy">
			<form action="<?php echo $this->topFolder; ?>cart/add" method="get">
			<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
			<table cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td rowspan="2"><input id="product-qty" type="text" name="qty[<?php echo $this->_item->get('id'); ?>]" value="1" /></td>
					<td align="center"><a href="javascript:;" class="plus">+</a></td>
					<td rowspan="2"><input type="submit" src="<?php echo $this->templateDir; ?>images/pixel-trans.gif" value="<?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_BUY')->get('value'); ?>" /></td>
				</tr>
				<tr>
					<td align="center"><a href="javascript:;" class="minus">-</a></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
    $('#product-view #image-area #main-image .tr .td').not(':first').hide();
    $('#product-view #image-area .thumbnails ul li').hover(function() {
        var el = $('#product-view #image-area #main-image .tr .td:eq('+$(this).index()+')');
        el.siblings().hide();
        el.show();
    }, function() {});
	$('#product-view #description-area .brand').each(function() {
		$(this).css({ background: 'transparent url(\'/images/filters/brand/'+$(this).find('a.title').attr('rel')+'-small.png\') no-repeat', width: '69px', height: '60px' })
		$(this).find('a.title').hide();
	});
	$('.buy .plus').bind('click', function() {
		$('#product-qty').val(parseInt($('#product-qty').val())+1);
	});
	$('.buy .minus').bind('click', function() {
		if(parseInt($('#product-qty').val())>1) {
			$('#product-qty').val(parseInt($('#product-qty').val())-1);
		}
	});
});
</script>