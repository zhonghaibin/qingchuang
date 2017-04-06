<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name='viewport' content='width=1000' />
    <title></title>
	
    <link href="/Public/style/home/base.css" rel="stylesheet" />
	<link href="/Public/style/home/common.css" rel="stylesheet" />
    <link href="/Public/style/home/index.css" rel="stylesheet" />
    <script src="/Public/js/home/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="/Public/H-ui/lib/layer/2.1/layer.js"></script>
	<script src="/Public/js/home/H-ui.home.js" type="text/javascript"></script>
    <script type="text/javascript">	
	/******************************************************/
        function Show_SubNav(obj) {
            var status = $(obj).children("ul").css("display");
            $('.nav_sub').css("display","none");
            if (status == "none") {
                $(obj).children("ul").css("display", "block");
            } else
            {
                $(obj).children("ul").css("display", "none");
            }
            
        }
	
</script>

<!--[if lt IE 9]>
	<script type="text/javascript" src="/Public/H-ui/lib/respond.min.js"></script>
	<![endif]-->

</head>
<body class='body_bg'> 
<div class="head" style='position: absolute' >
        <div class="head_sub" >
            <div style="float:left;">
                <a href="#"><img src="/Public/images/home/logo.png" alt="xxx" class="logo"/></a>
            </div>
            <div style="float:left;margin-left:30px;" >
                <div id="jsddm" class="nav_bar">
                    <div><span class="nav_1 nav_bg"></span><a href="<?php echo U('Index/index');?>" >首页</a></div>
                    <div><span class="nav_8 nav_bg"></span><a href="<?php echo U('Member/archives');?>" >我的档案</a></div>
                    <div onclick="Show_SubNav(this)" class="nav_dv"><span class="nav_3 nav_bg"></span><a href="#" >账户管理</a>
                        <ul class="nav_sub" >
                            <li><a href="<?php echo U('Transaction/activation');?>">激活码管理</a></li>
                            <li><a href="<?php echo U('Member/myteam');?>">我的团队</a></li>
                            <li><a href="<?php echo U('Member/group');?>">提供与得的记录</a></li>
                         
                        </ul>
                    </div>
                    <div onclick="Show_SubNav(this)" class="nav_dv"><span class="nav_4 nav_bg"></span><a href="#" >交易记录</a>
                        <ul class="nav_sub">
                            <li><a href="<?php echo U('Transaction/provide');?>">提供帮助记录</a></li>
                            <li><a href="<?php echo U('Transaction/apply');?>">接收帮助记录</a></li>
                            <li><a href="<?php echo U('Transaction/cash');?>">提供帮助交易记录</a></li>
							<li><a href="<?php echo U('Transaction/frozen');?>">推荐奖钱包记录</a></li>
							<li><a href="<?php echo U('Transaction/activity');?>">经理奖钱包记录</a></li>	
							<li><a href="<?php echo U('Transaction/pinlist');?>">激活码交易记录</a></li>
                        </ul>
                    </div>
                  
                    <div><span class="nav_6 nav_bg"></span><a href="<?php echo U('Reg/index');?>" >注册会员</a></div>
                </div>
            </div>
            <div style="float:right;">
                <div id="Ul1" class="nav_bar">
                    <div onclick="Show_SubNav(this)"  style='width:130px;overflow:visible;'>
					<span class="nav_7 nav_bg "></span><a href="#" >我的钱袋</a>
						 <ul class="nav_sub"  style='width:200px;'>
							  <li ><span class='block money_l'>钱包</span><span class='block money_r'><?php echo ($userinfo["cash"]); ?></span></li>
							  <li><span class='block money_l'>经理奖钱包</span><span class='block money_r' ><?php echo ($userinfo["activity"]); ?></span></li>
							  <li><span class='block money_l'>推荐奖钱包</span><span  class='block money_r'><?php echo ($userinfo["frozen"]); ?></span></li>
                        </ul>
					</div>
                    <div><span class="nav_5 nav_bg"></span><a href="<?php echo U('Article/newslist');?>" >新闻</a></div>
                    <div><span class="nav_9 nav_bg"></span><a href="<?php echo U('Message/messagebox');?>" >信息</a></div>
                    <div><span class="nav_10 nav_bg"></span><a href="<?php echo U('Login/logout');?>" >退出</a></div>
                </div>
            </div>
        </div>
    </div>
	<div class='clear' style='height:75px;'></div>
<!------------->
<form method="get" action="">
	{__TOKEN__}
    <div class="body_Dv">
    <div class="MessBox" >
         <div class="head_title" >
             <span class=" path left" >账户管理 > 激活币管理</span>
         </div>

       <div class="body_content" >
            <div class="mess_left_title left" >
                转账至：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext left mobile" name='mobile' placeholder="手机号" /> <a class="checkbtn check_username" >检查</a>&nbsp;&nbsp;&nbsp;<span class='mobile_tip' style='height:30px;line-height:38px;'></span>
            </div>
        </div>
       <div class="body_content" >
            <div class="mess_left_title left" >
                转账款额：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext left pin" name='pin' />&nbsp;&nbsp;&nbsp;<span class='pin_tip' style='height:30px;line-height:38px;'></span>
            </div>
        </div>
        <div class="body_content" style="height:25px; line-height:25px;" >
            <div class="mess_left_title left" style="height:25px; line-height:25px;" >
               
            </div>
            <div class="mess_right_title left" style=" color:#8f8f8f; height:25px; line-height:25px;" >
               您当前激活币为：<font color="f08200" ><?php echo ($userinfo["pin"]); ?></font> 个
            </div>
        </div>
        <div class="body_content body_contents" >
            <a class="send_ms pin_subtn" >确认转账</a>
        </div>
   </div>
        </div>
	
</form>
</body>
</html>
<script type="text/javascript">
	function isLegal(str){
		if(/[!,#,$,%,^,&,*,?,~,\\,|,;,",<,>,(,),+,.,\s+]/gi.test(str)) return false;
			var str1 = str.toLowerCase()
			if(str1.indexOf("script") >= 0 || str1.indexOf("select") >= 0 || str1.indexOf("update") >= 0 || str1.indexOf("delete") >= 0 || str1.indexOf("insert") >= 0 || str1.indexOf("insert") >= 0 || str1.indexOf("drop") >= 0 || str1.indexOf("truncate") >= 0 || str1.indexOf("union") >= 0 || str1.indexOf("user") >= 0 || str1.indexOf("load_file") >= 0 || str1.indexOf("outfile") >= 0)
			{
				return false;
			}
			return true;
		}
	function strLength(as_str){
		return as_str.replace(/[^\x00-\xff]/g, 'xx').length;
	}	
	
	function check_username(){
		var mobile=$.trim($('.mobile').val());
		telreg =  /^(1)[0-9]{10}$/;
		if(telreg.test(mobile)){
		  $('.mobile_tip').html('');
		}else{
			$('.mobile_tip').html('<span style="color:#d00000;">请输入手机号码</span>');
			flag=false;
		}
		return flag;
	}
	//检查手机格式
	function check_mobile(){
		var mobile=$.trim($('.mobile').val());
		telreg =  /^(1)[0-9]{10}$/;
		if(telreg.test(mobile)){
			 $.ajax({ 
				type:"post", 
				url:"/Home/Transaction/check_mobile", 
				data: {mobile:mobile}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					if(data.status==1){
						flag=false;
					}else{
						flag=true;
					}
					$('.mobile_tip').html(data.msg);
				}
				}); 
		}else{
			$('.mobile_tip').html('<span style="color:#d00000;">请输入手机号码</span>');
			flag=false;
		}
		return flag;
	}
	//检查币
	function check_pin(){
		var pin=$('.pin').val();
		if(pin){
			var regpin = new RegExp("^[0-9]+$");
			if(regpin.test(pin)){
				flag=true;
			}else{
				$('.pin_tip').html('<span style="color:#d00000;">格式不正确</span>');
				flag=false;
			}
			
		}else{
			$('.pin_tip').html('<span style="color:#d00000;">请输入激活币</span>');
			flag=false;
		}
		return flag;
	}

	$(function(){

		
		$('.mobile').blur(function(){
			check_username();
		});
		$('.pin').blur(function(){
			 check_pin();
		});
		$('.pin_subtn').click(function(){
			var flag=check_username();
			var flag1= check_pin();
			if(flag&& flag1){
				pin_save();
			}
		});
		$('.check_username').click(function(){

			check_mobile();
		});
	});
</script>