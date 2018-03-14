<div class="page-content">

<form class="regform" id="add-product-form" method="post" action="<?php echo site_url('admin/add_product'); ?>">
	<h2 style="text-align:left;">Insert New Product</h2>
	<table class="regform-input-group">
		<tr>
			<th><label>Title:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="title"  id="title" value="<?php echo set_value('title'); ?>" size="55" maxlength="255"/>
				<div class='errorp'><?php echo form_error('title'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Category:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="category"  id="category" value="<?php echo set_value('category'); ?>" size="55" maxlength="50"/>
				<div class='errorp'><?php echo form_error('category'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Author:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="author"  id="author" value="<?php echo set_value('author'); ?>" size="55" maxlength="50"/>
				<div class='errorp'><?php echo form_error('author'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Publisher:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="publisher"  id="publisher" value="<?php echo set_value('publisher'); ?>" size="55" maxlength="50"/>
				<div class='errorp'><?php echo form_error('author'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Price:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="price"  id="price" value="<?php echo set_value('price'); ?>" size="55" maxlength="50"/>
				<div class='errorp'><?php echo form_error('price'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Stock:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="stock"  id="stock" value="<?php echo set_value('stock'); ?>" size="55" maxlength="50"/>
				<div class='errorp'><?php echo form_error('stock'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Release Date:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="release_date"  id="release_date" value="<?php echo set_value('release_date'); ?>" size="55" maxlength="50"/>
				<div class="form-hint">YYYY-MM-DD.</div>
				<div class='errorp'><?php echo form_error('url'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Description:</label></th>
			<td class='reginput'>
				<textarea rows="5" cols="50" name="description"  id="description" maxlength="3000" ><?php echo set_value('description'); ?></textarea>
				<div class='errorp'><?php echo form_error('description'); ?></div>
			</td>
		</tr>
		
		<tr>
			<th><label>Image Url:</label></th>
			<td class='reginput'>
				<input class="input" type="text" name="url"  id="url" value="<?php echo set_value('url'); ?>" size="55" maxlength="255"/>
				<div class='errorp'><?php echo form_error('url'); ?></div>
			</td>
		</tr>
	</table>
	
	<div id="edit-submit" style="text-align:center;">
		<input id="logbutton" name="submit" type="submit" value="Submit"/>
		<a id="cancel_button" class="btn-gray-large" href="<?php echo site_url('admin'); ?>">Cancel</a>
	</div>

</form>

</div>