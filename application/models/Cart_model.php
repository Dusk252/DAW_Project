<?php class Cart_model extends CI_Model { 
        public function __construct() 
        { 
            $this->load->database(); 
			$this->load->model('product_model');
			$this->load->model('user_model');
        }
		
		public function add_item($id, $user) {
			$product = $this->check($id, $user);
			if(isset($product)) {
				$this->db->set('quantity', $product['quantity']+1);
				$this->db->where('user_id', $product['user_id']);
				$this->db->where('product_id', $product['product_id']);
				$this->db->update('cart');
			}
			else {
				$data = array(
					'user_id' => $user,
					'product_id' => $id,
					'quantity' => 1,
					'price' => $this->product_model->get_productinfo($id)['price'],
					'date_added' => date("Y-m-d H:i:s")
				);
				$query = $this->db->insert('cart', $data);
			}
		}
		
		public function remove_item($id, $user) {
			$this->db->where('product_id', $id);
			$this->db->where('user_id', $user);
			$this->db->delete('cart');
		}
		
		public function get_cart($user) {
			$this->db->select('*');
			$this->db->from('cart');
			$this->db->join('products', 'products.product_id = cart.product_id');
			$this->db->where('user_id', $user);
			$this->db->order_by('date_added', 'DESC');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function change_quantity($id, $user, $quantity) {
			$this->db->set('quantity', $quantity);
			$this->db->where('user_id', $user);
			$this->db->where('product_id', $id);
			$this->db->update('cart');
		}
		
		public function check($id, $user) {
			$this->db->select('*');
			$this->db->from('cart');
			$this->db->where('user_id', $user);
			$this->db->where('product_id', $id);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0];
			}
		}
		
		public function place_order($user, $address, $product_data) {
			$data = array(
				'user_id' => $user,
				'shipping_address' => $address,
				'status' => 'Not yet shipped',
				'placed_time' => date("Y-m-d H:i:s")
			);
			$this->db->insert('orders', $data);
			$order_id = $this->db->insert_id();
			foreach ($product_data as $item) {
				$data = array(
					'order_id' => $order_id,
					'product_id' => $item['product_id'],
					'quantity' => $item['quantity']
				);
				$this->db->insert('order_details', $data);
				$new_stock = $item['stock'] - $item['quantity'];
				$this->db->set('stock', $new_stock);
				$this->db->where('product_id', $item['product_id']);
				$this->db->update('products');
				$this->remove_item($item['product_id'], $user);
				$this->user_model->remove_item($item['product_id'], $user);
			}
		}
}
?>