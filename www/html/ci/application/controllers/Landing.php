<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// load database
//    $this->load->database();
		$this->load->helper('url');
	}

	public function index() {
		// get data to send to the view from database
//		$database   = "vizmvp";
//		$query      = $this->db->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE'");
//        $tables     = $query->result_array(PDO::FETCH_COLUMN);

		$info = "";
		$database_data = array();

//				if ( empty($tables)) {
//            $info = "<p>There are no tables in database \"{$database}\".</p>";
//        } else {
            //$info = "<p>Database \"{$database}\" has the following tables:</p>";
            //$database_data = $tables;
//        }

		$data = array(
			//'raw_html' => $info,
			//'tables' => $database_data
		);

		$this->load->view('landing', $data);
	}
}
