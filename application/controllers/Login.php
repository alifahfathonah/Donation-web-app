<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_login')) {
			redirect('dashboard');
		}
	}

	public function index()
	{
		if ($this->input->post()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$data = $this->db->get_where('users', ['username' => $username]);
			if ($data->num_rows() > 0) {
				$newData = $data->row();
				if (password_verify($password, $newData->password) == true) {
					$session = [
						'id' => $newData->id,
						'is_login' => true,
						'name' => $newData->name
					];
					$this->session->set_userdata($session);
					$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Login Success") })</script>');

					if ($this->session->userdata('current_url') !== null) {
						redirect($this->session->userdata('current_url'));
					} else {
						redirect('dashboard');
					}
				} else {
					$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.error("Username atau password salah") })</script>');
					redirect('login');
				}
			} else {
				$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.error("Username atau password salah") })</script>');
				redirect('login');
			}
		} else {
			$this->load->view('login');
		}
	}
}
