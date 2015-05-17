<?php
/*
 * Created on 13 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" product</h2>
<?php } else { ?>
	<h2><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_PRODUCT', 'value')->get('value'); ?></h2>
<?php } ?>
<?php $desc = $this->_item->get('description'); ?>
<form id="admin-product-edit-form" action="<?php echo $this->_core->getActionUrl('admin-product-save');?>" method="post">
	<table>
	<tr>
		<td><label for="admin-product-edit-form-code"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
		<td><input id="admin-product-edit-form-code" type="text" name="code" value="<?php echo $this->_item->get('code'); ?>" /></td>
	</tr>
	<tr>
		<td><label for="admin-product-edit-form-sku"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SKU', 'value')->get('value'); ?></label></td>
		<td><input id="admin-product-edit-form-sku" type="text" name="sku" value="<?php echo $this->_item->get('sku'); ?>" /></td>
	</tr>
	<tr>
		<td><label for="admin-product-edit-form-qty"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_QTY', 'value')->get('value'); ?></label></td>
		<td><input id="admin-product-edit-form-qty" type="text" name="quantity" value="<?php echo $this->_item->get('quantity'); ?>" /></td>
	</tr>
	<tr>
		<td><label for="admin-product-edit-form-packing"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PACKING', 'value')->get('value'); ?></label></td>
		<td><input id="admin-product-edit-form-packing" type="text" name="packing" value="<?php echo $this->_item->get('packing'); ?>" /></td>
	</tr>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-product-edit-form-name-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><input type="text" class="text" id="admin-product-edit-form-name-<?php echo $lang->get('id'); ?>" name="name[<?php echo $lang->get('id'); ?>]" value="<?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('name'):''); ?>" size="32" maxlength="255" /></td>
	</tr>
	<?php } ?>
		<tr>
			<td colspan="2"><a class="dropdown" href="javascript:;" rel="description-area-inner"><h3><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DESCRIPTION', 'value')->get('value'); ?></h3></a></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" id="description-area-inner" class="hidden inner">
	<?php foreach($this->_languages as $lang) { ?>
		<tr>
			<td><label for="admin-product-edit-form-shortdesc-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHORTDESC', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
			<td><textarea id="admin-product-edit-form-shortdesc-<?php echo $lang->get('id'); ?>" class="editor" name="shortdesc[<?php echo $lang->get('id'); ?>]" cols="64" rows="16"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('shortdesc'):''); ?></textarea></td>
		</tr>
	<tr>
	<td><label for="admin-product-edit-form-description-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DESCRIPTION', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea id="admin-product-edit-form-description-<?php echo $lang->get('id'); ?>" class="editor" name="description[<?php echo $lang->get('id'); ?>]" cols="64" rows="16"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('description'):''); ?></textarea></td>
	</tr>
	<?php } ?></table></td>
		</tr>

		<tr>
			<td colspan="2"><a class="dropdown" href="javascript:;" rel="reference-area-inner"><h3><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REFERENCE', 'value')->get('value'); ?></h3></a></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" id="reference-area-inner" class="hidden inner">
				<?php foreach($this->_languages as $lang) { ?>
				<tr>
					<td><label for="admin-product-edit-form-reference-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REFERENCE', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
					<td><textarea id="admin-product-edit-form-reference-<?php echo $lang->get('id'); ?>" class="editor" name="reference[<?php echo $lang->get('id'); ?>]" cols="64" rows="16"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('reference'):''); ?></textarea></td>
				</tr>
				<?php } ?></table></td>
		</tr>

		<tr>
			<td colspan="2"><a class="dropdown" href="javascript:;" rel="meta-area-inner"><h3><?php echo $this->_core->getModel('Translate/Collection')->get('META', 'value')->get('value'); ?></h3></a></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" id="meta-area-inner" class="hidden inner">
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-product-edit-form-metakey-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_METAKEY', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea id="admin-product-edit-form-metakey-<?php echo $lang->get('id'); ?>" name="metakey[<?php echo $lang->get('id'); ?>]" cols="64" rows="4"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('metakey'):''); ?></textarea></td>
	</tr>
	<tr>
	<td><label for="admin-product-edit-form-metadescription-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_METADESCRIPTION', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><textarea id="admin-product-edit-form-metadescription-<?php echo $lang->get('id'); ?>" name="metadescription[<?php echo $lang->get('id'); ?>]" cols="64" rows="4"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('metadescription'):''); ?></textarea></td>
	</tr>
	<?php } ?></table></td>
		</tr>
	<!-- <tr>
	<td><label for="admin-product-edit-form-type">Type</label></td>
	<td><select id="admin-product-edit-form-type" name="type">
	<?php /* foreach($this->_types as $type) { ?>
		<option value="<?php echo $type->get('id');?>"<?php if($type->get('id') == $this->_item->get('type')) { echo ' selected="selected"'; } ?>><?php echo $type->get('name');?></option>
	<?php } //*/?>
	</select></td>
	</tr>-->
	<tr>
	<td><label for="admin-product-edit-form-price"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-product-edit-form-price" name="price" value="<?php echo $this->_item->get('price')?>" size="32" maxlength="255" /></td>
	</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_1"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 1</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_1" name="price_1" value="<?php echo $this->_item->get('price_1')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_2"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 2</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_2" name="price_2" value="<?php echo $this->_item->get('price_2')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_3"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 3</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_3" name="price_3" value="<?php echo $this->_item->get('price_3')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_4"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 4</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_4" name="price_4" value="<?php echo $this->_item->get('price_4')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_5"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 5</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_5" name="price_5" value="<?php echo $this->_item->get('price_5')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_6"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 6</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_6" name="price_6" value="<?php echo $this->_item->get('price_6')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-product-edit-form-price_7"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRICE', 'value')->get('value'); ?> 7</label></td>
			<td><input type="text" class="text" id="admin-product-edit-form-price_7" name="price_7" value="<?php echo $this->_item->get('price_7')?>" size="32" maxlength="255" /></td>
		</tr>
	<tr>
	<td><label for="admin-product-edit-form-featured"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FEATURED', 'value')->get('value'); ?></label></td>
	<td><input type="checkbox" id="admin-product-edit-form-featured" name="featured" value="1"<?php if($this->_item->get('featured')>0) { echo ' checked="checked"'; }?> /></td>
	</tr>
        <tr>
            <td><label><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></label></td>
            <td>
                <input type="radio" id="admin-product-edit-form-status-off" name="status" value="0"<?php if($this->_item->get('status')==0) { echo ' checked="checked"'; }?> /> <label for="admin-product-edit-form-status-off"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_OFF', 'value')->get('value'); ?></label><br />
				<input type="radio" id="admin-product-edit-form-status-on" name="status" value="1"<?php if($this->_item->get('status')==1) { echo ' checked="checked"'; }?> /> <label for="admin-product-edit-form-status-on"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ON', 'value')->get('value'); ?></label>
			</td>
        </tr>
	</table>
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
	<h2 id="admin-product-edit-form-pages-h2"><a href="javascript:;"><span class="icon list-add"></span> <?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PAGES', 'value')->get('value'); ?></a></h2>
	<div id="admin-product-edit-form-pages"><?php $pages = $this->_item->get('pages'); ?>
		<ul class="links-list-vertical">
		<?php foreach($this->_pages as $page) { ?>
			<li><input id="page-<?php echo $page->get('id') ?>" type="checkbox" class="checkbox" name="pages[]" value="<?php echo $page->get('id'); ?>"<?php if($pages[$page->get('id')]) { echo ' checked="checked"'; } ?> /> <label for="page-<?php echo $page->get('id'); ?>"><?php echo $page->get('name') . ' (' . $page->get('url') . ')' ?></label></li>
		<?php } ?>
		</ul>
	</div>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
	<h2 id="admin-product-edit-form-filters-h2"><a href="javascript:;"><span class="icon list-add"></span> <?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILTERS', 'value')->get('value'); ?></a></h2>
	<div id="admin-product-edit-form-filters"><?php foreach($this->_filter_types as $filtertype) { ?>
		<h4><?php echo $filtertype->get('name'); ?></h4>
		<ul class="links-list">
		<?php $filtertype->getFilters(); $ifilters = $this->_item->get('filters'); foreach($filtertype->get('filters') as $k=>$v) { ?>
			<li><input id="product-edit-filter-<?php echo $v->get('id'); ?>" type="checkbox" name="filters[]" value="<?php echo $v->get('id'); ?>"<?php
			if(isset($ifilters[$v->get('id')])) echo ' checked="checked"';
			?> /> <label for="product-edit-filter-<?php echo $v->get('id'); ?>"><?php echo $v->get('name');?></label></li>
		<?php } ?>
		</ul>
	<?php } ?></div>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<?php if($this->_item->get('id')) { ?>
<form action="<?php echo $this->_core->getActionUrl('admin-product-image-upload');?>" method="post" enctype="multipart/form-data">
	<h2 id="admin-product-edit-upload-image">
		<a href="javascript:;"><span class="icon list-add"></span> <?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_UPLOAD_IMAGE', 'value')->get('value'); ?></a>
	</h2>
	<table id="admin-product-edit-table-upload-image">
		<tr>
			<td colspan="5"><?php foreach($this->_actions['image_area'] as $kx=>$vx) { ?>
				<a href="<?php echo $vx['url'] . '?'. $this->_core->getAllGetParams(); ?>"><?php echo $vx['name'];?></a>
				<?php } ?></td>
		</tr>
		<tr>
			<td colspan="5"><input type="file" name="image" /></td>
		</tr>
		<tr>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VIEW', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PATH', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
		<?php $images = $this->_item->get('images'); ?>
		<?php foreach($images as $group=>$image) { ?>
		<?php foreach($image['large'] as $k=>$v) { ?>
		<tr>
			<td><img src="<?php echo $image[280][$k]; ?>" border="0" /></td>
			<td><?php echo $v;?></td>
			<td><?php echo $group;?></td>
			<td><?php foreach($this->_actions['images'] as $kx=>$vx) { if($image['object'][$k] instanceof Model_Product_Image) { ?>
				<a href="<?php echo $vx['url'] . '?id='. $this->_item->get('id') . '&imgid=' . $image['object'][$k]->get('id'); ?>"<?php if($vx['warning']) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($vx['warning'], $image->get('name'))).'\');"';
			 } ?>><?php echo $vx['name'];?></a>
				<?php } } ?></td>
		</tr>
		<?php } ?>
		<?php } ?>
	</table>
	<input type="hidden" name="pid" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<form action="<?php echo $this->_core->getActionUrl('admin-product-video-upload');?>" method="post" enctype="multipart/form-data">
	<h2 id="admin-product-edit-upload-video"><a href="javascript:;"><span class="icon list-add"></span> <?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_UPLOAD_VIDEO', 'value')->get('value'); ?></a></h2>
	<table id="admin-product-edit-table-upload-video">
		<tr>
			<td colspan="5">
				<div>
					<label for="admin-product-edit-table-upload-video-file"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FILE', 'value')->get('value'); ?></label>
					<input id="admin-product-edit-table-upload-video-file" type="file" name="video" /></div>
				<div>
					<label for="admin-product-edit-table-upload-video-name"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></label>
					<input id="admin-product-edit-table-upload-video-name" type="text" name="name" value="" /></div>
				<div>
					<label for="admin-product-edit-table-upload-video-desc"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DESCRIPTION', 'value')->get('value'); ?></label>
					<input id="admin-product-edit-table-upload-video-desc" type="text" name="description" value="" />
				</div>
				<div>
					<label for="admin-product-edit-table-upload-video-script"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SCRIPT', 'value')->get('value'); ?> </label>
					<textarea id="admin-product-edit-table-upload-video-script" name="script" rows="3"></textarea>
				</div>
				<hr />
			</td>
		</tr>
		<tr>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VIEW', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PATH', 'value')->get('value'); ?></th>
			<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
		</tr>
		<?php $videos = $this->_item->get('videos'); ?>
		<?php foreach($videos as $k=>$v) { ?>
		<tr>
			<td><?php echo $v->get('name'); ?></td>
			<td><?php echo $v->get('path');?></td>
			<td><?php
				foreach($this->_actions['videos'] as $ka=>$va) { ?>
					<a href="<?php echo $va['url'] . '?pid=' . $this->_item->get('id') . '&id=' . $v->get('id'); ?>"<?php if($va['warning']) { 
						echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($va['warning'], $this->_item->get('name'))).'\');"';
					 } ?>><?php echo $va['name'];?></a>
				<?php } ?></td>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="pid" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<?php } ?>
<form id="admin-product-edit-form-action" action="<?php echo $this->_core->getActionUrl('admin-product-edit');?>?doctype=ajax" method="post">

</form>
<script type="text/javascript">
var _current_zip = _current_state = _current_city = '';
$(document).ready(function() {
	$.fn.fillLocation = function() {
		_current_city = $('#admin-product-edit-form-city').find('option[value='+$('#admin-product-edit-form-city').attr('value')+']').text();
		_current_zip = _current_city.substring(_current_city.lastIndexOf(',')+1).trim();
		_current_city = _current_city.substring(0, _current_city.lastIndexOf(','));
		
		_current_state = $('#admin-product-edit-form-state').find('option[value='+$('#admin-product-edit-form-state').attr('value')+']').text();
		_current_state = _current_state.substring(_current_state.lastIndexOf(',')+1).trim();
	}
	
	$('#admin-product-edit-form-items').hide();
	$('#admin-product-edit-form-items-h2').bind('click', function() {
		if($('#admin-product-edit-form-items').css('display') == 'none') {
			$('#admin-product-edit-form-items').show();
			$('#admin-product-edit-form-items-h2 span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-edit-form-items').hide();
			$('#admin-product-edit-form-items-h2 span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('#admin-product-edit-form-filters').hide();
	$('#admin-product-edit-form-filters-h2').bind('click', function() {
		if($('#admin-product-edit-form-filters').css('display') == 'none') {
			$('#admin-product-edit-form-filters').show();
			$('#admin-product-edit-form-filters-h2 span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-edit-form-filters').hide();
			$('#admin-product-edit-form-filters-h2 span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('#admin-product-edit-form-pages').hide();
	$('#admin-product-edit-form-pages-h2').bind('click', function() {
		if($('#admin-product-edit-form-pages').css('display') == 'none') {
			$('#admin-product-edit-form-pages').show();
			$('#admin-product-edit-form-pages-h2 span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-edit-form-pages').hide();
			$('#admin-product-edit-form-pages-h2 span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('#admin-product-edit-table-upload-image').hide();
	$('#admin-product-edit-upload-image').bind('click', function() {
		if($('#admin-product-edit-table-upload-image').css('display') == 'none') {
			$('#admin-product-edit-table-upload-image').show();
			$('#admin-product-edit-upload-image span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-edit-table-upload-image').hide();
			$('#admin-product-edit-upload-image span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('#admin-product-edit-table-upload-video').hide();
	$('#admin-product-edit-upload-video').bind('click', function() {
		if($('#admin-product-edit-table-upload-video').css('display') == 'none') {
			$('#admin-product-edit-table-upload-video').show();
			$('#admin-product-edit-upload-video span.icon').removeClass('list-add').addClass('list-remove');
		} else {
			$('#admin-product-edit-table-upload-video').hide();
			$('#admin-product-edit-upload-video span.icon').removeClass('list-remove').addClass('list-add');
		}
	});
	$('.button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-product-list')); ?>';
	});
	$('#admin-product-edit-form-state').bind('change', function() {
		$('#admin-product-edit-form-city').remove();
		$('#admin-product-edit-form-location').append('<select id="admin-product-edit-form-city" name="city"></select>');
		$('#admin-product-edit-form-action').empty().append(
			'<input type="hidden" name="action" value="getCities" /><input type="hidden" name="state" value="' +
			$(this).attr('value') +
			'" />');
		$.ajax({
			type:	'post',
			url:	'<?php echo $this->_core->getActionUrl('admin-product-edit');?>?doctype=ajax',
			data:	$('#admin-product-edit-form-action').serialize(),
			dataType: 'xml',
			success: function(response) {
				_current_state = $(response).find('state code').text();
				_current_city = $(response).find('city:first').find('name').text();
				_current_zip = $(response).find('city:first').find('zip').text();
				$('#admin-product-edit-form-citystate').attr('value', _current_city + ',' + _current_state);
				$(response).find('city').each(function(i, v) {
					var id = $(this).attr('id');
					var name = $(this).find('name').text();
					var zip = $(this).find('zip').text();
					$('#admin-product-edit-form-city').append('<option value="'+id+'">'+name+', '+zip+'</option>');
				});
				$('#admin-product-edit-form-city').unbind('change').bind('change', function() {
					$(this).fillLocation();
					$('#admin-product-edit-form-citystate').attr('value', _current_city + ',' + _current_state);
				});
			}
		});
		return false;
	});
	$('#admin-product-edit-form-city').bind('change', function() {
		$(this).fillLocation();
		$('#admin-product-edit-form-citystate').attr('value', _current_city + ',' + _current_state);
	});
	$('#admin-product-edit-form-city').fillLocation();
	$('table.hidden').hide().removeClass('hidden');
	$('a.dropdown').bind('click', function() {
		if($('#'+$(this).attr('rel')).is(':visible')) {
			$('#'+$(this).attr('rel')).hide('fast');
		} else {
			$('#'+$(this).attr('rel')).show('slow');
		}
		return false;
	});
});
</script>