<div class="page-content">

<form class="regform" method="post" action="<?php echo site_url('user/profile/edit'); ?>">
	<h2 style="text-align:left;">Edit Profile</h2>
	<table class="regform-input-group">
		<tr>
			<th><label>Username:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="username"  id="username" value="<?php echo ((strlen(set_value('username')) == 0) ? $username : set_value('username')); ?>" size="55" maxlength="50"/>
				<div class='errorp'><?php echo form_error('username'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Email:</label></th>
			<td class='reginput'>
				<p id="up_email"><?php echo $email;?></p>
			</td>
		</tr>
		
		<tr>
			<th><label>Current Password:</label></th>
			<td class='reginput'>
				<input class="input" type="password" name="pass1"  id="pass1" size="55" maxlength="50" />
				<div class='errorp'><?php echo form_error('pass1'); ?></div>
				<div class='errorp'><?php echo $message;?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>New Password:</label></th>
			<td class='reginput'>
				<input class="input" type="password" name="pass2"  id="pass2" size="55" maxlength="50" />
				<div class='errorp'><?php echo form_error('pass2'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Confirm New Password:</label></th>
			<td class='reginput'>
				<input class="input" type="password" name="pass3"  id="pass3" size="55" maxlength="50" />
				<div class='errorp'><?php echo form_error('pass2'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Address:</label></th>
			<td class='reginput' id='address'>
				<textarea rows="4" cols="50" name="address"  id="address" maxlength="255"><?php echo ((strlen(set_value('address')) == 0) ? $address : set_value('address')); ?></textarea>
				<div class='errorp'><?php echo form_error('address'); ?></div>
			</td>
		</tr>
	</table>
	
	<div id="edit-submit" style="text-align:center;">
		<input id="logbutton" name="submit" type="submit" value="Submit"/>
		<a id="cancel_button" class="btn-gray-large" href="<?php echo site_url('user/profile'); ?>">Cancel</a>
	</div>

</form>

</div>