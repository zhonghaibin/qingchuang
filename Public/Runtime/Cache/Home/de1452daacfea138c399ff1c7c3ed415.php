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
<form method="post" action="">	
{__TOKEN__}
    <div class="body_Dv">
    <div class="MessBox" style="padding-bottom:25px;" >
         <div class="head_title" >
             <span class=" path left" >注册新会员</span>
         </div>
    	<div class="body_content" >
            <div class="mess_left_title left" >
                手 机 号：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext mobile" name='mobile'  />
            </div>
			<div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='mobile_tip'></span></div>
        </div>

	  <div class="body_content" >
            <div class="mess_left_title left" >
                姓 名：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext tname" name='tname'  />
            </div><div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='tname_tip'></span></div>
      </div>
	 <div class="body_content" >
            <div class="mess_left_title left" >
                密 码：
            </div>
            <div class="mess_right_title left" >
                <input type="password" class="inputtext password"  name='password' />
            </div>
			<div class="mess_right_title left" style='line-height:38px;text-indent:4px;'>
			<span class='password_tip'></span> </div>
        </div>
		
		<div class="body_content" >
            <div class="mess_left_title left" >
                确 认 密 码：
            </div>
            <div class="mess_right_title left" >
                <input type="password" class="inputtext repwd"   name='repwd'/>
            </div>
			<div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='repwd_tip'></span></div>
        </div>
		<div class="body_content" >
            <div class="mess_left_title left" >
               二 级 密 码：
            </div>
            <div class="mess_right_title left" >
                <input type="password" class="inputtext towpassword"  name='towpassword' value='123456' />
            </div>
			<div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='towpassword_tip'></span></div>
        </div>
		
		<div class="body_content" >
            <div class="mess_left_title left" >
                确 认 密 码：
            </div>
            <div class="mess_right_title left" >
                <input type="password" class="inputtext towrepwd"   name='towrepwd' value='123456'/>
            </div>
			<div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='towrepwd_tip'></span></div>
        </div>

    <div class="body_content" >
            <div class="mess_left_title left" >
                支 付 宝 账 号：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext alipay" name='alipay' />
            </div>
			<div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='alipay_tip'></span></div>
        </div>
        <div class="body_content" >
            <div class="mess_left_title left" >
                银 行 账 号：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext bankno"   name='bankno'/>
            </div><div class="mess_right_title left" style='line-height:38px;text-indent:4px;'><span class='bankno_tip'></span></div>
        </div>
		<div class="body_content" >
            <div class="mess_left_title left" >
                银 行 名 称：
            </div>
            <div class="mess_right_title left" >
			<select class="select bankname"   style='padding:0px 6px;width:276px;height:38px;' name='bankname'>
				<?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["bankname"]); ?>"><?php echo ($vo["bankname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
            </div>
        </div> 
	
       <div class="checkboxdiv" >
           <input type="checkbox" value="1" class='read'  name='read' />
		   <span class='read_tip'>我已完全了解所有风险</span>
       </div>
       <div class="body_content body_contents" >
            <a class="send_ms reg_subtn" style="background:#f08200; width:250px" >立即注册</a>
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

	
	//检查密码
	function check_pwd(){
		var pwd=$.trim($('.password').val());
		var regp = new RegExp("^[0-9a-zA-Z]+$");
		var strlen = strLength(pwd);
		if(regp.test(pwd) && strlen>=6 && strlen<=12 ){
			$('.password_tip').html('');
			flag=true;
		}else{
			$('.password_tip').html('<span style="color:#d00000;">只能输入6-12位的密码</span>');
			flag=false;
		}
		return flag;
	}

	//检查确认密码
	function check_repwd(){
		var repwd=$.trim($('.repwd').val());
		var regrp = new RegExp("^[0-9a-zA-Z]+$");
		var strlen = strLength(repwd);
		if(regrp.test(repwd) && strlen>=6 && strlen<=12 ){
			if($('.password').val() != repwd){
				$('.repwd_tip').html('<span style="color:#d00000;">两次密码不一致</span>');
				flag=false;
			}else{
				$('.repwd_tip').html('');
				flag=true;
			}
		}else{
			$('.repwd_tip').html('<span style="color:#d00000;">只能输入6-12位的确认密码</span>');
			flag=false;
		}
		return flag;
	}

		//检查二级密码
	function check_towpwd(){
		var towpwd=$.trim($('.towpassword').val());
		var towregp = new RegExp("^[0-9a-zA-Z]+$");
		var strlen = strLength(towpwd);
		if(towregp.test(towpwd) && strlen>=6 && strlen<=12 ){
			$('.towpassword_tip').html('');
			flag=true;
		}else{
			$('.towpassword_tip').html('<span style="color:#d00000;">只能输入6-12位的二级密码</span>');
			flag=false;
		}
		return flag;
	}

	//检查确认密码
	function check_towrepwd(){
		var towrepwd=$.trim($('.towrepwd').val());
		var towregrp = new RegExp("^[0-9a-zA-Z]+$");
		var strlen = strLength(towrepwd);
		if(towregrp.test(towrepwd) && strlen>=6 && strlen<=12 ){
			if($('.towpassword').val() != towrepwd){
				$('.towrepwd_tip').html('<span style="color:#d00000;">两次密码不一致</span>');
				flag=false;
			}else{
				$('.towrepwd_tip').html('');
				flag=true;
			}
		}else{
			$('.towrepwd_tip').html('<span style="color:#d00000;">只能输入6-12位的确认密码</span>');
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
				url:"/Home/Reg/check_mobile", 
				data: {mobile:mobile}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					if(data.status==1){
						flag=false;
					}else{
						flag=true;
					}
					$('.mobile_tip').html("<span style='color:#d00000;'>"+data.msg+"</span>");
				}
				}); 

		}else{
			$('.mobile_tip').html('<span style="color:#d00000;">请输入手机号码</span>');
			flag=false;
		}
		return flag;
	}
//支付宝账号
	function check_alipay(){
		var alipay=$.trim($('.alipay').val());
		var telreg =  /^(1)[0-9]{10}$/;
		var rege=new RegExp("^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$", "i");
		if(telreg.test(alipay)||rege.test(alipay)){
			 $.ajax({ 
				type:"post", 
				url:"/Home/Reg/check_alipay", 
				data: {alipay:alipay}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					if(data.status==1){
						flag=false;
					}else{
						flag=true;
					}
					$('.alipay_tip').html("<span style='color:#d00000;'>"+data.msg+"</span>");
				}
				}); 
		}else{
			$('.alipay_tip').html('<span style="color:#d00000;">请输入支付宝账号</span>');
			flag=false;
		}
		return flag;
	}


	//姓名
	function check_tname(){
		var tname=$('.tname').val();
		if(tname){
			$('.tname_tip').html('');
			flag=true;
		}else{
			$('.tname_tip').html('<span style="color:#d00000;">请输入姓名</span>');
			flag=false;
		}
		return flag;
	}
	//银行卡号
	function check_bankno(){
		var bankno=$('.bankno').val();
		if(bankno){
			var regbank = new RegExp("^[0-9]+$");
			if(regbank.test(bankno)){
			   $.ajax({ 
				type:"post", 
				url:"/Home/Reg/check_bankno", 
				data: {bankno:bankno}, 
				dataType: 'json', 
				async : false,//设置为同步操作就可以给全局变量赋值成功 
				success:function(data){ 
					if(data.status==1){
						flag=false;
					}else{
						flag=true;
					}
					$('.bankno_tip').html("<span style='color:#d00000;'>"+data.msg+"</span>");
				}
				}); 
			}else{
				$('.bankno_tip').html('<span style="color:#d00000;">请输入银行账号</span>');
				flag=false;
			}
			
		}else{
			$('.bankno_tip').html('<span style="color:#d00000;">请输入银行账号</span>');
			flag=false;
		}
		return flag;
	}

	
	//读取

	function check_read(){
		
		var read=$("input[type='checkbox']").is(':checked');
		if(read){
			$('.read_tip').html('<span>我已完全了解所有风险</span>');
			flag=true;
		}else{
			$('.read_tip').html('<span style="color:#d00000;">你还没勾选</span>');
			flag=false;
		}
		return flag;
	}

	$(function(){
	
		$('.password').blur(function(){
			check_pwd();
		});
		$('.repwd').blur(function(){
			check_repwd();
		});
		$('.towpassword').blur(function(){
			check_towpwd();
		});
		$('.towrepwd').blur(function(){
			check_towrepwd();
		});
		
		$('.mobile').blur(function(){
			check_mobile();
		});
		$('.alipay').blur(function(){
			check_alipay();
		});
		$('.tname').blur(function(){
			check_tname();
		});
		$('.bankno').blur(function(){
			check_bankno();
		});
		$('.read').blur(function(){
			check_read();
		});
		$('.reg_subtn').click(function(){
			
			var flag2=check_pwd();
			var flag3=check_repwd();
			var flag4=check_alipay();
			var flag5=check_mobile();
			var flag6=check_tname();
			var flag7=check_bankno();
			var flag9=check_read();
			var flag10=check_towpwd();
			var flag11=check_towrepwd();
		
			if( flag2 && flag3 &&flag4 && flag5 && flag6 && flag7&&flag9&&flag10&&flag11){
				add_register();
			}
			
			
		});
	});
</script>