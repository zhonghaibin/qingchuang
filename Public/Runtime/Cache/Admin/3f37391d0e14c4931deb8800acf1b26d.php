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
<title>奖金收支明细</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 报告管理 <span class="c-gray en">&gt;</span> 奖金收支明细  <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form method="get" action="/index.php/Admin/Report/detailed.html">
<div class="pd-20">
  <div class="text-c">类型
  <span class="select-box" style='width:200px;'>
	<select name="search_type" class='select' value="">
	<option value="" >全部显示</option>
	<option value="1" <?php if($arr["search_type"] == 1): ?>selected<?php elseif($_GET['search_type']== 1): ?>selected<?php endif; ?>>现金钱袋</option>
    <option value="2" <?php if($arr["search_type"] == 2): ?>selected<?php elseif($_GET['search_type']== 2): ?>selected<?php endif; ?>>经理奖</option>
	<option value="3" <?php if($arr["search_type"] == 3): ?>selected<?php elseif($_GET['search_type']== 3): ?>selected<?php endif; ?>>推荐奖</option>
	
   </select></span>&nbsp;
	<label><input name="search_status" value="1" type="radio"  <?php if($arr["search_status"] == 1): ?>checked<?php endif; ?>>收入</label>&nbsp;
    <label><input name="search_status" value="2" type="radio"  <?php if($arr["search_status"] == 2): ?>checked<?php endif; ?>> 支出</label>&nbsp; &nbsp;  &nbsp; 
    日期范围：<input type="text" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" name='search_starttime' class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_starttime']); ?>">
    -
    <input type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" name='search_endtime' id="datemax" class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_endtime']); ?>">
    <input type="text" class="input-text" style="width:200px" placeholder="输入账号" id="" value="<?php echo ($arr['search_username']); ?>" name="search_username" ><button type="submit" class="btn btn-success" id="" ><i class="Hui-iconfont">&#xe665;</i> 搜索</button>

  </div>
  </form>
  <div class="cl pd-5 bg-1 bk-gray mt-20">
 
    <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span>
  </div>
  <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
      <tr class="text-c">
       
        <th width="30">ID</th>
		<th width="80">账号</th>
		<th width="60">种类</th>
        <th width="30">类型</th>
        <th width="">收入</th>
        <th width="">支出</th>
        <th width="">余额</th>
		<th width="">玩家账号</th>
		<th width="">玩家金额</th>
		<th width="">对比金额</th>
		<th width="">结算账号</th>
        <th width="">结算金额</th>
		<th width="50">结算比例</th>
		<th width="">描述</th>
		<th width="120">创建日期</th>
      </tr>
    </thead>
    <tbody>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td><?php echo ($i); ?></td>
		<td><?php echo ($vo["username"]); ?></td>
		<td><?php if($vo["type"] == 1): ?>现金钱袋<?php elseif($vo["type"] == 2): ?>经理奖<?php elseif($vo["type"] == 3): ?>推荐奖<?php endif; ?></td>
		<td><?php if($vo["status"] == 1): ?>收入<?php else: ?>支出<?php endif; ?></td>
        <td><?php echo ($vo["sum"]); ?></td>
        <td><?php echo ($vo["export"]); ?></td>
		<td><?php echo ($vo["balance"]); ?></td>
        <td><?php echo ($vo["fromname"]); ?></td>
        <td><?php echo ($vo["from_money"]); ?></td>
		<td><?php echo ($vo["recommend_money"]); ?></td>
		<td><?php echo ($vo["settlementname"]); ?></td>
        <td><?php echo ($vo["settlement_money"]); ?></td>
		<td><?php echo ($vo["from_scale"]); ?></td>
		<td><?php echo ($vo["explain"]); ?></td>
        <td class="user-status"><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></td>
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