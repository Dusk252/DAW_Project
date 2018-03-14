<div class="page-content">
<div class="index-container">
	<h2>New Releases</h2>
	<div class="product-scroll" style="text-align:left;">
		<?php foreach ($releases as $product): ?>
			<div class="scroll-item"><a href="<?php echo base_url() . 'store/products/' . $product['product_id'];?>"><img src="<?php echo $product['image']; ?>" style="width:auto; height:200px;"/></a></div>
		<?php endforeach; ?>
	</div>
</div>
	<br>
<div class="index-container">
	<h2>Recently Added</h2>
	<div class="product-scroll" style="text-align:left;">
		<?php foreach ($added as $product): ?>
			<div class="scroll-item"><a href="<?php echo base_url() . 'store/products/' . $product['product_id'];?>"><img src="<?php echo $product['image']; ?>" style="width:auto; height:200px;"/></a></div>
		<?php endforeach; ?>
	</div>
</div>
</div>