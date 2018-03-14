<div class="page-content">
	<h2>Manage Products</h2>
	<p class="search_term">searching "<b><?php echo $search_term;?></b>"</p>
	<?php echo (!(isset($products[0])) ? '<p class="search_error">No products found matching your search term.</p>' : 
	'<table id="cartTable">
	<thead>
		<tr>
			<th>Id</th>
			<th>Product</th>
			<th>Price</th>
			<th>Stock</th>
			<th>Action</th>
		</tr>
	</thead>');?>
	<tbody>
	<?php foreach ($products as $product): ?>
		<tr>
			<td class="cart-price">
				<span><?php echo $product['product_id'];?></span>
			</td>
			<td>
				<div class="cart-product-display">
					<a href="<?php echo base_url('admin/edit_product/') . $product['product_id'];?>">
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
			<td class="cart-price">
				<span><?php echo $product['price'];?></span> €
			</td>
			<td class="cart-quantity" <?php echo (($product['stock'] > 0) ? '' : 'style="background-color: rgba(241, 30, 70, 0.2);"');?>>
				<span><?php echo $product['stock'];?></span>
			</td>
			<td class="cart-actions">
				<p><a href="<?php echo base_url('admin/edit_product/') . $product['product_id'];?>">
				<button class="cart-wishlist">Edit Product Info</button>
				</a></p><p>
				<a href="<?php echo base_url('admin/delete_product/') . $product['product_id'];?>">
				<button class="cart-wishlist">Delete</button>
				</a></p>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>