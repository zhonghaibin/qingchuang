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
<title>直推会员列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span class="c-gray en">&gt;</span> 直推会员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">


	<div class="mt-0">
	<table class="table table-border table-bordered table-hover table-bg ">
		<thead>
			<tr class="text-c">
			<th width="">ID</th>
			<th width="">账号</th>
			<th width="">姓名</th>
			<th width="">手机</th>
			<th width="">等级</th>
			<th width="">直线数</th>
			<th width="">组数</th>
			<th width="">直线数(实)</th>
			<th width="">组数(实)</th>
			<th width="50">现金钱袋</th>
			<th width="50">经理奖</th>
			<th width="50">推荐奖 </th>
			<th width="80">注册时间</th>
			<th width="30">状态</th>
			<th width="120">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td><?php echo ($i); ?></td>
        <td class="text-l"><u style="cursor:pointer" class="text-primary" onclick="user_show('<?php echo ($vo["id"]); ?>','360','500','<?php echo ($vo["username"]); ?>','<?php echo U('Member/usershow');?>')"><?php echo ($vo["username"]); ?></u></td>
		<td class="text-l"><u style="cursor:pointer" class="text-primary"><a href='<?php echo U("/Home/Login/back_login",array("m"=>base64_encode($vo["id"])));?>' target='_blank'><?php echo ($vo["name"]); ?></a></u></td>
		<td class="text-l"><?php echo ($vo["mobile"]); ?></td>
        <td><?php echo ($level[$vo['star']]); ?></td>
		<td><?php echo ($vo["directnum"]); ?></td>
		<td><?php echo ($vo["group"]); ?></td>
        <td><?php echo ($vo["truedirectnum"]); ?></td>
        <td><?php echo ($vo["truegroup"]); ?></td>
		<td><?php echo ($vo["cash"]); ?></td>
        <td><?php echo ($vo["activity"]); ?></td>
        <td><?php echo ($vo["frozen"]); ?></td>
        <td><?php echo (date('Y-m-d ',$vo["regtime"])); ?></td>
		<?php if($vo["status"] == 3 ): ?><td class="td-status"><span  class="label">已冻结</span></td>
        <td class="f-14 td-manage"><a style="text-decoration:none" onClick="user_start(this,'<?php echo ($vo["id"]); ?>')" href="javascript:;" title=""><i class="Hui-iconfont">&#xe631;</i></a>
		<?php elseif($vo["status"] == 2): ?>
		<td class="td-status"><span  class="label label-danger">已删除</span></td>
        <td class="f-14 td-manage"><a style="text-decoration:none" onClick="user_start(this,'<?php echo ($vo["id"]); ?>')" href="javascript:;" title=""><i class="Hui-iconfont">&#xe631;</i></a>
		<?php else: ?>
		<td class="td-status"><span class="label label-success">已启用</span></td>
        <td class="f-14 td-manage"><a style="text-decoration:none" onClick="user_stop(this,'<?php echo ($vo["id"]); ?>')" href="javascript:;" title=""><i class="Hui-iconfont">&#xe6e1;</i></a><?php endif; ?>
		<a title="编辑" href="javascript:;" onClick="user_edit('<?php echo ($vo["id"]); ?>','660','500','修改用户信息','<?php echo U('Member/useredit');?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
		<a style="text-decoration:none" class="ml-5" onClick="user_password_edit('<?php echo ($vo["id"]); ?>','400','250','修改密码','<?php echo U('Member/userpasswordedit');?>')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a>
		<a style="text-decoration:none" class="ml-5" onClick="user_towpassword_edit('<?php echo ($vo["id"]); ?>','400','250','修改二级密码','<?php echo U('Member/usertowpasswordedit');?>')" href="javascript:;" title="修改二级密码"><i class="Hui-iconfont">&#xe605;</i></a>
		<a title="删除" href="javascript:;" onClick="user_del(this,<?php echo ($vo["id"]); ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	 
	  </tbody>
	</table>  
	<div id="pageNav" class="pageNav"><?php echo ($page); ?></div>
	</div>
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