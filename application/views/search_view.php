<div class="page-content">
	<!--buttons.js was here-->
	<p class="search_term">searching "<b><?php echo $search_term;?></b>"</p>
	<?php $_SESSION['search'] =  $search_term;?>
	<?php $this->session->unset_userdata('search_load');?>
	<?php echo ((isset($products[0])) ? '' : '<p class="search_error">No products found matching your search term.</p>');
		foreach ($products as $product): ?>
			<div class="cs-product-display">
				<a href="<?php echo base_url('store/products/') . $product['product_id'];?>">
					<img src="<?php echo $product['image'];?>"/>
				</a>
				<div class="cs-product-title">
					<a href="<?php echo base_url('store/products/') . $product['product_id'];?>">
						<?php echo $product['title'];?>
					</a>
				</div>
				<div class="cs-product-author">by <?php echo $product['author'];?></div>
				<div class="cs-product-display-details">
					<p>Price: <em class='cs-price'><?php echo $product['price'];?>€</em></p>
					<p class="stock"><div class="stock" style="color:
					<?php
						echo (($product['stock'] > 0) ? '#74E477;">In stock' : '#F11E46;">Not available');
					?></div></p>
					<p>Publisher: <?php echo $product['publisher'];?></p>
					<p>Release Date: <?php echo $product['release_date'];?></p>
				</div>
				<div class="cs-product-actions">
					<?php
						$wish_check = check_database($user_model, $product['product_id'], $user_id);
						if($wish_check) { ?>
							<a class="product-added" id="<?php echo $product['product_id'];?>" href="<?php echo site_url('user/wishlist');?>">View Wishlist</a>
					<?php	}
						else { ?>
							<a class="btn-gray-large form-button" id="<?php echo $product['product_id'];?>" href="<?php echo site_url('user/wishlist_add/') . $product['product_id'];?>" alt="<?php echo site_url('user/wishlist');?>">Add to Wishlist</a>
					<?php	}
						$cart_check = check_database($cart_model, $product['product_id'], $user_id);
						if($cart_check) { ?>
							<a class="product-added" id="<?php echo $product['product_id'];?>" href="<?php echo site_url('cart');?>">View Cart</a>
					<?php	}
						else { if ($product['stock'] <= 0) {?>
							<input class="disabled-button" type="button" value="Out of Stock"/>
						<?php } else {?>
							<a class="btn-gray-large form-button" id="<?php echo $product['product_id'];?>" href="<?php echo site_url('cart/add/') . $product['product_id'];?>" alt="<?php echo site_url('cart');?>">Add to Cart</a>
					<?php	}}?>
				</div>
			</div>
	<?php endforeach; ?>
</div>