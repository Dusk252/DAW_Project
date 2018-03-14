<div class="page-content">
	<h2>Order Details</h2>
	<div id="order_details_container">
	<table id="order_details_table" class="order_table">
	<thead>
	<tr><th>Order from <?php echo explode(' ', $placed_time)[0]?></th></tr>
	</thead>
	<tbody>
	<tr><td>
		<div class="order_status">
			<?php echo $status_min?> on <?php echo $status_date[0] . ' at ' . $status_date[1]?>
			<span <?php echo ($status_min=='Shipped' ? 'style="color: #40a262;"' : 'style="color: #f4e542;"');?>> <?php echo $status_text?></span>
		</div>
		<div class="order_status">
			<span style="font-weight: bold;"><?php echo ($status_min=='Shipped' ? 'Shipped' : 'Shipping');?> to: </span><?php echo $shipping_address;?>
		</div>
	</table>
	<table id="cartTable">
	<thead>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th>Price</th>
		</tr>
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
	<h3 id="order_total" style="text-align:right;">
		Total: <span id="total_price"><?php echo $total_price;?></span> € 
	</h3>
	<div class="order_btn_container">
		<a class="btn-gray-large" href="<?php echo $referrer;?>">Back</a>
	</div>
	</div>
</div>