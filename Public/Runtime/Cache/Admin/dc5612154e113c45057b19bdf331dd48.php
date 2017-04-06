<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/H-ui/lib/html5.js"></script>
<script type="text/javascript" src="/Public/H-ui/lib/respond.min.js"></script>
<script type="text/javascript" src="/Public/H-ui/lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/H-ui/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/H-ui/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/H-ui/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/H-ui/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="/Public/H-ui/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/H-ui/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<style type="text/css">
.msgs{display:inline-block;width:104px;color:#fff;font-size:12px;border:1px solid #0697DA;text-align:center;height:30px;line-height:30px;background:#0697DA;cursor:pointer;}
.msgs1{background:#E6E6E6;color:#818080;border:1px solid #CCCCCC;}
</style>
<title>修改密码</title>
</head>
<body>
<div class="pd-20">
  <form class="Huiform" action="/index.php/Admin/Rbac/adminpasswordedit.html?id=1" method="post">
    <table class="table">
      <tbody>
        <tr>
          <th width="100" class="text-r"><span class="c-red">*</span>新密码：</th>
          <td><input type="password" style="width:200px" class="input-text newpassword" value="" id="teacher-new-password" name="newpassword"></br>
		  <span class='newpwd_tip'></span>
		  </td>
        </tr>
        <tr>
          <th class="text-r"><span class="c-red">*</span> 确认密码：</th>
          <td><input type="password" style="width:200px" class="input-text repassword" value="" id="teacher-new-password2" name="repassword"></br>
			 <span class='repwd_tip'></span>
		  </td>
        </tr> 
		<tr>
          <th class="text-r"><span class="c-red">*</span> 短信验证码：</th>
          <td><input type="password" style="width:100px" class="input-text code" value="" id="teacher-new-password2" name="code" >&nbsp;&nbsp;<span class="msgs">获取短信验证码</span></br>
			 <span class='code_tip'></span>
		  </td>
        </tr>
        <tr>
          <th></th>
          <td><button class="btn  radius btn-primary" onclick='admin_password_save(<?php echo ($id); ?>)' type="button"><i class="Hui-iconfont">&#xe632;</i> 确定</td>
        </tr>
      </tbody>
    </table>
  </form>
</div>

<script type="text/javascript" src="/Public/H-ui/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/Public/H-ui/lib/laypage/1.2/laypage.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="/Public/H-ui/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/Public/H-ui/lib/jquery.validation/1.14.0/messages_zh.min.js"></script>
<script type="text/javascript" src="/Public/H-ui/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/H-ui/static/h-ui.admin/js/H-ui.admin.js"></script> 

</body>
</html>
<script type="text/javascript">
$(function(){
				//获取短信验证码
		var validCode=true;
		$(".msgs").click (function  () {
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
				set_code(<?php echo ($id); ?>);
			}
		})
	/****************************************/


});
</script>