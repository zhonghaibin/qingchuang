<?php if (!defined('THINK_PATH')) exit();?><head>
    <title></title>
    <meta name="Keywords" content="">
    <meta name="description" content="">
    <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/Public/style/home/main.css">
	<script src="/Public/js/home/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="/Public/H-ui/lib/layer/2.1/layer.js"></script>
	<script src="/Public/js/home/H-ui.home.js" type="text/javascript"></script>
    <style type="text/css">  
     #preview,img, .imgs
     {  
		width:240px;  
		height:180px;
     } 
	 span{font-size:15px;display:black;height:24px;line-height:24px;}
	 </style>
</head>
<body>

<div class='Common_box'><div class="title">
	<div class="img"></div>
	<div class="txt">订单详细信息 </div>
	</div>
	<div class='Common_box_box'>
	<span style='font-size:16px;font-weight:bold;'>根据下面的银行详细信息打款：</span>
	<div class='Common_box_row'>
		<span>推荐人账号：<?php echo ($reinfo["username"]); ?></span></br>
		<span>推荐人姓名：<?php echo ($reinfo["name"]); ?></span></br>
		<span>推荐人电话：<?php echo ($reinfo["mobile"]); ?></span></br>
	<div>
	<div style='height:2px;clear:both;'></div>
	<div class='Common_box_row'>
		<span>收款人账号：<?php echo ($userinfo["username"]); ?></span></br>
		<span>收款人姓名：<?php echo ($userinfo["name"]); ?></span></br>
		<span>收款人电话：<?php echo ($userinfo["mobile"]); ?></span></br>
		<?php if($userinfo["zff1"] == 1 and $userinfo["zff2"] == 1): ?><span>收款人银行名称：<?php echo ($userinfo["bank"]); ?></span></br>
		<span>收款人银行卡号：<?php echo ($userinfo["bankno"]); ?></span></br>
		<span>收款人支付宝：<?php echo ($userinfo["alipay"]); ?></span></br>
		<?php elseif($userinfo["zff1"] == 1 ): ?>
		<span>收款人银行名称：<?php echo ($userinfo["bank"]); ?></span></br>
		<span>收款人银行卡号：<?php echo ($userinfo["bankno"]); ?></span></br>
		<?php elseif($userinfo["zff2"] == 1 ): ?>
		<span>收款人支付宝：<?php echo ($userinfo["alipay"]); ?></span></br>
		<?php else: ?>
		<span>收款人银行名称：<?php echo ($userinfo["bank"]); ?></span></br>
		<span>收款人银行卡号：<?php echo ($userinfo["bankno"]); ?></span></br>
		<span>收款人支付宝：<?php echo ($userinfo["alipay"]); ?></span></br><?php endif; ?>
	<div>
	<!--<font color="red" id="sky_txt"></font>-->
	<div style='height:2px;clear:both;'></div>
	<div class='Common_box_row'>
	<?php if($crinfo["upload_doc"] != "" ): ?><div id="preview"><img src='/Public/upload/bank/<?php echo ($crinfo["c_user_id"]); ?>/<?php echo ($crinfo["upload_doc"]); ?>'></div> 
	<?php else: ?>
		  <div id="preview"><img src='/Public/images/home/bgg.png'></div><?php endif; ?>
	<div>
	<div style='height:2px;clear:both;'></div>
	<?php if($crinfo["status"] == 1 or $crinfo["status"] == 4): ?><form method="post" action="" id='bank_upform'  enctype="multipart/form-data" >
	<div class='Common_box_row'>
		<div class='Common_l Common_row'>
			{__TOKEN__}
			<input type="file" onchange="preview(this)" id='file' style='display:none;' name='upfile' />  
			<input type='button' value='选择图片' class='Common_input input_style__reset_bg file' >
		</div>
		<div class='Common_r Common_row'>
				<input type='hidden' value='<?php echo ($crinfo["id"]); ?>' name='id'>
				<input type='button' value='提 交'  onclick="sky_upfiles()" class='Common_input input_style__botton_bg'>
		</div>
	<div>
	</form>
<script src="/Public/js/admin/jquery-1.4.2.js" language="JavaScript" type="text/javascript"></script>
<script src="/Public/js/admin/jquery.form.js" language="JavaScript" type="text/javascript"></script>
 <script type="text/javascript"> 
 
	 $(document).ready(function(){
	 $(".file").click(function(){
 		$('#file').click();
		});
	 });

     function preview(file)  
     {  
     var prevDiv = document.getElementById('preview');  
     if (file.files && file.files[0])  
     {  
     var reader = new FileReader();  
     reader.onload = function(evt){  
     prevDiv.innerHTML = '<img  src="' + evt.target.result + '" />';  
    }    
     reader.readAsDataURL(file.files[0]);  
    }  
     else    
     {  
     prevDiv.innerHTML = '<div class="imgs" style="height:180px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';  
     }  
     }  
		function sky_upfiles(){
			var messtxt;
		 $("#bank_upform").ajaxSubmit({
			
			//dataType:'script',
			type:'post',
			url: "/Home/Index/addpromote",    
			beforeSubmit: function(){
				
				layer.msg('玩命上传中...',{icon:6,time:1000});
			},
			success: function(data){        
				if(data=="1"){
				  //messtxt = "上传成功！";
				 layer.msg('添加成功',{icon: 1,time:1000},function(){
				 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
				 parent.location.reload();
				 parent.layer.close(index); 
								 
								 });
				}else if(data=="-1"){
				messtxt = "文件超过规定大小！";
				layer.msg(messtxt,{icon:2,time:1000});
				}else if(data=="-2"){
				messtxt = "文件类型不符!";
				layer.msg(messtxt,{icon:2,time:1000});
				}else if(data=="-3"){
				messtxt = "移动文件出错!";
				layer.msg(messtxt,{icon:2,time:1000});
				}
				else if(data=="-4"){
				messtxt = "操作失败，账号已经冻结或者删除了！";
				layer.msg(messtxt,{icon:2,time:1000});
				}else{
				messtxt = "未知错误!";
				layer.msg(messtxt,{icon:2,time:1000});
				}
				//$("#sky_txt").html(messtxt); 
				
				//$("#sky_txt").append(data);
			},
			resetForm: false,
			clearForm: false
		});
//$("#upimgform").submit();
}

        </script><?php endif; ?>
	</div>
</div>

</body>
</html>