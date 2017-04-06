<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
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
<title>奖金设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统设置 <span class="c-gray en">&gt;</span> 奖金设置 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
<form method="post" action="/index.php/Admin/Webconfig/setbonus.html">
<table class="table table-border table-bordered table-hover table-bg">
  <tbody>
	<tr>
      <th class="text-r" width="200">提供帮助限额：</th><td><input type="text" name='providehelplimit' placeholder="" value="<?php echo ($setbonus["providehelplimit"]); ?>" style="width:200px" class="input-text providehelplimit">元
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<input type="text" placeholder="" readonly='readonly' value="<?php echo (date('Y-m-d H:i:s',$allowmoney["time"])); ?>" style="width:200px" class="input-text">到目前为止已经排单：<input type="text" placeholder="" value="<?php echo ($allowmoney["allmoney"]); ?>" style="width:200px" class="input-text" readonly='readonly'>元
	  </td>
    </tr>
	<tr>
      <th class="text-r" width="200">新用户注册奖励：</th><td><input type="text" name='newuserreward' placeholder="" value="<?php echo ($setbonus["newuserreward"]); ?>" style="width:200px" class="input-text newuserreward">元 （为0不赠送）</td>
    </tr>
	<tr>
      <th class="text-r" width="200">排队期每日利息：</th><td><input type="text" name='dailyinterest' placeholder="" value="<?php echo ($setbonus["dailyinterest"]); ?>" style="width:200px" class="input-text dailyinterest">%</td>
    </tr>
	<tr>
      <th class="text-r" width="200">冻结期：</th><td><input type="text"  placeholder="" name='freezingdays' value="<?php echo ($setbonus["freezingdays"]); ?>" style="width:200px" class="input-text freezingdays">天，每日利息：<input type="text"  placeholder=""  name='interestfreeze' value="<?php echo ($setbonus["interestfreeze"]); ?>" style="width:200px" class="input-text interestfreeze">%</td>
    </tr>
    <tr>
      <th class="text-r" width="200">赞助/提现倍数：</th><td><input type="text" name='multipleofextraction' placeholder="" value="<?php echo ($setbonus["multipleofextraction"]); ?>" style="width:200px" class="input-text multipleofextraction">必须填整数倍</td>
    </tr>
	<tr>
      <th class="text-r">每日申请接收帮助次数：</th><td><input type="text" name='frequency'  placeholder="" value="<?php echo ($setbonus["frequency"]); ?>" style="width:200px" class="input-text frequency">次（必须是整数）</td>
    </tr>
	<tr>
      <th class="text-r">会员最低提供帮助：</th><td><input type="text" name='minimumamount'  placeholder="" value="<?php echo ($setbonus["minimumamount"]); ?>" style="width:200px" class="input-text minimumamount">元</td>
    </tr>
	<tr>
      <th class="text-r">会员最低接收帮助：</th><td><input type="text" name='receivinglimit'  placeholder="" value="<?php echo ($setbonus["receivinglimit"]); ?>" style="width:200px" class="input-text receivinglimit">元</td>
    </tr>
    <tr>
      <th class="text-r">新会员最高只能排：</th><td><input type="text" name='newuserqueuelimit'  placeholder="" value="<?php echo ($setbonus["newuserqueuelimit"]); ?>" style="width:200px" class="input-text newuserqueuelimit">元</td>
    </tr>
	<tr>
      <th class="text-r">每升一级增加：</th><td><input type="text"  name='increaseamount' placeholder="" value="<?php echo ($setbonus["increaseamount"]); ?>" style="width:200px" class="input-text increaseamount">元</td>
    </tr>
	
    <tr>
      <th class="text-r" >经理每天提现限制：</th>
	  <td>
	    <?php if(is_array($manager)): foreach($manager as $key=>$manager): ?>级别：<input type="text" readonly="readonly"  value="<?php echo ($manager); ?>" style="width:200px" class="input-text ">推荐奖限制：<input type="text" name='recommend_<?php echo ($key); ?>' placeholder="" value="<?php echo ($recommend_dai[$key]); ?>" style="width:200px" class="input-text ">元 经理奖限制：<input type="text" name='manager_<?php echo ($key); ?>' placeholder="" value="<?php echo ($manager_dai[$key]); ?>" style="width:200px" class="input-text ">元<br/></br><?php endforeach; endif; ?>
	  </td>
    </tr>
	 <tr>
      <th class="text-r" >会员每次提现限制：</th>
	  <td>
	    <?php if(is_array($level)): foreach($level as $key=>$level): ?>级别：<input type="text" readonly="readonly"  value="<?php echo ($level); ?>" style="width:200px" class="input-text ">推荐奖限制：<input type="text" name='member_<?php echo ($key); ?>' placeholder="" value="<?php echo ($member_dai[$key]); ?>" style="width:200px" class="input-text ">元  <br/></br><?php endforeach; endif; ?>
	  </td>
    </tr>

	 <tr>
      <th class="text-r" >会员提供帮助限制：</th>
	  <td>
		 状态：
		  <label><input name="star_status" value="1" type="radio" <?php if($setbonus["star_status"] == 1): ?>checked='checked'<?php endif; ?>>启用</label>&nbsp;
		  <label><input name="star_status" value="0" type="radio" <?php if($setbonus["star_status"] == 0): ?>checked='checked'<?php endif; ?>>关闭</label>&nbsp;</br></br>
	      <?php if(is_array($star)): foreach($star as $k=>$star): ?>级别：<input type="text" readonly="readonly"  value="<?php echo ($star); ?>" style="width:200px" class="input-text ">&nbsp;&nbsp; 范围限制：<input type="text" name='zuidi_<?php echo ($k); ?>' placeholder="" value="<?php echo ($zuidi[$k]); ?>" style="width:200px" class="input-text ">元  &nbsp;&nbsp;到&nbsp;&nbsp;  <input type="text" name='zuigao_<?php echo ($k); ?>' placeholder="" value="<?php echo ($zuigao[$k]); ?>" style="width:200px" class="input-text ">元 <br/></br><?php endforeach; endif; ?>
	  </td>
    </tr>

	<tr>
      <th class="text-r">超时未打款扣除上级奖金：</th><td><input type="text" name='fine' placeholder="" value="<?php echo ($setbonus["fine"]); ?>" style="width:800px" class="input-text fine"> 元 (从小到大，请用,号隔开 ，如果对应的值不够，默认都按最后一个值扣除。)</td>
    </tr>
	<tr>
      <th class="text-r">无操作空置账号奖金清零：</th><td><input type="text"  name='clearancetime' placeholder="" value="<?php echo ($setbonus["clearancetime"]); ?>" style="width:200px" class="input-text clearancetime">小时(必须填整数)</td>
    </tr>
	<tr>
      <th class="text-r">打款时间：</th><td><input type="text" name='playingtime' placeholder="" value="<?php echo ($setbonus["playingtime"]); ?>" style="width:200px" class="input-text playingtime">小时(必须填整数)</td>
    </tr>
	<tr>
      <th class="text-r">收款时间：</th><td><input type="text" name='collectiontime' placeholder="" value="<?php echo ($setbonus["collectiontime"]); ?>" style="width:200px" class="input-text collectiontime">小时(必须填整数)</td>
    </tr>
    <tr>
      <th class="text-r"></th><td><button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i>  确定</button></td>
    </tr> 
 
  </tbody>
</table>
</div>
	
</form>

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