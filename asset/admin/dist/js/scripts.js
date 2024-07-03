function delete_files(id)
{
	if(confirm('Are you sure to delete this file?'))
	{
		$.ajax({
			type:'POST',
			url:site_url+'Admin/Admin_uploads/delete_uplaod_img',
			data:{id:id},
			dataType:'JSON',
			success:function(resp)
			{
				if(resp.status==1)
				{
					$('#tr'+id).remove();
					toastr.success(resp.msg);
				}else{
					toastr.error(resp.msg)
				}
			}
		});
	}
	return false;
}
function reject_content(id)
{
	if(confirm('Are you sure?'))
	{
		$('#rejct_id').val(id);
		$('#myModal').modal('toggle');
	}
	return false;
}
function addbtn(a) {
	var b= a+1;
	var htmladd='';

  htmladd = '<div class="form-group" id="appendthis'+b+'"><label for="Username" class="col-sm-2 control-label">Upload Image'+b+':</label>'+'<div class="col-sm-10" id="divmain'+b+'"><div class="col-sm-5">'+'<input type="file" name="image_1[]"  id="image'+b+'" class="form-control" onchange="return seepreview('+b+');"></div><div class="col-sm-5"  id="main">'+'<button  type="button" id="btAdd'+b+'" class="bt" style="border-radius: 50px;" onclick="return addbtn('+b+');">'+'<i class="fa fa-plus"></i> </button><button  style="border-radius: 50px;margin-left: 10px;" type="button" id="btRemove'+b+'" onclick="return removebtn('+b+');"><i class="fa fa-minus"></i> </button></div>'+'<br><br>'+'<img src="asset/homeimages/" id="imgpreview'+b+'"  width="100px" height="100px"  style="display: none"></div></div>'+'<input type="hidden" name="hdnimage1[]" id="ddd'+b+'" value="'+b+'">';
	$('#btAdd'+a).hide();
  $('#newwappend').append(htmladd);    
	$('#btAdd'+a).hide();
}


function removebtn(a) {
	var b=a-1;
	var hdn= $('#ddd').val();
	var id=a; 
	if (confirm("Are you sure you want to delete this image?")) {
		$.ajax({
			url: globalbase_url+'Admin/Admin/delete_image/'+id,
			type: "POST",
			success: function(response){
				if(response == 1){
					$('#appendthis'+a).remove();
					$('#btAdd'+b).show();
				}
				window.location.href = globalbase_url+"home_management";
				$("#success").html("'Success! Images has been deleted Successfully.").css("display", "block");
			}
		});
	} else {
		$('#appendthis'+a).show();
		$('#btAdd'+b).show();
	}
}