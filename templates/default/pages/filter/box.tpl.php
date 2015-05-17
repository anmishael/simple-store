<?php
/**
 * Created on 20 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

$getfilters = $this->_core->getRequest('filter');

?>
<div class="content-box filterbox">
	<div class="box-header"></div>
	<div class="box-inner">
		<div class="box-title"><?php echo $this->_core->getModel('Translate/Collection')->get('FILTER_BOX_TITLE')->get('value'); ?><div class="icon"></div></div>
		<div class="box-content">
			<?php if(sizeof($getfilters)>0) { ?>
			<div class="box-title2 active<?php echo sizeof($getfilters)>0?' no-background':''; ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('FILTER_BOX_TITLE_SELECTED')->get('value'); ?></div>
			<div class="filterboxselected">
				<?php foreach($this->_types_selected as $type) { ?>
				<?php $filters = $type->get('filters'); ?>
				<div class="filters inactive">
					<div class="value">
						<ul>
							<?php foreach($filters as $f=>$filter) { ?>
							<?php
							$id = $type->get('url') . '-filter-' . $filter->get('id');
							$arrurl = $getfilters;
							if($arrurl[$type->get('id')][$filter->get('id')]) {
								unset($arrurl[$type->get('id')][$filter->get('id')]);
							} else {
								$arrurl[$type->get('id')][$filter->get('id')] = $filter->get('id');
							}
							asort($arrurl);
							$url = $this->_core->arrToUrl(array('filter'=>$arrurl)) . '&' . $this->_core->getAllGetParams(array('filter'));
							?>
							<li><a class="remove" href="?<?php echo $url; ?>"></a><a href="?<?php echo $url; ?>"><?php echo $filter->get('name'); ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<?php } ?>
				<div class="removefilters">
					<a href="<?php echo $this->_page->get('url') . $this->_core->getAllGetParams(array('filter')); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('FILTER_BOX_CLEAR_ALL_FILTERS')->get('value'); ?></a>
				</div>
			</div>
			<div class="box-title2 active<?php echo sizeof($getfilters)>0?' no-background':''; ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('FILTER_BOX_TITLE')->get('value'); ?></div>
			<?php } ?>
			<form action="<?php echo $this->_core->getUrl(); ?>" method="get"><?php foreach($this->_types as $type) {
				$filters = $type->getFilters(); ?>
				<div class="filters">
					<div class="title closed"><?php echo $type->get('name'); ?><span class="icon"></span></div>
					<div class="value"><?php switch ( $type->get('display') ) {
						case 'checkbox': ?>
							<ul><?php
								foreach($filters as $f=>$filter) { ?>
									<?php
									$id = $type->get('url') . '-filter-' . $filter->get('id');
									$arrurl = $getfilters;
									if($arrurl[$type->get('id')][$filter->get('id')]) {
										unset($arrurl[$type->get('id')][$filter->get('id')]);
									} else {
										$arrurl[$type->get('id')][$filter->get('id')] = $filter->get('id');
									}
									asort($arrurl);
									$url = $this->_core->arrToUrl(array('filter'=>$arrurl)) . '&' . $this->_core->getAllGetParams(array('filter'));
									?>
									<li <?php echo ($getfilters[$type->get('id')][$filter->get('id')]?' class="selected"':''); ?>>
										<input id="<?php echo $id; ?>" type="checkbox"<?php echo ($getfilters[$type->get('id')][$filter->get('id')]?' checked="checked"':''); ?> name="filter[<?php echo $type->get('id'); ?>][<?php echo $filter->get('id'); ?>]" value="<?php echo $filter->get('id'); ?>" />
										<a href="?<?php echo $url; ?>"><?php echo $filter->get('name'); ?> (<?php echo $filter->get('products_count'); ?>)</a></li>
									<?php }
								?></ul><?php
							break;
						case 'select': ?>
							<ul>
								<li>
									<select name="filter[<?php echo $type->get('id'); ?>]">
										<option value=""></option>
										<?php foreach($filters as $f=>$filter) { ?>
										<option value="<?php echo $filter->get('id'); ?>"<?php echo ($getfilters[$type->get('id')]==$filter->get('id')?' selected="selected"':''); ?>><?php echo $filter->get('name'); ?></option>
										<?php } ?>
									</select>
								</li>
							</ul>
							<?php
							break;
						default:
							break;
					} ?></div>
				</div>
				<?php } ?>
				<?php if($this->_display_price) { ?>
					<p>
						<label for="amount"><?php echo $this->_core->getModel('Translate/Collection')->get('FILTER_BOX_PRICE_RANGE')->get('value'); ?></label>
					<div id="amount" style="border: 0; color: #f6931f; font-weight: bold;">
						<?php echo ( $this->_core->getRequest('price-min') ? $this->_core->getRequest('price-min') : 0) . ' ' . $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?>
						-
						<?php echo ( $this->_core->getRequest('price-max') ? $this->_core->getRequest('price-max') : $this->_max_price) . ' ' . $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?>
					</div>
					<input type="hidden" name="price-min" value="<?php echo $this->_core->getRequest('price-min')?$this->_core->getRequest('price-min'):0; ?>" />
					<input type="hidden" name="price-max" value="<?php echo $this->_core->getRequest('price-max')?$this->_core->getRequest('price-max'):$this->_max_price; ?>" />
					</p>
					<div id="slider-range"></div>
					<?php } ?>
				<div class="submit">
					<input type="submit" class="button button-small-light submit" value="<?php echo $this->_core->getModel('Translate/Collection')->get('FILTER_BOX_APPLY')->get('value'); ?>" />
				</div>
			</form></div>
	</div>
	<div class="box-footer"></div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.filterbox form').each(function(i) {
			var form = $(this);
		});
		$('.filterbox .box-inner .box-content .filters .value').removeClass('hidden').parents('.filters').find('.title.active').removeClass('closed').addClass('opened');
		$('.filterbox .box-inner .box-content .filters .title.active').each(function() {
			if($(this).parent().find('.value input[type=checkbox]:checked')[0]) {
				var title = $(this);
				var el = $(this).parent().find('.value');
				el.show('slow', function() { title.removeClass('closed').addClass('opened'); });
			}
		});
		/*
		$('.filterbox .box-inner .box-content .filters .title.active').bind('click', function() {
			var title = $(this);
			var el = $(this).parent().find('.value');
			if(el.is(':visible')) {
				el.hide('fast', function() { title.removeClass('opened').addClass('closed'); });
			} else {
				el.show('slow', function() { title.removeClass('closed').addClass('opened'); });
			}
		});
		//*/
		$('.filterbox').find('.box-inner .box-title').removeClass('closed').addClass('opened');
		$('.filterbox').parents('.block-box').siblings().each(function() {
			if(!$(this).find('.alwaysopened')[0]) {
				$(this).find('.box-content').hide();
			} else {
				$(this).find('.box-inner .box-title').removeClass('closed').addClass('opened');
			}
		});
		$('.block-box .box-title').css({cursor: 'pointer'});
		$('.block-box .box-title').bind('click', function() {
			var title = $(this);
			var el = $(this).parents('.box-inner').find('.box-content');
			if(el.is(':visible')) {
				el.hide('fast', function() { el.removeClass('opened').addClass('closed'); title.removeClass('opened').addClass('closed'); });
			} else {
				el.show('fast', function() { el.removeClass('closed').addClass('opened'); title.removeClass('closed').addClass('opened'); });
			}
		});
		if($( "#slider-range" )[0]) {
			$( "#slider-range" ).slider({
				range: true,
				min: 0,
				max: <?php echo (int)$this->_max_price; ?>,
				values: [ <?php echo $this->_core->getRequest('price-min')?$this->_core->getRequest('price-min'):0; ?>, <?php echo $this->_core->getRequest('price-max')?$this->_core->getRequest('price-max'):$this->_max_price; ?> ],
				slide: function( event, ui ) {
					$( "#amount").empty().text( ui.values[ 0 ] + " <?php echo $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?> - " + ui.values[ 1 ] + " <?php echo $this->_core->getModel('Currency/Collection')->fetch()->get('label'); ?>" );
					$('.filterbox form input[name=price-min]').val(ui.values[ 0 ]);
					$('.filterbox form input[name=price-max]').val(ui.values[ 1 ]);
				}
			});
			$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
					" - $" + $( "#slider-range" ).slider( "values", 1 ) );
		}
	});
</script>