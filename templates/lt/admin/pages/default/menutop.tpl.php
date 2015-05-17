<?php
/*
 * Created on May 25, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
?>
<ul<?php
	if ($this->cssclass) { echo ' class="'.$this->cssclass.'"'; }
	?>>
<?php foreach($this->data as $k=>$item) { ?>
	<li rel="<?php echo $item['parents']; ?>" class="<?php echo $this->liclass; ?>">
	<a href="/admin/<?php echo $item['url'];?>" rel="sub-<?php echo $item['id']; ?>" class="<?php echo $this->aclass; ?>"><?php echo $item['menuTitle']?></a></li>
	<?php if($item['block']) { ?>
		<?php if((int)$this->level==0) {
			$this->display_mainmenu(array('data'=>$item['block'], 'parents'=>$item['parents'], 'cssclass'=>'sub', 'level'=>(int)$this->level));
		} else {
			$this->display_mainmenu(array('data'=>$item['block'], 'parents'=>$item['parents'], 'level'=>(int)$this->level));
		}?>
		<?php $this->level--; ?>
	<?php }?>
<?php } ?>
</ul>