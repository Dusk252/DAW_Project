<?php
class Admin extends CI_Controller { 

        public function __construct() 
        { 
			parent::__construct();
			$this->load->model('admin_model');
			$this->load->model('product_model');
			$this->load->model('user_model');
			$this->load->helper('store_helper');
			$this->load->helper('url_helper');
			$this->load->library('user_agent');
			$this->load->library('session');
        } 
		
		//Shows admin page
		public function index() 
        {
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$data = load_header();
			$this->load->view('header.php', $data);
			$this->load->view('admin_view');
			$this->load->view('footer.php');
		}
	
		//If using a link a user tries to access the admin page, it's redirected to this page
		//If an admin tries 
		public function warning()
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$data = load_header();
			$this->load->view('header.php', $data);
			$this->load->view('admin_warning_view');
			$this->load->view('footer.php');
		}
		
		//Choosing to leave the account on prompt destroys the session
		public function log_redirect()
		{
			$this->session->sess_destroy();
			redirect(base_url('auth/login'));
		}
		
		//Changing password
		public function account()
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$this->load->library('form_validation'); 
			$this->form_validation->set_rules('pass1', 'password', 'required');
			$this->form_validation->set_rules('pass2', 'new password', 'alpha_dash|differs[pass1]');
			$this->form_validation->set_rules('pass3', 'new password', 'matches[pass2]');
			
			if ($this->form_validation->run() === FALSE) 
			{ 
				$data = $this->admin_model->get_admin_info($_SESSION['admin_id']);
				$data['message'] = '';
				$this->load->view('admin_account_view', $data); 
			} 
			else 
			{ 
				$check = $this->admin_model->check_password($_SESSION['admin_id']);
				if ($check) 
				{ 
					$this->admin_model->edit_admin_info($_SESSION['admin_id']);
					redirect(base_url('admin'));
				} 
				else 
				{ 
					$data['message'] = 'You entered a wrong password.'; 
					$this->load->view('admin_account_view', $data); 
				} 
			} 
			$this->load->view('footer.php');
		}
		
		//Add product page
		public function add_product()
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$this->load->library('form_validation'); 
			$this->form_validation->set_rules('title', 'title', 'required');
			$this->form_validation->set_rules('category', 'category', 'required');
			$this->form_validation->set_rules('author', 'author', 'required');
			$this->form_validation->set_rules('publisher', 'publisher', 'required');
			$this->form_validation->set_rules('price', 'price', 'required|decimal');
			$this->form_validation->set_rules('stock', 'stock', 'required|is_natural');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_rules('url', 'image url', 'required|valid_url');
			$this->form_validation->set_rules('release_date', 'release date', 'required|callback_validate_date');
			$this->form_validation->set_message('validate_date', 'Invalid date format.');
			
			if ($this->form_validation->run() === FALSE) 
			{
				$this->load->view('add_product_view', $data);
			} 
			else 
			{ 
			   $this->admin_model->add_product(); 
			   redirect(current_url()); 
			} 
			$this->load->view('footer.php');
		}
		
		//Delete product
		public function delete_product($id)
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			
			if (!isset($_SESSION['delid'])) {
				$data = load_header();
				$this->load->view('header.php', $data);
				$data['id'] = $id;
				$this->load->view('delete_confirmation', $data);
				$_SESSION['delid'] = 1;
				$this->load->view('footer.php');
			}
			else {
				unset($_SESSION['delid']);
				$this->admin_model->delete_product($id);
				redirect(base_url('admin/manage_products'));
			}
			
		}
		
		//Custom form validation rule to check if the date is in a valid format
		//when adding or modifying a product
		public function validate_date($date)
		{
			$dt = DateTime::createFromFormat("Y-m-d", $date);
			return $dt !== false && !array_sum($dt->getLastErrors());
		}
		
		//In all ways similar to a user performed search but if an admin is logged in
		//the search redirects to the method below
		public function manage_products()
		{
			unset($_SESSION['delid']);
			$this->search();
		}
		
		//Search performed with admin account uses this
		public function search()
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}

			else {
				$data = load_header();
				$this->load->view('header.php', $data);
			
				$kw = (null !== $this->input->post('search')) ? $this->input->post('search') : '';
				$data['search_term'] = $kw;
				$data['products'] = $this->product_model->search($kw, TRUE);
				$this->load->view('manage_products_view', $data);
			}
			
			$this->load->view('footer.php');
		}
		
		//Edit product page
		public function edit_product($id)
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$data = $this->product_model->get_productinfo($id);
			$referrer = $this->agent->referrer();
			if ($referrer != current_url() && !empty($referrer))
			{
				$_SESSION['referrer'] = $referrer;
			}
			else {
				$referrer = $_SESSION['referrer'];
			}
			$data['referrer'] = $referrer;
			
			$this->load->library('form_validation'); 
			$this->form_validation->set_rules('title', 'title', 'required');
			$this->form_validation->set_rules('category', 'category', 'required');
			$this->form_validation->set_rules('author', 'author', 'required');
			$this->form_validation->set_rules('publisher', 'publisher', 'required');
			$this->form_validation->set_rules('price', 'price', 'required|decimal');
			$this->form_validation->set_rules('stock', 'stock', 'required|is_natural');
			$this->form_validation->set_rules('description', 'description', 'required');
			$this->form_validation->set_rules('url', 'image url', 'required|valid_url');
			$this->form_validation->set_rules('release_date', 'release date', 'required|callback_validate_date');
			$this->form_validation->set_message('validate_date', 'Invalid date format.');
			
			if ($this->form_validation->run() === FALSE) 
			{
				$this->load->view('modify_product_view', $data);
			} 
			else 
			{ 
				$this->admin_model->edit_product($id); 
				redirect($referrer);
			} 
			$this->load->view('footer.php');
		}
		
		//Manage orders
		//Allows admin to check the orders and update their status
		public function manage_orders()
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$data['orders'] = $this->admin_model->get_all_orders();
			foreach ($data['orders'] as $key => $item) {
				$data['orders'][$key]['products'] = $this->user_model->get_order_details($item['order_id']);
				$data['orders'][$key]['status_min'] = $item['status']==2 ? 'Shipped' : 'Placed';
				$data['orders'][$key]['status_date'] = $item['status']==2 ? explode(' ', $item['shipped_time']) : explode(' ', $item['placed_time']);
				$data['orders'][$key]['status_text'] = $item['status']==2 ? 'Shipped' : ($item['status']==1 ? 'Shipping soon' : 'Not yet shipped');
			}
			$this->load->view('manage_orders_view', $data);
			
			$this->load->view('footer.php');
		}
		
		//Makes call to database to update order status
		public function update_order_status($id)
		{
			if (!isset($_SESSION['admin_id'])) {
				redirect(base_url());
			}
			$this->admin_model->update_status($_POST['order_status'], $id);
			redirect($this->agent->referrer());
		}
}
?>