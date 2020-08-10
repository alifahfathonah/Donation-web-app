<?php

function is_login()
{
	$CI = get_instance();
	$is_login = $CI->session->userdata('is_login');
	if (!$is_login) {
		$CI->session->set_userdata('current_url', current_url());
		$CI->session->set_flashdata('msg', '<script>$(document).ready(function() { toastr.error("Mohon Login Untuk Melanjutkan") })</script>');
		redirect('login');
	}
}

function date_readable($date, $is_datetime = false)
{
	if ($is_datetime) {
		$phpdate = strtotime($date);
		$newDate = date('d/m/Y H:i:s', $phpdate);
	} else {
		$phpdate = strtotime($date);
		$newDate = date('d/m/Y', $phpdate);
	}

	return $newDate;
}
