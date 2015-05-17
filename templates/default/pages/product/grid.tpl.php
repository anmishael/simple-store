<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 $_p_start = $this->_current_page - 2;
 if($_p_start <= 0) {
 	$_p_start = 1;
 }
 $_p_end = $this->_current_page + 2;
 if($_p_end > $this->_totalpages) {
 	$_p_end = $this->_totalpages;
 }
 
?>
<div id="product-list">
	<div id="product-list-main">
		<?php
		 if(isset($this->_items)) {
		?>
		<div id="product-list-list" class="product-list"><form action="<?php echo $this->_url; ?>" method="get">
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
					<ul class="layout">
						<li rel="grid" id="grid"><a href="<?php echo $this->_url . '?view=grid&' . $this->_core->getAllGetParams(array('view')) ?>" class="selected"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_GRID')->get('value'); ?></a></li>
						<li rel="list" id="list"><a href="<?php echo $this->_url . '?view=list&' . $this->_core->getAllGetParams(array('view')) ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_LIST')->get('value'); ?></a></li>
						<!--<li rel="window" id="window"><a href="<?php echo $this->_url . '?view=window&' . $this->_core->getAllGetParams(array('view')) ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('PAGINATION_TEXT_WINDOW')->get('value'); ?></a></li>-->
					</ul><?php if($this->_totalpages>1) { ?>
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
			<div class="clear"></div>
		<ul class="products grid">
		<?php $i=0; foreach($this->_items as $item) { ?>
		<?php $images = $item->fetchImages()->get('images'); $image = $images['image'][120]; $brand = $item->getFilterByName('brand', true); ?>
		<li class="col<?php echo $i; ?>">
		<div class="product">
			<div class="image"><a href="<?php echo $this->topFolder; ?>product/view?id=<?php echo $item->get('id'); ?>"><img src="<?php echo $image[0]; ?>" border="0" /></a></div>
			<div class="description">
				<div class="name"><a href="<?php echo $this->topFolder; ?>product/view?id=<?php echo $item->get('id'); ?>"><?php echo $item->get('name'); ?></a></div>
				<div class="brand"><a class="title" rel="<?php echo $brand->get('url'); ?>"><?php echo $brand->get('name') ?></a></div>
				<div class="price"><?php echo $item->get('price'); ?></div>
				<a class="button" href="/product/view?id=<?php echo $item->get('id'); ?>"><span>Go</span></a>
			</div>
			<div class="clear"></div>
		</div>
		</li>
		<?php $i++; if($i == $this->_params['rowlength']) { $i=0; ?><li class="clear separator"></li><?php }?>
		<?php } ?>
		</ul>
			<div class="clear"></div><form action="<?php echo $this->_url; ?>">
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
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
$('.product-list .product .brand').each(function() {
	$(this).css({ background: 'transparent url(\'/images/filters/brand/'+$(this).find('a.title').attr('rel')+'-small.png\') no-repeat', width: '69px', height: '60px' })
	$(this).find('a.title').hide();
});
</script>