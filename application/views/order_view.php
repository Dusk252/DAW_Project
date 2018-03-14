<div class="page-content">
	<h2>Order Overview</h2>
	<?php echo (!$empty_orders ? '
	<table id="cartTable">
	<thead>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th>Price</th>
		</tr>
	</thead>
	' : '<p class="search_term">You haven\'t placed any orders yet.</p>');?>
	</thead>
	<tbody>
	<?php foreach ($products as $product): ?>
		<tr>
			<td>
				<div class="cart-product-display">
					<a href="<?php echo base_url('store/products/') . $product['product_id'];?>">
						<img src="<?php echo $product['image'];?>"/>
					</a>
					<div class="cart-product-title">
						<?php echo $product['title'];?>
					</div>
					<div class="cart-product-author">by <?php echo $product['author'];?></div>
					<div class="cart-product-display-details">
						<p>Publisher: <?php echo $product['publisher'];?></p>
						<p>Release Date: <?php echo $product['release_date'];?></p>
					</div>
				</div>
			</td>
			<td class="cart-quantity">
				<span><?php echo $product['quantity'];?></span>
			</td>
			<td class="cart-price">
				<span><?php echo $product['price'] * $product['quantity'];?></span> €
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<h3 style="text-align:right;">
		Total: <span id="total_price"><?php echo $total_price;?></span> € 
	</h3>
	<hr>
	<h2>Shipping Address and Payment Information</h2>
	<form id="order-info" method="post" action="<?php echo site_url('cart/order');?>">
		<h3>Shipping Address</h3>
		<textarea rows="4" cols="50" name="address"  id="address" maxlength="255"><?php echo ((strlen(set_value('address')) == 0) ? $address : set_value('address')); ?></textarea>
		<div class='errorp'><?php echo form_error('address'); ?></div>
		<h3>Credit Card Number</h3>
		<input type="text" name="cc"  id="cc" size="55" maxlength="64" />
		<div class='errorp'><?php echo form_error('cc'); ?></div>
		<div id="order-submit">
			<input id="cpl-order-btn" class="btn-green-large" name="complete_order" type="submit" value="Complete Order"/>
		</div>
	</form>
</div>