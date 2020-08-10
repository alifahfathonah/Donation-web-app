<?php

class All_model extends CI_Model
{
	public function getHigher()
	{
		$data = $this->db->query('SELECT name,amount_of_donation AS amount FROM donators ORDER BY amount DESC LIMIT 10')->result();
		return $data;
	}

	public function getDonationsByType()
	{
		$data = $this->db->query('SELECT COUNT(type) AS amount, type FROM donations GROUP BY type ORDER BY amount DESC')->result();
		return $data;
	}

	public function getDonations()
	{
		$data = $this->db->query('SELECT
    `donations`.*
    , `donators`.`name` AS name
FROM
    `donations`
    INNER JOIN `donators` 
        ON (`donations`.`donator` = `donators`.`id`)
	ORDER BY id DESC')->result();

		return $data;
	}
}
