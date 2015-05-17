<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

if(sizeof($this->_items)>0) {
	?>
<div class="main-wrapper"><div class="inner-wrapper" id="main-error-area"><div class="inner">
	<ul>
		<?php foreach($this->_items as $item) { ?>
		<li><?php echo $item->get('content');?></li>
		<?php } ?>
	</ul></div></div></div>
<?php } ?>