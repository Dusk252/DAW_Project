<?php class User_model extends CI_Model { 
        public function __construct() 
        { 
            $this->load->database(); 
        }
		
		public function add_item($id, $user) {
			$product = $this->check($id, $user);
			if(!isset($product)) {
				$data = array(
						'user_id' => $user,
						'product_id' => $id,
						'date_added' => date("Y-m-d H:i:s")
					);
				$query = $this->db->insert('wishlist', $data);
			}
		}
		
		public function remove_item($id, $user) {
			$this->db->where('product_id', $id);
			$this->db->where('user_id', $user);
			$this->db->delete('wishlist');
		}
		
		public function get_wishlist($user) {
			$this->db->select('*');
			$this->db->from('wishlist');
			$this->db->join('products', 'products.product_id = wishlist.product_id');
			$this->db->where('user_id', $user);
			$this->db->order_by('date_added', 'DESC');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function check($id, $user) {
			$this->db->select('*');
			$this->db->from('wishlist');
			$this->db->where('user_id', $user);
			$this->db->where('product_id', $id);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0];
			}
		}
		
		public function get_user_info($user) {
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('user_id', $user);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0];
			}
		}
		
		public function check_password($user) {
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('user_id', $user);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				$array = $query->result_array()[0];
				if ((password_verify($this->input->post('pass1'), $array['password']))) {
					return true;
				}
			}
			return false;
		}
		
		public function edit_user_info($user) {
			$data = array();
			if (!strlen(trim($this->input->post('username')))==0) {
				$data['username'] = $this->input->post('username');
				$_SESSION['name'] = $this->input->post('username');
			}
			if (!strlen(trim($this->input->post('pass2')))==0) {
				$data['password'] = password_hash($this->input->post('pass2'), PASSWORD_BCRYPT);
			}
			if (!strlen(trim($this->input->post('address')))==0) {
				$data['address'] = $this->input->post('address');
			}
			$this->db->set($data);
			$this->db->where('user_id', $user);
			$this->db->update('users');
		}
		
		public function get_address($user) {
			$this->db->select('address');
			$this->db->from('users');
			$this->db->where('user_id', $user);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0]['address'];
			}
		}
		
		public function get_order_info($user) {
			$this->db->select('*');
			$this->db->from('orders');
			$this->db->where('user_id', $user);
			$this->db->order_by('placed_time', 'DESC');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_single_order_info($order_id) {
			$this->db->select('*');
			$this->db->from('orders');
			$this->db->where('order_id', $order_id);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0];
			}
		}
		
		public function get_order_details($order_id) {
			$this->db->select('*');
			$this->db->from('order_details');
			$this->db->join('products', 'products.product_id = order_details.product_id');
			$this->db->where('order_id', $order_id);
			$query = $this->db->get();
			return $query->result_array();
		}
}
?>