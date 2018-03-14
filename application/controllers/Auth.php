<?php
class Auth extends CI_Controller { 
        public function __construct() 
        { 
			parent::__construct(); 
			$this->load->model('auth_model'); 
			$this->load->model('cart_model');
			$this->load->helper('url_helper');
			$this->load->library('user_agent');			
			$this->load->helper('store_helper'); 
			$this->load->library('session'); 
        } 
		
		//No simple auth page
		//always redirects to auth/register if url entered manually
        public function index() 
        { 
			redirect(base_url('auth/register'));
        } 
		
		public function register()
		{
			$this->load->library('form_validation'); 
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$this->form_validation->set_rules('username', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|is_unique[admin.email]');
			$this->form_validation->set_rules('pass1', 'Password', 'required|alpha_dash');
			$this->form_validation->set_rules('pass2', 'Password confirmation', 'required|matches[pass1]');
			
			if ($this->form_validation->run() === FALSE) 
			{ 
				$this->load->view('register_view', $data); 
			} 
			else 
			{ 
			   $this->auth_model->register_user(); 
			   redirect(base_url()); 
			} 
			
			$this->load->view('footer.php');
		}
		
		public function login()
		{
			$this->load->library('form_validation'); 
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$this->form_validation->set_rules('email', 'email', 'required');
			
			if(isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
				$this->load->view('login_warning_view');
			}
			else {
				if ($this->form_validation->run() === FALSE) 
				{
					//says you're already logged in
					$data['message'] = '';
					$this->load->view('login_view', $data); 
				} 
				else 
				{ 
					$tupple = $this->auth_model->validate_user(); 
					if (isset($tupple)) 
					{ 
						//if user credentials entered
						$_SESSION['user_id'] = $tupple['user_id'];
						$_SESSION['name'] = $tupple['username'];
						if(isset($_SESSION['cart'])) {
							foreach($_SESSION['cart'] as $product) {
								$this->cart_model->add_item($product['id'], $_SESSION['user_id']);
							}
						}
						redirect(base_url());
					}
					else 
					{ 
						$tupple = $this->auth_model->validate_admin(); 
						if (isset($tupple)) 
						{ 
							//if admin credentials entered
							$_SESSION['admin_id'] = $tupple['admin_id'];
							$_SESSION['name'] = $tupple['username'];
							redirect(base_url());
						}
						else {
							//wrong info
							$data['message'] = 'You entered an invalid username/password combination.'; 
							$this->load->view('login_view', $data); 
						}
					} 
				}
			}
			
			$this->load->view('footer.php');
		}
		
		public function logout() 
		{   
			$this->session->sess_destroy();
			redirect(base_url());
		}
}
?>