<div class="page-content">
	<div id="categories-table">
		<h2>Categories</h2>
		<?php foreach ($categories as $cat): ?>
			<a href="<?php echo $cat['category'];?>"><div class="category-item"><?php echo $cat['category'];?></div></a>
		<?php endforeach; ?>
	</div>
</div>