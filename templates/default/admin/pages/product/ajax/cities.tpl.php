<?php
/*
 * Created on 3 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
echo'<?xml version="1.0" encoding="UTF-8"?>'; 
?>
<?php if(is_object($this->_state)) { ?>

<state>
	<name><?php echo $this->_state->get('name');?></name>
	<code><?php echo $this->_state->get('code');?></code>
	<cities>
<?php if(sizeof($this->_cities)>0) { ?>
<?php foreach($this->_cities as $k=>$city) { ?>
		<city id="<?php echo $city->get('id')?>">
			<name><?php echo $city->get('name')?></name>
			<zip><?php echo $city->get('zip')?></zip>
		</city>
<?php } ?>
<?php } ?>
	</cities>
</state>
<?php }?>