<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (isset($_GET['referral'])) {
            $referral_id = $_GET['referral'];
            $this->session->set_userdata('referral_id', $referral_id);
        }
        $this->load->library('Ajax_pagination');
        $this->load->model('search_model');
        $this->load->model('common_model');
        $this->perPage  = 10;
        $this->perPage2 = 6;
        error_reporting(0);
    }

    public function find_tradesman_ajax($cat_name = null, $cate_id = null)
    {
        $pagedata   = [];
        $conditions = [];

        $page = $this->input->post('page_num');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //$category_details = $this->common_model->get_single_data('category',array('slug'=>$cat_name));

        $conditions['search']['amount1'] = (isset($_REQUEST['amount1']) && !empty($_REQUEST['amount1'])) ? $_REQUEST['amount1'] : '';

        $conditions['search']['amount2'] = (isset($_REQUEST['amount2']) && !empty($_REQUEST['amount2'])) ? $_REQUEST['amount2'] : '';

        $conditions['search']['rating'] = (isset($_REQUEST['rating']) && !empty($_REQUEST['rating'])) ? $_REQUEST['rating'] : '';

        $conditions['search']['search'] = (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) ? $_REQUEST['search'] : '';

        $conditions['search']['location'] = (isset($_REQUEST['location']) && !empty($_REQUEST['location'])) ? $_REQUEST['location'] : '';

        $conditions['search']['cate_id'] = (isset($_REQUEST['cate_id']) && !empty($_REQUEST['cate_id'])) ? $_REQUEST['cate_id'] : '';

        //$conditions['search']['cate_id'] = (isset($cate_id) && !empty($cate_id))?$cate_id:'';

        $totalRec             = count($this->search_model->get_tradesmem($conditions));
        $json['q1']           = $this->db->last_query();
        $pagedata['totalRec'] = $totalRec;

        $base_url = site_url() . 'search/find_tradesman_ajax';

        /*if($cat_name){
        $base_url = $base_url.'/'.$cat_name;
        }

        if($cate_id){
        $base_url = $base_url.'/'.$cate_id;
        }*/

        $config['target']     = '#search_data';
        $config['base_url']   = $base_url;
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage2;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage2;

        $get_users_cat = $this->search_model->get_tradesmem($conditions);
        $json['q2']    = $this->db->last_query();
        $json['data']  = '';

        if (count($get_users_cat) > 0) {
            foreach ($get_users_cat as $get) {

                $json['data'] .= '<div class="tradesmen-box">
			<div class="tradesmen-top">
				<div class="pull-left">
					<div class="img-name">

						<a href="' . base_url('profile/' . $get['id']) . '">';

                if ($get['profile']) {

                    $json['data'] .= '<img src="' . site_url('img/profile/' . $get['profile']) . '">';

                } else {

                    $json['data'] .= '<img src="' . site_url() . 'img/profile/dummy_profile.jpg">';

                }
                $json['data'] .= '</a>

						<div class="names">
							<a href="' . base_url('profile/' . $get['id']) . '"><h4> ' . $get['trading_name'] . '</h4></a>';

                /*if($get['company']){
                $json['data'] .= '<h5> Company: '.$get['company'].' </h5>';
                }*/
                $json['data'] .= '<span class="btn btn-warning btn-xs">' . $get['average_rate'] . '</span>';

                $json['data'] .= '<span class="star_r">';

                for ($i = 1; $i <= 5; $i++) {

                    if ($i <= $get['average_rate']) {

                        $json['data'] .= '<i class="fa fa-star active"></i>';

                    } else {

                        $json['data'] .= '<i class="fa fa-star"></i>';

                    }

                }

                $json['data'] .= '</span>(' . $get['total_reviews'] . ' reviews)
						</div>
					</div>
				</div>
				<div class="pull-right">
					<div class="from-group text-right hire-tn" style="margin: 18px 0;">
						<a href="' . base_url('profile/' . $get['id']) . '" class="btn btn-primary" ><img src="' . site_url() . 'img/hire-up.png"> Hire Me</a>
					</div>
				</div>
			</div>
			<div class="tradesmen-bottom">
				<div class="tradesmen-member">
					<div class="pull-left">
						<div class="from-group revie">
							Tradesperson in
						</div>
					</div>
					<div class="pull-right">
						<span class="from-group">
							<i class="fa fa-map-marker"></i>
							'.$get['city'].'

						</span>

					</div>
				</div>';

                if ($get['about_business']) {

                    $json['data'] .= '<div class="tradesmen-desc">
					<p>';
                    if (strlen($get['about_business']) > 150) {
                        $json['data'] .= substr($get['about_business'], 0, 150) . '<a href="' . base_url('profile/' . $get['id']) . '">Read More</a>';
                    } else {
                        $json['data'] .= $get['about_business'];
                    }
                    $json['data'] .= '</p>
				</div>';
                }

                $json['data'] .= '</div>';

                $sql    = "SELECT * FROM rating_table WHERE rt_rateTo = " . $get['id'] . " ORDER BY tr_id DESC LIMIT 1";
                $query  = $this->db->query($sql);
                $rating = $query->result_array();

                if (count($rating) > 0) {
                    $rating   = $rating[0];
                    $sql      = "SELECT CONCAT(`f_name`, ' ', `l_name`) as `username` FROM `users` WHERE `id` = " . $rating['rt_rateBy'];
                    $query    = $this->db->query($sql);
                    $user     = $query->result_array();
                    $user     = $user[0];
                    $sql      = "SELECT title,direct_hired FROM tbl_jobs WHERE job_id = " . $rating['rt_jobid'];
                    $query    = $this->db->query($sql);
                    $jobTitle = $query->result_array();
                    $jobTitle = $jobTitle[0];

                    $json['data'] .= '<div class="tradesman-feedback">
					<div class="set-gray-box">';
                    if ($jobTitle['direct_hired'] == 1) {
                        $json['data'] .= '<h4>Work for ' . $get['trading_name'] . '</h4>';
                    } else if ($jobTitle['title']) {
                        $json['data'] .= '<h4>' . $jobTitle['title'] . '</h4>';
                    } else {
                        $json['data'] .= '<h4>Work for ' . $get['trading_name'] . '</h4>';
                    }

                    $json['data'] .= '<p class="recent-feedback">
							<em>Latest Review:</em>
						</p>
						<div cite="/job/view/5059288" class="summary">
							<p>' . $rating['rt_comment'] . '</p>
						</div>
						<p class="tradesman-feedback__meta">By <strong class="job-author">' . $user['username'] . '</strong>&nbsp;on
							<em class="job-date">' . date("d M Y", strtotime($rating['rt_create'])) . '</em>
						</p>
					</div>
				</div>';
                }

                $json['data'] .= '</div>';

            }} else {
            $json['data'] .= '<p class="alert alert-danger">No data found.</p>';
        }
        $json['data'] .= $this->ajax_pagination->create_links();

        echo json_encode($json);

    }

    public function find_tradesman($cat_name = null, $cate_id = null)
    {

        $pagedata = [];

        $url_segement2 = $this->uri->segment(1);

        if ($url_segement2) {
            $cat_name = $url_segement2;
        }

        $city_name = $this->uri->segment(2);

        $city_data           = false;
        $local_category_data = false;

        if ($city_name) {
            $city_data = $this->common_model->get_single_data('tbl_city', ['city_name' => $city_name]); //print_r($city_data);
        }

        $category_details = $this->common_model->get_single_data('category', ['slug' => $cat_name]);

        if (!$category_details) {
            $local_category_data = $this->common_model->get_single_data('local_category', ['slug' => $cat_name]);
            if ($local_category_data) {
                $category_details = $this->common_model->get_single_data('category', ['cat_id' => $local_category_data['parent_id']]);
                $city_data        = $this->common_model->get_single_data('tbl_city', ['id' => $local_category_data['location']]);

            }
        }

        // if ($category_details['cat_parent'] != 0) {

        //     $category_details = $this->common_model->get_single_data('category',array('cat_id'=>$category_details['cat_parent']));
        // }
        $page['all_category'] = $this->common_model->get_all_data('category', '');

        $conditions['search']['amount1'] = (isset($_REQUEST['amount1']) && !empty($_REQUEST['amount1'])) ? $_REQUEST['amount1'] : '';

        $conditions['search']['amount2'] = (isset($_REQUEST['amount2']) && !empty($_REQUEST['amount2'])) ? $_REQUEST['amount2'] : '';

        $conditions['search']['rating'] = (isset($_REQUEST['rating']) && !empty($_REQUEST['rating'])) ? $_REQUEST['rating'] : '';

        $conditions['search']['search'] = (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) ? $_REQUEST['search'] : '';

        $conditions['search']['location'] = (isset($_REQUEST['location']) && !empty($_REQUEST['location'])) ? $_REQUEST['location'] : '';

        $conditions['search']['cate_id']   = ($category_details) ? $category_details['cat_id'] : '';
        $conditions['search']['city_name'] = ($city_name) ? $city_name : '';

        $totalRec = count($this->search_model->get_tradesmem($conditions));

        $pagedata['totalRec'] = $totalRec;

        $base_url = site_url() . 'search/find_tradesman_ajax';

        /*if($cat_name){
        $base_url = $base_url.'/'.$cat_name;
        }

        if($cate_id){
        $base_url = $base_url.'/'.$cate_id;
        }*/

        $config['target']     = '#search_data';
        $config['base_url']   = $base_url;
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage2;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $conditions['start'] = 0;
        $conditions['limit'] = $this->perPage2;

        $pagedata['get_users_cat'] = $this->search_model->get_tradesmem($conditions);
        //echo $this->db->last_query();
        $pagedata['category_details']    = $category_details;
        $pagedata['city_data']           = $city_data;
        $pagedata['local_category_data'] = $local_category_data;
        //$pagedata['last']=$this->db->last_query();
        $pagedata['find_trades'] = $this->common_model->GetColumnName('other_content', ['id' => 1]);
        $this->load->view('site/category_details', $pagedata);
    }
    public function index($cat_name = null)
    {
        $pagedata = [];

        $url_segement2 = $this->uri->segment(2);

        if ($url_segement2) {
            $cat_name = $url_segement2;
        }

        $city_data = false;

        $city_name = (isset($_REQUEST['location']) && !empty($_REQUEST['location'])) ? $_REQUEST['location'] : '';

        if ($city_name) {
            $city_data = $this->common_model->get_single_data('tbl_city', ['city_name' => $city_name]);
        }

        $check_budget = $this->common_model->get_single_data('show_page', ['id' => 2]);
        $show_budget  = 1;
        if ($check_budget && $check_budget['status'] == 0) {
            $show_budget = 0;
        }

        if ($cat_name) {
            $category_details              = $this->common_model->get_single_data('category', ['slug' => $cat_name]);
            $pagedata['selected_categroy'] = $category_details;
            $category_id                   = ($category_details) ? $category_details['cat_id'] : '';
        } else {
            $category_id = '';
        }

        $conditions['search']['category_id'] = $category_id;
        $conditions['search']['search1']     = (isset($_REQUEST['search1']) && !empty($_REQUEST['search1'])) ? $_REQUEST['search1'] : '';

        $conditions['search']['location'] = (isset($_REQUEST['location']) && !empty($_REQUEST['location'])) ? $_REQUEST['location'] : '';

        $totalRec             = count($this->search_model->getRows($conditions));
        $pagedata['totalRec'] = $totalRec;

        $config['target']     = '#search_data';
        $config['base_url']   = site_url() . 'search/search_ajax';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $conditions['start'] = 0;
        $conditions['limit'] = $this->perPage;

        $pagedata['show_budget'] = $show_budget;

        $pagedata['all_jobs']   = $this->search_model->getRows($conditions);
        $pagedata['city_data2'] = $city_data;
        $pagedata['find_job']   = $this->common_model->GetColumnName('other_content', ['id' => 2]);

        $pagedata['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));

        $this->load->view('site/search_post', $pagedata);
    }
    public function search_ajax()
    {

        $pagedata   = [];
        $conditions = [];

        $page = $this->input->post('page_num');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $category_id = $this->input->post('category_id');
        $location    = $this->input->post('location');
        $amount1     = $this->input->post('amount1');
        $amount2     = $this->input->post('amount2');
        $search1     = $this->input->post('search1');
        if (!empty($category_id)) {
            $conditions['search']['category_id'] = $category_id;
            $selected_categroy                   = $this->common_model->get_category('category', $category_id);
        }

        if (!empty($location)) {
            $conditions['search']['location'] = $location;
        }
        /*
        if(!empty($amount1)){
        $conditions['search']['amount1'] = $amount1;
        }
        if(!empty($amount2)){
        $conditions['search']['amount2'] = $amount2;
        }*/
        if (!empty($search1)) {
            $conditions['search']['search1'] = $search1;
        }
        $totalRec = count($this->search_model->getRows($conditions));
        $this->db->last_query();
        $config['target']     = '#search_data';
        $config['base_url']   = base_url() . 'search/search_ajax';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        $all_jobs     = $this->search_model->getRows($conditions);
        $json['q2']   = $this->db->last_query();
        $json['data'] = '';

        $check_budget = $this->common_model->get_single_data('show_page', ['id' => 2]);
        $show_budget  = 1;
        if ($check_budget && $check_budget['status'] == 0) {
            $show_budget = 0;
        }
        $user_profile = $this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));

        if (count($all_jobs) > 0) {
            foreach ($all_jobs as $row) {
                $json['data'] .= '<div class="tradesmen-box">
					<div class="tradesmen-top">
						<div class="row">
							<div class="col-sm-9 col-xs-7">
							<div class="pull-left">

									<div class="names">';
                if ($this->session->userdata('user_id')) {

                    if ($this->session->userdata('type') == 1) {
                        $json['data'] .= '<a href="' . site_url() . 'details/?post_id=' . $row['job_id'] . '"><h4>' . $row['title'] . '</h4></a>';
                    } else {
                        $json['data'] .= '<a href="javascript:void(0);"><h4>' . $row['title'] . '</h4></a>';
                    }
                } else {
                    $json['data'] .= '<a href="' . site_url() . 'login"><h4>' . $row['title'] . '</h4></a>';
                }

                $json['data'] .= '<span class="from-group">';

                $get_user = $this->common_model->get_user_by_id($row['userid']);

                $time_ago = $this->common_model->time_ago($row['c_date']);

                $json['data'] .= $time_ago . " by " . $get_user[0]['f_name'] . ' ' . $get_user[0]['l_name'] . "";

                $json['data'] .= '</div>

							</div>
							</div>
							<div class="col-sm-3 col-xs-5">
							<div class="pull-right">';

                $json['data'] .= '';
                $show_budget_d = '';
                if ($show_budget == 1) {
                    if ($row['budget'] > 0) {
                        $show_budget_d .= '£' . $row['budget'];
                    }

                    if ($row['budget2'] > 0) {
                        $show_budget_d .= ' - £' . $row['budget2'];
                    }
                }

                $json['data'] .= '<h3>' . $show_budget_d . '</h3>';

                $json['data'] .= '<div class="from-group text-right" style="margin-top: 10px;">';

                if ($this->session->userdata('user_id')) {
                    if($user_profile['u_email_verify'] != 1){
                        $json['data'] .= '<a href="javascript:void(0)" class="btn btn-warning" onclick="showPopup(1)">Quote Now</a>';
                    }elseif (empty($user_profile['about_business'])){
                        $json['data'] .= '<a href="javascript:void(0)" class="btn btn-warning" onclick="showPopup(2)">Quote Now</a>';
                    }else{
                        if ($this->session->userdata('type') == 1) {
                            $json['data'] .= '<a href="' . site_url() . 'details/?post_id=' . $row['job_id'] . '" class="btn btn-warning">Quote Now</a>';
                        }
                    }
                } else {
                    $json['data'] .= '<a href="' . site_url() . 'login" class="btn btn-warning">Quote Now</a>';
                }
                
                $json['data'] .= '</div>
							</div>
							</div>
						</div>
					</div>
					<div class="tradesmen-bottom">

						<div class="tradesmen-desc"><p>' . $row['description'] . '</p> </p>
						</div>
					</div>
				</div>';

            }} else {
            $json['data'] .= '<div class="alert alert-warning">No record found</div>';
        }
        $json['category_id'] = $category_id;
        $json['data'] .= $this->ajax_pagination->create_links();

        echo json_encode($json);
    }

    public function report_job()
    {
        $reason = $this->input->post('reason');
        if ($this->input->post('reason') == 'Other' && $this->input->post('otherReason') != '') {
            $reason = $this->input->post('otherReason');
        }
        $insert['job_id']  = $this->input->post('job_id');
        $insert['user_id'] = $this->session->userdata('user_id');
        $insert['reason']  = $reason;
        $this->common_model->insert('report_job', $insert);
        echo "Success";
    }

}
