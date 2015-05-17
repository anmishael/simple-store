<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$_p_start = $this->_current_page - 5;
if($_p_start <= 0) {
	$_p_start = 1;
}
$_p_end = $this->_current_page + 5;
if($_p_end > $this->_totalpages) {
	$_p_end = $this->_totalpages;
}
$m_items_per_bundle = 5;
?>
<div id="product-list">
	<div id="product-list-main">
		<?php
		if(isset($this->_items)) {
			?>
			<div id="product-list-list" class="product-list">
				<?php if($this->_params['pagination'] === true || $this->_params['pagination'] == 'true') { ?>
				<form action="<?php echo $this->_url; ?>" method="get">
				<?php $getArray = $this->_core->getAllGetArray(array('sort')); ?>
				<?php foreach($getArray as $k=>$v) { ?>
				<input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>" />
				<?php } ?>
				<div class="pagination">
					<div class="title">
						<ul class="currency">
							<li>грн</li>
						</ul>
						<ul class="sort">
							<li class="sortby"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_SORT_BY')->get('value'); ?></li>
							<li><select name="sort" onchange="this.form.submit();"><?php foreach($this->_sortby as $key=>$sort) { ?>
								<option value="<?php echo $key; ?>"<?php echo ($this->_defaultsort == $key?' selected="selected"':''); ?>><?php echo $sort['title']; ?></option>
								<?php } ?></select></li>
							<li><?php echo sprintf($this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_DISPLAY')->get('value'), ($this->_limit_start+1), ($this->_limit_start+sizeof($this->_items)), $this->_total); ?></li>
							<li>
								<a class="displayall" href="?limit=0&<?php echo $this->_core->getAllGetParams(array('limit'));?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_SHOW_ALL')->get('value'); ?></a>
							</li>
						</ul>
						<div class="clear"></div>
					</div>
					<div class="pages">
						<!--<ul class="layout">
							<li rel="list" id="list"><a href="<?php echo $this->_url . '?view=list&' . $this->_core->getAllGetParams(array('view')) ?>" class="selected"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_LIST')->get('value'); ?></a></li>
							<!--<li rel="window" id="window"><a href="<?php echo $this->_url . '?view=window&' . $this->_core->getAllGetParams(array('view')) ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_WINDOW')->get('value'); ?></a></li>-->
						<!--</ul>--><?php if($this->_totalpages>1) { ?>
						<ul>
							<?php if($this->_current_page>1) { ?>
							<li><a href="?_p=<?php echo ($this->_current_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_PREV')->get('value'); ?></a></li>
							<?php } ?>
							<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
							<li><a<?php if($k == $this->_current_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a></li>
							<?php }?>
							<?php if($this->_current_page<$this->_totalpages) { ?>
							<li><a href="?_p=<?php echo ($this->_current_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_NEXT')->get('value'); ?></a></li>
							<?php } ?>
							<?php if($this->_totalpages>1) { ?>
							<li>&nbsp;</li>
							<li><select name="_p" onchange="this.form.submit();">
								<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
								<option value="<?php echo $k; ?>"<?php if($k == $this->_current_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
								<?php } ?>
							</select></li>
							<?php } ?>
							<li class="clear"></li>
						</ul><?php } ?>
					</div>
				</div></form>
				<?php } ?>
				<div class="clear"></div>
				<ul class="products list">
					<?php foreach($this->_items as $item) { ?>
					<?php $images = $item->fetchImages()->get('images'); $image = $images['image'][200]; $filters = $item->fetchFilters(true)->get('filters'); $brand = $item->getFilterByName('brand', true); ?>
					<li class="col<?php echo $i; ?>"><?php $status_class = ($item->get('status_new')?' status_new':($item->get('status_action')?' status_action':($item->get('status_topsell')?' status_topsell':''))); ?>
						<div class="product<?php echo $status_class; ?>">
							<div class="image"><a rel="lightbox" href="<?php echo $images['image']['large'][0]; ?>"><img src="<?php echo $image[0]; ?>" border="0" /></a></div>
							<div class="description"><?php if(is_numeric($item->get('bundle_id'))) { $bundle = $item->fetchBundle()->get('bundle'); ?>
								<div class="bundle">
									<div class="name"><?php echo $bundle->get('name'); ?></div>
									<?php $price = array('min-price'=>$this->_core->getRequest('price-min'), 'max-price'=>$this->_core->getRequest('price-max')*1.15); ?>
									<?php $disabledall = true; $products = $bundle->fetchProducts($price, 1)->get('products'); ?>
									<div class="bundleproducts"><form action="<?php echo $this->topFolder; ?>cart/add" method="get" class="add-to-cart-form">
										<table width="100%" cellspacing="0" cellpadding="2">
											<tr>
												<th width="12%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_CODE', 'value')->get('value'); ?></th>
												<th width="50%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_NAME', 'value')->get('value'); ?></th>
												<th width="9%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_PACK_SHORT', 'value')->get('value'); ?></th>
												<th width="1%"></th>
												<?php if($this->_display_price) { ?><th width="12%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_PRICE', 'value')->get('value'); ?></th><?php } ?>
												<th width="16%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_BUY', 'value')->get('value'); ?></th>
											</tr>
											<?php $qty = 0; $i=0; foreach($products as $product) { $qty+=$product->get('quantity'); $qtyclass = ($product->get('quantity')>0?($product->get('quantity')>10?'lot':'little'):'missing') . ' '.$product->get('quantity'); ?>
											<?php $disabled = $product->get('quantity') == 0 || $product->get('price') == 0 || !$this->_display_price; if(!$disabled) $disabledall = false; ?>
											<?php $status_class = ($product->get('status_new')?' status_new':($product->get('status_action')?' status_action':($product->get('status_topsell')?' status_topsell':''))); ?>
											<tr class="product-row<?php echo $status_class; ?>">
												<td><?php echo $product->get('code'); ?></td>
												<td><?php echo $product->get('name'); ?></td>
												<td><?php echo $product->get('packing'); ?></td>
												<td><div class="product-qty <?php echo $qtyclass; ?>"></div></td>
												<?php if($this->_display_price) { ?><td class="price"><?php echo $product->get('price'); ?></td><?php } ?>
												<td class="buy<?php echo $disabled?' disabled':''; ?>">
													<input type="hidden" name="id[]" value="<?php echo $product->get('id'); ?>" />
													<table cellspacing="0" cellpadding="0">
													<tr>
														<td><a class="remove" rel="<?php echo $item->get('id'); ?>"></a></td>
														<td><input class="qty" type="text" name="qty[<?php echo $product->get('id'); ?>]" value="" <?php echo $disabled?' disabled="disabled"':''; ?> /></td>
														<td><a class="add" rel="<?php echo $item->get('id'); ?>"></a></td>
													</tr>
													</table>
												</td>
											</tr>
											<?php $i++; } ?>
											<tr>
												<th colspan="6" class="bottom-col"></th>
											</tr>
										</table>
										<?php if($i>$m_items_per_bundle) { ?>
										<div class="list-buttons right hidden">
											<input type="button" class="button button-small-gray submit expand" value="<?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_EXPAND', 'value')->get('value'); ?>" />
											<input type="button" class="button button-small-gray submit collapse" value="<?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_COLLAPSE', 'value')->get('value'); ?>" />
										</div>
										<?php } ?>
										<input<?php echo $disabledall?' disabled="disabled"':''; ?> type="submit" class="button button-small-<?php echo $disabledall?'gray':'light'; ?> submit right" value="<?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_ORDER', 'value')->get('value'); ?>" />
									</form>
									</div>
								</div>
								<?php } else { ?>
								<?php $qtyclass = ($item->get('quantity')>0?($item->get('quantity')>10?'lot':'little'):'missing') . ' '.$item->get('quantity'); ?>
								<div class="bundle">
									<div class="name"><?php echo $item->get('name'); ?></div>
									<div class="bundleproducts"><form action="<?php echo $this->topFolder; ?>cart/add" method="get" class="add-to-cart-form">
										<table width="100%" cellspacing="0" cellpadding="2">
											<tr>
												<th width="12%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_CODE', 'value')->get('value'); ?></th>
												<th width="50%"></th>
												<th width="9%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_PACK_SHORT', 'value')->get('value'); ?></th>
												<th width="1%"></th>
												<?php if($this->_display_price) { ?><th width="12%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_PRICE', 'value')->get('value'); ?></th><?php } ?>
												<th width="16%"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_BUY', 'value')->get('value'); ?></th>
											</tr>
											<?php $disabled = $item->get('quantity') == 0 || $item->get('price') == 0 || !$this->_display_price; ?>
											<tr class="product-row<?php echo $status_class; ?>">
												<td><?php echo $item->get('code'); ?></td>
												<td></td>
												<td><?php echo $item->get('packing'); ?></td>
												<td><div class="product-qty <?php echo $qtyclass; ?>"></div></td>
												<?php if($this->_display_price) { ?><td class="price"><?php echo $item->get('price'); ?></td><?php } ?>
												<td class="buy<?php echo $disabled?' disabled':''; ?>">
													<input type="hidden" name="id[]" value="<?php echo $item->get('id'); ?>" />
													<table cellspacing="0" cellpadding="0">
													<tr>
														<td><a class="remove" rel="<?php echo $item->get('id'); ?>"></a></td>
														<td><input class="qty" type="text" name="qty[<?php echo $item->get('id'); ?>]" value="" <?php echo $disabled?' disabled="disabled"':''; ?> /></td>
														<td><a class="add" rel="<?php echo $item->get('id'); ?>"></a></td>
													</tr>
													</table>
												</td>
											</tr>
											<tr>
												<th colspan="6" class="bottom-col"></th>
											</tr>
										</table>
										<input<?php echo $disabled?' disabled="disabled"':''; ?> type="submit" class="button button-small-<?php echo $disabled?'gray':'light'; ?> submit right" value="<?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_ORDER', 'value')->get('value'); ?>" />
									</form>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="clear"></div>
							<a rel="lightbox" href="<?php echo $images['image']['large'][0]; ?>"><div class="label"></div></a>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="clear"></div>
				<?php if($this->_params['pagination'] === true || $this->_params['pagination'] == 'true') { ?>
				<form action="<?php echo $this->_url; ?>">
					<div class="pagination">
						<div class="pages"><?php if($this->_totalpages>1) { ?>
							<ul>
								<?php if($this->_current_page>1) { ?>
								<li><a href="?_p=<?php echo ($this->_current_page-1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_PREV')->get('value'); ?></a></li>
								<?php } ?>
								<?php for($k = $_p_start; $k <= $_p_end; $k++) { ?>
								<li><a<?php if($k == $this->_current_page) { ?> class="selected"<?php } ?> href="?_p=<?php echo $k . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $k; ?></a></li>
								<?php }?>
								<?php if($this->_current_page<$this->_totalpages) { ?>
								<li><a href="?_p=<?php echo ($this->_current_page+1) . '&' . $this->_core->getAllGetParams(array('_p')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_NEXT')->get('value'); ?></a></li>
								<?php } ?>
								<?php if($this->_totalpages>1) { ?>
								<li>&nbsp;</li>
								<li><select name="_p" onchange="this.form.submit();">
									<?php for($k = 1; $k <= $this->_totalpages; $k++) { ?>
									<option value="<?php echo $k; ?>"<?php if($k == $this->_current_page) { ?> selected="selected"<?php } ?>><?php echo $k; ?></option>
									<?php } ?>
								</select></li>
								<?php } ?>
								<li class="clear"></li>
							</ul><?php } ?>
						</div>
					</div></form>
				<?php } ?>
			</div>
			<?php } if($this->_no_products) {
			echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_NO_PRODUCTS')->get('value');
		} ?>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#product-list-list ul.products.list li .product .brand').each(function() {
			$(this).css({ background: 'transparent url(\'/images/filters/brand/'+$(this).find('a.title').attr('rel')+'-small.png\') no-repeat', width: '69px', height: '60px' })
			$(this).find('a.title').hide();
		});
		$('.bundleproducts').each(function() {
			var row = 0;
			var hd = false;
			var bundle = $(this);
			$(this).find('table tr.product-row').each(function() {
				if(!$(this).find('th')[0]) {
					row++;
					if(row><?php echo (int)$m_items_per_bundle;?>) {
						$(this).hide();
						hd = true;
					}
				}
			});
			if(hd) {
				$(this).find('.list-buttons .collapse').hide();
				$(this).find('.list-buttons .expand').show();
				$(this).find('.list-buttons').removeClass('hidden').show();
				$(this).find('.list-buttons .expand').unbind('click').bind('click', function() {
					$(bundle).find('table tr').show();
					$(bundle).find('.list-buttons .collapse').show();
					$(bundle).find('.list-buttons .expand').hide();
				});
				$(this).find('.list-buttons .collapse').unbind('click').bind('click', function() {
					var row = 0;
					$(bundle).find('table tr.product-row').each(function() {
						if(!$(this).find('th')[0]) {
							row++;
							if(row><?php echo (int)$m_items_per_bundle;?>) {
								$(this).hide();
							}
						}
					});
					$(bundle).find('.list-buttons .collapse').hide();
					$(bundle).find('.list-buttons .expand').show();
				});
			}
		});
		$('.product-list .bundleproducts td.buy .add').unbind('click').bind('click', function() {
			if(!$(this).parents('.buy').hasClass('disabled')) {
				var val = parseInt($(this).parents('.buy').find('input.qty').val());
				if(isNaN(val)) val = 1;
				else val++;
				$(this).parents('.buy').find('input.qty').val(val);
			}
		});
		$('.product-list .bundleproducts td.buy .remove').unbind('click').bind('click', function() {
			if(!$(this).parents('.buy').hasClass('disabled')) {
				var val = parseInt($(this).parents('.buy').find('input.qty').val());
				if(isNaN(val)) val = 0;
				else if(val>0) val--;
				$(this).parents('.buy').find('input.qty').val(val);
			}
		});
	});
</script>