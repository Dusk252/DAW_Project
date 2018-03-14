<?php
class Cart extends CI_Controller { 

        public function __construct() 
        { 
			parent::__construct(); 
			$this->load->model('cart_model');
			$this->load->model('user_model');
			$this->load->model('product_model');
			$this->load->helper('store_helper');
			$this->load->library('user_agent');	
			$this->load->helper('url_helper'); 			
			$this->load->library('session');
        } 
		
		//Show user cart
        public function index() 
        { 
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			$data = load_header();
			$this->load->view('header.php', $data);
		
			if(isset($_SESSION['user_id'])) {
				//Gets products in cart from database based on user id
				$data['products'] = $this->cart_model->get_cart($_SESSION['user_id']);
				$data['total_price'] = 0;
				$data['global_stock_check'] = true;
				$data['empty_cart'] = (isset($data['products'][0]) ? false : true);
				foreach ($data['products'] as $key => $item) {
					//For each item, check whether it's on user database
					$data['products'][$key]['wishlist_check'] = check_database($this->user_model, $item['product_id'], $_SESSION['user_id']);
					$data['total_price'] = $data['total_price'] + $item['price'] * $item['quantity'];
					//For each item, check whether it's in stock
					if (!($item['stock'] > 0)) {
						$data['global_stock_check'] = false;
					}
			}
			$this->load->view('cart_view', $data);
			}
			
			$this->load->view('footer.php');
		}
		
		//Add item to cart
		public function add($id = NULL) {
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			
			if(!isset($id)) {
				$id = $_POST['id'];
			}
			if(isset($_SESSION['user_id'])) {
				$this->cart_model->add_item($id, $_SESSION['user_id']);
			}
			else {
				if (!isset($_SESSION['cart'][$id])) {
					$_SESSION['cart'][$id]['id'] = $id;
					$_SESSION['cart'][$id]['quantity'] = 1;
					$_SESSION['cart'][$id]['date_added'] = date("Y-m-d H:i:s");
				}
				else {
					$_SESSION['cart'][$id]['id'] = $id;
					$_SESSION['cart'][$id]['quantity'] = $_SESSION['cart'][$id]['quantity'] + 1;
				}
			}
			$_SESSION['search_load'] = 1;
			redirect($this->agent->referrer());
		}
		
		//Remove item from cart
		public function remove($id) {
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			if(isset($_SESSION['user_id'])) {
				$this->cart_model->remove_item($id, $_SESSION['user_id']);
			}
			else {
				if(isset($_SESSION['cart'])) {
					if (isset($_SESSION['cart'][$id])) {
						$new_data = $_SESSION['cart'];
						unset($new_data[$id]);
						$this->session->set_userdata('cart', $new_data);
					}
				}
			}
			redirect(base_url('cart'));
		}
		
		//Change item quantity
		public function change_quantity($id = FALSE) {
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			if(!$id) {
				$id = $_POST['id'];
			}
			$quantity = $_POST['quantity'];
			if ($quantity || $_POST['flag']  <= $this->product_model->get_productinfo($id)['stock']) {
				if(isset($_SESSION['user_id'])) {
					$this->cart_model->change_quantity($id, $_SESSION['user_id'], $quantity);
				}
				//cart display for non session doesn't work
/*				else {
					if(isset($_SESSION['cart'])) {
						$_SESSION['cart'][$id]['quantity'] = $quantity;
					}
				}*/
			}
			redirect($this->agent->referrer());
		}
		
		//Place an order
		public function order() {
			if (isset($_SESSION['admin_id'])) {
				redirect(base_url('admin/warning'));
			}
			if(isset($_SESSION['user_id'])) {
				//Check if order placement request has come from the cart page
				if(($this->agent->referrer() == base_url('cart')) || ($this->agent->referrer() == current_url())) {
					$data = load_header();
					$this->load->view('header.php', $data);
					
					$data['total_price'] = 0;
					$data['products'] = $this->cart_model->get_cart($_SESSION['user_id']);
					foreach ($data['products'] as $item) {
						$data['total_price'] = $data['total_price'] + $item['price'] * $item['quantity'];
					}
					$data['empty_orders'] = !isset($data['products'][0]);
					$this->load->library('form_validation'); 
					
					$this->form_validation->set_rules('address', 'shipping address', 'required');
					$this->form_validation->set_rules('cc', 'credit card', 'required|callback_validate_cc');
					
					//$this->form_validation->set_message('validate_cc','Invalid credit card number.');
					//^credit card checksum, see commented function at the bottom
				
					if ($this->form_validation->run() === FALSE) 
					{ 
						$data['address'] = $this->user_model->get_address($_SESSION['user_id']);
						$this->load->view('order_view', $data);
						$this->load->view('footer.php');
					} 
					else 
					{
						$data['products'] = $this->cart_model->get_cart($_SESSION['user_id']);
						foreach ($data['products'] as $item) {
							if ($item['stock'] - $item['quantity'] < 0) {
								redirect(base_url('cart'));
							}
						}
						$this->cart_model->place_order($_SESSION['user_id'], $this->input->post('address'), $data['products']);
						redirect(base_url('cart/order_success'));
					}
					
				}
				//Send to cart if unexpected referrer
				else {
					redirect(base_url('cart'));
				}
			}
			//Send to login if user isn't logged in
			else {
				redirect(base_url('auth/login'));
			}
		}
		
		//Display order success page
		public function order_success() {
			if($this->agent->referrer() == base_url('cart/order')) {
				$data = load_header();
				$this->load->view('header.php', $data);
				$this->load->view('order_success_view');
				$this->load->view('footer.php');
			}
			else {
				redirect(base_url('cart'));
			}
		}
		
		//Credit card checksum
		//annoying for testing purposes so commented out
		/*public function validate_cc($cc) {
			$cc = preg_replace('/[^\d]/', '', $cc);
			$sum = '';
			for ($i = strlen($cc) - 1; $i >= 0; -- $i) {
				$sum .= $i & 1 ? $cc[$i] : $cc[$i] * 2;
			}
			return (array_sum(str_split($sum)) % 10 === 0) && (strlen($cc)>=12 && strlen($cc)<=16);
		}*/
		
}
?>