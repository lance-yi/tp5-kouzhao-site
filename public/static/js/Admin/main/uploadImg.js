			$(function(){
				var bar = $('.bar'); 
				var percent = $('.percent'); 
				var showimg = $('#showimg'); 
				var progress = $(".progress"); 
				var files = $(".files"); 
				var btn = $(".btn span"); 
				$("#fileupload").wrap("<form id='myupload' action='action.php' method='post' enctype='multipart/form-data'></form>"); 
				$("#fileupload").change(function(){ //选择文件 
					$("#myupload").ajaxSubmit({ 
						dataType:  'json', //数据格式为json 
						beforeSend: function() { //开始上传 
							showimg.empty(); //清空显示的图片 
							progress.show(); //显示进度条 
							var percentVal = '0%'; //开始进度为0% 
							bar.width(percentVal); //进度条的宽度 
							percent.html(percentVal); //显示进度为0% 
							btn.html("上传中..."); //上传按钮显示上传中 
						}, 
						uploadProgress: function(event, position, total, percentComplete) { 
							var percentVal = percentComplete + '%'; //获得进度 
							bar.width(percentVal); //上传进度条宽度变宽 
							percent.html(percentVal); //显示上传进度百分比 
						}, 
						success: function(data) { //成功 
							//获得后台返回的json数据，显示文件名，大小，以及删除按钮 
							files.html("<b>"+data.name+"("+data.size+"k)</b><span class='delimg' rel='"+data.pic+"'>删除</span>"); 
							//显示上传后的图片 
							var img = "http://www.anjing365.com/Uploads/images/"+data.pic; 
							showimg.html("<img src='"+img+"'>"); 
							btn.html("添加附件"); //上传按钮还原 
						}, 
						error:function(xhr){ //上传失败 
							btn.html("上传失败"); 
							bar.width('0'); 
							files.html(xhr.responseText); //返回失败信息 
						} 
					}); 
				}); 
				$(".delimg").live('click',function(){ 
					var pic = $(this).attr("rel"); 
					$.post("action.php?act=delimg",{imagename:pic},function(msg){ 
						if(msg==1){ 
							files.html("删除成功."); 
							showimg.empty(); //清空图片 
							progress.hide(); //隐藏进度条 
						}else{ 
							alert(msg); 
						} 
					});
				});				
			})