<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User extends Admin_Controller {

	    public function __construct()
    {
        parent::__construct();
   // this load library class check user login session or manege page settings
   //$this->load->library("App_Controller");
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{



	//	echo "agasdgada";
		  print_r($this->app_controller->db_table_role);
	//	echo $this->data['meta_title'];
		$this->load->view('user');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */