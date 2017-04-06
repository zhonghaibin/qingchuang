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
 <div class="body_Dv">
 <div class="MessBox" >
    <div class="divcentent">
        <div class="new_dv" >
           
             <div class="head_title" >
             <span class=" path left" >交易记录 > 推荐奖钱包记录</span>
             </div>


            <div style="margin:20px;">
            <table class="tablebg">
                        <tbody>
                            <tr class="datafield">
                                <th style="border: 1px #fceed1 solid; font-size: 12px;" colspan="12">
                                    <nobr>推荐奖钱包记录</nobr>
                                </th>

                            </tr>
                            <tr class="datalist">
                                <td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>编号</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>类型</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>收入</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>支出</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>余额</nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>玩家账号</nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>玩家金额</nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>结算账号</nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>结算金额</nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>结算比例</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>日期</nobr>
                                </td>
								<td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>描述</nobr>
                                </td>

                            </tr>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="datalist">
                                <td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr><?php echo ($i); ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php if($vo["status"] == 1): ?>收入<?php elseif($vo["status"] == 2): ?>支出<?php endif; ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["sum"]); ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["export"]); ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["balance"]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["from"]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["from_money"]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["settlement"]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["settlement_money"]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["from_scale"]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["explain"]); ?></nobr>
                                </td>
                              
                               
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                         
                               
                            </tr>
                        </tbody>
                    </table>
				<div class='page'>
				<?php echo ($page); ?>
				</div>


 </div>
        </div>


        </div>
        



        </div>
        </div>
</body>
</html>