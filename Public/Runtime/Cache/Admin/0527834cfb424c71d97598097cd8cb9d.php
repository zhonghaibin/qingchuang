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
<title>角色编辑</title>
</head>
<body>
<div class="pd-20">
  <form class="Huiform" id="loginform" >
    <table class="table table-border table-bordered table-bg">
      <tbody>
        <tr>
          <th class="text-r" width="80">角色名称：</th>
          <td><input name="rolename" type="text" class="input-text rolename" id="" value="" datatype="*1-20" nullmsg="角色名称不能为空！"> 
          </td>
        </tr>
        <tr>
          <th class="text-r va-t" >权限：</th>
          <td>
            <table class="table table-border table-bordered table-bg">
              <tbody>
			  <?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><tr>
				<td  colspan='2'  style='font-weight:bold;font-size:13px;color:red;'><input name="power_id[]" type="checkbox" value="<?php echo ($vo1["id"]); ?>">&nbsp;&nbsp;<?php echo ($vo1["name"]); ?></td>
			  </tr>
			  <?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i; if($vo2[pid] == $vo1[id]): ?><tr>
					<th style='color:rgb(83, 1, 119);width: 100px;'><input name="power_id[]" type="checkbox" value="<?php echo ($vo2["id"]); ?>">&nbsp;&nbsp; <?php echo ($vo2["name"]); ?></th>
					<td class="permission-list" >
					<div class="cl">
					<?php if(is_array($list3)): $i = 0; $__LIST__ = $list3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($i % 2 );++$i; if($vo3[pid] == $vo2[id]): ?><label class="item"><input name="power_id[]" type="checkbox" value="<?php echo ($vo3["id"]); ?>">&nbsp;&nbsp; <?php echo ($vo3["name"]); ?></label><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
					</td>
                </tr><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
        <tr>
          <th class="text-r va-t">描述：</th>
          <td><textarea name="remarks" class="textarea remarks" id="newpassword" placeholder="描述下角色所具有的权限" style="width:400px; height:50px; resize:none"></textarea> 
          </td>
        </tr>
        
        <tr>
          <th></th>
          <td>
            <button type="button" onclick='admin_role_add_save()' class="btn btn-success radius" id="admin-role-save" ><i class="icon-ok"></i> 确定</button>
          </td>
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