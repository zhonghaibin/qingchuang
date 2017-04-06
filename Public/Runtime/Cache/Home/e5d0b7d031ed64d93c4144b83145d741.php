<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
   <div class="body_Dv">
   <div class="MessBox" >
   <div class="head_title" >
   <span class=" path left" >信息 > 撰写信息</span>  <a class="btn" href="<?php echo U('Message/messagebox');?>">信件箱</a>  
   </div>
   <div class="body_content" >
   <div class="mess_left_title left" >
                类型：
   </div>
            <div class="mess_right_title left" >
                <select  style='width:276px;height:38px;' class='type' name='type'> 
                    <option value="1" >不打款</option>
                    <option value="2" >不确认</option>
                    <option value="3" >其他</option>
                </select>
               
            </div>
        </div>
       <div class="body_content" >
            <div class="mess_left_title left" >
                主题：
            </div>
            <div class="mess_right_title left" >
                <input type="text" class="inputtext subject" name='subject' />
            </div>
			<div class="mess_right_title left"  style='height:38px;line-height:38px;text-indent:5px;'>
			<span class="msg_subject_tip" style="color:#d00000;"></span>
			</div>
        </div>
       <div class="body_content" >
            <div class="mess_left_title left" >
                内容：
            </div>
            <div class="mess_right_title left" >
                <textarea rows="5" cols="39" style='padding: 6px 12px; border-radius: 4px;border: 1px solid #ccc;' name='content' class='content'></textarea>
            </div>
			<div class="mess_right_title left" style='height:38px;line-height:38px;text-indent:5px;'><span class="msg_message_tip" style="color:#d00000;"></span> </div>
        </div>
        <div class="body_content body_contents" >
            <a class="send_ms message_btn" >发送信息</a>
        </div>
   </div>
        </div>
</body>
</html>
<script type="text/javascript">
function check_empty(obj,obj2,html){
		var vals=$.trim($(obj).val());
		if(vals){
			flag=true;
			$(obj2).html('');
		}else{
			flag=false;
			$(obj2).html(html);
		}
		return flag;
	}

$(function(){
		$('.subject').blur(function(){
			check_empty(this,'.msg_subject_tip','请输入主题');
		});
		$('.content').blur(function(){
			check_empty(this,'.msg_message_tip','请输入内容');
		});

		$('.message_btn').click(function(){
			var flag1=check_empty('.subject','.msg_subject_tip','请输入主题');
			var flag2=check_empty('.content','.msg_message_tip','请输入内容');
			if(flag1 && flag2){

				add_message();
				var msg_subject=$('.msg_subject').val();
				var msg_message=$('.msg_message').val();
				
			}
		});
});
</script>