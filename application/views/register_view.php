<div class="page-content">

<form class="regform" method="post" action="<?php echo site_url('auth/register'); ?>">
	<h2 style="text-align:left;">New account registration</h2>
	<table class="regform-input-group">
		<tr>
			<th><label>Username</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="username"  id="username" value="<?php echo set_value('username'); ?>" size="55" maxlength="50"/>
				<div class="form-hint">Insert your desired username.</div>
				<div class='errorp'><?php echo form_error('username'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Email</label></th>
			<td class='reginput'>
				<input class="input" type="email" name="email"  id="email" value="<?php echo set_value('email'); ?>" size="65" maxlength="50"/>
				<div class="form-hint">Insert a valid email address.</div>
				<div class='errorp'><?php echo form_error('email'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Password</label></th>
			<td class='reginput'>
				<input class="input" type="password" name="pass1"  id="pass1" size="55" maxlength="50" />
				<div class="form-hint">Insert your desired password. Maximum lenght is 35 characters.</div>
				<div class='errorp'><?php echo form_error('pass1'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Password confirmation</label></th>
			<td class='reginput'>
				<input class="input" type="password" name="pass2"  id="pass2" size="55" maxlength="50" />
				<div class="form-hint">Insert your password again.</div>
				<div class='errorp'><?php echo form_error('pass2'); ?></div>
			</td>
		</tr>
	</table>
	
	<h3 style="text-align:center;">
		<input id="logbutton" name="submit" type="submit" value="Submit" />
	</h3>

</form>

</div>