<?php
/**
 * File: filter.tpl.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */
?>
<div id="block-filter" class="white-bg">
<form id="block-filter-form" action="/product/list" method="get">
<div class="padding-10">
	<h3 class="margin-10 antiqua regular font-24">Location & Property Details:</h3>
	<hr class="brown" />
	<div style="width: 75%; margin: 0px auto;">
		<table width="100%">
			<tr>
				<td><label for="filter-form-location">City, State</label></td>
				<td></td>
				<td width="80"><label for="filter-form-zip">Zip</label></td>
				<td width="40">&nbsp;</td>
				<td width="150"><label for="filter-form-type">Property Type</label></td>
			</tr>
			<tr>
				<td><input id="filter-form-location" type="text" class="text" name="location" value="<?php echo $this->_core->getRequestGet('location');?>" size="28" maxlength="64" /></td>
				<td align="center">or</td>
				<td><input id="filter-form-zip" type="text" class="text" name="zip" value="<?php echo $this->_core->getRequestGet('zip');?>" size="16" maxlength="64" /></td>
				<td>&nbsp;</td>
				<td><select class="lighter" id="filter-form-type" name="type" size="1">
						<option value="-1">any</option>
						<?php foreach($this->_filters['types'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select>
				</td>
			</tr>
		</table>
		<hr class="light" />
		<table width="100%">
			<tr id="content-filter-inner">
				<td width="150"><label for="filter-form-price-min">Min Price</label></td>
				<td></td>
				<td width="150"><label for="filter-form-price-max">Max Price</label></td>
				<td></td>
				<td width="150"><label for="filter-form-radius">Search Radius</label></td>
				<td width="40"></td>
				<td width="150"><label for="filter-form-furnished">Furnished</label></td>
			</tr>
			<tr>
				<td><select class="lighter" id="filter-form-price-min" name="price-min" size="1">
					<?php foreach($this->_filters['price-min'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
				<td align="center">-</td>
				<td><select class="lighter" id="filter-form-price-max" name="price-max" size="1">
						<?php foreach($this->_filters['price-max'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
				<td></td>
				<td><select class="lighter" id="filter-form-radius" name="radius" size="1">
						<?php foreach($this->_filters['radius'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
				<td></td>
				<td><select class="lighter" id="filter-form-furnished" name="furnished" size="1">
						<?php foreach($this->_filters['furnished'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
			</tr>
			<tr>
				<td><label for="filter-form-square-min">Sq.ft, min</label></td>
				<td></td>
				<td><label for="filter-form-square-max">Sq.ft, max</label></td>
				<td></td>
				<td><label for="filter-form-beds">Bedrooms</label></td>
				<td></td>
				<td><label for="filter-form-bathrooms">Baths</label></td>
			</tr>
			<tr>
				<td><select class="lighter" id="filter-form-square-min" name="square-min" size="1">
						<?php foreach($this->_filters['square-min'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
				<td align="center">-</td>
				<td><select class="lighter" id="filter-form-square-max" name="square-max" size="1">
						<?php foreach($this->_filters['square-max'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
				<td></td>
				<td><select class="lighter" id="filter-form-beds" name="beds" size="1">
						<?php foreach($this->_filters['beds'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
				<td></td>
				<td><select class="lighter" id="filter-form-baths" name="baths" size="1">
						<?php foreach($this->_filters['baths'] as $item) { ?>
						<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
					<?php } ?>
					</select></td>
			</tr>
		</table>	
	</div>
</div>
<div class="separator" id="product-filter-separator1">
	<div class="strip"></div>
	<div class="inner">
		<div class="right" id="sep-button-search">
			<div class="button-xsmall-light">
				<div class="inner"><a class="block-filter-form-submit" href="javascript:;">Search <span style="font-size: 14px;">&rsaquo;</span></a></div>
			</div>
		</div>
	</div>
</div>
<div class="padding-10">
	<h3 class="margin-10 antiqua regular font-24">Property Features:</h3>
	<hr class="brown" />
	<div class="padding-10">
	<table id="product-filter-features-list" width="100%"><?php foreach($this->_features as $k=>$v) { ?>
		<tr>
			<td class="heading" valign="top"><?php echo $v->get('name');?></td>
			<td valign="top"><ul><?php foreach($v->get('filters') as $x=>$y) { ?>
				<li><input id="product-filter-features-list-<?php echo $v->get('id')?>-<?php echo $y->get('id')?>" type="checkbox" name="<?php echo $y->get('id')?>" /><label for="product-filter-features-list-<?php echo $v->get('id')?>-<?php echo $y->get('id')?>"><?php echo $y->get('name');?></label></li>
			<?php }?><li class="clear"></li></ul></td>
		</tr><?php $k++; if($k<sizeof($this->_features)) { ?>
		<tr>
			<td></td>
			<td><hr class="brown" /></td>
		</tr><?php } ?>
	<?php }?></table></div>
</div>
<div class="separator" id="product-filter-separator2">
	<div class="strip"></div>
	<div class="inner">
		<div class="right" id="sep-button-search">
			<div class="btn-search2">
				<input type="image" value="Search" src="/templates/forrent/css/images/pixel-trans.gif" width="126" height="36" class="title" />
			</div>
		</div>
		<div class="right nowrap sortway">
			<input id="product-filter-sortway-asc" type="checkbox" name="asc" value="1" /><label for="product-filter-sortway-asc"> Ascending</label>
		</div>
		<div class="right nowrap sortorder">
			<div><label for="filter-form-sort">Sort Results</label></div>
			<div><select class="lighter" id="filter-form-sort" name="sort" size="1">
				<?php foreach($this->_filters['sort'] as $item) { ?>
				<?php echo '<option value="' . $item['value'] . '">' . $item['name'] . '</option>'; ?>
				<?php } ?>
			</select></div>
		</div>
	</div>
</div>
<div class="padding-10">
</div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('a.block-filter-form-submit').bind('click', function() {
		$('form#block-filter-form').submit();
		return false;
	});
});
</script>