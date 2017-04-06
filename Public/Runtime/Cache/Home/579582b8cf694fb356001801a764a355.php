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
		<span>打款人账号：<?php echo ($userinfo["username"]); ?></span></br>
		<span>打款人姓名：<?php echo ($userinfo["name"]); ?></span></br>
		<span>打款人电话：<?php echo ($userinfo["mobile"]); ?></span></br>
		<?php if($userinfo["zff1"] == 1 and $userinfo["zff2"] == 1): ?><span>打款人银行名称：<?php echo ($userinfo["bank"]); ?></span></br>
		<span>打款人银行卡号：<?php echo ($userinfo["bankno"]); ?></span></br>
		<span>打款人支付宝：<?php echo ($userinfo["alipay"]); ?></span></br>
		<elseif condition='$userinfo.zff1 eq 1'>
		<span>打款人银行名称：<?php echo ($userinfo["bank"]); ?></span></br>
		<span>打款人银行卡号：<?php echo ($userinfo["bankno"]); ?></span></br>
		<?php elseif($userinfo["zff2"] == 1): ?>
		<span>打款人支付宝：<?php echo ($userinfo["alipay"]); ?></span></br>
		<?php else: ?>
		<span>打款人银行名称：<?php echo ($userinfo["bank"]); ?></span></br>
		<span>打款人银行卡号：<?php echo ($userinfo["bankno"]); ?></span></br>
		<span>打款人支付宝：<?php echo ($userinfo["alipay"]); ?></span></br><?php endif; ?>
	<div>
	<div style='height:2px;clear:both;'></div>

	<div class='Common_box_row' >
		<?php if($crinfo["upload_doc"] != "" ): ?><div id="preview"><img src='/Public/upload/bank/<?php echo ($crinfo["c_user_id"]); ?>/<?php echo ($crinfo["upload_doc"]); ?>'></div> 
		<?php else: ?>
		  <div id="preview"><img src='/Public/images/home/bgg.png'></div><?php endif; ?>
	<div>
	
	<div style='height:2px;clear:both;'></div>
		<?php if($crinfo["status"] == 2): ?><form method="post" action="">
		<div class='Common_box_row'>
		<div class='Common_l Common_row'>
			
			<input type='hidden' class='id' name='id' value='<?php echo ($crinfo["id"]); ?>' />
			<input type='button' value='拒绝' class='Common_input input_style__reset_bg fake_btn' onclick='fake_save()'>
		</div>
		<div class='Common_r Common_row'>{__TOKEN__}
				<input type='button' value='确认' class='Common_input input_style__botton_bg' onclick='affirm_save()'>
		</div>
	<div>
	</form><?php endif; ?>
	</div>
</div>

</body>
</html>