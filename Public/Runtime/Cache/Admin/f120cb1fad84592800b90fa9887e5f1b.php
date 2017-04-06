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
<title>查看/回复</title>
</head>
<body>
<div class="pd-20">
  <div class="Huiform">
    <form action="/index.php/Admin/Message/messageedit.html?id=15" method="post">
      <table class="table table-bg">
        <tbody>
          <tr>
            <th width="100" class="text-r"> 账号：</th>
            <td><input type="text" style="width:300px" class="input-text" value="<?php echo ($userinfo["username"]); ?>" placeholder=""  ></td>
          </tr>
          <tr>
            <th class="text-r">主题：</th>
            <td><input type="text" style="width:300px" class="input-text" value="<?php echo ($message_row["subject"]); ?>" placeholder=""></td>
          </tr>
		  <tr>
            <th class="text-r">内容：</th>
            <td><textarea style="width:300px;height:100px;"><?php echo ($message_row["content"]); ?></textarea></td>
          </tr>
		  <tr>
            <th class="text-r">回复：</th>
            <td><textarea style="width:300px;height:100px;" name='reply' class='reply'><?php echo ($message_row["reply"]); ?></textarea></td>
          </tr>
          <tr>
            <th></th>
            <td><button  class="btn btn-primary radius" type="button" onclick='message_edit_save(<?php echo ($message_row["id"]); ?>)'><i class="Hui-iconfont">&#xe632;</i>  回 复</button></td>
          </tr>
        </tbody>
      </table>
    </form>
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