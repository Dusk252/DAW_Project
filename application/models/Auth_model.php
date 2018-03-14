<?php class Auth_model extends CI_Model { 
        public function __construct() 
        { 
                  $this->load->database(); 
        }
		
		public function register_user() 
		{ 
            $pass1 = $this->input->post('pass1');  
            $pass = password_hash($pass1, PASSWORD_BCRYPT);
            $present_date = date("Y-m-d H:i:s"); 
			$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'register_date' => $present_date,
				'password' => $pass
			);
            $query = $this->db->insert('users', $data);
		} 
		
		public function validate_user()
		{	
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('email', $this->input->post('email'));
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				$array = $query->result_array()[0];
				if ((password_verify($this->input->post('pass'), $array['password']))) {
					return $array;
				}
			}
		}
		
		public function validate_admin()
		{
			$this->db->select('*');
			$this->db->from('admin');
			$this->db->where('email', $this->input->post('email'));
			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				$array = $query->result_array()[0];
				if ((password_verify($this->input->post('pass'), $array['password']))) {
					return $array;
				}
			}
		}
	}
?>