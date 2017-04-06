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
<title>信件列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 信件管理<span class="c-gray en">&gt;</span> 信件列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form method="get" action="/index.php/Admin/Message/index.html">
<div class="pd-20">
  <div class="text-c">
  <label><input name="search_type" value="1" type="radio" <?php if($arr['search_type'] == 1): ?>checked='checked' <?php elseif($_GET['search_type']== 1): ?>checked='checked'<?php endif; ?>>不打款</label>&nbsp;
 <label><input name="search_type" value="2" type="radio" <?php if($arr['search_type'] == 2): ?>checked='checked' <?php elseif($_GET['search_type']== 2): ?>checked='checked'<?php endif; ?>>不确认</label>&nbsp;
 <label><input name="search_type" value="3" type="radio" <?php if($arr['search_type'] == 3): ?>checked='checked' <?php elseif($_GET['search_type']== 3): ?>checked='checked'<?php endif; ?>>其他</label>&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;
 日期范围：
    <input type="text" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" name='search_starttime' class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_starttime']); ?>">
    -
    <input type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" name='search_endtime' id="datemax" class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_endtime']); ?>">
    <input type="text" class="input-text" style="width:250px" placeholder="输入姓名" id="" value="<?php echo ($arr['search_username']); ?>" name="search_username" ><button type="submit" class="btn btn-success" id="" ><i class="Hui-iconfont">&#xe665;</i>搜索</button>

  </div>
  </form>
  <div class="cl pd-5 bg-1 bk-gray mt-20">
    <span class="l"><a href="javascript:;" onClick="message_datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i>  批量删除</a>
  </span>
    <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span>
  </div>
  <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
      <tr class="text-c">
        <th width="25"><input type="checkbox" ></th>
        <th width="80">ID</th>
		<th width="80">类型</th>
		<th width="">主题</th>
        <th width="100">账号</th>
		<th width="100">姓名</th>
        <th width="90">手机</th>
        <th width="130">加入时间</th>
        <th width="70">状态</th>
        <th width="100">操作</th>
      </tr>
    </thead>
    <tbody>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td><input type="checkbox" name="delid" value="<?php echo ($vo["id"]); ?>"></td>
        <td><?php echo ($i); ?></td> 
		<td><?php echo ($vo["type"]); ?></td>
		<td class="text-l"><?php echo ($vo["subject"]); ?></td>
		<td><?php echo ($vo["username"]); ?></td>
		<td><?php echo ($vo["name"]); ?></td>
        <td><?php echo ($vo["mobile"]); ?></td>
        <td><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
		<td><?php if($vo["status"] == 1): ?>未读<?php elseif($vo["status"] == 2): ?>未回复<?php else: ?>已回复<?php endif; ?></td>
        <td class="td-status"> <a title="查看" href="javascript:;" onClick="message_look('<?php echo ($vo["id"]); ?>','550','500','查看/回复','<?php echo U('Message/messageedit');?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe665;</i></a><a title="删除" href="javascript:;" onClick="message_del(this,<?php echo ($vo["id"]); ?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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