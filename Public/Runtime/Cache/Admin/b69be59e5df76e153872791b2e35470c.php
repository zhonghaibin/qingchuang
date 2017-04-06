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
<title> 奖励设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统设置 <span class="c-gray en">&gt;</span> 奖励设置 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
<form method="post" action="/index.php/Admin/Webconfig/setreward.html">

<table class="table table-border table-bordered table-hover table-bg">
  <tbody>

	<tr>
      <th class="text-r" width="200">会员级别：</th><td><input type="text"  placeholder="" name='level' value="<?php echo ($setreward['level']); ?>" style="width:500px" class="input-text level">用,号隔开，（从低到高）</td>
    </tr>
	<?php if($setreward['level'] != ''): ?><tr>
      <th class="text-r" >会员推荐奖设置:</th>
	  <td>
	  <?php if(is_array($level)): foreach($level as $key=>$level): ?>级别：
	  <input type="text" readonly="readonly"  value="<?php echo ($level); ?>" style="width:200px" class="input-text ">可以获得：
	  <input type="text"  placeholder="" name='<?php echo ($key); ?>' value="<?php echo ($dai[$key]); ?>" style="width:200px" class="input-text ">代<br/><br/><?php endforeach; endif; ?>
	  </td>
    </tr><?php endif; ?>
    <tr>
	<tr>
      <th class="text-r">会员推荐奖比例：</th><td><input type="text" name='recommendedaward' id="website-icp" placeholder="" value="<?php echo ($setreward['recommendedaward']); ?>" style="width:500px" class="input-text ">%  用,号隔开 </td>
    </tr>

	<tr>
      <th class="text-r" width="200">经理级别：</th><td><input type="text"  placeholder="" name='manager' value="<?php echo ($setreward['manager']); ?>" style="width:500px" class="input-text manager">用,号隔开，（从低到高）</td>
    </tr

	<tr>
      <th class="text-r">经理无限代提成比例：</th>
	  <td><input type="text"  placeholder="" name='managerbonus' value="<?php echo ($setreward['managerbonus']); ?>" style="width:500px" class="input-text ">% 用,号隔开，（从低到高）</td>
    </tr>
	<tr>
      <th class="text-r"></th><td><button  id="system-base-save" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i>  确定</button></td>
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