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
<title>编辑咨讯</title>
</head>
<body>
<div class="pd-20">
  <div class="Huiform">
 <form action="/index.php/Admin/Article/articleedit.html?id=11" >
      <table class="table table-bg">
        <tbody>
          <tr>
            <th class="text-r"><span class="c-red">*</span> 标题： </th>
            <td><input type="text" style="width:300px" class="input-text art_title"  value="<?php echo ($article_row["art_title"]); ?>"  placeholder="" id="user-name" name="art_title" datatype="*2-16" nullmsg="标题不能为空">作者：<input type="text" style="width:118px" class="input-text art_author"  value="<?php echo ($article_row["art_author"]); ?>" placeholder="" id="user-tel" name="art_author"> 
			<span class="c-red">*</span> 来源：
            <input type="text" style="width:118px" class="input-text art_source"  value="<?php echo ($article_row["art_source"]); ?>"  placeholder="" id="user-tel" name="">
				分类：
			 <select class="art_type" id="sel_Sub" name="art_type" onChange="SetSubID(this);" style='width:150px;height:31px;'>
			    <?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo1["id"]); ?>"><?php echo (htmlspecialchars_decode($vo1["art_class_name"])); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
          </tr>
         
          <tr>
            <th class="text-r">内容：</th>
            <td>
			<textarea id="editor"  style="width:900px;height:480px;" class='editor' ><?php echo (htmlspecialchars_decode($article_row["art_content"])); ?></textarea>
			</td>
          </tr>
          <tr>
            <th><input type='hidden' name='id' class='id' value='<?php echo ($id); ?>' ></th>
            <td><button class="btn btn-primary radius" type="button"  onclick='article_edit_save()'><i class="Hui-iconfont">&#xe632;</i> 保存</button></td>
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
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/H-ui/lib/My97DatePicker/WdatePicker.js"></script>  
<script type="text/javascript" src="/Public/H-ui/lib/webuploader/0.1.5/webuploader.min.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/ueditor/1.4.3/ueditor.config.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/ueditor/1.4.3/ueditor.all.min.js"> </script> 
<script type="text/javascript" src="/Public/H-ui/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
 var  ue=UE.getEditor('editor');
 
</script>