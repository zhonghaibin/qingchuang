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
<title>修改管理员信息</title>
</head>
<body>
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;' ><span class="c-red">*</span>账号：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text username" value="<?php echo ($admin_row["username"]); ?>" placeholder="" id="username" name="username">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'>角色：</label>
			<div class="formControls col-xs-7 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="groupid">
					<?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo["id"] == $admin_row.groupid): ?>selected<?php endif; ?>><?php echo ($vo["rolename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>性别：</label>
			<div class="formControls col-xs-7 col-sm-9 skin-minimal">
				<div class="radio-box">
					<input name="sex" type="radio" id="sex-1" value="1" <?php if($admin_row["sex"] == 1): ?>checked<?php endif; ?> >
					<label for="sex-1">男</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="sex-2" name="sex" value="0" <?php if($admin_row["sex"] == 0): ?>checked<?php endif; ?>>
					<label for="sex-2">女</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="sex-3" name="sex" value="-1" <?php if($admin_row["sex"] == -1): ?>checked<?php endif; ?>>
					<label for="sex-3">保密</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>手机：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text mobile" value="<?php echo ($admin_row["mobile"]); ?>" placeholder="" id="mobile" name="mobile">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>邮箱：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text email" placeholder="@" name="email" id="email"  value="<?php echo ($admin_row["email"]); ?>" >
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>地址：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text address" placeholder="" name="address"  value="<?php echo ($admin_row["address"]); ?>" >
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'>备注：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<textarea name="abstract" cols="" rows="" class="textarea abstract"  placeholder="说点什么...最少输入10个字符" onKeyUp="textarealength(this,100)"><?php echo ($admin_row["abstract"]); ?></textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'>短信验证码：</label>
			<div class="formControls col-xs-7 col-sm-9">
					<input type="text" class="input-text code" placeholder="" name="code"  value=""  style='width:120px;'>&nbsp;&nbsp;<span class="msgs">获取短信验证码</span>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

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


	$("#form-member-add").validate({
		rules:{
			username:{
				required:true,
				minlength:6,
				maxlength:12
			},
			mobile:{
				required:true,
				isMobile:true,
			},
			email:{
				required:true,
				email:true,
			},
			address:{
				required:true,
			},
			code:{
			required:true,
			
			}
			
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			admin_edit_save(<?php echo ($id); ?>);
		}
	});


});
</script>