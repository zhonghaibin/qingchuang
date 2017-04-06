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
<title>准经理组</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span class="c-gray en">&gt;</span>准经理组 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
<form method="get" action="/index.php/Admin/Member/manager.html">
	<div class="text-c"> 
		<label><input name="search_star" value="1" type="radio" <?php if($arr['search_star'] == 1): ?>checked='checked' <?php elseif($_GET['search_star']== 1): ?>checked='checked'<?php endif; ?>>M2</label>&nbsp;
		<label><input name="search_star" value="2" type="radio" <?php if($arr['search_star'] == 2): ?>checked='checked'<?php elseif($_GET['search_star']== 2): ?>checked='checked'<?php endif; ?>>&nbsp;&nbsp;M3</label>&nbsp;
		<label><input name="search_star" value="3" type="radio" <?php if($arr['search_star'] == 3): ?>checked='checked'<?php elseif($_GET['search_star']== 3): ?>checked='checked'<?php endif; ?>>&nbsp;&nbsp;经理</label>&nbsp;
		<label><input name="search_star" value="4" type="radio" <?php if($arr['search_star'] == 4): ?>checked='checked'<?php elseif($_GET['search_star']== 4): ?>checked='checked'<?php endif; ?>>&nbsp;&nbsp;高级</label>&nbsp;
		<label><input name="search_star" value="5" type="radio" <?php if($arr['search_star'] == 5): ?>checked='checked'<?php elseif($_GET['search_star']== 5): ?>checked='checked'<?php endif; ?>>&nbsp;&nbsp;总监</label>&nbsp;
		<label><input name="search_star" value="6" type="radio" <?php if($arr['search_star'] == 6): ?>checked='checked'<?php elseif($_GET['search_star']== 6): ?>checked='checked'<?php endif; ?>>&nbsp;&nbsp;董事</label>&nbsp;
		<button type="submit" class="btn btn-success" id="" ><i class="Hui-iconfont">&#xe665;</i> 搜 索</button> 
	</div>
</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
	<div class="mt-0">
	<table class="table table-border table-bordered table-hover table-bg ">
		<thead>
			<tr class="text-c">
			<th width="">ID</th>
			<th width="">账号</th>
			<th width="">姓名</th>
			<th width="">推荐人</th>
		    <th width="">推荐人姓名</th>
			<th width="">等级</th>
			<th width="">直线数</th>
			<th width="">直线数(实)</th>
			<th width="80">注册时间</th>
			<th width="30">状态</th>
			<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td><?php echo ($i); ?></td>
        <td class="text-l"><?php echo ($vo["username"]); ?></td>
		<td class="text-l"><?php echo ($vo["name"]); ?></td>
		<td class="text-l"><?php echo ($vo["recommend"]); ?></td>
		<td ><?php echo ($vo["recommendname"]); ?></td>
        <td><?php echo ($vo["star"]); ?></td>
		<td><?php echo ($vo["directnum"]); ?></td>
        <td><?php echo ($vo["truedirectnum"]); ?></td>
        <td><?php echo (date('Y-m-d ',$vo["regtime"])); ?></td>
		<?php if($vo["status"] == 3 ): ?><td class="td-status"><span  class="label">已冻结</span></td>
        <td class="f-14 td-manage">
		<?php elseif($vo["status"] == 2): ?>
		<td class="td-status"><span  class="label label-danger">已删除</span></td>
        <td class="f-14 td-manage">
		<?php else: ?>
		<td class="td-status"><span class="label label-success">已启用</span></td>
        <td class="f-14 td-manage"><?php endif; ?>
		<a title="编辑" href="javascript:;" onClick="manager_edit('<?php echo ($vo["id"]); ?>','600','200','修改用户等级','<?php echo U('Member/manageredit');?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
	    </td>
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