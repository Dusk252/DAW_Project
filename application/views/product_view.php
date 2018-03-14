<div class="page-content">
<!--buttons.js was here-->
<div class="product-img">
	<img src="<?php echo $image;?>"/>
</div>

<div class="product-details">
	<div class="product-header">
		<div class="product-price-stock">
			<?php echo $price;?> €
			<div class="stock" style="color:
			<?php
				echo (($stock > 0) ? '#74E477;">In stock' : '#F11E46;">Not available');
			?></div>
		</div>
		<div class="product-title">
			<?php echo $title;?>
		</div>
		<div class="product-author">
			by <?php echo $author;?>
		</div>
	</div>
	<div class="cs-product-display-details">
		<p>Publisher: <?php echo $publisher;?></p>
		<p>Release Date: <?php echo $release_date;?></p>
	</div>
</div>

<div class="description">
		<b>Product Description:</b><br>
		<?php echo $description;?>
</div>

<div class="product-actions">
	<?php if(!$admin) {
		$wish_check = check_database($user_model, $product_id, $user_id);
		if($wish_check) { ?>
			<a class="product-added" id="<?php echo $product_id;?>" href="<?php echo site_url('user/wishlist');?>">View Wishlist</a>
	<?php	}
		else { ?>
			<a class="btn-gray-large form-button" id="<?php echo $product_id;?>" href="<?php echo site_url('user/wishlist_add/') . $product_id;?>" alt="<?php echo site_url('user/wishlist');?>">Add to Wishlist</a>
	<?php	}
		$cart_check = check_database($cart_model, $product_id, $user_id);
		$session_check = isset($userdata['cart']) && isset($userdata['cart'][$product_id]);
		if($cart_check || $session_check) { ?>
			<a class="product-added" id="<?php echo $product_id;?>" href="<?php echo site_url('cart');?>">View Cart</a>
	<?php	}
		else { if ($stock <= 0) {?>
			<input class="disabled-button" type="button" value="Out of Stock"/>
		<?php } else {?>
			<a class="btn-gray-large form-button" id="<?php echo $product_id;?>" href="<?php echo site_url('cart/add/') . $product_id;?>" alt="<?php echo site_url('cart');?>">Add to Cart</a>
	<?php	}}}
		else {?>
			<a class="btn-gray-large" href="<?php echo site_url('admin/edit_product/') . $product_id;?>">Edit Product</a>
			<a class="btn-gray-large" href="<?php echo site_url('admin/delete_product/') . $product_id;?>">Delete Product</a>
	<?php	}?>
</div>

</div>