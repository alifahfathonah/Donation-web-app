<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Donation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('All_model', 'model');
	}

	public function index()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			if (!isset($data['id']) || $data['id'] == '') {
				$this->db->insert('donations', $data);
				$donator = $this->db->get_where('donators', ['id' => $data['donator']])->row();
				$this->db->update('donators', ['amount_of_donation' => $donator->amount_of_donation + 1], ['id' => $donator->id]);
				$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Donasi Berhasil Ditambahkan") })</script>');
			} else {
				$this->db->update('donations', $data, ['id' => $data['id']]);
				$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Donasi Berhasil Diupdate") })</script>');
			}
			redirect('donation');
		} else {
			$data = [
				'title' => 'Donasi',
				'donators' => $this->db->get('donators')->result(),
				'donations' => $this->model->getDonations()
			];
			$this->template->load('template', 'donation', $data);
		}
	}

	public function getOne($id)
	{
		header("Content-Type: application/json; charset=UTF-8");

		$data = $this->db->get_where('donations', ['id' => $id])->row();
		echo json_encode($data);
	}

	public function delete($id)
	{
		$this->db->delete('donations', ['id' => $id]);
		$this->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.success("Donatur Berhasil Dihapus") })</script>');
		redirect('donation');
	}
}
