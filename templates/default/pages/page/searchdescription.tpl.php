<?php
/**
 * Created on 6 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<div class="inner-wrapper">
<div class="short">
<?php
$desc = explode(' ', $this->_page->get('searchdescription'));
$desc = array_chunk($desc, 50);
echo implode(' ', $desc[0]);
?>... &nbsp;
<a href="javascript:;" class="more">Детальніше</a>
</div>
<div class="long hidden">
<?php
echo $this->_page->get('searchdescription');
?> &nbsp;
<a href="javascript:;" class="less">Менше</a>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#searchdescription .long').hide().removeClass('hidden');
	$('#searchdescription .short .more').bind('click', function() {
		$('#searchdescription .short').hide();
		$('#searchdescription .long').show('fast');
	});
	$('#searchdescription .long .less').bind('click', function() {
		$('#searchdescription .long').hide();
		$('#searchdescription .short').show();
	});
})
</script>