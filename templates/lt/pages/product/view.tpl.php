<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php $images = $this->_item->get('images');$images = $images['image']; $videos = $this->_item->get('videos'); ?>
<div id="product-view">
	<div id="image-area" class="mybox-view">
		<!--<div id="main-image" class="box-rounded table">
			<div class="tr">
				<?php // foreach($images['large'] as $k => $image) { ?>
				<div class="td mybox-row">
					<a class="mybox-thumb large" href="<?php //echo $image ?>" rel="<?php //echo $images['60'][$k] ?>"><img src="<?php //echo $images['280'][$k] ?>" border="0" /></a>
				</div><?php // } ?>
				<?php // foreach($videos as $k => $video) { ?>
				<div class="td mybox-row">
					<a class="mybox-thumb large video" rel=""><?php //echo $video->get('script'); ?></a>
				</div><?php // } ?>
			</div>
		</div>-->
		<div class="thumbnails">
			<ul class="table">
				<?php foreach($images[60] as $k=>$image) { ?>
				<li class="box-rounded tr mybox-row"><a class="td mybox-thumb thumb image" href="<?php echo $images['large'][$k]; ?>" rel="{small:'<?php echo $images['60'][$k]; ?>',medium:'<?php echo $images['280'][$k]; ?>',large:'<?php echo $images['large'][$k]; ?>'}"><img src="<?php echo $image; ?>" border="0" /></a></li>
				<?php } ?>
				<?php foreach($videos as $k=>$video) { ?>
				<li class="box-rounded tr mybox-row"><a class="td mybox-thumb thumb video" href="<?php echo urlencode($video->get('script')); ?>" rel="mybox[small]"><img src="<?php echo $this->templateDir; ?>css/images/video.png" border="0" /></a></li>
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
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<?php } ?>
		<?php } ?>
		<div class="clear"></div>
		<div class="buy">
			<form action="<?php echo $this->topFolder; ?>cart/add" method="get">
				<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
				<div class="price"><?php echo $this->_item->get('price') . ' ' . $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?></div>
				<table cellspacing="2" cellpadding="0" border="0">
					<tr>
						<td rowspan="2"><input id="product-qty" type="text" name="qty[<?php echo $this->_item->get('id'); ?>]" value="1" /></td>
						<td align="center"><a href="javascript:;" class="plus">+</a></td>
						<td rowspan="2"><input type="submit" src="<?php echo $this->templateDir; ?>images/pixel-trans.gif" value="<?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_BUY')->get('value'); ?>" /></td>
					</tr>
					<tr>
						<td align="center"><a href="javascript:;" class="minus">-</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</form>
		</div>
		<!--<div class="subtitle"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_DESCRIPTION')->get('value'); ?></div>-->
		<div class="clear"></div>
		<div class="description"><?php echo $this->_item->get('shortdesc'); ?></div>
	</div>
	<div class="clear"></div>
	<div id="desctabs-area">
		<!--<h3><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_REFERENCE')->get('value'); ?></h3>-->
		<!--
		<ul class="tabs">
			<li class="current"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_BASIC')->get('value'); ?></li>
			<li><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_FULL')->get('value'); ?></li>
		</ul>-->

		<h3><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_FULL')->get('value'); ?></h3>
		<div class="tab full"><?php echo $this->_item->get('reference'); ?></div>
		<h3><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_BASIC')->get('value'); ?></h3>
		<div class="tab basic"><?php echo $this->_item->get('description'); ?></div>
		<!--<div class="tabs-view">
			<div class="tab basic"><?php //echo $this->_item->get('description'); ?></div>
			<div class="tab full"><?php //echo $this->_item->get('reference'); ?></div>
		</div>-->
	</div>
	<div id="reviews-area">
		<h3><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_REVIEW_TITLE')->get('value'); ?></h3>
		<?php if( ($reviews = $this->_item->get('reviews')) ) { ?>
		<div class="items">
			<?php foreach($reviews as $review) { ?>
			<div class="item">
				<div class="info">
					<div class="name"><?php echo $review->get('name'); ?></div>
					<div class="added"><?php echo $review->get('added'); ?></div>
					<div class="rating"><?php echo $review->get('rating'); ?></div>
				</div>
				<div class="description">
					<div class="content"><?php echo $review->get('content'); ?></div>
				</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<h3 id="review-write-title"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_WRITE_REVIEW_TITLE')->get('value'); ?></h3>
		<form id="review-form" action="<?php echo $this->topFolder; ?>product/review/add?<?php echo $this->_core->getAllGetParams();?>" method="post">
			<div class="form">
				<div class="row">
					<div class="label"><label for="review-form-name"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_REVIEW_NAME')->get('value'); ?></label></div>
					<div class="field"><input id="review-form-name" name="name" value="<?php echo $this->_post['name']?$this->_post['name']:($this->_customer->get('id')?$this->_customer->get('name_first') . ' ' . $this->_customer->get('name_last'):''); ?>" /></div>
				</div>
				<div class="row">
					<div class="label"><label for="review-form-email"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_REVIEW_EMAIL')->get('value'); ?></label></div>
					<div class="field"><input id="review-form-email" name="email" value="<?php echo $this->_post['email']?$this->_post['email']:($this->_customer->get('id')?$this->_customer->get('email'):''); ?>" /></div>
				</div>
				<div class="row">
					<div class="label"><label for="review-form-content"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_REVIEW_CONTENT')->get('value'); ?></label></div>
					<div class="field"><textarea id="review-form-content" name="content"><?php echo $this->_post['content']?$this->_post['content']:''; ?></textarea></div>
				</div>
				<div class="captcha">
					<table>
						<tr>
							<td>
								<label for="review-form-captcha"><?php echo $this->_core->getModel('Translate/Collection')->get('PRODUCT_VIEW_REVIEW_CAPTCHA')->get('value'); ?></label><br />
								<input id="review-form-captcha" type="text" name="captcha" value="" />
							</td>
							<td><img src="<?php echo $this->topFolder; ?>captcha.php" /></td>
						</tr>
					</table>
				</div>
				<div class="send">
					<input type="hidden" name="pid" value="<?php echo $this->_item->get('id'); ?>" />
					<input type="hidden" name="rating" value="0" />
					<input src="/templates/default/css/images/pixel-trans.gif" value="<?php echo $this->_core->getModel('Translate/Collection')->get('BUTTON_SAVE')->get('value'); ?>" height="26" type="image" width="115">
					<a href="javascript:;" onclick="document.getElementById('review-form').submit()" class="title"><?php echo $this->_core->getModel('Translate/Collection')->get('BUTTON_SAVE')->get('value'); ?></a>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	$(document).ready(function() {
		/*
		$('#product-view #image-area #main-image .tr .td').not(':first').hide();
		$('#product-view #image-area #main-image .tr .td .video iframe').each(function() {
			var width = parseInt($(this).attr('width'));
			var height = parseInt($(this).attr('height'));
			$(this).parents('.mybox-thumb.video').attr('rel', '{width:'+width+',height:'+height+'}');
			var ratio_wh = width/height;
			if(width>280) {
				width = 280;
				height = width/ratio_wh;
			}
			if(height>280) {
				height = 280;
				width = height*ratio_wh;
			}
			$(this).attr('width', width);
			$(this).attr('height', height);
		});
		//*/
//		$('.mybox-view').myBox();
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
		$('#review-form').hide();
		$('#review-write-title').bind('click', function() {
			var el = $(this).parent().find('#review-form');
			if(el.is(':visible')) {
				el.hide();
			} else {
				el.show();
			}
		});
		/*
		$('.tabs').each(function() {
			$(this).parent().find('.tab').eq(0).siblings().hide();
			$(this).find('li').bind('click', function() {
				$(this).addClass('current').siblings().removeClass('current');
				$(this).parents('ul').parent().find('.tabs-view .tab').eq($(this).index()).show().siblings().hide();
			});
		});
		//*/
	});
</script>