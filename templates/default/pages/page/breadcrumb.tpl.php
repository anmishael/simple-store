<?php
/*
 * Created on 19 черв. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
?>
<div class="breadcrumbs">
	<ul>
		<li><a href="<?php echo $this->topFolder;?>" class="home"><div class="icon-home"></div></a></li>
		<li>&raquo;</li>
		<li><a href=""><?php echo $this->_item->get('typename')?></a></li>
		<li>&raquo;</li>
		<li><a href=""><?php echo $this->_item->get('statename')?></a></li>
		<li>&raquo;</li>
		<li><a href=""><?php echo $this->_item->get('cityname')?></a></li>
	</ul>
</div>