<?php
/*
 * Created on May 24, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php if(!$this->_user || !$this->_user->get('id')) { ?>
<form action="" method="post">
	<div class="left">
		<label for="input-username">Username</label><br />
		<input type="text" class="text" name="username" value="" size="16" maxlength="64" />
	</div>
	<div class="right">
		<label for="input-password">Password</label><br />
		<input type="password" class="password" name="password" size="16" maxlength="64" />
		<input type="submit" class="submit button" value="Login" />
	</div>
</form>
<?php } else { ?>
You're logged in as <?php echo $this->_user->get('username'); ?> <a href="<?php echo $this->_core->getSingleton('Config')->adminUrl?>user/logout">Logout</a>
<?php }?>