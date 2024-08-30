<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My404 extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('UTC');
		$this->load->model('common_model');
		error_reporting(0);		
	}
	public function index(){
		$this->load->view('site/My404');
	}
}