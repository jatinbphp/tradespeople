<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		error_reporting(0);

	}
	public function index(){
		$data = getParent();
		echo '<pre>';
		print_r($data);
	}
}