<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bulkmail extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		//date_default_timezone_set('Europe/London');
		error_reporting(0);

	}
	public function send_bulk_email(){echo "yessssss";
		$row = 1;
		$this->load->helper('file');
		$string = read_file('https://www.tradespeoplehub.co.uk/under_construction/Book1.csv');
		$handle = fopen("Book1.csv", "r");echo "NOooo";
		if ($handle !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				$row++;
				for ($c=0; $c < 1; $c++) {
					$data_txt["Name"][] = $data[0];
					$data_txt["Email"][] = $data[1];
				}
			}
			print_r($data_txt);
			fclose($handle);
		}
	}
}
?>