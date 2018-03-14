<div class="page-content">
<!--quantity.js was here-->
	<h2>Shopping Cart</h2>
	<?php echo ($global_stock_check ? '' : '<p class="search_error">Your shopping cart contains some products that are out of stock. Please remove them before placing an order.</p>');?>
	<?php echo (!$empty_cart ? '
	<table id="cartTable">
	<thead>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th>Action</th>
			<th>Price</th>
		</tr>
	</thead>
	' : '<p class="search_term">Your shopping cart is currently empty.</p>');?>
	<tbody>
	<?php foreach ($products as $product): ?>
		<tr>
			<td>
				<div class="cart-product-display">
					<a href="<?php echo base_url('store/products/') . $product['product_id'];?>">
						<img src="<?php echo $product['image'];?>"/>
					</a>
					<div class="<?php echo (($product['stock'] > 0) ? 'cart-product-title' : 'cart-product-title-oos');?>">
						<a href="<?php echo base_url('store/products/') . $product['product_id'];?>">
							<?php echo $product['title'];?>
						</a>
						<?php echo (($product['stock'] > 0) ? '' : '  OUT OF STOCK');?>
					</div>
					<div class="cart-product-author">by <?php echo $product['author'];?></div>
					<div class="cart-product-display-details">
						<p>Publisher: <?php echo $product['publisher'];?></p>
						<p>Release Date: <?php echo $product['release_date'];?></p>
					</div>
				</div>
			</td>
			<td class="cart-quantity">
				<form method="post" class="cart-quantity-form" action="<?php echo base_url('cart/change_quantity/') . $product['product_id'];?>">
				<input class="input-quantity" id="<?php echo $product['product_id'];?>" name="quantity" alt="<?php echo base_url('cart/change_quantity') . ' ' . base_url('cart/remove/') . $product['product_id'] . ' ' . $product['stock'];?>" onblur="updateQuantity(this, 'onblur')" type="text" maxlength="2" value="<?php echo $product['quantity'];?>"/>
				<span id="m<?php echo $product['product_id'];?>" class="quantity-error-message"></span>
				<noscript><button type="submit" class="cart-wishlist">Update</button></noscript>
				</form>
			</td>
			<td class="cart-actions">
				<a href="<?php echo ($product['wishlist_check'] ? (base_url('user/wishlist')) : (base_url('user/wishlist_add/') . $product['product_id'] . "/1"))?>">
					<button class="<?php echo ($product['wishlist_check'] ? 'cart-wishlist-set' : 'cart-wishlist');?>"><?php echo ($product['wishlist_check'] ? "View Wishlist" : "Move to Wishlist");?></button>
				</a><br>
				<a href="<?php echo base_url('cart/remove/') . $product['product_id'];?>">remove from cart ></a>
			</td>
			<td class="cart-price">
				<span id="p<?php echo $product['product_id'];?>" value="<?php echo $product['price'];?>">
					<?php echo $product['price'] * $product['quantity'];?>
				</span> €
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<h3 style="text-align:right;">
		Total: <span id="total_price"><?php echo $total_price;?></span> € 
		<a href="<?php echo (($global_stock_check && (!$empty_cart)) ? (base_url('cart/order') . '">' . '<input class="btn-green-large"') : ('">' . '<input class="btn-green-disabled"'));?> name="place_order" type="submit" value="Place Order"/></a>
	</h3>
</div>