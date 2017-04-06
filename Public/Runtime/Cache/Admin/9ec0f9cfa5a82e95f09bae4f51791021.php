<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
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
<link rel="stylesheet" href="/Public/H-ui/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">

<title>关系列表</title>
</head>
<body class="pos-r">
<div class="pos-a" style="width:150px;left:0;top:0; bottom:0; height:100%; border-right:1px solid #e5e5e5; background-color:#f5f5f5">
	<ul id="treeDemo" class="ztree">
	</ul>
</div>
<div style="margin-left:150px;">
	
	<table class="table">
	<tr>
		<td class="va-t"><IFRAME ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width='100% ' height='800px' SRC="<?php echo U('Member/usertreeinfo');?>"></IFRAME></td>
	</tr>
</table>

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
<script type="text/javascript" src="/Public/H-ui/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script> 
<script type="text/javascript" src="/Public/H-ui/lib/zTree/v3/js/jquery.ztree.core-3.5.js"></script>
<!--
<script type="text/javascript">
var setting = {
	view: {
		dblClickExpand: false,
		showLine: true,
		selectedMulti: false

	},
	data: {
		simpleData: {
			enable:true,
			idKey: "id",
			pIdKey: "pId",
			rootPId: ""
		}
	},
	callback: {
		beforeClick: function(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
				demoIframe.attr("src",treeNode.file );
				return true;
			
		}
	}
	
};

 var zNodes;//数据变量              
//ajax提交数据，请求后台PHP处理返回出目录结构json数据
$.ajax({
	url:"/Admin/Member/usertree",
	type: "post",
	async: false,
	dataType:"json",  
	success: function (data) {
			//alert(data);
			zNodes=data;    //将请求返回的数据存起来
			 //alert(zNodes);
	},
	error: function (){//请求失败处理函数  
		alert('请求失败');  
	},  
})

var code;
		
function showCode(str) {
	if (!code) code = $("#code");
	code.empty();
	code.append("<li>"+str+"</li>");
}
		
$(document).ready(function(){
	var t = $("#treeDemo");
	t = $.fn.zTree.init(t, setting, zNodes);
	demoIframe = $("#testIframe");
	demoIframe.bind("load", loadReady);
	var zTree = $.fn.zTree.getZTreeObj("tree");
	zTree.selectNode(zTree.getNodeByParam("id",'11'));
});
</script>-->
<SCRIPT type="text/javascript">
				
		  var setting = {
		
			async: {
				enable: true,
				url:"/Admin/Member/mytree",
				autoParam:["id", "name=n", "level=lv"],
				otherParam:{"otherParam":"zTreeAsyncTest"},
				dataFilter: filter,
				type:'post',
				
			},callback: {
		beforeClick: function(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
				demoIframe.attr("src",treeNode.file );
				return true;
			
		}
	}
			
			

		};

		function filter(treeId, parentNode, childNodes) {
		if (!childNodes) return null;
			for (var i=0, l=childNodes.length; i<l; i++) {
				childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
			}
			return childNodes;
		}
		

		$(document).ready(function(){
			var t = $("#treeDemo");
			t = $.fn.zTree.init(t, setting);
			demoIframe = $("#testIframe");
			demoIframe.bind("load", loadReady);
			var zTree = $.fn.zTree.getZTreeObj("tree");
			
		});

		
	</SCRIPT>
</body>
</html>