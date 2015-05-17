<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */


?>
<div class="content-box productpopularbox">
	<div class="box-header"></div>
	<div class="box-inner">
		<div class="box-title"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_POPULAR_BOX_TITLE')->get('value'); ?></div>
		<div class="box-content">
			<ul>
				<?php foreach($this->_items as $item) { ?>
				<?php $images = $item->fetchImages()->get('images'); ?>
				<li>
					<div class="item">
						<?php $bundle = $item->fetchBundle()->get('bundle'); if($bundle instanceof Model_Product_Bundle) { ?>
						<div class="image"><img src="<?php echo $images['image'][60][0]; ?>" title="<?php echo htmlspecialchars($bundle->get('name'))?>" /></div>
						<?php $products = $bundle->fetchProducts()->get('products'); ?>
						<?php $qty = 0; $i=0; foreach($products as $product) { $qty+=$product->get('quantity'); $qtyclass = ($product->get('quantity')>0?($product->get('quantity')>10?'lot':'little'):'missing'); ?>
							<div class="name">
								<a href="<?php echo $this->topFolder; ?>product/view?id=<?php echo $product->get('id'); ?>">
									<?php echo $product->get('name'); ?>
								</a>
							</div>
							<?php } } else { ?>
						<div class="image"><img src="<?php echo $images['image'][60][0]; ?>" title="<?php echo htmlspecialchars($item->get('name'))?>" /></div>
						<div class="name">
							<a href="<?php echo $this->topFolder; ?>product/view?id=<?php echo $item->get('id'); ?>">
								<?php echo $item->get('name'); ?>
							</a>
						</div>
						<?php }?>
						<div class="clear"></div>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="box-footer"></div>
</div>