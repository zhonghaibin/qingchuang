

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
		shade:0.4,
		title: title,
		content: url,
		skin: 'home-class',
		maxmin:false,
			
	
	});

}




/*-申请帮助-提交*/
function apply_add_save()
{
		var sum=$('.sum').val();
		var token=$("input[name='token']").val();
		var zffs3=$("input[name='zffs3']:checked").val();
		var zffs4=$("input[name='zffs4']:checked").val();
		if(sum)
	{
		  layer.confirm('你确定要接收帮助'+sum+'？',function(index){

		$.ajax({ 
				type:"post", 
				url:"/Home/Index/apply_add", 
				data: {sum:sum,token:token,zffs3:zffs3,zffs4:zffs4}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:1500},function(){
						 
						  location.replace(location.href);
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
	});
	}
	else
	{
		layer.msg('请输入金额',{icon:2,time:1500});
	}
}

/*-提供帮助-提交*/
function provide_add_save()
{
		var money=$('.money').val();
		var token=$("input[name='token']").val();
		var zffs1=$("input[name='zffs1']:checked").val();
		var zffs2=$("input[name='zffs2']:checked").val();
		if(money)
	{
	    layer.confirm('你确定要提供帮助'+money+'？',function(index){
		$.ajax({ 
				type:"post", 
				url:"/Home/Index/provide_add", 
				data: {money:money,token:token,zffs1:zffs1,zffs2:zffs2}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon:1,time:1500},function(){
						
						 location.replace(location.href);
						 });
						
					}
					else
					{
						 layer.msg(data.msg,{icon:2,time:1500},function(){
						location.replace(location.href);
						 
						 });
					}
				 
				} 
			});
});
	}
	else
	{
		layer.msg('请输入金额',{icon:2,time:1500});
	}
		
}
/*--提交*/
function affirm_save()
{
		var id=$('.id').val();
		var token=$("input[name='token']").val();
		
		$.ajax({ 
				type:"post", 
				url:"/Home/Index/affirm", 
				data: {id:id,token:token}, 
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
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
					}
				 
				} 
			});
}
/*--拒绝*/
function fake_save()
{
		var id=$('.id').val();
		var token=$("input[name='token']").val();
		$.ajax({ 
				type:"post", 
				url:"/Home/Index/fake", 
				data: {id:id,token:token}, 
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
						 var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
						 parent.location.reload();
						 parent.layer.close(index); 
						 
						 });
					}
				 
				} 
			});
}

function  add_register()
{

		
		var password=$('.password').val();
		var repwd=$('.repwd').val();
		var towpassword=$('.towpassword').val();
		var towrepwd=$('.towrepwd').val();
		var mobile=$('.mobile').val();
		var alipay=$('.alipay').val();
		var tname=$('.tname').val();
		var bankno=$('.bankno').val();
		var bankname=$('.bankname').val();
		var pin=$('.pin').val();
		var token=$("input[name='token']").val();

		$.ajax({ 
				type:"post", 
				url:"/Home/Reg/register", 
				data: {password:password,repwd:repwd,mobile:mobile,alipay:alipay,tname:tname,bankno:bankno,bankname:bankname,towpassword:towpassword,towrepwd:towrepwd,pin:pin,token:token}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				
				 if(data.status==1)
					{
						 layer.msg(data.msg,{icon: 1,time:1500},function(){
							location.replace(location.href);
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

function  add_message()
{
		
		var type=$('.type').val();
		var subject=$('.subject').val();
		var content=$('.content').val();
		$.ajax({ 
				type:"post", 
				url:"/Home/Message/message", 
				data: {type:type,subject:subject,content:content}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					
				 if(data.status==1)
					{ 
					 
					 layer.msg(data.msg,{icon: 1,time:1500},function(){
					     $('.subject').val('');
						 $('.content').val('');
					 });
					     
						
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1500});
					}
				 
				} 
			});

}
function  userinfo_save()
{
		
		var name=$('.tname').val();
		var mobile=$('.mobile').val();
		var alipay=$('.alipay').val();
		var bankno=$('.bankno').val();
		var bank=$('.bankname').val();
		var towpwd=$('.towlevelpassword').val();

		layer.confirm('每个用户只能修改一次资料，你确认要修改？',function(index){
		$.ajax({ 
				type:"post", 
				url:"/Home/Member/userinfo", 
				data: {name:name,mobile:mobile,alipay:alipay,bankno:bankno,bank:bank,towpwd:towpwd}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					
				 if(data.status==1)
					{ 
					 
					 layer.msg(data.msg,{icon: 1,time:2500},function(){
					   $('.towlevelpassword').val('');
					 });
					     
						
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:2500});
					}
				 
				} 
			});
	});
}
function  towpassword_save()
{
		
		var oldtowpassword=$('.oldtowpassword').val();
		var towpassword=$('.towpassword').val();
		var towrepwd=$('.towrepwd').val();
		$.ajax({ 
				type:"post", 
				url:"/Home/Member/towpassword_save", 
				data: {oldtowpassword:oldtowpassword,towpassword:towpassword,towrepwd:towrepwd}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					
				 if(data.status==1)
					{ 
					 
					 layer.msg(data.msg,{icon: 1,time:1500},function(){
					    $('.oldtowpassword').val('');
						$('.towpassword').val('');
						$('.towrepwd').val('');
					 });
					     
						
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1500});
					}
				 
				} 
			});

}
function password_save()
{
		
		var oldpassword=$('.oldpassword').val();
		var password=$('.password').val();
		var repwd=$('.repwd').val();
		$.ajax({ 
				type:"post", 
				url:"/Home/Member/password_save", 
				data: {oldpassword:oldpassword,password:password,repwd:repwd}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					
				 if(data.status==1)
					{ 
					 
					 layer.msg(data.msg,{icon: 1,time:1500},function(){
					    $('.oldpassword').val('');
						$('.password').val('');
						$('.repwd').val('');
					 });
					     
						
					}
					else
					{
						 layer.msg(data.msg,{icon: 2,time:1500});
					}
				 
				} 
			});

}
function pin_save()
{
		
		var mobile=$('.mobile').val();
		var pin=$('.pin').val();
		var token=$("input[name='token']").val();
		$.ajax({ 
				type:"post", 
				url:"/Home/Transaction/activation", 
				data: {mobile:mobile, pin: pin,token:token}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
				 if(data.status==1)
					{ 
					 
					 layer.msg(data.msg,{icon: 1,time:1500},function(){
						location.replace(location.href);
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
/*************首页的*******************/
//打款窗口
function playmoney(w,h,title,url){
	layer_show(w,h,title,url);
	
}
//收款窗口
function receivables(w,h,title,url){
	layer_show(w,h,title,url);
	
}
/**************Transaction********************/
//打款窗口
function playmoneys(w,h,title,url){
	layer_show(w,h,title,url);
	
}
//收款窗口
function receivabless(w,h,title,url){
	layer_show(w,h,title,url);
	
}
function search_group()
{

	var mobile=$.trim($('.mobile').val());
	telreg =  /^(1)[0-9]{10}$/;
	if(mobile)
	{
		if(telreg.test(mobile)){
		   
		   flag=true;

		}else{
			$('.mobile_tip').html('<span style="color:#d00000;">请输入手机号码</span>');
			flag=false;
		}
	}
	else
	{
		flag=false;
		$('.mobile_tip').html('<span style="color:#d00000;">请输入手机号码</span>');
	}

	if(flag==true)
	{
		 $("form").submit();
	}
	
}
function petpwd_save()
{
	var mobile=$.trim($('.mobile').val());
	var codes=$.trim($('.codes').val());
	var password=$.trim($('.password').val());
		$.ajax({ 
				type:"post", 
				url:"/Home/Login/petpwd", 
				data: {mobile:mobile,codes:codes,password:password}, 
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
function pet_pwd(w,h,title,url){
	layer_show(w,h,title,url);
	
}
function set_code()
{
		
		var mobile=$.trim($('.mobile').val());
		$.ajax({ 
				type:"post", 
				url:"/Home/Login/set_code", 
				data: {mobile:mobile}, 
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