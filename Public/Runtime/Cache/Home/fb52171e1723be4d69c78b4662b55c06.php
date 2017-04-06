<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name='viewport' content='width=1000' />
    <title>登录</title>
    <link href="/Public/style/home/base.css" rel="stylesheet" />
    <link href="/Public/style/home/login.css" rel="stylesheet" />
	<script src="/Public/js/home/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/Public/H-ui/lib/layer/2.1/layer.js"></script>
	<script src="/Public/js/home/H-ui.home.js" type="text/javascript"></script>
    <style type="text/css">
        .backimg {
            background-color: #F5F5F5;
            background-image: url('/Public/images/home/loginbg.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
			background-size:100% 100%;
        }
		span{color:red;}
    </style>
</head>
<body class="backimg">
    <div class="Login_1box" >
        <div style="text-align: center; padding:30px 11px 10px 11px">
            <img src="/Public/images/home/login_logo_03.png" style="width:166px;" />
        </div>

        <div class="Login_2box">
            <div>
                <p class="fontsize14 l_tips">账号：</p>
                <div>
                    <input type="text" class="inputstyle username"  />
					<div class='username_tip'  style="color:red;"><span></span></div>
                </div>
            </div>
            <div  class="LoginInput">
                <p class="fontsize14 l_tips">密码：</p>
                <div>
                    <input type="password" class="inputstyle pwd"   />
					 <div class='pwd_tip'  style="color:red;"><span></span></div>
                </div>
            </div>

            <div class="LoginInput">
                <div>
                    <input type="text" class="inputstyle code" placeholder="输入验证码" style="width: 160px; padding: 0 5px;"  />
					<img  src="<?php echo U('Login/code');?>"  alt="点击刷新验证码" style="cursor: pointer; margin-left: 15px; margin-top: -5px;" align="absmiddle" border="0"  onclick="this.src='<?php echo U('Login/code');?>?d='+Math.random();" id='code'>	 <div class='code_tip'  style="color:red;"><span></span></div>
                </div>
            </div>

            <div class="LoginInput">
                <div>
                    <a href="javascript:void();" style="background-color: #f8b551; border-radius: 4px; color: white; display: block; font-size: 20px; height: 41px; line-height: 41px; text-align: center;"  class='log_btn'>登录</a>
                </div>
               <div style='height:40px;line-height:40px;text-align:center;'> <span style='cursor:pointer;' onclick="pet_pwd('520','400','找回密码','<?php echo U('Login/petpwd');?>');"> 忘记密码？</span></div>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    $(function() {
        $('.username,.pwd').focus(function() {
            $(this).attr('placeholder', '');
        });
        var uname = $.trim($('.username').val());
        var pwd = $.trim($('.pwd').val());
		var code=$.trim($('.code').val());
        $('.username').blur(function() {
            if (uname == '') {
                $(this).attr('placeholder', '');
            }
        });
        $('.pwd').blur(function() {
            if (pwd == '') {
                $(this).attr('placeholder', '');
            }
        });
		$('.code').blur(function() {
            if (code == '') {
                $(this).attr('placeholder', '');
            }
        });
        $('.log_btn').click(function() {
            var uname = $.trim($('.username').val());
            var pwd = $.trim($('.pwd').val());
			var code=$.trim($('.code').val());
            if (!uname) {
                $('.username_tip span').html('请输入账号!');
                return false;
            } else {
                $('.username_tip span').html('');
            }
            if (!pwd || (pwd.length<6&&pwd.length>12)) {
                $('.pwd_tip span').html('请输入6-12位数的密码');
                return false;
            } else {
                $('.pwd_tip span').html('');
            }
			if (!code || (code.length!=4)) {
                $('.code_tip span').html('请输入4位数的验证码');
                return false;
            } else {
                $('.code_tip span').html('');
            }
       
            if (uname && pwd && pwd.length>=6&&pwd.length <=12) {
				
                $.post('/index.php/Home/Login/ajax_login', {username: uname, pwd: pwd,code:code},
                function(data) {
                    if (data.status == 1) {
                        $('.username_tip span').html('');
                        $('.pwd_tip span').html('');
						$('.code_tip span').html('');
                        location.href = data.url;
                    } else {
                        if (data.type == 1) {
							$('#code').attr("src","<?php echo U('Login/code');?>?d="+Math.random());
                            $('.username_tip span').html(data.msg);
							
                        } else if(data.type == 2){
							$('#code').attr("src","<?php echo U('Login/code');?>?d="+Math.random());
                            $('.pwd_tip span').html(data.msg);
							
                        }else
						{ $('#code').attr("src","<?php echo U('Login/code');?>?d="+Math.random());
						     $('.code_tip span').html(data.msg);
							
						}
                    }
                }, "json");
			   }           
        });
    });
</script>