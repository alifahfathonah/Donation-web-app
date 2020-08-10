<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Donator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_login();
	}

	public function index()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			if (!isset($data['id']) || $data['id'] == '') {
				$this->db->insert('donators', $data);
				$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Donatur Berhasil Ditambahkan") })</script>');
			} else {
				$this->db->update('donators', $data, ['id' => $data['id']]);
				$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Donatur Berhasil Diupdate") })</script>');
			}
			redirect('donator');
		} else {
			$data = [
				'data' => $this->db->get('donators')->result(),
				'title' => 'Donatur'
			];
			$this->template->load('template', 'donator', $data);
		}
	}

	public function getOne($id)
	{
		header("Content-Type: application/json; charset=UTF-8");

		$data = $this->db->get_where('donators', ['id' => $id])->row();
		echo json_encode($data);
	}

	public function delete($id)
	{
		$data = $this->db->get_where('donations', ['donator' => $id])->num_rows();

		if ($data > 0) {
			$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.error("Donatur sudah melakukan donasi") })</script>');
		} else {
			$this->db->delete('donators', ['id' => $id]);
			$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Donatur Berhasil Dihapus") })</script>');
		}
		redirect('donator');
	}
}
