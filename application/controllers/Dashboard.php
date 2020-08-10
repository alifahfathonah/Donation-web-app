<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('All_model', 'model');
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'users' => $this->db->get('users')->result()
		];
		$this->template->load('template', 'dashboard', $data);
	}

	public function new()
	{
		$data = $this->input->post();
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->db->insert('users', $data);
		$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Admin Berhasil Ditambahkan") })</script>');
		redirect('dashboard');
	}

	public function get_top_10()
	{
		header("Content-Type: application/json; charset=UTF-8");

		$data = $this->model->getHigher();
		echo json_encode($data);
	}

	public function get_by_type()
	{
		header("Content-Type: application/json; charset=UTF-8");

		$data = $this->model->getDonationsByType();
		echo json_encode($data);
	}

	public function del($id)
	{
		if ($id == $this->session->userdata('id')) {
			$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.error("Kamu tidak bisa menghapus dirimu sendiri") })</script>');
		} else {
			$this->db->delete('users', ['id' => $id]);
			$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Data berhasil dihapus") })</script>');
		}
		redirect('dashboard');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	}
}
