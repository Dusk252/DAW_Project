<div class="page-content">
	<h2>Order History</h2>
	<?php foreach ($orders as $order): ?>
		<table class="order_table">
			<thead>
			<tr><th>Order from <?php echo explode(' ', $order['placed_time'])[0]?><span><?php echo '#' . $order['order_id'];?></span></th></tr>
			</thead>
			<tbody>
			<tr><td>
				<div class="order_status">
					<?php echo $order['status_min']?> on <?php echo $order['status_date'][0] . ' at ' . $order['status_date'][1]?>
					<span <?php echo ($order['status_min']=='Shipped' ? 'style="color: #40a262;"' : 'style="color: #f4e542;"');?>> <?php echo $order['status_text']?></span>
				</div>
				<div class="order_contents"><h3>Contents:</h3>
				<ul>
					<?php foreach ($order['products'] as $product): ?>
					<li><?php echo $product['title'];?> x<?php echo $product['quantity']?></li>
					<?php endforeach; ?>
				<ul></div>
				<div class="order_btn_container">
					<a class="btn-gray-large" href="<?php echo base_url('user/order_history/') . $order['order_id'];?>">View Details</a>
				</div>
			</td></tr>
			</tbody>
		</table>
	<?php endforeach; ?>
</div>