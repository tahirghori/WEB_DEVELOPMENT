<?php

/**
* Config Application model
*/
class Config_application_m extends CI_Model
{
	var $db_name = DB_NAME;

	function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

	public function getBbTableName($value='')
	{

		$sql = "SELECT table_name, ENGINE
				FROM information_schema.tables
				WHERE table_type = 'BASE TABLE'
				AND table_schema='".$this->db_name."'
				ORDER BY table_name ASC";

		$query = $this->db->query($sql);
		return $query->result();

	}

}

?>