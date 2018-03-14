<?php
class Store extends CI_Controller { 

        public function __construct() 
        { 
			parent::__construct(); 
			$this->load->model('product_model'); 
			$this->load->model('cart_model'); 
			$this->load->model('user_model'); 
			$this->load->helper('url_helper'); 
			$this->load->helper('store_helper'); 
			$this->load->library('session'); 
        } 
		
		//The store's main page
		//Ges newest releases for a scrolling displayer
        public function index() 
        { 
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$data['added'] = $this->product_model->get_30_latestadded();
			$data['releases'] = $this->product_model->get_30_newreleases();
			
			$this->load->view('index_view', $data);
			$this->load->view('footer.php');
        } 
		
		//Shows an individual product
		//If admin, editing options are displayed
		public function products($id)
		{
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$data = $this->product_model->get_productinfo($id);
			$data['admin'] = isset($_SESSION['admin_id']) ? true : false;
			$data['user_id'] = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '');
			$data['cart_model'] = $this->cart_model;
			$data['user_model'] = $this->user_model;
			$data['userdata'] = $_SESSION;
			$this->load->view('product_view', $data);
			
			$this->load->view('footer.php');
		}
		
		//Navigate by product categories
		public function categories($id = NULL)
		{
			$data = load_header();
			$this->load->view('header.php', $data);
			
			if(isset($id)) {
				$data['id'] = $id;
				$data['products'] = $this->product_model->get_categoryproducts($id);
				$data['user_id'] = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '');
				$data['cart_model'] = $this->cart_model;
				$data['user_model'] = $this->user_model;
				$data['userdata'] = $_SESSION;
				$this->load->view('category_view', $data);
			}
			else {
				$data['categories'] = $this->product_model->get_categorylist();
				$this->load->view('category_list', $data);
			}
			
			$this->load->view('footer.php');
		}
		
		//Search results page
		public function search()
		{
			$data = load_header();
			$this->load->view('header.php', $data);
			
			$kw = $this->input->post('search');
			if(empty($kw) && !isset($_SESSION['search_load'])) {
				$this->load->view('search_empty');
			}
			else {
				if(empty($kw) && isset($_SESSION['search']) && isset($_SESSION['search_load'])) {
					$kw = $_SESSION['search'];
					$this->session->unset_userdata('search_load');
				}
				$data['search_term'] = $kw;
				$data['products'] = $this->product_model->search($kw);
				$data['user_id'] = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '');
				$data['cart_model'] = $this->cart_model;
				$data['user_model'] = $this->user_model;
				$this->load->view('search_view', $data);
			}	
			$this->load->view('footer.php');
		}
		
		//FAQ page
		public function faq()
		{
			$data = load_header();
			$this->load->view('header.php', $data);
			$this->load->view('store_info_view');
			$this->load->view('footer.php');
		}
}
?>