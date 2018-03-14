<?php
class User extends CI_Controller { 

        public function __construct() 
        { 
			parent::__construct(); 
			$this->load->model('user_model');
			$this->load->model('cart_model');
			$this->load->helper('store_helper');
			$this->load->helper('url_helper'); 			
			$this->load->library('session');
			$this->load->library('user_agent');
        } 
		
		
		//General user page
		public function index() 
        {
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			
			$data = load_header();
			$this->load->view('header.php', $data);
			if (isset($_SESSION['user_id'])) {
				$data['logout'] = '<div class="profile-link"><a href="' . base_url('auth/logout') . '">>>LogOut</a></div>';
			}
			else {
				$data['logout'] = '';
			}
			$this->load->view('user_view', $data);
			$this->load->view('footer.php');
		}
		
		//User profile
		//Both display and edit views are handled by this controller
		public function profile($edit = NULL)
		{
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			
			if(isset($_SESSION['user_id'])) {
				$data = load_header();
				$this->load->view('header.php', $data);
				
				$data = $this->user_model->get_user_info($_SESSION['user_id']);
				$data['register_date'] = substr($data['register_date'], 0, 10);
				$data['message'] = '';
				if(!isset($edit)) {
					$this->load->view('profile_view', $data);
				}
				else {
					$this->load->library('form_validation'); 
					$this->form_validation->set_rules('pass1', 'password', 'required');
					$this->form_validation->set_rules('pass2', 'new password', 'alpha_dash|differs[pass1]');
					$this->form_validation->set_rules('pass3', 'new password', 'matches[pass2]');
					
					if ($this->form_validation->run() === FALSE) 
					{ 
						$this->load->view('profile_edit_view', $data); 
					} 
					else 
					{ 
						$check = $this->user_model->check_password($_SESSION['user_id']);
						if ($check) 
						{ 
							$this->user_model->edit_user_info($_SESSION['user_id']);
							redirect(base_url('user/profile'));
						} 
						else 
						{ 
							$data['message'] = 'You entered a wrong password.'; 
							$this->load->view('profile_edit_view', $data); 
						} 
					} 
				}
			}
			else {
				redirect(base_url('auth/login'));
			}
			
			$this->load->view('footer.php');
		}
		
		//User specific wishlist
		public function wishlist()
		{
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			
			if(isset($_SESSION['user_id'])) {
				$data = load_header();
				$this->load->view('header.php', $data);
		
				$data['products'] = $this->user_model->get_wishlist($_SESSION['user_id']);
				$data['cart_model'] = $this->cart_model;
				$data['user_id'] = ($_SESSION['user_id']);
				$this->load->view('wishlist_view', $data);
			}
			else {
				redirect(base_url('auth/login'));
			}
			
			$this->load->view('footer.php');
		}
		
		//Adds to wishlist; self-explanatory
		public function wishlist_add($id=NULL, $cart=NULL)
		{
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			
			if(isset($_SESSION['user_id'])) {
				if(!isset($id)) {
					$id = $_POST['id'];
				}
				$this->user_model->add_item($id, $_SESSION['user_id']);
				if($cart == 1) {
					$this->cart_model->remove_item($id, $_SESSION['user_id']);
					redirect(base_url('cart'));
				}
				redirect($this->agent->referrer());
			}
			else {
				redirect(base_url('auth/login'));
			}
		}
		
		//Removes from wishlist; self-explanatory
		public function wishlist_remove($id)
		{
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			
			if(isset($_SESSION['user_id'])) {
				$this->user_model->remove_item($id, $_SESSION['user_id']);
				redirect(base_url('user/wishlist'));
			}
			else {
				redirect(base_url('auth/login'));
			}
		}
		
		//Show user order history and order status
		public function order_history($id = NULL)
		{	
			if(isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
				$data = load_header();
				$this->load->view('header.php', $data);
				
				if(!isset($id)) {
					
					if (isset($_SESSION['admin_id'])) {
						redirect(base_url('admin/warning'));
					}
					
					$data['orders'] = $this->user_model->get_order_info($_SESSION['user_id']);
					$data['empty_history'] = (isset($data['products'][0]) ? false : true);
					foreach ($data['orders'] as $key => $item) {
						$data['orders'][$key]['products'] = $this->user_model->get_order_details($item['order_id']);
						$data['orders'][$key]['status_min'] = $item['status']==2 ? 'Shipped' : 'Placed';
						$data['orders'][$key]['status_date'] = $item['status']==2 ? explode(' ', $item['shipped_time']) : explode(' ', $item['placed_time']);
						$data['orders'][$key]['status_text'] = $item['status']==2 ? 'Shipped' : ($item['status']==1 ? 'Shipping soon' : 'Not yet shipped');
					}
					$this->load->view('order_history_view', $data);
				}
				else {
					$data = $this->user_model->get_single_order_info($id);
					$data['total_price'] = 0;
					$data['products'] = $this->user_model->get_order_details($id);
					$data['empty_orders'] = isset($data['products'][0]) ? false : true;
					foreach ($data['products'] as $item) {
						$data['total_price'] = $data['total_price'] + $item['price'] * $item['quantity'];
					}
					$data['status_min'] = $data['status']==2 ? 'Shipped' : 'Placed';
					$data['status_date'] = $data['status']==2 ? explode(' ', $data['shipped_time']) : explode(' ', $data['placed_time']);
					$data['status_text'] = $data['status']==2 ? 'Shipped' : ($data['status']==1 ? 'Shipping soon' : 'Not yet shipped');
					$data['referrer'] = $this->agent->referrer();
					$this->load->view('order_details_view', $data);
				}
				
				$this->load->view('footer.php');
			}
			else {
				redirect(base_url('auth/login'));
			}
		}	
}
?>