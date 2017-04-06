/* -----------H-ui前端框架-------------
* H-ui.admin.js v2.4
* http://www.h-ui.net/
* Created & Modified by guojunhui
* Date modified 15:42 2016.03.14
*
* Copyright 2013-2016 北京颖杰联创科技有限公司 All rights reserved.
* Licensed under MIT license.
* http://opensource.org/licenses/MIT
*
*/
var num=0,oUl=$("#min_title_list"),hide_nav=$("#Hui-tabNav");

/*获取顶部选项卡总长度*/
function tabNavallwidth(){
	var taballwidth=0,
		$tabNav = hide_nav.find(".acrossTab"),
		$tabNavWp = hide_nav.find(".Hui-tabNav-wp"),
		$tabNavitem = hide_nav.find(".acrossTab li"),
		$tabNavmore =hide_nav.find(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))
    });
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})
	}
}

/*左侧菜单响应式*/
function Huiasidedisplay(){
	if($(window).width()>=768){
		$(".Hui-aside").show()
	} 
}
function getskincookie(){
	var v = getCookie("Huiskin");
	var hrefStr=$("#skin").attr("href");
	if(v==null||v==""){
		v="default";
	}
	if(hrefStr!=undefined){
		var hrefRes=hrefStr.substring(0,hrefStr.lastIndexOf('skin/'))+'skin/'+v+'/skin.css';
		$("#skin").attr("href",hrefRes);
	}
}
function Hui_admin_tab(obj){
	if($(obj).attr('_href')){
		var bStop=false;
		var bStopIndex=0;
		var _href=$(obj).attr('_href');
		var _titleName=$(obj).attr("data-title");
		var topWindow=$(window.parent.document);
		var show_navLi=topWindow.find("#min_title_list li");
		show_navLi.each(function() {
			if($(this).find('span').attr("data-href")==_href){
				bStop=true;
				bStopIndex=show_navLi.index($(this));
				return false;
			}
		});
		if(!bStop){
			creatIframe(_href,_titleName);
			min_titleList();
		}
		else{
			show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
			var iframe_box=topWindow.find("#iframe_box");
			iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src",_href);
		}
	}

}
function min_titleList(){
	var topWindow=$(window.parent.document);
	var show_nav=topWindow.find("#min_title_list");
	var aLi=show_nav.find("li");
};
function creatIframe(href,titleName){
	var topWindow=$(window.parent.document);
	var show_nav=topWindow.find('#min_title_list');
	show_nav.find('li').removeClass("active");
	var iframe_box=topWindow.find('#iframe_box');
	show_nav.append('<li class="active"><span data-href="'+href+'">'+titleName+'</span><i></i><em></em></li>');
	var taballwidth=0,
		$tabNav = topWindow.find(".acrossTab"),
		$tabNavWp = topWindow.find(".Hui-tabNav-wp"),
		$tabNavitem = topWindow.find(".acrossTab li"),
		$tabNavmore =topWindow.find(".Hui-tabNav-more");
	if (!$tabNav[0]){return}
	$tabNavitem.each(function(index, element) {
        taballwidth+=Number(parseFloat($(this).width()+60))
    });
	$tabNav.width(taballwidth+25);
	var w = $tabNavWp.width();
	if(taballwidth+25>w){
		$tabNavmore.show()}
	else{
		$tabNavmore.hide();
		$tabNav.css({left:0})
	}
	var iframeBox=iframe_box.find('.show_iframe');
	iframeBox.hide();
	iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src='+href+'></iframe></div>');
	var showBox=iframe_box.find('.show_iframe:visible');
	showBox.find('iframe').load(function(){
		showBox.find('.loading').hide();
	});
}
function removeIframe(){
	var topWindow = $(window.parent.document);
	var iframe = topWindow.find('#iframe_box .show_iframe');
	var tab = topWindow.find(".acrossTab li");
	var showTab = topWindow.find(".acrossTab li.active");
	var showBox=topWindow.find('.show_iframe:visible');
	var i = showTab.index();
	tab.eq(i-1).addClass("active");
	iframe.eq(i-1).show();
	tab.eq(i).remove();
	iframe.eq(i).remove();
}
/*弹出层*/
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
function layer_show(w,h,title,url){
	if (title == null || title == '') {
		title=false;
	};
	if (url == null || url == '') {
		url="404.html";
	};
	if (w == null || w == '') {
		w=800;
	};
	if (h == null || h == '') {
		h=($(window).height() - 50);
	};
	layer.open({
		type: 2,
		area: [w+'px', h +'px'],
		fix: false, //不固定
		maxmin: true,
		shade:0.4,
		title: title,
		content: url
	});
}


/*关闭弹出框口*/
function layer_close(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}
$(function(){
	getskincookie();
	//layer.config({extend: 'extend/layer.ext.js'});
	Huiasidedisplay();
	var resizeID;
	$(window).resize(function(){
		clearTimeout(resizeID);
		resizeID = setTimeout(function(){
			Huiasidedisplay();
		},500);
	});
	
	$(".nav-toggle").click(function(){
		$(".Hui-aside").slideToggle();
	});
	$(".Hui-aside").on("click",".menu_dropdown dd li a",function(){
		if($(window).width()<768){
			$(".Hui-aside").slideToggle();
		}
	});
	/*左侧菜单*/
	$.Huifold(".menu_dropdown dl dt",".menu_dropdown dl dd","fast",1,"click");
	/*选项卡导航*/

	$(".Hui-aside").on("click",".menu_dropdown a",function(){
		Hui_admin_tab(this);
	});
	
	$(document).on("click","#min_title_list li",function(){
		var bStopIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		$("#min_title_list li").removeClass("active").eq(bStopIndex).addClass("active");
		iframe_box.find(".show_iframe").hide().eq(bStopIndex).show();
	});
	$(document).on("click","#min_title_list li i",function(){
		var aCloseIndex=$(this).parents("li").index();
		$(this).parent().remove();
		$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
		num==0?num=0:num--;
		tabNavallwidth();
	});
	$(document).on("dblclick","#min_title_list li",function(){
		var aCloseIndex=$(this).index();
		var iframe_box=$("#iframe_box");
		if(aCloseIndex>0){
			$(this).remove();
			$('#iframe_box').find('.show_iframe').eq(aCloseIndex).remove();	
			num==0?num=0:num--;
			$("#min_title_list li").removeClass("active").eq(aCloseIndex-1).addClass("active");
			iframe_box.find(".show_iframe").hide().eq(aCloseIndex-1).show();
			tabNavallwidth();
		}else{
			return false;
		}
	});
	tabNavallwidth();
	
	$('#js-tabNav-next').click(function(){
		num==oUl.find('li').length-1?num=oUl.find('li').length-1:num++;
		toNavPos();
	});
	$('#js-tabNav-prev').click(function(){
		num==0?num=0:num--;
		toNavPos();
	});
	
	function toNavPos(){
		oUl.stop().animate({'left':-num*100},100);
	}
	
	/*换肤*/
	$("#Hui-skin .dropDown-menu a").click(function(){
		var v = $(this).attr("data-val");
		setCookie("Huiskin", v);
		var hrefStr=$("#skin").attr("href");
		var hrefRes=hrefStr.substring(0,hrefStr.lastIndexOf('skin/'))+'skin/'+v+'/skin.css';
		
		$(window.frames.document).contents().find("#skin").attr("href",hrefRes);
		//$("#skin").attr("href",hrefResd);
	});
}); 


//myjs

/*批量删除 用户*/
function datadel_admin(){
	layer.confirm('确认要删除吗？',function(index){
	 var str="";
	$('input[name="delid"]:checked').each(function(){
       str += $(this).val()+","
      });
	 
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/datadel_admin", 
				data: {str:str}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){
					
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:2000});
						 location.replace(location.href);
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});



	});
}

/*批量删除 角色*/
function datadel_role(){
	layer.confirm('确认要删除吗？',function(index){
	 var str="";
	$('input[name="delid_role"]:checked').each(function(){
       str += $(this).val()+","
      });

	 
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/datadel_role", 
				data: {str:str}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{    layer.msg(data.msg,{icon: 1,time:2000});
						 location.replace(location.href);
					}
					else
					{ layer.msg(data.msg,{icon: 2,time:2000});
						
					}
				 
				} 
			});



	});
}
/*批量删除 节点*/
function datadel_power(){
	layer.confirm('确认要删除吗？',function(index){
	 var str="";
	$('input[name="delid_power"]:checked').each(function(){
       str += $(this).val()+","
      });

	 
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/datadel_power", 
				data: {str:str}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{    layer.msg(data.msg,{icon: 1,time:2000});
						 location.replace(location.href);
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
						
					}
				 
				} 
			});



	});
}




/*留言-删除*/
function message_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Message/message_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });
}
//留言 批量删除
function message_datadel()
{
	layer.confirm('确认要删除吗？',function(index){
	 var str="";
	$('input[name="delid"]:checked').each(function(){
       str += $(this).val()+","
      });
	 
		$.ajax({ 
				type:"get", 
				url:"/Admin/Message/datadel_message", 
				data: {str:str}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){
					
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:2000});
						 location.replace(location.href);
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});



	});
}

//留言-编辑
function message_look(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	


}
//回复留言
function message_edit_save(id)
{

	var reply=$('.reply').val();
	$.ajax({ 
			type:"post", 
			url:"/Admin/Message/messageedit", 
			data: {reply:reply,id:id}, 
			dataType: 'json', 
			async : false,//设置为同步操作就可以给全局变量赋值成功 
			success:function(data){ 
			 if(data.status==1)
				{
					
					 layer.msg(data.msg,{icon: 1,time:2000},function(){
					 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
					 parent.location.reload();
					 parent.layer.close(index); 
					 
					 });
					
				}
				else
				{
					layer.msg(data.msg,{icon: 2,time:2000});
				}
			 
			} 
		});


}


/*----------用户管理------------------*/
/*用户-添加*/



function user_add(w,h,title,url){
	layer_show(w,h,title,url);
}
function user_add_save()
{
		
		var name=$('.name').val();
		var alipay=$('.alipay').val();
		var mobile=$('.mobile').val();
		var password=$('.password').val();
		var bankno=$('.bankno').val();
		var bank=$('.bank').val();
		var towlevelpassword=$('.towlevelpassword').val();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Member/useradd", 
				data: {bank:bank,bankno:bankno,alipay:alipay,mobile:mobile,password:password,name:name,towlevelpassword:towlevelpassword}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
						
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
}


/*用户-查看*/
function user_show(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}
/*用户-密码-修改*/
function user_password_edit(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}
//
function user_password_save(id,w,h,title,url)
{
		var newpassword=$('.newpassword').val();
		var repassword=$('.repassword').val();
		 if (!newpassword) {
                $('.newpwd_tip').html('请输入密码');
                return false;
            } else {
			 if (newpassword.length<6 || newpassword.length>12) {
				$('.newpwd_tip').html('请输入6-12位数的密码!');
				return false;
				} else {
				$('.newpwd_tip').html('');
				}
					
            }
			
           
			if (!repassword) {
                $('.repwd_tip').html('请再次输入密码');
                return false;
            } else {
                 if (repassword.length<6 ||　repassword.length>12) {
                $('.repwd_tip').html('请输入6-12位数的密码!');
                return false;
				 } else {
                $('.repwd_tip').html('');
				}
            }
           
			if(repassword!=newpassword)
			{
				 $('.repwd_tip').html('两次密码不一致!');
                return false;
			}

			$.ajax({ 
				type:"post", 
				url:"/Admin/Member/userpasswordedit", 
				data: {id:id,newpassword:newpassword}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{ 
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
}
/*用户-密码-修改*/
function user_towpassword_edit(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}
//二级密码
function user_towpassword_save(id,w,h,title,url)
{
		var townewpassword=$('.townewpassword').val();
		var towrepassword=$('.towrepassword').val();
		 if (!townewpassword) {
                $('.townewpwd_tip').html('请输入密码');
                return false;
            } else {
			 if (townewpassword.length<6 || townewpassword.length>12) {
				$('.townewpwd_tip').html('请输入6-12位数的二级密码!');
				return false;
				} else {
				$('.townewpwd_tip').html('');
				}
					
            }
			
           
			if (!towrepassword) {
                $('.repwd_tip').html('请再次输入二级密码');
                return false;
            } else {
                 if (towrepassword.length<6 ||　towrepassword.length>12) {
                $('.towrepwd_tip').html('请输入6-12位数的二级密码!');
                return false;
				 } else {
                $('.towrepwd_tip').html('');
				}
            }
           
			if(towrepassword!=townewpassword)
			{
				 $('.towrepwd_tip').html('两次密码不一致!');
                return false;
			}

			$.ajax({ 
				type:"post", 
				url:"/Admin/Member/usertowpasswordedit", 
				data: {id:id,townewpassword:townewpassword}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{ 
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
}
/*用户-编辑*/
function user_edit(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	


}
function manager_edit(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	


}
/*等级-编辑-保存*/
function manager_edit_save(id){

		var star=$('.star').val();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Member/manageredit", 
				data: {star:star,id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

}
/*用户-编辑-保存*/
function user_edit_save(id){

	
		var name=$('.name').val();
		var alipay=$('.alipay').val();
		var mobile=$('.mobile').val();
		var bank=$('.bank').val();
		var bankno=$('.bankno').val();
		var star=$('.star').val();
		var stars=$('.stars').val();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Member/useredit", 
				data: {star:star,bank:bank,bankno:bankno,id:id,alipay:alipay,mobile:mobile,name:name,stars:stars}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

}

/*用户-停用*/
function user_stop(obj,id){
	$.ajax({ 
				type:"get", 
				url:"/Admin/Member/user_stop", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="user_start(this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe631;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label">已冻结</span>');
					 $(obj).remove();

					}
					else
					{
					   layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

	
}
/*用户-启用*/
function user_start(obj,id){
	$.ajax({ 
				type:"get", 
				url:"/Admin/Member/user_start", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="user_stop(this,'+id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label label-success">已启用</span>');
					 $(obj).remove();
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});
}
/*用户-删除*/
function user_del(obj,id,w,h){
	layer.confirm('用户删除须谨慎，确认要删除吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Member/user_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon:1,time:2000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });
}
/*奖金-删除*/
function bonus_del(obj,id,w,h){
	layer.confirm('清空奖金后不能恢复，你确认要清空吗？',function(index){
	  
		$.ajax({ 
				type:"post", 
				url:"/Admin/Member/bonus_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 
						 $(obj).parents("tr").remove(); 
						 layer.msg(data.msg,{icon:1,time:2000});
						
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });
}
/*------------资讯管理----------------*/
/*获取分类值*/
function SetSubID(obj) {
	$("#hid_ccid").val($(obj).val());
}
/*资讯-分类-添加*/
function article_class_add(obj){
	var v = $("#article-class-val").val();
	if(v==""||v==null){
		return false;
	}else{
		//ajax请求 添加分类
	}
}
/*咨讯-分类-删除*/
function article_class_del(obj,id){
	layer.confirm('删除须谨慎，确认要删除吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Article/article_class_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });
}

//保存分类修改
function class_save(id){

		 
		var pid=$('.pid').val();
		var art_class_name=$('.art_class_name').val();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Article/articleclassedit", 
				data: {id:id,pid:pid,art_class_name:art_class_name}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

}
/*资讯-分类-编辑*/
function article_class_edit(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}
/*资讯-添加*/
function article_add(w,h,title,url){
	layer_show(w,h,title,url);
}
function article_add_save()
{
		
		var art_title=$('.art_title').val();
		var art_source=$('.art_source').val();
		var art_author=$('.art_author').val();
		var art_type=$('.art_type').val();
		var editorvalue=UE.getEditor('editor').getContent();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Article/articleadd", 
				data: {art_title:art_title,art_source:art_source,art_author:art_author,art_type:art_type,editorvalue:editorvalue}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index= parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						parent.layer.close(index);
						
						 
						 });
						 
						
						
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});
}
/*资讯-编辑*/
function article_edit(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}
function article_edit_save(){
		var id=$('.id').val();
		var art_title=$('.art_title').val();
		var art_source=$('.art_source').val();
		var art_author=$('.art_author').val();
		var art_type=$('.art_type').val();
		var editorvalue=UE.getEditor('editor').getContent();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Article/articleedit", 
				data: {id:id,art_title:art_title,art_source:art_source,art_author:art_author,art_type:art_type,editorvalue:editorvalue}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index= parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						parent.layer.close(index);
						
						 
						 });
						 
						
						
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});
}

//咨询-查看
function article_zhang(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}
/*资讯-下架*/
function article_xiajia(obj,id){
			
				$.ajax({ 
				type:"get", 
				url:"/Admin/Article/article_stop", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.art_status==1)
					{
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_fabu(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe631;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label">已下架</span>');
					 $(obj).remove();
					}
					else
					{
					layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

	
}
/*资讯-发布*/
function article_fabu(obj,id){

			$.ajax({ 
				type:"get", 
				url:"/Admin/Article/article_start", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.art_status==1)
					{
					$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_xiajia(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6e1;</i></a>');
					$(obj).parents("tr").find(".td-status").html('<span class="label label-success">已发布</span>');
					$(obj).remove();
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
	
}
/*咨讯-删除*/
function article_del(obj,id){
	layer.confirm('文章删除须谨慎，确认要删除吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Article/article_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });
}
/*咨询批量-删除*/
function article_datadel()
{
	layer.confirm('确认要删除吗？',function(index){
	 var str="";
	$('input[name="delid"]:checked').each(function(){
       str += $(this).val()+","
      });
	 
		$.ajax({ 
				type:"get", 
				url:"/Admin/Article/datadel_article", 
				data: {str:str}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){
					
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:2000});
						 location.replace(location.href);
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});



	});
}
/*管理员-密码-修改*/
function admin_password_edit(id,w,h,title,url){


	layer_show(w,h,title,url+'?id='+id);
}
function admin_password_save(id){



		var newpassword=$('.newpassword').val();
		var repassword=$('.repassword').val();
		var code=$('.code').val();
		 if (!newpassword) {
                $('.newpwd_tip').html('请输入密码');
                return false;
            } else {
			 if (newpassword.length<6 || newpassword.length>12) {
				$('.newpwd_tip').html('请输入6-12位数的密码!');
				return false;
				} else {
				$('.newpwd_tip').html('');
				}
					
            }
			
           
			if (!repassword) {
                $('.repwd_tip').html('请再次输入密码');
                return false;
            } else {
                 if (repassword.length<6 ||　repassword.length>12) {
                $('.repwd_tip').html('请输入6-12位数的密码!');
                return false;
				 } else {
                $('.repwd_tip').html('');
				}
            }
           
			if(repassword!=newpassword)
			{
				 $('.repwd_tip').html('两次密码不一致!');
                return false;
			}
			if (!code) {
                $('.code_tip').html('请输入短信验证码');
                return false;
            } else {
                 if (code.length!=6) {
                $('.code_tip').html('请输入6位数的短信验证码!');
                return false;
				 } else {
                $('.code_tip').html('');
				}
            }

			$.ajax({ 
				type:"post", 
				url:"/Admin/Rbac/adminpasswordedit", 
				data: {id:id,newpassword:newpassword,code:code}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{ 
						  layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
	
}


/*------------图片库--------------*/
/*图片库-分类-添加*/
function picture_class_add(obj){
	var v = $("#picture-class-val").val();
	if(v==""||v==null){
		return false;
	}else{
		//ajax请求 添加分类
	}
}

/*图片库-分类-编辑*/
function picture_class_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*图片库-添加*/
function picture_add(w,h,title,url)
{
	layer_show(w,h,title,url);
}

function picture_add_save(w,h,title,url){
		var src=$('.src').val();
		var title=$('.title').val();
		var tage=$('.tage').val();
		var href=$('.href').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Picture/pictureadd", 
				data: {src:src,title:title,tage:tage,href:href}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg('添加成功',{icon: 1,time:2000});
						
					}
					else
					{
						layer.msg('添加失败',{icon: 2,time:2000});
					}
				 
				} 
			});
}
/*图片库-编辑*/
function picture_edit(id,w,h,title,url){
	layer_show(w,h,title,url+'?id='+id);
}

/*图片库-下架*/
function picture_xiajia(obj,id){
	$.ajax({ 
				type:"get", 
				url:"/Admin/Picture/picture_stop", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_fabu(this,'+id+')" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe631;</i></a>');
					$(obj).parents("tr").find(".td-status").html('<span class="label">已下架</span>');
					$(obj).remove();
					}
					else
					{
					layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});

	
}
/*图片库-发布*/
function picture_fabu(obj,id){
	$.ajax({ 
				type:"get", 
				url:"/Admin/Picture/picture_start", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					
						$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_xiajia(this,'+id+')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6e1;</i></a>');
						$(obj).parents("tr").find(".td-status").html('<span class="label label-success">已发布</span>');
						$(obj).remove();
					}
					else
					{
					layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});


}
/*图片-删除*/
function picture_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Picture/picture_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});
  });
}

function datadel_picture()
{
	
	layer.confirm('确认要删除吗？',function(index){
	 var str="";
	$('input[name="delid"]:checked').each(function(){
       str += $(this).val()+","
      });
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Picture/datadel_picture", 
				data: {str:str}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){
				
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:2000});
						 location.replace(location.href);
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
	});
}
/*------------管理员管理--------------*/
/*管理员-角色-添加*/
function admin_role_add(w,h,title,url){
	layer_show(w,h,title,url);
}
function admin_role_add_save(){
	var text='';    
	  $('input[name="power_id[]"]:checked').each(function(){    
	    text += ","+$(this).val(); 
	  });   
	
	 var rolename=$('.rolename').val();
	 var remarks=$('.remarks').val();
	
		$.ajax({ 
				type:"post", 
				url:"/Admin/Rbac/adminroleadd", 
				data: {powerid:text,remarks:remarks,rolename:rolename}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
						
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
	

}
/*管理员-角色-编辑*/
function admin_role_edit(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	
}

function admin_role_edit_save(){
	var text='';    
	  $('input[name="power_id[]"]:checked').each(function(){    
	    text += ","+$(this).val(); 
	  });   
	 var id=$('.id').val();
	 var rolename=$('.rolename').val();
	 var remarks=$('.remarks').val();
	
		$.ajax({ 
				type:"post", 
				url:"/Admin/Rbac/adminroleedit", 
				data: {id:id,powerid:text,remarks:remarks,rolename:rolename}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
						
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
	

}


function admin_add()
{
	$('.Huiform').submit();
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	
layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
	
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/admin_role_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
					 layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });
}

/*管理员-权限-添加*/
function admin_permission_add(){
	$('.Huiform').submit();
}
/*管理员-权限-编辑*/
function admin_permission_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){

layer.confirm('节点删除须谨慎，确认要删除吗？',function(index){
	
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
					
				 
				} 
			});
  });

}
//编辑节点资料
function power_edit(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	


}
//保存节点资料
function power_edit_save(id){

		var name=$('.name').val();
		var control_action=$('.control_action').val();
		var pid=$('.pid').val();
		var sort=$('.sort').val();
		var level=$('.level').val();
		var style=$('.style').val();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Rbac/poweredit", 
				data: {id:id,name:name,control_action:control_action,pid:pid,sort:sort,level:level,style:style}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

}
/*管理员-编辑-保存*/
//function admin_edit_save(obj,id){
//	var i = parent.layer.getFrameIndex();

//	parent.layer.close(i);
//}
//编辑管理员资料
function admin_edit(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	


}
//保存管理员资料
function admin_edit_save(id){

	

		var sex=$('input[name="sex"]:checked').val();
		var groupid=$("#groupid  option:selected").val();
		var username=$('.username').val();
		var email=$('.email').val();
		var address=$('.address').val();
		var abstract=$('.abstract').val();
		var mobile=$('.mobile').val();
		var code=$('.code').val();
	


		$.ajax({ 
				type:"post", 
				url:"/Admin/Rbac/adminedit", 
				data: {id:id,username:username,sex:sex,email:email,address:address,abstract:abstract,mobile:mobile,groupid:groupid,code:code}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						  layer.msg(data.msg,{icon: 1,time:2000},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						  });
					}
					else
					{
						layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});

}

/*管理员-删除*/
function admin_del(obj,id){
layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
	
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/admin_del", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:2000});
					}
				 
				} 
			});
  });

}
/*管理员-停用*/
function admin_stop(obj,id){
	
	$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/admin_stop", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
			
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_start(this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe631;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label">已冻结</span>');
					 $(obj).remove();

					}
					else
					{
					layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});

	
	
}
/*管理员-启用*/
function admin_start(obj,id){
		$.ajax({ 
				type:"get", 
				url:"/Admin/Rbac/admin_start", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label label-success">已启用</span>');
					 $(obj).remove();
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});
}

//基本设置
function baseconfig()
{
		var onoff=$('input[name="onoff"]:checked').val();
		var webname=$('.webname').val();
		var weburl=$('.weburl').val();
		var title=$('.title').val();
		var keywords=$('.keywords').val();
		var description=$('.description').val();
		var copyright=$('.copyright').val();
		var icp=$('.icp').val();
		var cnzz=$('.cnzz').val();
		var ip=$('.ip').val();
		var num=$('.num').val();
		var email_status=$('input[name="email_status"]:checked').val();
		var smtpserver=$('.smtpserver').val();
		var smtpport=$('.smtpport').val();
		var smtpuser=$('.smtpuser').val();
		var smtppwd=$('.smtppwd').val();
		var interst=$('.interst').val();
		$.ajax({ 
				type:"post", 
				url:"/Admin/Webconfig/index", 
				data: {onoff:onoff,webname:webname,weburl:weburl,title:title,keywords:keywords,description:description,copyright:copyright,icp:icp,cnzz:cnzz,ip:ip,num:num,email_status:email_status,smtpserver:smtpserver,smtpport:smtpport,smtpuser:smtpuser,smtppwd:smtppwd,interst:interst}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:2000});
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:2000});
					}
				 
				} 
			});

}

//停用银行
function bank_stop(obj,id){
	
	$.ajax({ 
				type:"get", 
				url:"/Admin/Webconfig/bank_stop", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="bank_start(this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe631;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label">已停用</span>');
					 $(obj).remove();

					}
					else
					{
					   layer.msg(data.msg,{icon: 2,time:1000});
					}
				 
				} 
			});

	
}
//启用银行
function bank_start(obj,id){

	$.ajax({ 
				type:"get", 
				url:"/Admin/Webconfig/bank_start", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
					 $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="bank_stop(this,'+id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
					 $(obj).parents("tr").find(".td-status").html('<span class="label label-success">已启用</span>');
					 $(obj).remove();
					}
					else
					{
						layer.msg(data.msg,{icon:2,time:1000});
					}
				 
				} 
			});
}
//添加银行
function bankadd()
{
		
		var bankname=$('.bankname').val();
		var sort=$('.sort').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Webconfig/bankadd", 
				data: {bankname:bankname,sort:sort}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
							layer.msg(data.msg,{icon: 1,time:1000});
							 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
							 parent.location.reload();
							 parent.layer.close(index); 
						 });
						 
					}
					else 
					{
						layer.msg(data.msg,{icon:2,time:1000});
						
					}
				 
				} 
			});

}
//修改银行信息
function bankedit(id,w,h,title,url){

	 layer_show(w,h,title,url+'?id='+id);	
}
//保存银行信息
function bank_edit_save(id){
		
		var bankname=$('.bankname').val();
		var sort=$('.sort').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Webconfig/bankedit", 
				data: {id:id,bankname:bankname,sort:sort}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
							layer.msg(data.msg,{icon: 1,time:1000});
							 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
							 parent.location.reload();
							 parent.layer.close(index); 
						 });
						 
					}
					else 
					{
						layer.msg(data.msg,{icon:2,time:1000});
						
					}
				 
				} 
			});
	
}

/*银行-删除*/
function bankdel(obj,id){
	layer.confirm('删除须谨慎，确认要删除吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Webconfig/bankdel", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon:1,time:1000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1000});
					}
				 
				} 
			});
  });
}

//添加R
function add_r()
{
		
		var username=$('.username').val();
		var money=$('.money').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Adddata/add_r", 
				data: {username:username,money:money}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
								 $('input').val("");
							     $('.money').val("");}
							   );
						 
					}
					else 
					{
						layer.msg(data.msg,{icon: 2,time:1000});
						
					}
				 
				} 
			});

}
//添加C
function add_c()
{
		
		var username=$('.username').val();
		var money=$('.money').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Adddata/add_c", 
				data: {username:username,money:money}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
								 $('input').val("");
							     $('.money').val("");}
							   );
						 
					}
					else 
					{
						layer.msg(data.msg,{icon:2,time:1000});
						
					}
				 
				} 
			});

}
//添加现金钱袋
function add_cash()
{
		
		var username=$('.username').val();
		var money=$('.money').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Adddata/add_cash", 
				data: {username:username,money:money}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
								 $('input').val("");
								 $('.money').val("");
								 } );
						 
						
						 
					}
					else 
					{
						layer.msg(data.msg,{icon: 2,time:1000});
						
					}
				 
				} 
			});

}
//扣除现金钱袋
function del_cash()
	{
		
		var username=$('.username').val();
		var money=$('.money').val();

		$.ajax({ 
				type:"post", 
				url:"/Admin/Adddata/del_cash", 
				data: {username:username,money:money}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
								 $('input').val("");
								 $('.money').val("");
								 } );
						 
						
						 
					}
					else 
					{
						layer.msg(data.msg,{icon: 2,time:1000});
						
					}
				 
				} 
			});

}
//添加激活币
function add_pin()
{
		
		var username=$('.username').val();
		var money=$('.money').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Adddata/add_pin", 
				data: {username:username,pin:money}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
								 $('input').val("");
							     $('.money').val("");}
							   );
						 
					}
					else 
					{
						layer.msg(data.msg,{icon:2,time:1000});
						
					}
				 
				} 
			});

}
//扣除激活币
function del_pin()
{
		
		var username=$('.username').val();
		var money=$('.money').val();
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Adddata/del_pin", 
				data: {username:username,pin:money}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000},function()  { 
								 $('input').val("");
							     $('.money').val("");}
							   );
						 
					}
					else 
					{
						layer.msg(data.msg,{icon:2,time:1000});
						
					}
				 
				} 
			});

}



/*舍表-删除*/
function c_del(obj,id){
	layer.confirm('撤单须谨慎，确认删除要吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Report/cancel_c", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:1000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1000});
					}
				 
				} 
			});
  });
}
/*得表-删除*/
function r_del(obj,id){
	layer.confirm('撤单须谨慎，确认删除要吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Report/cancel_r", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:1000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1000});
					}
				 
				} 
			});
  });
}
/*订单表-删除*/
function cr_del(obj,id){
	layer.confirm('<font color="red">注意：订单取消后将无法罚款推荐人，请先操作罚款推荐人，再来取消订单。</font><br />你确定要取消订单？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Report/cancel_cr", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 $(obj).parents("tr").remove();
						 layer.msg(data.msg,{icon: 1,time:1000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1000});
					}
				 
				} 
			});
  });
}

/*罚款推荐人*/
function fine_recommend(rid,uid){
	layer.confirm('确定要罚款推荐人吗？',function(index){
	
		$.ajax({ 
				type:"get", 
				url:"/Admin/Report/fine", 
				data: {rid:rid,uid:uid}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						
						 layer.msg(data.msg,{icon: 1,time:1000});
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1000});
					}
				 
				} 
			});
  });
}
function set_code(id)
{
		
		
		$.ajax({ 
				type:"post", 
				url:"/Admin/Rbac/set_code", 
				data: {id:id}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{ 
					 
					 layer.msg(data.msg,{icon: 1,time:1500},function(){
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index);
					 });     
						
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1500},function(){
						 location.replace(location.href);
						 });  
					}
				 
				} 
			});
}