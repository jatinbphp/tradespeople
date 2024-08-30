<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gen_html extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		date_default_timezone_set('Europe/London');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Common_model');
		$this->check_login();
		error_reporting(0);

	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}
	public function index(){
		//print_r($this->input->post);
		if($this->input->post('submit') == "generate"){
			$status = 0;
			$job_ids = $this->input->post('jobs_list');
			$job_ids_arr = explode(",", $job_ids);
			$jobList = "";
			if(count($job_ids_arr)>0){
				$jobList .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
									<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
								</tr>';
								foreach($job_ids_arr as $jobs){
									$job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$jobs));
									$jobList .= $this->job_email_body($job_info);
								}
				$jobList .= '</table>';
			}

			$html = '<p style="margin:0;padding:10px 0px">Hi '.$user_info['f_name'].',</p>';
			
			if(count($job_ids_arr)==1){
				$job_category_id = $job_info["category"];
				$cat_info = $this->Common_model->get_single_data('category',array('cat_id '=>$job_category_id));
				$job_title = $job_info["title"];
				$job_category_name = $cat_info["cat_name"];
				$homeowner_info = $this->Common_model->get_single_data('users',array('id'=>$job_info["userid"]));
				$homeowner_county = $homeowner_info["county"];
				$html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted in the ' . $homeowner_county . ' area.</p>';
				$subject = "Need more " . $job_category_name . " jobs in " . $homeowner_county . " to fill your schedule?";
			}else{
				$html .= '<p style="margin:0;padding:10px 0px">Here are the latest job posts that were posted in your area.</p>';
				$subject = "Latest job posts near you : Fill the gap in your schedule";
			}
			
			$html .= $jobList;
			$html .= '<p><h4 style="font-size:15px; color: #2875D7;">Who we are</h4></p>';
			$html .= '<p style="margin:0;padding:10px 0px">TradespeopleHub is a market-leading online platform that connects homeowners to professional tradespeople. We’ve helped many companies like yours find a massive pool of new customers, which is especially vital during these uncertain times of COVID-19.</p>';
			$html .= '<p><h4 style="font-size:15px; color: #2875D7;">How it works</h4></p>';
			$html .= '<ul>
						<li>Create an account</li>
						<li>Pick a job you want</li>
						<li>Send a proposal</li>
						<li>Complete the job</li>
						<li>Leave feedback</li>
					</ul>';
			$html .= '<p><h4 style="font-size:15px; color: #2875D7;">Why choose us?</h4></p>';
			$html .= '<ul>
						<li>Our pay-as-you-go option which is a great budget option at just 3 GBP per lead.</li>
						<li>Use our service for 30-days without paying.</li>
						<li>Monthly plans which range from 10-20 GBP.</li>
					</ul>';
			$html .= '<br /><p style="margin:0;padding:10px 0px">If you have any more questions, I’d be delighted to jump on a quick call with you to run through the details?</p>';
			$msg = '<!DOCTYPE html>
					<html>
						<head>
							<title>{subject}</title>
							<meta name="viewport" content="width=device-width, initial-scale=1.0" />
							<style type="text/css" media="only screen and (max-width: 480px)">
								/* Mobile styles */
								@media only screen and (max-width: 480px) {

									[class="w320"] {
										width: 320px !important;
									}

									[class="mobile-block"] {
										width: 100% !important;
										display: block !important;
									}
								}
							</style>
						</head>
						<body style="margin:0">
							<div data-section-wrapper="1">
								<center>
									<table data-section="1" style="width: 600;" width="600" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td>
													<div data-slot-container="1" style="min-height: 30px">
														<div data-slot="text">
															<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
																<tbody>
																	<tr>
																		<td align="center" valign="top">
																			<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 50px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
																				<tbody>
																					<tr>
																						<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
																							<table border="0" cellpadding="0" cellspacing="10" width="100%">
																								<tbody>
																									<tr>
																										<td align="center" style="text-align: center;" valign="middle"><img src="'.site_url().'img/logo_invert.png" alt="Logo" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																					<tr>
																						<td align="center" valign="top">
																							<table border="0" cellpadding="0" cellspacing="10" width="100%">
																								<tbody>
																									<tr>
																										<td align="left" valign="top" style="color:#444;font-size:14px">
																											'.$html.'
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
															Kind regards,<br /><br />{signature}
															<br />
															<br />
															{unsubscribe_text} | {webview_text}
															<br />
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</center>
							</div>
						</body>
					</html>';
			$data["htm"] = htmlentities($msg);
			$data["status"] = $status;
			$data['jobs'] = $this->Common_model->get_all_data('tbl_jobs',array('is_delete!='=>1),'job_id');
			$this->load->view('Admin/gen_html_view',$data);
		}else{
			$data['jobs'] = $this->Common_model->get_all_data('tbl_jobs',array('is_delete!='=>1),'job_id');
			$this->load->view('Admin/gen_html_page',$data);
		}
	}
	public function add_job(){
		$selected_jobs_list=implode(',',$this->input->post('job_ids'));
		$where_in = $this->input->post('job_ids');
		$result_jobs = $this->Common_model->fetch_records('tbl_jobs', false, "job_id ,title", false, false, false, false, "job_id", $where_in);
		$selected_jobs = '';
		if(count($result_jobs)>0){
			foreach ($result_jobs as $row){
				$selected_jobs .= '<p id="del_job' . $row["job_id"] . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">'  . $row["title"] . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_job(' . $row["job_id"] . ')"><i class="fa fa-close"></i></button> </p>';
			}
		}
		$json['selected_jobs_list'] = $selected_jobs_list;
		$json['selected_jobs'] = $selected_jobs;
		$json['status'] = 1;
		echo json_encode($json);
	}
	public function job_email_body($job,$frequency=null){
		$return = '
					<tr>
						<td style="border:1px solid #E1E1E1; padding:10px 10px; width: 65%; vertical-align: top;">';
				$return .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">Job title: ' .$job['title'] .'</h4>
							<p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">
								Description: ' .$job['description'] .'
							</p>
						</td>
						<td style="border:1px solid #E1E1E1; padding:10px 10px; width: 35%;  vertical-align: top;">
							<h4 style="font-size:18px; margin: 0; margin-bottom: 8px; color: #333;">' .$job['budget'] .' - ' . $job['budget2'] . ' GBP</h4>
							<a href="' .site_url() .'proposals?post_id=' .$job['job_id'] .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">View Job</a>
						</td>
					</tr>';
				
				return $return;
	  }
	  public function generate_html(){
		$status = 0;
		$job_ids = $this->input->post('jobs_list');
		$job_ids_arr = explode(",", $job_ids);
		$jobList = "";
		if(count($job_ids_arr)>0){
			$jobList .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
								<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
							</tr>';
							foreach($job_ids_arr as $jobs){
								$job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$jobs));
								$jobList .= $this->job_email_body($job_info);
							}
			$jobList .= '</table>';
		}

			$html = '<p style="margin:0;padding:10px 0px">Hi '.$user_info['f_name'].',</p>';
			
		if(count($job_ids_arr)==1){
			$html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p>';
			$job_category_id = $job_info["category"];
			$cat_info = $this->Common_model->get_single_data('category',array('cat_id '=>$job_category_id));
			$job_title = $job_info["title"];
			$job_category_name = $cat_info["cat_name"];
			$subject = "New " . $job_category_name . " Job Posted:" . $job_title . ":Quote now!";
		}else{
			$html .= '<p style="margin:0;padding:10px 0px">Here are the latest job posts near you.</p>';
			$subject = "Latest Job Posts Near You:Quote now!";
		}
		
		$html .= $jobList;
		//$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
		
		$msg = '<!DOCTYPE html>
				<html>
					<head>
						<title>{subject}</title>
						<meta name="viewport" content="width=device-width, initial-scale=1.0" />
						<style type="text/css" media="only screen and (max-width: 480px)">
							/* Mobile styles */
							@media only screen and (max-width: 480px) {

								[class="w320"] {
									width: 320px !important;
								}

								[class="mobile-block"] {
									width: 100% !important;
									display: block !important;
								}
							}
						</style>
					</head>
					<body style="margin:0">
						<div data-section-wrapper="1">
							<center>
								<table data-section="1" style="width: 600;" width="600" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td>
												<div data-slot-container="1" style="min-height: 30px">
													<div data-slot="text">
														<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
															<tbody>
																<tr>
																	<td align="center" valign="top">
																		<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
																			<tbody>
																				<tr>
																					<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
																						<table border="0" cellpadding="0" cellspacing="10" width="100%">
																							<tbody>
																								<tr>
																									<td align="center" style="text-align: center;" valign="middle"><img src="'.site_url().'img/logo_invert.png" alt="Logo" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td align="center" valign="top">
																						<table border="0" cellpadding="0" cellspacing="10" width="100%">
																							<tbody>
																								<tr>
																									<td align="left" valign="top" style="color:#444;font-size:14px">
																										'.$html.'
																										 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																										 <p style="margin:0;padding:10px 0px">The '.Project.' Team</p>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td align="center" valign="top" style="background-color:#2b3133;color:white">
																						<table border="0" cellpadding="0" cellspacing="10" width="100%">
																							<tbody>
																								<tr>
																									<td align="left" valign="top" width="80%">
																										<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © 2020 <a href="'.site_url().'" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
														 <br />
														<br />
														{unsubscribe_text} | {webview_text}
														<br />
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</center>
						</div>
					</body>
				</html>';
		/*$find = array("<",">","&");
		$replace = array("&lt;","&gt;","&amp;");
		$data["htm"] = str_replace($find,$replace,$html);*/
		$data["htm"] = htmlentities($msg);
	  $data["status"] = $status;
	  $data['jobs'] = $this->Common_model->get_all_data('tbl_jobs',array('is_delete!='=>1),'job_id');
		$this->load->view('Admin/gen_html_view',$data);
  }
}
?>