<?php
/**
 * Created on 19 ���. 2012
 * By Mikel Annjuk <anmishael@gmail.com>
 * Especially for KinetoscopeMedia Inc.
 */

?>
<div class="brands">
	<ul>
		<?php foreach($this->_items as $item) { ?>
			<li>
				<div class="box-inner"><a href="<?php echo $this->topFolder . $item->get('url');?>">
						<div class="image" style="background: transparent url('<?php
						echo ($item->get('image'))?$item->get('image'): $this->topFolder . 'images/filters/brand/' . $item->get('url') . '-small.png';
						?>') no-repeat center right"></div>
					</a>
				</div>
			</li>
		<?php } ?>
		<li class="clear"></li>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#content-right .brands ul li .box-inner .image').hover(
			function() {
				$(this).css({backgroundPosition:'0% 50%'});
			}, function() {
				$(this).css({backgroundPosition:'-69px 50%'});
			}
		);
	});
</script>