<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_uploads extends MY_Controller { 
	
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("upload_model");
		$this->check_login();
		require_once('application/libraries/ConvertApi/autoload.php');
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}
	public function active_file($id) {
		if($id)
		{
			$run = $this->common_model->update('uploads',array('active_status'=>1),$id);
			if($run)
			{
				$this->session->set_flashdata('succ','Success: File has been activated successfully.');
			}
		} else {
			$this->session->set_flashdata('err','Something went wrong');
		}
		redirect('active_content');
	}

	public function deactive_file($id) {
		if($id)
		{
			$run = $this->common_model->update('uploads',array('active_status'=>0),$id);
			if($run)
			{
				$this->session->set_flashdata('succ','Success: File has been deactivated successfully.');
			}
		} else {
			$this->session->set_flashdata('err','Something went wrong');
		}
		redirect('active_content');
	}
	public function reject_content() {
		$id = $_REQUEST['id'];
		$reject_reason = $_REQUEST['reject_reason'];
		if($id)
		{
			$data = $this->common_model->getRows('uploads',$id);
			$user = $this->common_model->get_userDataByid($data['user_id']);
			$update['status'] = 3;
			$update['reject_reason'] = $reject_reason;
		
			$run = $this->common_model->my_update('uploads',array('id'=>$id),$update);
			if($run)
			{
				$to = $user['email'];
				$subject = 'Content rejected';
				$msg = '<p>Hello, '.$user['fname'].' '.$user['lname'].'</p>';
				$msg .= '<p>This is mail to inform you that, your file has been rejected by '. Project .' team.</p>';
				$msg .= '<p>Due to: <b>'.$reject_reason.'</b></p>';
				$msg .= '<p>Check your account for more information.</p>';
				$this->common_model->send_mail($to,$subject,$msg,null,null,'support');
				
				$this->session->set_flashdata('msg','<div class="alert alert-success"> Success! Content has been rejcted successfully.</div>');
		
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger"> Error! Something went wrong, please try again later.</div>');
				
			}
		}
		else 
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger"> Error! Something went wrong, please try again later.</div>');
			
		} 
		redirect('pending_content');
		 
	}
	public function approve_content($id) {
		//echo $id = $_REQUEST['id'];die;
		if($id)
		{
			$data = $this->common_model->getRows('uploads',$id);
			$user = $this->common_model->get_userDataByid($data['user_id']);
			$update['status'] = 2;
		
			$run = $this->common_model->my_update('uploads',array('id'=>$id),$update);
			if($run)
			{
				$to = $user['email'];
				$subject = 'Content approved';
				$msg = '<p>Hello, '.$user['fname'].' '.$user['lname'].'</p>';
				$msg .= '<p>This is mail to inform you that, your file has been approved by '. Project .' team.</p>';
				$msg .= '<p>Check your account for more information.</p>';
				$this->common_model->send_mail($to,$subject,$msg,null,null,'support');
				
				$this->session->set_flashdata('msg','<div class="alert alert-success"> Success! Content has been approved successfully.</div>');
		
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger"> Error! Something went wrong, please try again later.</div>');
				
			}
		}
		else 
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger"> Error! Something went wrong, please try again later.</div>');
			
		} 
		redirect('pending_content');
		 
	}
	public function admin_upload_files() { 
		//$result['actives']=$this->common_model->newgetRows('uploads',array('status'=>2),'id'); 
		
		
		$this->load->view('Admin/admin_upload_files');
		
	}
	public function admin_pending_content() { 
	
		$result['uploads']=$this->common_model->newgetRows('uploads',array('status'=>0,'user_id'=>0),'id');
		$result['subcategory']=$this->common_model->getRows('subcategory');		
		
		
		$this->load->view('Admin/admin_pending_content',$result);
		
	}
	public function submit_file_desc() {
		$this->form_validation->set_rules('description_en','English Description','required|max_length[200]');
		$this->form_validation->set_rules('description_ar','Arabic Description','required|max_length[200]');
		$this->form_validation->set_rules('category1','Category','required');
		$this->form_validation->set_rules('price_en','Price is','required');
		$this->form_validation->set_rules('hashtag_en','Keyword in english','required');
		$this->form_validation->set_rules('hashtag_ar','Keyword in arabic','required');

		if($this->input->post('main_category')==4){
		$this->form_validation->set_rules('dimension','Dimension','required');
		$this->form_validation->set_rules('aspect_ratio','Aspect Ratio','required');
		$this->form_validation->set_rules('fps','FPS','required');
		$this->form_validation->set_rules('video_clip_length','Video clip length','required');
		$this->form_validation->set_rules('file_name','Url','required');
		}
		
		if ($this->form_validation->run()==false) 
		{
			$json['status'] = 0;
			$json['msg'] = validation_errors();
		}
		else 
		{
		  $file_action=1;
		  $main_category=$this->input->post('main_category');
          
   	      if($main_category==4){
   	      	$file_name=$this->input->post('file_name');
   	      	$path='asset/upload_admin/'.$file_name;
	   	      if(!file_exists($path))
	   	      {
                 $file_action = 0;
	   	      }else{
	   	      	$uplate['admin_file_name']=$this->input->post('file_name');
	   	      }
   	      }
              
			$uplate['description_en'] = $this->input->post('description_en');
			$uplate['description_ar'] = $this->input->post('description_ar');
			$uplate['sub_cat_en'] = $this->input->post('category1');
			
			$uplate['price_en'] = $this->input->post('price_en');
			
			$uplate['hashtag_en'] = $this->input->post('hashtag_en');
			$uplate['hashtag_ar'] = $this->input->post('hashtag_ar');
            /*only video uplode contant*/
			$uplate['dimension'] = $this->input->post('dimension');
			$uplate['aspect_ratio'] = $this->input->post('aspect_ratio');
			$uplate['fps'] = $this->input->post('fps');
			$uplate['video_clip_length'] = $this->input->post('video_clip_length');
			$uplate['v_url'] = $this->input->post('v_url');
			$uplate['status'] = 2;
			//$uplate['edit'] = 2; 
			$items = $this->input->post('items');
			$single_itme = $this->input->post('single_itme');
			if(($items || $single_itme) && $file_action==1)
			{
				$hashtag_enArr = explode(',',$uplate['hashtag_en']);
				$hashtag_arArr = explode(',',$uplate['hashtag_ar']);
				
				if(count($hashtag_enArr) < 7)
				{
					$json['status'] = 0;
					$json['msg'] = 'Please select minimum 7 keywords in english!';
					$json['focus'] = 'hashtag_en';
				} else if(count($hashtag_arArr) < 7){
					$json['status'] = 0;
					$json['msg'] = 'Please select minimum 7 keywords in arabic!';
					$json['focus'] = 'hashtag_ar';
				} else {
					if($items)
					{
						foreach($items as $item)
						{
							$run = $this->common_model->my_update('uploads',array('id'=>$item),$uplate);
						}
					} else {
						$run = $this->common_model->my_update('uploads',array('id'=>$single_itme),$uplate);
					}
					$json['status'] = 1;
					$json['msg'] = 'File has been submitted successfully!.';
				}
			} 
			else
			{
				$json['status'] = 0;
				if($file_action==0){
                    $json['msg'] = 'File name does not Exist!';
				}else{
					$json['msg'] = 'Please select at least one file!';
				}
			}
		}
		echo json_encode($json);
	}
	public function get_sub_cate_by_maincat() {
		$id = $_REQUEST['id']; 
		$subcatid = (isset($_REQUEST['subcatid']))?$_REQUEST['subcatid']:''; 

		$main = $this->common_model->getRows('category',$id);
		$json['main'] = '<option value="'.$id.'">'.$main['name_en'].'</option>';
		$json['sub'] = '';
		
		$sub = $this->common_model->newgetRows('subcategory',array('cat_id'=>$id),'name_en');
		foreach($sub as $subc)
		{
			$selected = ($subcatid==$subc['id'])?'selected':'';
			$json['sub'] .= '<option '.$selected.' value="'.$subc['id'].'">'.$subc['name_en'].'</option>';
		}
		echo json_encode($json);
	}
	public function delete_uplaod_img() {
		$id = $_REQUEST['id'];
		$data = $this->common_model->getRows('uploads',$id);
		if($data)
		{
			$new_file_name = $data['image'];
			$new_thumb_name = $data['thumb'];
			$run = $this->common_model->delete('uploads',$id);
			if($run)
			{
				unlink('asset/site/img/uplaod_files/'.$new_file_name);
				unlink('asset/site/img/uplaod_files/thumbs/'.$new_thumb_name);
				$json['status'] = 1;
				$json['msg'] = 'Success: File has been deleted successfully!';
			}
			else
			{
				$json['status'] = 0;
				$json['msg'] = 'Error: Something went wrong!';
			}
		}
		else
		{
			$json['status'] = 0;
			$json['msg'] = 'Error: Something went wrong!';
		}
		echo json_encode($json);
	}
	public function active_content() { 
		$result['actives']=$this->common_model->newgetRows('uploads',array('status'=>2),'id'); 
		
		
		$this->load->view('Admin/active_content',$result);
		
	}
	public function pending_content() { 
		$result['pendings']=$this->common_model->newgetRows('uploads',array('status'=>1),'id'); 
		
		
		$this->load->view('Admin/pending_content',$result);
		
	}
	public function rejected_content() { 
		$result['rejecteds']=$this->common_model->newgetRows('uploads',array('status'=>3),'id'); 
		
		
		$this->load->view('Admin/rejected_content',$result);
		
	}
	public function check_and_upload_image() {
		$unique = rand(1000,9999).time();
		$json['unique'] = $unique;
		if(!empty($_FILES)){
			// Include the database configuration file
				
			// File path configuration
			$targetDir = "asset/site/img/uplaod_files/";
			$thumbDir = "asset/site/img/uplaod_files/thumbs/";
			$fileName = $_FILES['file']['name'];
			$filesize = $_FILES['file']['size'];
			$nameArr = explode('.',$fileName);
			$ext = end($nameArr);
			$is_orantation = true;
			$extdata = $this->upload_model->get_cat_by_ext($ext);
			$logo = base_url().'asset/site/img/watermark.png';
			
			$file_name = 'outboxmaster_'.$unique.'.'.$ext;
			
			if($extdata) {
				if($extdata['ext_cat']=='PHOTOS'){ 
					
					if($filesize >= (4194304)){
						if($ext=='psd'){
							if(move_uploaded_file($_FILES['file']['tmp_name'],$targetDir.$file_name)) {
								$video = $targetDir.$file_name;
								$upload_img = rand(10000,99999).'outboxmaster_'.$unique.'.png';
								$thumbnail = $thumbDir.$upload_img;
								$is_orantation = false;
								$usmap = $video;
								$im = new Imagick();
								$svg = file_get_contents($usmap);

								$im->readImageBlob($svg);

								
								$im->setImageFormat("png24");
								$im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);  

								
								$im->setImageFormat("jpeg");
								$im->adaptiveResizeImage(720, 445);

								$im->writeImage($thumbnail);
								$im->clear();
								$im->destroy();
							} else {
								$upload_img = false;
								$msg = '<div class="alert alert-danger error_unique'.$unique.'">
									
										<div class="alert" id="small-image">
											Something went wrong, try again later!
											<ul>
												<li>'.$fileName.'</li>
											</ul>
										</div>
									</div>';
							}	
						} else {
							$upload_img = $this->cwUpload('file',$targetDir,$file_name,TRUE,$thumbDir,'720','445');
							$thumbnail = $thumbDir.$upload_img;
							$video = $targetDir.$file_name;
						}
					} else {
						$upload_img = false;
						$msg = '<div class="alert alert-danger error_unique'.$unique.'">
							
								<div class="alert" id="small-image">
									Your image is too small; it must be at least 4 megabites.
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
					}
					
				} else if($extdata['ext_cat']=='VECTORS') {
					
					if(move_uploaded_file($_FILES['file']['tmp_name'],$targetDir.$file_name)) {
						$video = $targetDir.$file_name;
						$upload_img = rand(10000,99999).'outboxmaster_'.$unique.'.png';
						$thumbnail = $thumbDir.$upload_img;
						$is_orantation = false;
						$usmap = $video;
						$im = new Imagick();
						$svg = file_get_contents($usmap);

						$im->readImageBlob($svg);

						
						$im->setImageFormat("png24");
						$im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);  

						
						$im->setImageFormat("jpeg");
						$im->adaptiveResizeImage(720, 445);

						$im->writeImage($thumbnail);
						$im->clear();
						$im->destroy();
					} else {
						$upload_img = false;
						$msg = '<div class="alert alert-danger error_unique'.$unique.'">
							
								<div class="alert" id="small-image">
									Something went wrong, try again later!
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
					}					
				} else if($extdata['ext_cat']=='EDITORIAL') {
					if(move_uploaded_file($_FILES['file']['tmp_name'],$targetDir.$file_name)) {
						$video = $targetDir.$file_name;
						$upload_img = rand(10000,99999).'outboxmaster_'.$unique.'.png';
						$thumbnail = $thumbDir.$upload_img;
						$is_orantation = false;
						if($ext == 'pdf') {
							$im = new imagick($video.'[0]');
							$im->setImageFormat('png24');
							//$im->setBackgroundColor(new ImagickPixel('white'));
							$im->setImageBackgroundColor('#ffffff');
							//$im->flattenImages();
							
							$im->setImageAlphaChannel(11); // Imagick::ALPHACHANNEL_REMOVE
							$im->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
							//$im->blurImage(5,3);
							
							$im->setImageFormat("png24");
							$im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);
							
							$im->setImageFormat("jpeg");
							$im->adaptiveResizeImage(720, 445);

							$im->writeImage($thumbnail);
							$im->clear();
							$im->destroy();
						} else {
							$new_doc = 'asset/docToPdf/'.time().rand().'.doc';
							$new_pdf = 'asset/docToPdf/'.time().rand().'.pdf';
							
							ConvertApi::setApiSecret('SP3UYQys3ucVHHkN');
							
							$result = ConvertApi::convert('pdf', [
											'File' => $video,
									], 'docx'
							);
							
							$result->saveFiles($new_pdf);
							
							$im = new imagick($new_pdf.'[0]');
							$im->setImageFormat('png24');
							//$im->setBackgroundColor(new ImagickPixel('white'));
							$im->setImageBackgroundColor('#ffffff');
							//$im->flattenImages();
							
							$im->setImageAlphaChannel(11); // Imagick::ALPHACHANNEL_REMOVE
							$im->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
							//$im->blurImage(5,3);
							
							$im->setImageFormat("png24");
							$im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);
							
							$im->setImageFormat("jpeg");
							$im->adaptiveResizeImage(720, 445);

							$im->writeImage($thumbnail);
							$im->clear();
							$im->destroy();
						}
						
					} else {
						$upload_img = false;
						$msg = '<div class="alert alert-danger error_unique'.$unique.'">
									
									<div class="alert" id="small-image">
										Something went wrong, try again later!
										<ul>
											<li>'.$fileName.'</li>
										</ul>
									</div>
								</div>';
					}
				} else if($extdata['ext_cat']=='VIDEOS') {
					if($filesize <= (4194304)){
						if(move_uploaded_file($_FILES['file']['tmp_name'],$targetDir.$file_name)) {
							$video = $targetDir.$file_name;
							$upload_img = rand(10000,99999).'outboxmaster_'.$unique.'.jpeg';
							$thumbnail = $thumbDir.$upload_img;
							$is_orantation = false;
							// shell command [highly simplified, please don't run it plain on your script!]
							shell_exec("ffmpeg -i $video -s 720x445 -deinterlace -an -ss 1 -t 00:00:01 -r 5 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");

						} else {
							$upload_img = false;
							$msg = '<div class="alert alert-danger error_unique'.$unique.'">
								
									<div class="alert" id="small-image">
										Something went wrong, try again later!
										<ul>
											<li>'.$fileName.'</li>
										</ul>
									</div>
								</div>';
						}
					} else {
						$upload_img = false;
						$msg = '<div class="alert alert-danger error_unique'.$unique.'">
								<strong> This upload file largest Max upload file size 4MB </strong>
								<div class="alert" id="small-image">
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
					}
				} else {
					$upload_img = false;
					$msg = '<div class="alert alert-danger error_unique'.$unique.'">
								
								<div class="alert" id="small-image">
									File is not in acceptable format!
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
				}
				// Upload file to server
				if($upload_img){
					
					$stamp = imagecreatefrompng($logo);
					if($ext=='jpg' || $ext=='jpeg' || $extdata['ext_cat']=='VIDEOS')
					{
						$im = imagecreatefromjpeg($thumbnail);
					}
					else
					{
						$im = imagecreatefrompng($thumbnail);
					}
					

					// Set the margins for the stamp and get the height/width of the stamp image
					$marge_right = 0;
					$marge_bottom = 0;
					$sx = imagesx($stamp);
					$sy = imagesy($stamp);

					// Copy the stamp image onto our photo using the margin offsets and the photo 
					// width to calculate positioning of the stamp. 
					imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

					imagepng($im,$thumbnail);
					imagedestroy($im);
					
					if($is_orantation) {
						list($width, $height) = getimagesize($video);
					
						if( $width > $height) {
								$insert['orientation'] = "Horizontal";
						} else {
								$insert['orientation'] = "Vertical";
						}
						$insert['width'] = $width;
						$insert['height'] = $height;
					}
					
					
					$insert['m_cat_en'] = $extdata['ext_catId'];
					$insert['type'] = $extdata['ext_cat'];
					$insert['image'] = $file_name;
					$insert['thumb'] = $upload_img;
					$insert['img_name'] = $fileName;
					$insert['status'] = 0;
					$insert['user_id'] = 0;
				
					$run = $this->common_model->insert('uploads',$insert);
					if($run)
					{
					// Insert file information in the database	
						$json['status'] = 1;
						$json['img_id'] = $run;
						$json['new_file_name'] = $file_name;
						$json['new_thumb_name'] = $upload_img;
						$json['msg'] = '<div class="alert alert-success error_unique'.$unique.'">
								
								<div class="alert" id="small-image">
									File has been upladed successfully!
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
					}
					else{
						$json['status'] = 0;
						$json['msg'] = '<div class="alert alert-danger error_unique'.$unique.'">
							
								<div class="alert" id="small-image">
									Something went wrong, try again later!
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
					}
			
				}
				else 
				{
					$json['status'] = 0;
					$json['msg'] = $msg;
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger error_unique'.$unique.'">
								<div class="alert" id="small-image">
									File is not in acceptable format!
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
			}
		}
		
		else
		{
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger error_unique'.$unique.'">
								<div class="alert" id="small-image">
									Something went wrong, try again later!
									<ul>
										<li>'.$fileName.'</li>
									</ul>
								</div>
							</div>';
		}
		echo json_encode($json);
	}
	public function delete_img() {
		$new_file_name = $_REQUEST['new_file_name'];
		$new_thumb_name = $_REQUEST['new_thumb_name'];
		$img_id = $_REQUEST['img_id'];
		
		$run = $this->common_model->delete('uploads',$img_id);
		if($run)
		{
			unlink('asset/site/img/uplaod_files/'.$new_file_name);
			unlink('asset/site/img/uplaod_files/thumbs/'.$new_thumb_name);
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	function read_file_docx($filename) {
    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);

    if (!$zip || is_numeric($zip)) return false;


    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }// end while

    zip_close($zip);

    //echo $content;
    //echo "<hr>";
    //file_put_contents('1.xml', $content);     

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
	}
	public function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
	 
    //folder path setup
    $target_path = $target_folder;
    $thumb_path = $thumb_folder;
    
    //file name setup
    $filename_err = explode(".",$_FILES[$field_name]['name']);
    $filename_err_count = count($filename_err);
    $file_ext = $filename_err[$filename_err_count-1];
    if($file_name != ''){
        $fileName = $file_name;
    }else{
        $fileName = $_FILES[$field_name]['name'];
    }
    
    //upload image path
    $upload_image = $target_path.basename($fileName);
    
    //upload image
    if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
    {
			//thumbnail creation
			if($thumb == TRUE)
			{
					$thumbnail = $thumb_path.rand(10000,99999).$fileName;
					list($width,$height) = getimagesize($upload_image);
					$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
					switch($file_ext){
							case 'jpg':
									$source = imagecreatefromjpeg($upload_image);
									break;
							case 'jpeg':
									$source = imagecreatefromjpeg($upload_image);
									break;

							case 'png':
									$source = imagecreatefrompng($upload_image);
									break;
							case 'gif':
									$source = imagecreatefromgif($upload_image);
									break;
							default:
									$source = imagecreatefromjpeg($upload_image);
					}

					imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
					switch($file_ext){
							case 'jpg' || 'jpeg':
									imagejpeg($thumb_create,$thumbnail,100);
									break;
							case 'png':
									imagepng($thumb_create,$thumbnail,100);
									break;

							case 'gif':
									imagegif($thumb_create,$thumbnail,100);
									break;
							default:
									imagejpeg($thumb_create,$thumbnail,100);
					}

			}
			$imageArray = explode('/',$thumbnail);
			return end($imageArray);
    }
    else
    {
        return false;
    }
	}

   public function vedio_approvel()
   {
   	   $json['status']=0;
   	   $file_name=$this->input->post('file_name');
   	   $id=$this->input->post('v_id');
   	   $path='asset/upload_admin/'.$file_name;
   	   if(file_exists($path))
   	   {
   	   	 $update['admin_file_name']=$file_name;
   	   	 $update['status']=2;
   	     $run = $this->common_model->my_update('uploads',array('id'=>$id),$update);
	   	     if($run){
	   	     $json['status']=1;
	   	      $this->session->set_flashdata('msg','<div class="alert alert-success">
			    Success! Content has been approved successfully.
			  </div>');
	   	     }else{
	         $json['msg']='<div class="alert alert-Info">
			    Some problem please try again.
			  </div>';
	   	     }
   	   }else{
   	   	  $json['msg']='<div class="alert alert-danger">
		    File name not exist please change file name.
		  </div>';
   	   }
   	   echo json_encode($json);
   }  
}
