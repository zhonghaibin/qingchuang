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
<title>系统匹配列表</title>
</head>
<body> 
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 匹配管理 <span class="c-gray en">&gt;</span> 系统匹配列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">

  <table class="table table-border table-bordered table-bg  table-sort" >
  <form method="post" action="/index.php/Admin/Text/index.html">
  <tr>
	<td  style='text-align:center;width:50%'>提供赞助：  日期范围: <input type="text" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;"
	value="<?php echo ($arr['search_starttime_c']); ?>" name='search_starttime_c' >
    -
    <input type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;"  name='search_endtime_c' value="<?php echo ($arr['search_endtime_c']); ?>">

	
	</td>
	<td style='text-align:center;width:50%'>申请赞助：  日期范围: 
	<input type="text" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;" value="<?php echo ($arr['search_starttime_r']); ?>" name='search_starttime_r' >
    -
    <input type="text" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;"  name='search_endtime_r' value="<?php echo ($arr['search_endtime_r']); ?>">&nbsp;<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i>搜索</button>
	</td>
  </tr></form>
  <tr>
	<td ><span class="r">共有数据：<strong><?php echo ($count_c); ?></strong> 条</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span class='c_tip'></span>&nbsp;
	<span class="l">共有：<strong><?php echo ($sum_c); ?></strong> 金额</span></td>
	<td ><span class="r">共有数据：<strong><?php echo ($count_r); ?></strong> 条</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span class='r_tip'>&nbsp;</span><span class="l">共有：<strong><?php echo ($sum_r); ?></strong> 金额</span></td>
  </tr>
  <tr>
  <form method="post" action="/index.php/Admin/Text/index.html">

	<td style='vertical-align: top;'>
	<table class="table table-border table-bordered table-bg table-hover table-sort" >
      <tr class="text-c">
        <th><input name="" type="checkbox" class='c_check' onclick="All(this,'c_id[]')" value=""></th>
        <th>ID</th> 
		<th>账号</th>
		<th>星级</th>
        <th>用户名</th>
        <th>金额</th>
        <th>剩余金额</th>
        <th>创建时间</th>
      </tr>
 
    <tbody>
	<?php if(is_array($list_c)): $i = 0; $__LIST__ = $list_c;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td><input name="c_id[]" type="checkbox" value="<?php echo ($vo["id"]); ?>" class='c_check'></td>
        <td><?php echo ($vo["id"]); ?></td>
        <td><?php echo ($vo["username"]); ?></td> 
		<td><?php echo ($vo["stars"]); ?></td>
		<td><?php echo ($vo["name"]); ?></td>
        <td><?php echo ($vo["money"]); ?></td>
        <td><?php echo ($vo["sum"]); ?></td>
        <td><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
	</td>
	<td style=' vertical-align: top'>
	<table class="table table-border table-bordered table-bg table-hover table-sort"  >
    
      <tr class="text-c">
        <th><input name="" type="checkbox" value=""  onclick="All(this,'r_id[]')" class='r_check'></th>
        <th>ID</th>
		<th>账号</th>
		<th>星级</th>
        <th>用户名</th>
        <th>金额</th>
        <th>剩余金额</th>
        <th>创建时间</th>
      </tr>
   
    <tbody>
	<?php if(is_array($list_r)): $i = 0; $__LIST__ = $list_r;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="text-c">
        <td><input name="r_id[]" type="checkbox" value="<?php echo ($vo["id"]); ?>" class='r_check'></td>
        <td><?php echo ($vo["id"]); ?></td> 
		<td><?php echo ($vo["username"]); ?></td>
		<td><?php echo ($vo["stars"]); ?></td> 
		<td><?php echo ($vo["name"]); ?></td>
        <td><?php echo ($vo["money"]); ?></td>
        <td><?php echo ($vo["sum"]); ?></td>
        <td><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
	</td>
  </tr>
  <tr>
  <input type='hidden' name='flag' value='matching'>
	<td colspan='2' style='text-align:center;'><button name="" id="button" class="btn btn-success" type="submit">提交</button></td>
  </tr>
  </table>
   
</div>

	
</form>

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
<script type="text/javascript">
	function All(e, itemName){
		var aa = document.getElementsByName(itemName);
	    for (var i=0; i<aa.length; i++)
	    aa[i].checked = e.checked; //得到那个总控的复选框的选中状态
	}
	function Item(e, allName){
		var all = document.getElementsByName(allName)[0];
		if(!e.checked) all.checked = false;
		else{
			var aa = document.getElementsByName(e.name);
			for (var i=0; i<aa.length; i++)
			if(!aa[i].checked) return;
			all.checked = true;
		}
	}
	$(function(){
      $(".c_check").click(function() {  
      var c_check= $("input[name='c_id[]']:checked").serialize();
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Text/c_check_sum", 
				data: {c_check:c_check}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					$('.c_tip').html("<span style='color:#d00000;width:auto;'>"+data.msg+"</span>");
				}
				});


      });  
	 $(".r_check").click(function() {  
		var r_check= $("input[name='r_id[]']:checked").serialize();
		$.ajax({ 
				type:"get", 
				url:"/Admin/Text/r_check_sum", 
				data: {r_check:r_check}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					$('.r_tip').html("<span style='color:#d00000;width:auto;'>"+data.msg+"</span>");
				}
				});


      });


		
	  	$("#button").click(function(){

		if($("#button").css("display")=="none"){

		$("#button").show();

		}else{

		 $("#button").hide();
				
				layer.msg('请不要刷新页面，等待页面自动跳转',{icon: 1,time:5500}); 		
				

		}

		});

});  
</script>