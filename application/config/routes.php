<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller']   = 'home';
$route['404_override']         = 'My404';
$route['translate_uri_dashes'] = false;
$route['about-us']             = 'home/about';
$route['services']             = 'home/services';
$route['find_tradesmen']       = 'home/find_tradesmen';
$route['advice-centre']        = 'home/advice_centre';
$route['tradesman-start']      = 'home/tradesman_start';
$route['service/(:any)']       = 'home/serviceDetail/$1';
$route['pre-service/(:any)']   = 'home/preServiceDetail/$1';
$route['category/(:any)']      = 'home/categoryDetail/$1';
$route['category/(:any)/(:any)']      = 'home/categoryDetail/$1/$2';
$route['category/(:any)/(:any)/(:any)']      = 'home/categoryDetail/$1/$2/$3';
$route['checkout']		       = 'home/checkout';
$route['serviceCheckout']		= 'checkout/serviceCheckout';
$route['thakyou']		= 'checkout/thankyou';

$route['affiliate']           = 'home/view_affiliate';
$route['affiliate-signup']    = 'home/affiliate_signup';
$route['affiliate-login']     = 'home/affiliate_login';
$route['affiliate-dashboard'] = 'users/affiliate_dashboard';

$route['login']                 = 'home/login';
$route['how-it-work']           = 'home/how_it_work';
$route['how_it_work_tradesmen'] = 'home/how_it_work_tradesmen';
//$route['marketers']='home/view_affiliate';
$route['faq']               = 'home/faq';
$route['tradesman-support'] = 'home/tradesman_support';
$route['tradesman-help']    = 'home/tradesman_help';
$route['testimonial']       = 'home/testimonial';

$route['contact']                                = 'home/contact';
$route['blog']                                   = 'home/blog';
$route['blog/(:any)']                            = 'home/blog_detail/$1';
$route['fund-request-form/(:any)/(:any)/(:any)'] = 'home/fund_request_form/$1/$2/$3';
// $route['cost-guide']='home/cost_guide';

$route['find_tradesmen'] = 'home/find_tradesmen';

$route['homeowner-support']     = 'home/homeowner_support';
$route['homeowner-help-centre'] = 'home/homeowner_help_centre';

$route['live_leads']         = 'home/live_leads';
$route['advice-guides']      = 'home/advice_guides';
$route['hiring-advice']      = 'home/hiring_advice';
$route['cost-guides']        = 'home/cost_guides';
$route['cost-guides/(:any)'] = 'home/cost_guide_detail/$1';
//$route['cost-guide-detail/(:any)']='home/cost_guide_detail/$1';

$route['register']            = 'home/before_register';
$route['signup-step1']        = 'home/signup_step1';
$route['signup-step2/(:any)'] = 'home/signup_step2/$1';
$route['signup-step2']        = 'home/signup_step2';
$route['signup-step3']        = 'home/signup_step3';
$route['signup-step4']        = 'home/signup_step4';
$route['signup-step5']        = 'home/signup_step5';
$route['signup-step6']        = 'home/signup_step6';
$route['signup-step7']        = 'home/signup_step7';
$route['signup-step8']        = 'home/signup_step8';
$route['billing-info']        = 'home/signup_step8';
$route['signup-step9']        = 'home/signup_step9';

$route['edit-profile']   = 'users/edit_profile';
$route['profile/(:any)'] = 'users/profile/$1';

$route['dashboard']  = 'users/dashboard';
$route['my-account'] = 'users/dashboard';

$route['email-verify']                 = 'home/email_verify';
$route['privacy-policy']               = 'home/privacy_policy';
$route['cookie-policy']                = 'home/cookie_policy';
$route['email-verified/(:any)/(:any)'] = 'home/email_verified/$1/$2';
$route['terms-and-conditions']         = 'home/terms_and_conditions';
$route['change-password']              = 'users/change_password';
$route['delete-account']='users/delete_account';
$route['notifications']                = 'home/notifications';
$route['memberships']                  = 'home/memberships';
$route['payments']                     = 'home/payments';
$route['account']                      = 'home/account';
$route['forgot-password']              = 'home/forgot_password';
$route['trust_verification']           = 'home/trust_verification';
$route['categories']                   = 'home/categories';
$route['sends']                        = 'home/sends';

//$route['find-tradesmen']='home/category_detail';
//$route['find-tradesmen/(:any)']='home/category_detail/$1';
//$route['find-tradesmen/(:any)/(:any)']='home/category_detail/$1/$2';

$route['find-tradesmen']        = 'search/find_tradesman';
$route['find-tradesmen/(:any)'] = 'search/find_tradesman/$1';

require_once 'slug_cate_routing.php';

//$route['([^/]+)/?']='search/find_tradesman/$1';

$route['find-jobs']               = 'search/index';
$route['find-jobs/(:any)']        = 'search/index/$1';
$route['find-jobs/(:any)/(:any)'] = 'search/index/$1/$2';

$route['post-job'] = 'home/post_job';

$route['signup'] = 'home/signup';

$route['marketer_email_verify'] = 'home/marketer_email_verify';
$route['my-posts']              = 'users/my_posts';

$route['rejected-jobs'] = 'users/rejected_jobs';

$route['jobs-rejected'] = 'users/jobs_rejected';

$route['project_detail'] = 'home/project_detail';
$route['project_name']   = 'home/project_name';

$route['membership-plans'] = 'home/membership_plans';

$route['pay_as_you_go']         = 'home/pay_as_you_go';
$route['subscription-plan']     = 'home/subscription_plan';
$route['wallet']                = 'wallet/wallet';
$route['transaction-history']   = 'wallet/transaction_history';
$route['buy_plan']              = 'subcription_plan/buy_plan';
$route['plan-purchase-history'] = 'wallet/plan_purchase_history';
$route['save-card-list']        = 'wallet/saveCardList';
$route['delete-card/(:num)']    = 'wallet/deleteCard/$1';
$route['card-info/(:num)']      = 'wallet/cardInfo/$1';

// $route['home-owner-save-card']='wallet/homeOwnerSaveCard';

// $route['billing-info']='home/signup_step8';

$route['job-detail'] = 'Posts/job_detail';

$route['proposals'] = 'posts/proposals';
$route['files']     = 'posts/files';
$route['task']      = 'home/task';

//not getted
$route['my_job_bids'] = 'users/my_job_bids';
$route['verify']      = 'users/verify';
$route['company']     = 'users/company';
$route['trades']      = 'users/trades';
//not getted
$route['my_reviews']                             = 'users/my_reviews';
$route['details']                                = 'posts/details';
$route['proposals_edit']                         = 'posts/proposals_edit';
$route['payments']                               = 'posts/payments';
$route['reviews']                                = 'posts/reviews';
$route['review-invitation']                      = 'users/review_invitation';
$route['my-account']                             = 'users/my_account';
$route['my-jobs']                                = 'users/my_jobs';
$route['jobs-in-progress']                       = 'users/jobs_in_progress';
$route['milestone-requests']                     = 'users/milestone_requests';
$route['fund-withdrawal']                        = 'users/fund_withdrawal';
$route['earnings']                               = 'users/earnings';
$route['manage-bank']                            = 'users/manageBank';
$route['in-progress']                            = 'users/in_progress';
$route['completed-jobs']                         = 'users/completed_jobs';
$route['jobs-completed']                         = 'users/jobs_completed';
$route['exists-refferals']                       = 'users/exists_refferals';
$route['payout-request-list']                    = 'users/payout_request_list';
$route['new-referral']                           = 'users/new_referral';
$route['new-jobs']                               = 'users/new_jobs';
$route['inbox']                                  = 'chat/inbox';
$route['dispute-job/(:any)']                     = 'Dispute/dispute_job/$1';
$route['dispute/(:any)']                         = 'Dispute/dispute/$1';
$route['reject_dispute_offer']                   = 'Dispute/reject_offer';
$route['submit_dispute_offer']                   = 'Dispute/submit_offer';
$route['submitAsktoAdmin']                       = 'Dispute/submitAsktoAdmin';
$route['dispute_accept_and_close/(:any)/(:any)'] = 'Dispute/accept_and_close/$1/$2';
$route['cancel_dispute/(:any)/(:any)']           = 'Dispute/cancel_dispute/$1/$2';
$route['sen_comment']                            = 'Dispute/send_massege';
$route['invoice/(:any)']                         = 'Posts/invoice/$1';
$route['mile-invoice/(:any)']                    = 'Posts/mile_invoice/$1';
$route['view-invoice/(:any)']                    = 'invoice/auto_update_paln/$1';
$route['notifications']                          = 'Users/notifications';
$route['spendamount-history']                    = 'wallet/spendamount_history';
$route['disputed-milestones']                    = 'users/disputed_milestones';
$route['rewards']                                = 'users/rewards';
$route['recent-jobs']                            = 'users/recent_jobs';
$route['work-in-progress']                       = 'users/work_in_progress';
$route['completed']                              = 'users/completed';
$route['invoices']                               = 'users/invoices';
$route['addons']                                 = 'addon/index';
$route['make-addon-payment/(:any)']              = 'addon/make_addon_payment/$1';
$route['my-services']              				 = 'Users/my_services';
$route['promo-code']              				 = 'Users/promo_code';
$route['delete-promo-code/(:any)']                  = 'Users/delete_coupons/$1';
$route['my-orders']              				 = 'Users/my_orders';
$route['order-tracking/(:any)']                  = 'Users/order_tracking/$1';
$route['my-faviourits']              			 = 'Users/my_faviourits';
$route['add-service']              	 	         = 'Users/addServices';
$route['open-add-service']              	 	 = 'Users/openAddServiceForm';
$route['add-service2']                           = 'Users/addServices2';
$route['add-service3']                           = 'Users/addServices3';
$route['add-service4']                           = 'Users/addServices4';
$route['add-service5']                           = 'Users/addServices5';
$route['add-service6']                           = 'Users/addServices6';
$route['edit-service/(:num)']              	 	 = 'Users/editServices/$1';
$route['open-edit-service/(:num)']               = 'Users/openEditServiceForm/$1';
$route['test']                    = 'Users/pTest';
$route['delete-service/(:num)']              	 = 'Users/deleteServices/$1';
$route['submit-requirement']              = 'Users/submitRequirement';

//$route['blog-detail/(:any)']='home/blog_detail/$1';

//----------------------start admin--------------
$route['Admin']                 = 'Admin/Admin_login/index';
$route['Admin_dashboard']       = 'Admin/Admin/Admin_dashboard';

$route['tradesmen_user']        = 'Admin/Admin/tradesmen_user';
$route['tradesmen_user/(:any)']='Admin/Admin/tradesmen_user/$1';

$route['service_category']        = 'Admin/Admin/service_category';
$route['approval_pending_service']        = 'Admin/Admin/approval_pending_service';
$route['required_modification']        = 'Admin/Admin/required_modification';
$route['approved_service']        = 'Admin/Admin/approved_service';
$route['all_services']        = 'Admin/Admin/service_list';
$route['location']        = 'Admin/Admin/location';
$route['service-orders']        = 'Admin/Admin/service_orders';

$route['homeowners_users']      = 'Admin/Admin/homeowners_users';
$route['homeowners_users/(:any)']='Admin/Admin/homeowners_users/$1';

$route['public_profile/(:any)'] = 'users/profile/$1';
$route['category']              = 'Admin/Admin/category';
$route['subcategory']           = 'Admin/Admin/subcategory';
$route['Admin_logout']          = 'Admin/Admin/logout';
$route['Admin/Manage_profile']  = 'Admin/Admin/Manage_profile';
$route['skills_management']     = 'Admin/Admin/skills_management';
$route['business_types']        = 'Admin/Admin/business_types';
$route['child_category/(:any)'] = 'Admin/Admin/child_category/$1';
$route['Contact_requests']      = 'Admin/Admin/contact_requests';
$route['job_report']            = 'Admin/Admin/job_report';
$route['deleted_accounts'] = 'Admin/Admin/deleted_accounts';

$route['edit-profile/(:any)']                = 'Admin/Admin/edit_profile/$1';
$route['admin_county']                       = 'Admin/Region/county';
$route['admin_city']                         = 'Admin/Region/city';
$route['tradesmen_contacts']                 = 'Admin/Admin/tradesmen_contacts';
$route['homeowners_contacts']                = 'Admin/Admin/homeowners_contacts';
$route['marketers-contacts']                 = 'Admin/Admin/marketers_contacts';
$route['packages']                           = 'Admin/Packages';
$route['homepage_content']                   = 'Admin/Admin/homepage_content';
$route['affiliaters']                        = 'Admin/Admin/affiliaters';
$route['payouts']                            = 'Admin/Admin/payouts';
$route['refferals']                          = 'Admin/Admin/refferals';
$route['admin_settings']                     = 'Admin/Admin/admin_settings';
$route['marketer_refferals']                 = 'Admin/Admin/marketer_refferals';
$route['refferals-setting']                  = 'Admin/Admin/refferalsSetting';
$route['pending_referral_payouts']           = 'Admin/Admin/referral_payouts';
$route['approved_referral_payouts']          = 'Admin/Admin/referral_payouts';
$route['reject_referral_payouts']            = 'Admin/Admin/referral_payouts';
$route['homepage_banner']                    = 'Admin/Admin/HamePageBanner';
$route['cost_guide_management']              = 'Admin/Admin/cost_guide_management';
$route['users_transactions']                 = 'Admin/Admin/transactions';
$route['user_plans']                         = 'Admin/Admin/user_plans';
$route['user_jobs']                          = 'Admin/Admin/user_jobs';
$route['user_bid_jobs']                      = 'Admin/Admin/user_bid_jobs';
$route['payment_setting']                    = 'Admin/Admin/payment_setting';
$route['withdrawal_history']                 = 'Admin/Admin/withdrawal_history';
$route['withdrawal-history']                 = 'Admin/Admin/withdrawal_history';
$route['dispute']                            = 'Admin/Dispute/dispute';
$route['Admin/ask-step-in']                  = 'Admin/Dispute/ask_to_step_in';
$route['dispute_details/(:any)']             = 'Admin/Dispute/dispute_details/$1';
$route['makedisputefinal']                   = 'Admin/Dispute/makedisputefinal';
$route['add_dispute_comment']                = 'Admin/Dispute/add_dispute_comment';
$route['Admin/cancel_dispute/(:any)/(:any)'] = 'Admin/Dispute/cancel_dispute/$1/$2';
$route['user_rewards']                       = 'Admin/Admin/user_rewards';
$route['settings']='Admin/Admin/settings';
$route['ratings_management']                 = 'Admin/Admin/ratings_management';
$route['sub_admin']                          = 'Admin/sub_admin/index';
$route['blog_management']                    = 'Admin/Blog';
$route['bank-transfer-request']              = 'Admin/dispute/banner_transfer_request';
$route['Admin/homeowner-fund-withdrawal']    = 'Admin/withdrawal/homeowner_fund_withdrawal';
$route['Admin/addons-management']            = 'Admin/Addon/index';
$route['Admin/job-amount']                   = 'Admin/post/job_amount';
$route['Admin/category-find-job']            = 'Admin/slug/category_find_job';
$route['Admin/category-default-content']     = 'Admin/slug/category_default_content';
$route['Admin/affiliate-metadata']           = 'Admin/slug/affiliateMetadata';
$route['Admin/send-bulk-mail']               = 'Admin/packages/send_bulk_mail';
// added by pranotosh
$route['Admin/create-post']             = 'Admin/Home/post_job';
$route['Admin/send-emails']             = 'Admin/Send_mails_new/send_emails';
$route['Admin/generate-html']           = 'Admin/Gen_html';
$route['Admin/marketers-setting']       = 'Admin/Admin/marketers_sharable';
$route['Admin/marketers-sharable-link'] = 'Admin/Admin/marketers_sharable_link';

$route['Admin/homeowner-sharable']  = 'Admin/Admin/homeowner_sharable';
$route['Admin/homeowner-setting']   = 'Admin/Admin/homeowner_setting';
$route['Admin/homeowner-invertees'] = 'Admin/Admin/invertees';

$route['Admin/tradesman-sharable']  = 'Admin/Admin/tradesman_sharable';
$route['Admin/tradesman-setting']   = 'Admin/Admin/tradesman_setting';
$route['Admin/tradesman-invertees'] = 'Admin/Admin/invertees';

//Coupon Management
$route['Admin/coupon-management']  = 'Admin/Coupons/index';

// $route['Admin/edit-post']='Admin/User_Posts';
$route['edit-marketer/(:num)']  = 'Admin/Admin/edit_marketer/$1';
$route['view-referrals/(:num)'] = 'Admin/Admin/view_referrals/$1';

$route['local-category'] = 'Admin/Local_Category/local_category';
$route['location-local-category'] = 'Admin/Location_Local_Category/location_local_category';
