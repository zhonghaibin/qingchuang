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
   <script type="text/javascript">	
		function overhidden(id)
		{
			$(".heddin_"+id).toggle();
		}
   </script>
   <style type='text/css'>
		.heddin{display:none;}
   </style>
    <div class="body_Dv">
  <div class="MessBox" >
    <div class="divcentent">
        <div class="new_dv" >
		<div class="head_title" >
             <span class=" path left" >交易记录 > 提供帮助记录</span>
            </div>
            <div style="margin:20px;">
            <table class="tablebg">
                        <tbody>
                            <tr class="datafield">
                                <th style="border: 1px #fceed1 solid; font-size: 12px;" colspan="9">
                                    <nobr>提供帮助记录</nobr>
                                </th>

                            </tr>
                            <tr class="datalist">
                                <td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>编号</nobr>
                                </td>
                                <td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>金额</nobr>
                                </td>
								<td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>未匹配金额</nobr>
                                </td>
                               
								<td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>排队天数</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>冻结天数</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>利息</nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr>匹配状态</nobr>
                                </td> 
								<td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>下单时间</nobr>
                                </td>
								<td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr>操作</nobr>
                                </td>
                            </tr>
							<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="datalist">
                                <td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr><?php echo ($vo["eg"]); ?></nobr>
                                </td>
                                <td style="border: 1px #fceed1 solid; font-size: 12px;">
                                    <nobr><?php echo ($vo["money"]); ?></nobr>
                                </td>

                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["sum"]); ?></nobr>
                                </td>
                              
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["lineup_date"]); ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["frozen_date"]); ?></nobr>
                                </td>
                               <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($vo["interest"]); ?></nobr>
                                </td>
                                <td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo ($status[$vo['status']]); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></nobr>
                                </td>
								<td style="font-size: 12px; border: 1px #fceed1 solid;">
                                    <nobr><a href='javascript:;' onclick='overhidden(<?php echo ($vo["id"]); ?>);' >查看</a></nobr>
                                </td>
                            </tr>
							<tr class="datalist heddin_<?php echo ($vo["id"]); ?> heddin">
                                 <td style="border: 1px #fceed1 solid; font-size: 12px;" colspan='9'>
									<table class="tablebg" >
										<tr class="datalist">
											<td>编号</td>
											<td>交易进度</td>
											<td>匹配时间</td>
											<td>接受会员账号</td>
											<td>接受会员姓名</td>
											<td>倒计时</td>
											<td>付款金额</td>
											<td>操作</td>
										</tr>
									<?php if(is_array($listcr)): $i = 0; $__LIST__ = $listcr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i; if($vos["c_id"] == $vo["id"]): ?><tr class="datalist">
											<td><?php echo ($vos["cr_eg"]); ?></td>
											<td><?php echo ($crstatus[$vos[status]]); ?></td>
											<td><?php echo (date('Y-m-d H:i:s',$vos["create_date"])); ?></td>
											<td><?php echo ($vos["username"]); ?></td>
											<td><?php echo ($vos["name"]); ?></td>
											<td>
											<?php if($vos["status"] == 2 ): ?><strong id="hour_show_<?php echo ($i); ?>" style="color:green;"><s id="h"></s>0h:</strong>
										   <strong id="minute_show_<?php echo ($i); ?>" style="color:green;"><s></s>00m:</strong>
										   <strong id="second_show_<?php echo ($i); ?>" style="color:green;"><s></s>00s</strong>
											<?php else: ?>
										   <strong id="hour_show_<?php echo ($i); ?>" style="color:#d00000;"><s id="h"></s>0h:</strong>
										   <strong id="minute_show_<?php echo ($i); ?>" style="color:#d00000;"><s></s>00m:</strong>
										   <strong id="second_show_<?php echo ($i); ?>" style="color:#d00000;"><s></s>00s</strong><?php endif; ?>
										   </td>
											<td><?php echo ($vos["sum"]); ?></td>
											<td> <a href='javascript:#' onclick='playmoneys("600","600","提供帮助","<?php echo U("Transaction/playmoney",array("id"=>$vos["id"]));?>")'>详情</a></td>
										</tr>
										
								<script type="text/javascript">
                                <?php if($vos["status"] == 1 or $vos["status"] == 4 ): ?>var intDiff_<?php echo ($i); ?> =<?php echo ($vos["die_time"]); ?>;
								<?php elseif($vos["status"] == 2): ?>
								var intDiff_<?php echo ($i); ?> =<?php echo ($vos["receive_time"]); ?>;
								<?php else: ?>
								var intDiff_<?php echo ($i); ?> =0;<?php endif; ?>
                                    //var intDiff = parseInt(60);//倒计时总秒数量
                                    function timer_<?php echo ($i); ?>(intDiff_<?php echo ($i); ?>) {
                                        window.setInterval(function() {
                                            var day = 0,
                                                    hour = 0,
                                                    minute = 0,
                                                    second = 0;//时间默认值
                                            if (intDiff_<?php echo ($i); ?> > 0) {
                                                //day = Math.floor(intDiff / (60 * 60 * 24));
                                                hour = Math.floor(intDiff_<?php echo ($i); ?> / (60 * 60));
                                                minute = Math.floor(intDiff_<?php echo ($i); ?> / 60) - (hour * 60);
                                                second = Math.floor(intDiff_<?php echo ($i); ?>) - (hour * 60 * 60) - (minute * 60);
                                            }
                                            if (minute <= 9)
                                                minute = '0' + minute;
                                            if (second <= 9)
                                                second = '0' + second;
                                            //$('#day_show').html(day+"天");
                                            $('#hour_show_<?php echo ($i); ?>').html('<s id="h"></s>' + hour + 'h:');
                                            $('#minute_show_<?php echo ($i); ?>').html('<s></s>' + minute + 'm:');
                                            $('#second_show_<?php echo ($i); ?>').html('<s></s>' + second + 's');
                                            intDiff_<?php echo ($i); ?> --;
                                        }, 1000);
                                    }

                                    $(function() {
                                        timer_<?php echo ($i); ?>(intDiff_<?php echo ($i); ?>);
                                    });
                                </script><?php endif; endforeach; endif; else: echo "" ;endif; ?>
									</table>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                           
                        </tbody>
                    </table>

					<div class='page'><?php echo ($page); ?></div>


        </div>

 </div>
  
        </div>
        



        </div>
        </div>
</body>
</html>