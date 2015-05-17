<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<?php if(sizeof($this->_items)>0) { ?>
<div id="product-recommend-list">
	<h3><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_RECOMMEND_PRODUCTS')->get('value'); ?></h3>
	<div class="product-list">
		<ul class="products grid">
		<?php $i=0; foreach($this->_items as $item) { ?>
		<?php $images = $item->fetchImages()->get('images'); $image = $images['image'][100]; ?>
			<li class="col<?php echo $i; ?>">
				<div class="product">
					<div class="image"><img src="<?php echo $image[0]; ?>" /></div>
					<div class="description">
						<div class="name"><a href="<?php echo $this->topFolder; ?>product/view?id=<?php echo $item->get('id'); ?>"><?php echo $item->get('name'); ?></a></div>
						<div class="brand"><?php echo $item->get('brand'); ?></div>
						<div class="price"><?php echo $item->get('price'); ?></div>
						<a class="button" href="/product/view?id=<?php echo $item->get('id'); ?>"><span>Go</span></a>
					</div>
					<div class="clear"></div>
				</div>
				</li>
			<?php $i++; if($i == $this->_params['rowlength']) { $i=0; ?><li class="clear separator"></li><?php }?>
		<?php } ?>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<?php } ?>