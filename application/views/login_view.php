<div class="page-content">

<form class="logform" method="post" action="<?php echo site_url('auth/login'); ?>">
	<h2 style="text-align:center;">Log In</h2>
	<div class='errorp'><?php echo validation_errors(); echo $message;?></div>
	<table class="logform-input-group">
		<tr>
			<th><label>Email</label></th>
			<td class='loginput'>
				<input class="input" type="email" name="email"  id="email" value="<?php echo set_value('email'); ?>" size="55" maxlength="50"/>
			</td>
		</tr>
		<tr>
			<th><label>Password</label></th>
			<td class='loginput'>
				<input class="input" type="password" name="pass"  id="pass" size="55" maxlength="50" />
			</td>
		</tr>
	</table>
	<h3 style="text-align:center;">
		<input id="logbutton" name="submit" type="submit" value="Submit" />
	</h3>
	<p style="text-align: center; width: 100%;">No account yet? Register <a href="<?php echo base_url('auth/register');?>">here</a>.</p>
</form>

</div>