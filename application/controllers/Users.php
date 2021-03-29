<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['name'],$_SESSION['email'])) {
			redirect('auth');
		}

		if ($_SESSION['role_id'] != 1) {
			redirect('admin/dashboard');
		}
	}
	// public function index()
	// {
	// 	$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
	// 	echo "login sukses" . $data['user']['name'];
	// }

	public function index()
	{
		$this->db->select('users.id, users.name, users.email, users.role_id, users.role_id, role.role as role_name');
		$this->db->from('users');
		$this->db->join('role', 'role.id = users.role_id', 'left');
		$query = $this->db->get();
		$data['users'] = $query->result();;
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('admin/users/index', $data);
	}

	public function store()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$role_id = $this->input->post('role_id');
		
		$data = array(
			'name' => $name,
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'role_id' => $role_id,
			'is_active' => 1
		);

		$this->db->insert('users', $data);

		redirect('users/index');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$role_id = $this->input->post('role_id');

		$data = array(
			'name' => $name,
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'role_id' => $role_id,
			'is_active' => 1,
		);

		$where = array(
			'id'	=> $id
		);

		$this->db->where($where);
		$this->db->update('users', $data);

		redirect('users/index');
	}

	public function destroy()
	{
		$id = $this->uri->segment(3);
		$this->db->delete('users', array('id' => $id));

		redirect('users/index');
	}
}
