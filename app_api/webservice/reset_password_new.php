<?php
	session_start();
	include("con1.php");
	include("function_app.php");

	if(isset($_POST['uniqcode']))
	{
		$uniqcode = $_POST['uniqcode'];
		$check_email=$mysqli->prepare("SELECT `forgot_id`, `user_id`, `email`, `user_type`,`active_flag`,`delete_flag`, `createtime` FROM `forgot_password_master` WHERE `active_flag`='0' AND `forgot_pass_identity`=?");
		$check_email->bind_param("i",$uniqcode);
		$check_email->execute();
		$check_email->store_result();
		$check_email_count=$check_email->num_rows;
		if($check_email_count <= 0)
		{
			$show_msg = 'This link is deactivated';
			$_SESSION['message'] = $show_msg;
			$sucess = 'false';
			$_SESSION['sucess'] = $sucess;
			echo '<script>window.location.href="forget_password_reset.php?uniqcode1='.$uniqcode.'&session_remove=session_remove";</script>';
		}
		else
		{
			$check_email->bind_result($forgot_id, $user_id, $email, $user_type, $active_flag, $delete_flag,$createtime);
			$check_email->fetch();
			
			$new_password 	=	md5($_POST['password']);
			$active_flag 	=	1;
			$login_type 	=	0;
			$updatetime		=	date('Y-m-d H:i:s');
			
			$update_password=$mysqli->prepare("UPDATE user_master SET login_type=?, password=?, updatetime=?  WHERE user_id=?");
			$update_password->bind_param("sssi",$login_type, $new_password, $updatetime, $user_id);
			$update_password->execute();
			$update_password->store_result();
			$update_password_count=$update_password->affected_rows;  //0 1
			if($update_password_count>0)
			{
				$delet_password=$mysqli->prepare("UPDATE forgot_password_master SET active_flag=?,updatetime=? WHERE forgot_pass_identity=?");
				$delet_password->bind_param("sss",$active_flag,$updatetime,$uniqcode);
				$delet_password->execute();
				$delet_password->store_result();
				$delet_password_count=$delet_password->affected_rows;  //0 1
				if($delet_password_count>0)
				{
					$show_msg	 			=	'Password Updated Successfully';
					$sucess 				=	'true';
					$_SESSION['message'] 	=	$show_msg;
					$_SESSION['sucess'] 	=	$sucess;
					//header("location:forget_password_reset.php?uniqcode=".$uniqcode);
					echo '<script>window.location.href="forget_password_reset.php?uniqcode1='.$uniqcode.'&session_remove=session_remove";</script>';
				}else{
					$show_msg = 'Password Not Update';
					$sucess = 'false';
					$_SESSION['message'] = $show_msg;
					$_SESSION['sucess'] = $sucess;
					//header("location:forget_password_reset.php?uniqcode=".$uniqcode);
					echo '<script>window.location.href="forget_password_reset.php?uniqcode1='.$uniqcode.'&session_remove=session_remove";</script>';
				}
			}else{
				$show_msg = 'Password Not Update';
				$sucess = 'false';
				$_SESSION['message'] = $show_msg;
				$_SESSION['sucess'] = $sucess;
			   // header("location:forget_password_reset.php?uniqcode=".$uniqcode);
			   echo '<script>window.location.href="forget_password_reset.php?uniqcode1='.$uniqcode.'&session_remove=session_remove";</script>';
			}
		}
	}
	else
	{
		$show_msg 				=	'This link is not valid...';
		$_SESSION['message'] 	=	$show_msg;
		$sucess 				=	'false';
		$_SESSION['sucess'] 	=	$sucess;
		echo '<script>window.location.href="forget_password_reset.php?uniqcode1='.$uniqcode.'&session_remove=session_remove";</script>';
		//header("location:forget_password_reset.php?uniqcode=".$uniqcode);
	}

?>