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
<title>系统匹配报告</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 报告管理 <span class="c-gray en">&gt;</span> 系统匹配报告<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form method="get" action="/index.php/Admin/Report/transaction.html?search_status=1&amp;search_starttime=&amp;search_endtime=&amp;token=dc6795069eee9b3c2f86296dc87c0018_79019532956756af0675a2030d02623e">
<div class="pd-20">
  <div class="text-c"> 
      
	<label><input name="search_status" value="1" type="radio"  <?php if($arr["search_status"] == 1): ?>checked <?php elseif($_GET['search_status']== 1): ?>checked<?php endif; ?>>等待付款</label>&nbsp;
    <label><input name="search_status" value="2" type="radio"  <?php if($arr["search_status"] == 2): ?>checked <?php elseif($_GET['search_status']== 2): ?>checked<?php endif; ?>> 等待确认</label>&nbsp; 
	<label><input name="search_status" value="3" type="radio"  <?php if($arr["search_status"] == 3): ?>checked <?php elseif($_GET['search_status']== 3): ?>checked<?php endif; ?>>交易完成</label>&nbsp; 
	<label><input name="search_status" value="4" type="radio"  <?php if($arr["search_status"] == 4): ?>checked <?php elseif($_GET['search_status']== 4): ?>checked<?php endif; ?>>拒绝</label>&nbsp;
	<label><input name="search_status" value="5" type="radio"  <?php if($arr["search_status"] == 5): ?>checked <?php elseif($_GET['search_status']== 5): ?>checked<?php endif; ?>>24小时过期</label>&nbsp;
	<label><input name="search_status" value="6" type="radio"  <?php if($arr["search_status"] == 6): ?>checked <?php elseif($_GET['search_status']== 6): ?>checked<?php endif; ?>>没确认过期</label>
	&nbsp;&nbsp;&nbsp;
    日期范围：<input type="text" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" name='search_starttime' class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_starttime']); ?>">
    -
    <input type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" name='search_endtime' id="datemax" class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_endtime']); ?>">
   <button type="submit" class="btn btn-success" id="" ><i class="Hui-iconfont">&#xe665;</i> 搜索</button>

  </div>
  </form>
  
  <div class="cl pd-5 bg-1 bk-gray mt-20">
 
    <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span>
  </div>
  <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
      <tr class="text-c">
      
        <th width="30">ID</th>
		<th width="115">流水号</th>
		<th width="115">舍-流水号</th>
		<th width="115">得-流水号</th>
        <th width="">舍-账号</th>
        <th width="">舍-姓名</th>
		<th width="">得-账号</th>
        <th width="">得-姓名</th>
        <th width="">本金</th>
        <th width="">状态</th>
		<th width="80">创建日期 </th>
		<?php if($arr["search_status"] == 3): ?><th width="160">完成日期 </th><?php endif; ?> 

         <?php if($arr["search_status"] == 1 or $arr["search_status"] == 2 or $arr["search_status"] == 4 or $arr["search_status"] == 5 or $arr["search_status"] == 6 ): ?><th width="160">操作</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
       
        <td><?php echo ($i); ?></td>
		<td><?php echo ($vo["cr_eg"]); ?></td>
		<td><?php echo ($vo["c_eg"]); ?></td>
		<td><?php echo ($vo["r_eg"]); ?></td>
		<td><?php echo ($vo["c_username"]); ?></td>
		<td><?php echo ($vo["c_name"]); ?></td>
		<td><?php echo ($vo["r_username"]); ?></td>
        <td><?php echo ($vo["r_name"]); ?></td>
        <td><?php echo ($vo["sum"]); ?></td>
		<td><?php echo ($status[$vo["status"]]); ?></td>
        <td><?php echo (date('Y-m-d',$vo["create_date"])); ?></td>
		<?php if($arr["search_status"] == 3): ?><td><?php echo (date('Y-m-d H:i:s',$vo["finish_date"])); ?></td><?php endif; ?> 
        <?php if($arr["search_status"] == 1 or $arr["search_status"] == 2 or $arr["search_status"] == 4 or $arr["search_status"] == 5 or $arr["search_status"] == 6 ): ?><td class="user-status"> 
		<a title="罚款推荐人" href="javascript:;" onClick="fine_recommend(<?php echo ($vo["recommend"]); ?>,<?php echo ($vo["c_user_id"]); ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6b7;</i> 罚款推荐人</a>	
		<a title="撤单" href="javascript:;" onClick="cr_del(this,<?php echo ($vo["id"]); ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe66b;</i>  取消订单</a>
		</td><?php endif; ?>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
  <div id="pageNav" class="pageNav"><?php echo ($page); ?></div>
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