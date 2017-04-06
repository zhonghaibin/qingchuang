<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>找回密码</title>
<script src="/Public/js/home/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="/Public/H-ui/lib/layer/2.1/layer.js"></script>
<script src="/Public/js/home/H-ui.home.js" type="text/javascript"></script>


<style type="text/css">
form{margin:0px auto;font-size:14px;padding:20px;}
label{font-size:14px;color:#555;line-height:40px;margin-right:10px;}
input{width:212px;height:38px;border-style:none;padding:0 4px;border:1px solid #C8C8C8;margin-right:10px;outline:none;}
.msgs{display:inline-block;width:104px;color:#fff;font-size:12px;border:1px solid #0697DA;text-align:center;height:30px;line-height:30px;background:#0697DA;cursor:pointer;}
form .msgs1{background:#E6E6E6;color:#818080;border:1px solid #CCCCCC;}
form table tr td{}
input[type='button']{ background:#009900;font-size:16px;width:100px; cursor:pointer;color:#fff;}
</style>

</head>
<body>

<form>
<table >
<tr  ><td colspan="4"  style='text-align:center;font-size:18px;height:40px;line-height:40px;font-weight:bold;'>找&nbsp;&nbsp;回&nbsp;&nbsp;密&nbsp;&nbsp;码</td></tr>
<tr>
	<td style='text-align:right;'>手机号码:</td>
	<td colspan="2" width='230'><input type="text" class="c_code_msg mobile" style="margin:0px 5px 0px 5px;"></td>
	<td width='115'><span class="mobile_tip">请输入手机号码</span></td>
</tr>
<tr >
	<td style='text-align:right;'>短信验证码:</td>
	<td ><input type="text" class="c_code_msg codes" style="margin:0px 5px 0px 5px;width:100px;"></td>
	<td><span class="msgs">获取短信验证码</span></td>
	<td><span class="codes_tip">请输入短信验证码</span></td>
	
</tr>
<tr >
	<td style='text-align:right;'>密码:</td>
	<td colspan="2"><input type="password" class="c_code_msg password" style="margin:0px 5px 0px 5px;"></td>
	
	<td><span class="password_tip">只能输入6-12位的密码</span></td>
	
</tr>
<tr >
	<td style='text-align:right;'>确认密码:</td>
	<td colspan="2"><input type="password" class="c_code_msg repwd" style="margin:0px 5px 0px 5px;"></td>
	
	<td><span class="repwd_tip">只能输入6-12位的确认密码</span></td>
	
</tr>
<tr >
	<td  colspan="4" style='text-align:center;'> <br /><input type="button" value='确定' class='subtn'></td>
</tr>
</table>	
</form>
</body>
</html>
<script type="text/javascript">
	function isLegal(str){
		if(/[!,#,$,%,^,&,*,?,~,\\,|,;,",<,>,(,),+,.,\s+]/gi.test(str)) return false;
			var str1 = str.toLowerCase()
			if(str1.indexOf("script") >= 0 || str1.indexOf("select") >= 0 || str1.indexOf("update") >= 0 || str1.indexOf("delete") >= 0 || str1.indexOf("insert") >= 0 || str1.indexOf("insert") >= 0 || str1.indexOf("drop") >= 0 || str1.indexOf("truncate") >= 0 || str1.indexOf("union") >= 0 || str1.indexOf("user") >= 0 || str1.indexOf("load_file") >= 0 || str1.indexOf("outfile") >= 0)
			{
				return false;
			}
			return true;
		}
	function strLength(as_str){
		return as_str.replace(/[^\x00-\xff]/g, 'xx').length;
	}


	//检查手机格式
	function check_mobile(){
		var mobile=$.trim($('.mobile').val());
		telreg =  /^(1)[0-9]{10}$/;
		if(telreg.test(mobile)){
		
			 $.ajax({ 
				type:"post", 
				url:"/Home/Login/check_mobile", 
				data: {mobile:mobile}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					if(data.status==1){
						flag=false;
					}else{
						flag=true;
						
					}
					$('.mobile_tip').html("<span style='color:#d00000;'>"+data.msg+"</span>");
				}
				}); 

		}else{
			$('.mobile_tip').html('<span style="color:#d00000;">请输入手机号码</span>');
			flag=false;
		}
		return flag;
	}
//检查密码
	function check_pwd(){
		var pwd=$.trim($('.password').val());
		var regp = new RegExp("^[0-9a-zA-Z]+$");
		var strlen = strLength(pwd);
		if(regp.test(pwd) && strlen>=6 && strlen<=12 ){
			$('.password_tip').html('');
			flag=true;
		}else{
			$('.password_tip').html('<span style="color:#d00000;">只能输入6-12位的密码</span>');
			flag=false;
		}
		return flag;
	}

	//检查确认密码
	function check_repwd(){
		var repwd=$.trim($('.repwd').val());
		var regrp = new RegExp("^[0-9a-zA-Z]+$");
		var strlen = strLength(repwd);
		if(regrp.test(repwd) && strlen>=6 && strlen<=12 ){
			if($('.password').val() != repwd){
				$('.repwd_tip').html('<span style="color:#d00000;">两次密码不一致</span>');
				flag=false;
			}else{
				$('.repwd_tip').html('');
				flag=true;
			}
		}else{
			$('.repwd_tip').html('<span style="color:#d00000;">只能输入6-12位的确认密码</span>');
			flag=false;
		}
		return flag;
	}

	//检查短信验证码
	function check_codes(){
		var codes=$.trim($('.codes').val());
		if(!codes || (codes.length!=6)){
		
			 $('.codes_tip').html('<span style="color:#d00000;">请输入短信验证码</span>');
			flag=false;

		}
		else
		{ 
			$('.codes_tip').html(' ');
		   flag=true;
		}
		return flag;
	}
	$(function(){
	

		
		$('.password').blur(function(){
			check_pwd();
		});
		$('.repwd').blur(function(){
			check_repwd();
		});
		$('.mobile').blur(function(){
			check_mobile();
		});
		
		$('.codes').blur(function(){
			check_codes();
		});
		$('.subtn').click(function(){
			
		
			var flag1=check_mobile();
			var flag3=check_codes();
			var flag2=check_pwd();
			var flag4=check_repwd();
			if( flag1 && flag3&&flag2 && flag4){
				petpwd_save();
			}
			
			
		});


			//获取短信验证码
		var validCode=true;
		$(".msgs").click (function  () {
		
			var flag1=check_mobile();
			if( flag1){
			var time=60*3;
			var code=$(this);
			var flag=false;
			if (validCode) {
				validCode=false;
				code.addClass("msgs1");
				flag=true;
			var t=setInterval(function  () {
				time--;
				code.html(time+"秒");
				if (time==0) {
					clearInterval(t);
				code.html("重新获取");
					validCode=true;
				code.removeClass("msgs1");

				}
			},1000)
			}
			if(flag)
			{  
				flag=false;
				set_code();
			}

			}
			else
			{
				$('.codes_tip').html(' ');
				$('.password_tip').html(' ');
				$('.repwd_tip').html(' ');
			}

			

		})
	});
</script>