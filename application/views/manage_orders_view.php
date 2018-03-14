<div class="page-content">
	<h2>Manage Orders</h2>
	<?php foreach ($orders as $order): ?>
		<table class="order_table">
			<thead>
			<tr><th>Order from <?php echo explode(' ', $order['placed_time'])[0]?><span>Order Id: #<?php echo $order['order_id'];?></span></th></tr>
			</thead>
			<tbody>
			<tr><td>
				<div class="order_status">
					<div class="order-status-date"><?php echo $order['status_min']?> on <?php echo $order['status_date'][0] . ' at ' . $order['status_date'][1]?>
					<span <?php echo ($order['status_min']=='Shipped' ? 'style="color: #40a262;"' : 'style="color: #f4e542;"');?>> <?php echo $order['status_text']?></span></div>
					<form method="post" class="order-manage-form" action="<?php echo base_url('admin/update_order_status/') . $order['order_id'];?>">
					<select id="status_select" name="order_status">
						<option value="0" <?php echo ($order['status']==0 ? 'selected="selected"' : '');?>>Not Yet Shipped</option>
						<option value="1" <?php echo ($order['status']==1 ? 'selected="selected"' : '');?>>Shipping Soon</option>
						<option value="2" <?php echo ($order['status']==2 ? 'selected="selected"' : '');?>>Shipped</option>
					</select>
					<button type="submit" class="cart-wishlist">Update Status</button>
					</form>
					<a class="order-manage-details" href="<?php echo base_url('user/order_history/') . $order['order_id'];?>"><button class="cart-wishlist">View Order Details</button></a>
				</div>
			</td></tr>
			</tbody>
		</table>
	<?php endforeach; ?>
</div>
