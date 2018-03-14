<?php class Product_model extends CI_Model { 
        public function __construct() 
        { 
            $this->load->database(); 
        }
		
		public function get_productinfo($id) 
		{ 
			$this->db->select('*');
			$this->db->from('products');
			$this->db->where('product_id', $id);
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				return $query->result_array()[0];
			}
		}
		
		public function get_30_latestadded()
		{
			$this->db->select('*');
			$this->db->from('products');
			$this->db->order_by('added_at', 'DESC');
			$this->db->limit('30');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_30_newreleases()
		{
			$this->db->select('*');
			$this->db->from('products');
			$this->db->order_by('release_date', 'DESC');
			$this->db->limit('30');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_categorylist()
		{
			$this->db->select('category');
			$this->db->from('products');
			$this->db->distinct();
			$this->db->group_by('category');
			
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_categoryproducts($cat)
		{
			$this->db->select('*');
			$this->db->from('products');
			$this->db->where('category', $cat);
			$this->db->order_by('release_date', 'DESC');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function search($kw, $order_flag = FALSE)
		{
			$this->db->select('*');
			$this->db->from('products');
			$this->db->like('title', $kw);
			$order_flag ? $this->db->order_by('product_id', 'ASC') : $this->db->order_by('release_date', 'DESC');
			
			$query = $this->db->get();
			return $query->result_array();
		}
}
?>