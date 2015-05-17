<?php
/**
 * Created on 20 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 ?>
 <table>
 	<tr>
 		<td>Created:</td>
 		<td><?php echo $this->_item->get('added'); ?></td>
 	</tr>
 	<tr>
 		<td>From:</td>
 		<td><?php echo $this->_item->get('name_first') . ' ' . $this->_item->get('name_last') . ' &lt;' . $this->_item->get('email') . '&gt;'?></td>
 	</tr>
 	<tr>
 		<td>Subject:</td>
 		<td><?php echo htmlspecialchars($this->_item->get('title')); ?></td>
 	</tr>
 	<tr>
 		<td>Content:</td>
 		<td><?php echo htmlspecialchars($this->_item->get('content')); ?></td>
 	</tr>
 </table>
 <p></p>
 <div>
 <?php if($this->_items) {  $items = $this->_items; foreach($items as $message) { ?>
 	<p class="item">
	  	<div class="title">
	  		<?php echo htmlspecialchars($message->get('title'));?>
	  		<?php echo htmlspecialchars($message->get('added'));?>
	  	</div>
	  	<div>
	  		<?php echo htmlspecialchars($message->get('content'));?>
	  	</div>
  	</p>
 <?php } } else { $message = $this->_item; } ?>
 </div>
 <form action="<?php echo $this->_core->getActionUrl('admin-message-send');?>" method="post">
 	<h3>Send an answer</h3>
 	<div id="admin-pages-message-view-send-form">
 		<table>
 			<tr>
 				<td>From:</td>
 				<td><input type="text" name="name_first" value="<?php echo $this->_user->get('name_first'); ?>" /> <input type="text" name="name_last" value="<?php echo $this->_user->get('name_last'); ?>" /> <input type="text" name="email" value="<?php echo $this->_user->get('email'); ?>" size="32" /></td>
 			</tr>
 			<tr>
 				<td>Subject:</td>
 				<td><input type="text" name="title" value="RE: <?php echo htmlspecialchars($message->get('title')); ?>" size="64" /></td>
 			</tr>
 			<tr>
 				<td>Content:</td>
 				<td><textarea name="content" rows="8"></textarea></td>
 			</tr>
 		</table>
 		<input type="hidden" name="cid" value="<?php echo $this->_item->get('cid'); ?>" />
 		<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
 		<input type="hidden" name="parent" value="<?php echo $message->get('id'); ?>" />
		<input type="button" class="button" id="button-cancel" value="Cancel" />
		<input type="submit" class="button" name="_save" value="Apply" />
		<input type="submit" class="button" name="_save" value="Send" />
 	</div>
 </form>
 <script type="text/javascript">
$(function() {
    $('.button-cancel').bind('click', function() {
    	window.location('<?php echo $this->_core->getActionUrl('admin-message-list')?>');
    	return false;
    });
});
</script>