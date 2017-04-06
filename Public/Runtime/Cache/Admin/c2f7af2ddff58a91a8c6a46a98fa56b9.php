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
<title>修改用户信息</title>
</head>
<body>
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-member-add">
		
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>手机：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text mobile" value="<?php echo ($member_row["mobile"]); ?>" placeholder="" id="mobile" name="mobile">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>支付宝：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text alipay" placeholder="" name="alipay" id="alipay" value="<?php echo ($member_row["alipay"]); ?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>姓名：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text name" placeholder="" name="name" id="name" value="<?php echo ($member_row["name"]); ?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'><span class="c-red">*</span>银行卡号：</label>
			<div class="formControls col-xs-7 col-sm-9">
				<input type="text" class="input-text bankno" placeholder="" name="bankno" id="bankno" value="<?php echo ($member_row["bankno"]); ?>" >
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'>银行名称：</label>
			<div class="formControls col-xs-7 col-sm-9"> <span class="select-box">
				<select class="select bank" size="1" name="bank">
					<?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["bankname"]); ?>" <?php if($member_row["bank"] == $vo["bankname"] ): ?>selected<?php endif; ?>><?php echo ($vo["bankname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</select>
				</span> </div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'>等级：</label>
			<div class="formControls col-xs-7 col-sm-9"> <span class="select-box">
				<select class="select star" size="1" name="star">
				<?php if(is_array($level)): foreach($level as $key=>$vo): ?><option value="<?php echo ($key); ?>" <?php if($member_row["star"] == $key ): ?>selected=selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3" style='text-align:right;'>星级：</label>
			<div class="formControls col-xs-7 col-sm-9"> <span class="select-box">
				<select class="select stars" size="1" name="stars">
				<?php echo ($member_row["stars"]); ?>
				<option value="0" <?php if($member_row["stars"] == 0 ): ?>selected=selected<?php endif; ?>>
				0星
				</option>
				<option value="1" <?php if($member_row["stars"] == 1 ): ?>selected=selected<?php endif; ?>>1星</option>
				<option value="2" <?php if($member_row["stars"] == 2 ): ?>selected=selected<?php endif; ?>>2星</option>
				<option value="3" <?php if($member_row["stars"] == 3 ): ?>selected=selected<?php endif; ?>>3星</option>
				</select>
				</span> </div>
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

	
	$("#form-member-add").validate({
		rules:{
			mobile:{
				required:true,
				isMobile:true,
			},
			alipay:{
				required:true,
				
			},
			name:{
				required:true,
			},
			bankno:{
				required:true,
			},
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
		user_edit_save(<?php echo ($id); ?>);
		}
	});
});
</script>