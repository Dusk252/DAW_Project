<?php class Admin_model extends CI_Model { 
        public function __construct() 
        { 
            $this->load->database(); 
        }
		
		public function get_admin_info($admin) {
			$this->db->select('username, email');
			$this->db->from('users');
			$this->db->where('user_id', $admin);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0];
			}
		}
		
		public function edit_admin_info($admin) {
			$data = array();
			if (!strlen(trim($this->input->post('username')))==0) {
				$data['username'] = $this->input->post('username');
				$_SESSION['name'] = $this->input->post('username');
			}
			if (!strlen(trim($this->input->post('pass2')))==0) {
				$data['password'] = password_hash($this->input->post('pass2'), PASSWORD_BCRYPT);
			}
			$this->db->set($data);
			$this->db->where('admin_id', $admin);
			$this->db->update('admin');
		}
		
		public function check_password($admin) {
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('user_id', $admin);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				$array = $query->result_array()[0];
				if ((password_verify($this->input->post('pass1'), $array['password']))) {
					return true;
				}
			}
			return false;
		}
		
		public function add_product()  {
			$present_date = date("Y-m-d H:i:s"); 
			$data = array(
				'title' => $this->input->post('title'),
				'category' => $this->input->post('category'),
				'author' => $this->input->post('author'),
				'publisher' => $this->input->post('publisher'),
				'price' => $this->input->post('price'),
				'stock' => $this->input->post('stock'),
				'description' => $this->input->post('description'),
				'image' => $this->input->post('url'),
				'added_at' => $present_date,
				'release_date' => $this->input->post('release_date')
			);
			$this->db->insert('products', $data);
		}
		
		public function delete_product($id) {
			$this->db->where('product_id', $id);
			$this->db->delete('products');
		}
		
		public function edit_product($id)  {
			$data = array(
				'title' => $this->input->post('title'),
				'category' => $this->input->post('category'),
				'author' => $this->input->post('author'),
				'publisher' => $this->input->post('publisher'),
				'price' => $this->input->post('price'),
				'stock' => $this->input->post('stock'),
				'description' => $this->input->post('description'),
				'image' => $this->input->post('url'),
				'release_date' => $this->input->post('release_date')
			);
			$this->db->where('product_id', $id);
			$this->db->update('products', $data);
		}
		
		public function get_all_orders() {
			$this->db->select('*');
			$this->db->from('orders');
			$this->db->order_by('status', 'ASC');
			$this->db->order_by('placed_time', 'DESC');
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function update_status($status, $id) {
			$present_date = date("Y-m-d H:i:s");
			$this->db->set('status', $status);
			if ($status==1) {
				$this->db->set('processed_time', $present_date);
			}
			if ($status==2) {
				$this->db->set('shipped_time', $present_date);
			}
			$this->db->where('order_id', $id);
			$this->db->update('orders');
		}
}
?>