<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	private function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			if (password_verify($password, $user['password'])) {
				$data = [
					'email' 		=> $user['email'],
					'name' 			=> $user['name'],
					'role_id' 	=> $user['role_id'],
				];

				$this->session->set_userdata($data);
				if ($data['role_id'] == 2) {
					# code...
					redirect('user/dashboard');
				} else {
					redirect('admin/dashboard');
					# code...
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert"> Failed, Password not match</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert"> Failed, Account is not register</div>');
			redirect('auth');
		}
	}
	public function index()
	{
		$this->form_validation->set_rules('email', 'email', 'required', 'valid_email');
		$this->form_validation->set_rules('password', 'password', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/login');
		} else {
			$this->login();
		}
	}

	public function registration()
	{
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required', 'valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[6]|matches[password_repeat]', [
			'matches' => 'password dont match',
			'min_length' => 'password too shord',
		]);
		$this->form_validation->set_rules('password', 'password', 'required|matches[password]');

		if ($this->form_validation->run() == false) {
			# code...
			$this->load->view('auth/register');
		} else {

			$data = [
				'name' => $this->input->post('name', true),
				'email' => $this->input->post('email', true),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 1,
				'create_at' => time(),
			];

			$this->db->insert('users', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Success, Your account has been created</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('password');

		redirect('auth');
	}
}
