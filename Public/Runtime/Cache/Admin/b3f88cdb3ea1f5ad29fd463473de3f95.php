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
<title>分类管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 资讯管理 <span class="c-gray en">&gt;</span> 分类管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20 text-c">
  <form class="Huiform" action="/index.php/Admin/Article/articleclass.html" method="post">
    上级栏目：
	<span class="select-box" style='width:200px;'>
    <select  class='select' id="sel_Sub" name="pid" onChange="SetSubID(this);">
      <option value="0">顶级分类</option>
	  <?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo1["id"]); ?>"><?php echo (htmlspecialchars_decode($vo1["art_class_name"])); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
	</span>
    <input type="hidden" id="hid_ccid" value="">
    <input class="input-text" style="width:250px" name='art_class_name' type="text" value="" placeholder="输入分类" id="article-class-val"><button type="submit" class="btn btn-primary" id="" name="" onClick="article_class_add(this);"><i class="Hui-iconfont">&#xe600;</i>添加</button>
  </form>
  <div class="article-class-list cl mt-20">
    <table class="table table-border table-bordered table-hover table-bg">
      <thead>
        <tr class="text-c">
          <th width="80">ID</th>
          <th>分类名称</th>
          <th width="70">操作</th>
        </tr>
      </thead>
      <tbody>
     <?php if(is_array($list3)): $i = 0; $__LIST__ = $list3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($i % 2 );++$i;?><tr class="text-c">
          <td><?php echo ($vo3["id"]); ?></td>
          <td class="text-l"><?php echo (htmlspecialchars_decode($vo3["art_class_name"])); ?></td>
          <td class="f-14"><a title="编辑" href="javascript:;" onClick="article_class_edit('<?php echo ($vo3["id"]); ?>','500','200','分类编辑','<?php echo U('Article/articleclassedit');?>')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onClick="article_class_del(this,'<?php echo ($vo3["id"]); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
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