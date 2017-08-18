<?php
defined('BASEPATH') OR exit('No direct script access allowed');



require_once 'vendor/autoload.php';
class Landing extends CI_Controller {

	private $loader;
	private $twig;
	

	public function __construct() {
		parent::__construct();

		// load database

        $this->load->database();
		$this->load->helper(array('url', 'form'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('tracking_model');

		if(!isset($_SESSION['loggedIn'])){
			$newdata = array(
        		'username'  => null,
        		'loggedIn' => false
			);
			$this->session->set_userdata($newdata);
		}




		//setup twig
		$this->loader = new Twig_Loader_Filesystem('ci/application/views');
		$this->twig = new Twig_Environment($this->loader);
	}
	
	public function trackingNavigation(){
		
       
		
		$pagename =  $this->input->post('page');
		$time =  $this->input->post('time');
		$city =  $this->input->post('city');
		$country =  $this->input->post('country');
		
		$data = array(
	    	'page_name' => 		$pagename,
	        'recorded_at' =>	$time,
	        'city' => 			$city,
	        'country' => 		$country
        );
		
		$this->tracking_model->input_navigation_data($data);
        
	}
	public function trackingLanding(){
		
		$time =  $this->input->post('time');
		$city =  $this->input->post('city');
		$country =  $this->input->post('country');
		
		$data = array(
	   
	        'recorded_at' => $time,
	        'city' => $city,
	        'country' => $country
        );

		$this->tracking_model->input_landing_data($data);
        
	}
	


	public function index() {

		$info = "";
		$data = array(
			'session' => 	$_SESSION['loggedIn'],
			'base_url' => 	base_url(),
			'countries' => 	$this->tracking_model->get_countries(),
			'cities' => 	$this->tracking_model->get_cities()
		);

		// render views
		$this->output->set_output(
			$this->twig->render(
				'landing.php',
				$data
			)
		);
	}
	
		public function login() {
		$this->load->model('user_model');
		$data = array(
			'session' => 	$_SESSION,
			'error' => 		'',
			'base_url' => 	base_url(),
			'countries' => $this->tracking_model->get_countries(),
			'cities' => 	$this->tracking_model->get_cities()			
		);
		$GLOBALS['dbUser'] = $this->user_model->get_user($this->input->post('username'));

		
		$this->form_validation->set_rules('username', 'Username');

        $this->form_validation->set_rules('password', 'Password', "md5|callback_password_check",
        	array(
				'password_check' => "An error occured",
		   )
		);

		if($this->form_validation->run()== true){
			$newdata = array(
        		'username'  => 	$this->input->post('username'),
        		'loggedIn' => 	true
			);

			$this->session->set_userdata($newdata);
			
			echo('loggedIn');
			
		
		}else{
			echo(validation_errors('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> &nbsp', ''));

		}	
	}


	public function password_check($password){
		if($password ===  $GLOBALS['dbUser']['password']){
			return true; 
		}
		return false;
	}
	
	public function logout(){
		
		$newdata = array(
        	'username'  => 	null,
        	'loggedIn' => 	false
		);

		$this->session->set_userdata($newdata);
		

	}

	public function landingChartData(){
		if('applied' == $this->input->post('applied')){
			echo json_encode($this->tracking_model->get_landing_data($this->input->post('minDate'), $this->input->post('maxDate'), $this->input->post('countries'), $this->input->post('cities')));
		}else{
			echo json_encode($this->tracking_model->get_landing_data());
		}
		
	}

	public function navigationChartData(){
		if('applied' == $this->input->post('applied')){
			echo json_encode($this->tracking_model->get_navigation_data($this->input->post('minDate'), $this->input->post('maxDate'), $this->input->post('countries'), $this->input->post('cities')));
		}else{
			echo json_encode($this->tracking_model->get_navigation_data());
		}
	}
}

