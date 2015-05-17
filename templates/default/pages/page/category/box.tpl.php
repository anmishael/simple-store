<?php
/**
 * Created on 26 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
?>
<div class="content-box categorybox">
	<div class="box-header"></div>
	<div class="box-inner">
		<div class="box-title"><?php echo $this->_core->getModel('Translate/Collection')->get('BOX_CATEGORY_TITLE', 'value')->get('value'); ?><div class="icon"></div></div>
		<div class="box-content"><ul class="top">
			<?php foreach($this->_items as $item) { ?>
			<li id="categoryrow-<?php echo $item->get('id'); ?>"><?php if(sizeof($item->get('children'))>0) { ?><a class="plus closed" href="javascript:;" rel="<?php echo $item->get('id'); ?>"><span class="icon"></span></a> <?php } ?></a><a href="<?php echo $item->get('url'); ?>"><?php echo $item->get('name'); ?></a><?php if($this->_parents[$item->get('id')] || ($item->get('parent')==0)) { echo $this->displayChildren($item); } ?></li>
			<?php } ?>
		</ul></div>
	</div>
	<div class="box-footer"></div>
</div>
<script type="text/javascript">
	var pageid = '<?php echo $this->_page->get('id'); ?>';
	$(document).ready(function() {
		$('.categorybox .subtree').hide();
		$('.categorybox .plus').bind('click', function() {
			if($('#tree-'+$(this).attr('rel')).is(':hidden')) {
                $('#tree-'+$(this).attr('rel')).show(0.5);
				$(this).addClass('opened').removeClass('closed');//.text('-');
				$(this).parent().siblings().find('ul.subtree').hide();
                $(this).parent().siblings().find('.plus').removeClass('opened').addClass('closed');//.text('+');
			} else {
                $('#tree-'+$(this).attr('rel')).find('ul.subtree').hide();
                $('#tree-'+$(this).attr('rel')).find('.plus').removeClass('opened').addClass('closed');//text('+');
                $('#tree-'+$(this).attr('rel')).hide();
                $(this).addClass('closed').removeClass('opened');//.text('+');
			}
		});
		$.fn.displayCategoryTree = function(id, recursive) {
			if(id) {
				var pid = id.toString().split('-')[1];
//				console.log(pid);
				$('#'+id).show(0.5);
				$('#'+id).parent().find('a.plus[rel='+pid+']').addClass('opened').removeClass('closed');//text('-');
				if(recursive) {
					$(this).displayCategoryTree($('#'+id).parents('ul.subtree').attr('id'), recursive);
				}
			}
		}
		if(pageid) {
			$(document).displayCategoryTree($('#categoryrow-'+pageid).addClass('current').parents('.subtree').attr('id'), true)
		}
	});
</script>