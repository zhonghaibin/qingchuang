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
<link href="/Public/style/home/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/Public/style/home/main.v001.css" type="text/css"/>
<div class="body_Dv"> 
<div class="divcentent" >
<div class="clear"></div>
<div class="info">
	<div class="left">
    		<span  class="nav_11 nav_bg" style="margin-left:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp; <span>级别：<?php echo ($star[$selfinfo['star']]); ?></span>
    </div>
    <div class="right" >
    	&nbsp; <span></span>&nbsp; <span></span>&nbsp; <span>
    </div>
</div>

<div class="warning"  >
	<div class="center warning_box">
        <span  class="nav_12 left" style="width:40px;height:40px;display:block;">&nbsp;</span>
        <span class="left  block red">警示： 这里是54青创金融互助社区，自愿承担一切风险！</span></div>
</div>
    <div class="bannerbox" >
		<?php if(is_array($bannerlist)): $i = 0; $__LIST__ = array_slice($bannerlist,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><img src="/Public/upload/banner/<?php echo ($vo["src"]); ?>" /><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
<div class="gnxanniu" >
      <a class="sup left" id="pdBtn" >提 供 帮 助</a>
      <a class="acc right" id="gdBtn" >接 受 帮 助</a>
</div>
<!---->
    <div class="row">
	<div style="display:none; " id="pdWrap" class="col-md-12">
                            <div class="widget widget-body-white">

                              <form id="provide_help" class="form-horizontal margin-none" name="buy_share_form">
								{__TOKEN__}
                                <div class="widget-head widget-head-blue">

                                  <h4 class="heading">

                                    <i class="fa fa-usd"></i> 我要提供帮助

                                  </h4>

                                </div>

                                  <div class="w_l_123" >
                                       <div class=" text_tips left" >支付方式：</div>
                                       <div class="inp right" >
                                        <label>
                                        <input type="checkbox" value="1" class="ckbox zffs1" name="zffs1" checked="">
                                        银行支付
                                        </label>

                                      <label>

                                        <input type="checkbox" value="1" class="ckbox zffs2" name="zffs2" checked="">

                                        支付宝支付

                                      </label>

                                       </div>
                                  </div>
                                   
                                  <div class="w_l_123" >
                                       <div class=" text_tips left" >提供帮助金额：</div>
                                       <div class="inp right" >
                                         <input type="text" id="" value="" class="input_texts money" name='money'   placeholder="输入金额（金额必须为<?php echo ($relust['multipleofextraction']); ?>的倍数）" />
                                       </div>
                                  </div>

                                   <div class="w_l_123" >
                                       <div class=" text_tips left" ></div>
                                       <div class="inp right" >
                                         <span class="red">*温馨提示：我已阅读公告警示，充分了解所有风险，并选择参与，既思想健全。 </span>
                                       </div>
                                  </div>
                                  <div class="data-footer innerAll half text-right clearfix">
                                  <input type="button" value="提供帮助" class="btn_next btn-warning btn-sm btn btn-primary " id="jhwjjc" onclick='provide_add_save()'>

                                </div>
                              </form>

                            </div>

                          </div>

                          <div style="display: none;" id="gdWrap" class="col-md-12">

                            <div class="widget widget-body-white">

                              <form id="Form1" class="form-horizontal margin-none" name="buy_share_form"  >
														{__TOKEN__}
                                <div class="widget-head widget-head-blue">

                                  <h4 class="heading">

                                    <i class="fa fa-usd"></i> 我要接受帮助

                                  </h4>

                                </div>

                                  <div class="w_l_123" >
                                       <div class=" text_tips left" >支付方式：</div>
                                       <div class="inp right" >
                                           <label>

                                        <input type="checkbox" value="1" class="ckbox zffs3" name="zffs3" checked="">

                                        银行支付

                                      </label>

                                      <label>

                                        <input type="checkbox" value="1" class="ckbox zffs4" name="zffs4" checked="">

                                        支付宝支付

                                      </label>
                                       </div>
                                  </div>
                                   
                                  <div class="w_l_123" >
                                       <div class=" text_tips left" >接收帮助金额：</div>
                                       <div class="inp right" >
                                         <input type="text" id="Text1" value="" class="input_texts sum" name='sum'   placeholder="输入金额（金额必须为<?php echo ($relust['multipleofextraction']); ?>的倍数）" />
                                       </div>
                                  </div>

                                   <div class="w_l_123" >
                                       <div class=" text_tips left" ></div>
                                       <div class="inp right" >
                                         <span class="notweight" > 您现有可接受帮助总余额： <?php echo ($selfinfo["cash"]); ?> RMB</span>
                                       </div>
                                  </div>
                                 
                                    <div class="w_l_123" >
                                       <div class=" text_tips left" ></div>
                                       <div class="inp right" >
                                         <span class="notweight" >  您最低可接受帮助金额： <?php echo ($relust["receivinglimit"]); ?> RMB </span>
                                       </div>
                                  </div>
                                  <div class="data-footer innerAll half text-right clearfix">

                                  <input type="button" value="接受帮助" class="btn_next btn-warning btn-sm btn btn-primary " id="Submit1" onclick='apply_add_save()'/>

                                </div>
                              </form>

                            </div>

                          </div>

                        </div>
<!---->
<div class="clear" ></div>
<div style="margin-top: 10px; margin-bottom: 10px;" >
            <div class="left" style="width: 687px;">
                <div class="core_con">
            <table class="tablebg">
                <tbody>
                     <tr class="datafield">
                        <th style="border: 1px #fceed1 solid; font-size: 14px;" colspan="7">
                            <nobr>我的提供帮助</nobr>
                        </th>
                        
                    </tr>
                    <tr class="datalist">
                        <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr>编号</nobr>
                        </td>
                        <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr>交易进度</nobr>
                        </td>

                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>匹配时间</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>接受会员</nobr>
                        </td>
                      	<td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>倒计时</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>付款金额</nobr>
                        </td>
					
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>操作</nobr>
                        </td>
                    </tr>
				<?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="datalist">
                            <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr><?php echo ($vo["c_eg"]); ?></nobr>
                        </td>
                        <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr><?php echo ($crstatus[$vo[status]]); ?></nobr>
                        </td>

                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr><?php echo ($vo["name"]); ?></nobr>
                        </td>
                          <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>	
								<?php if($vo["status"] == 2 ): ?><strong id="hour_show_<?php echo ($i); ?>" style="color:green;"><s id="h"></s>0h:</strong>
							   <strong id="minute_show_<?php echo ($i); ?>" style="color:green;"><s></s>00m:</strong>
							   <strong id="second_show_<?php echo ($i); ?>" style="color:green;"><s></s>00s</strong>
								<?php else: ?>
							   <strong id="hour_show_<?php echo ($i); ?>" style="color:#d00000;"><s id="h"></s>0h:</strong>
							   <strong id="minute_show_<?php echo ($i); ?>" style="color:#d00000;"><s></s>00m:</strong>
							   <strong id="second_show_<?php echo ($i); ?>" style="color:#d00000;"><s></s>00s</strong><?php endif; ?>
								<script type="text/javascript">
                                <?php if($vo["status"] == 1 or $vo["status"] == 4 ): ?>var intDiff_<?php echo ($i); ?> =<?php echo ($vo["die_time"]); ?>;
								<?php elseif($vo["status"] == 2): ?>
								var intDiff_<?php echo ($i); ?> =<?php echo ($vo["receive_time"]); ?>;
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
                                </script>
								
							</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr><?php echo ($vo["sum"]); ?> CNY</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <a href='javascript:#' onclick='playmoney("600","600","提供帮助","<?php echo U("Index/playmoney",array("id"=>$vo["id"]));?>")'>详情</a>
                        </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
            </table>
        </div>
                 
                <div class="core_con">
            <table class="tablebg">
                <tbody>
                     <tr class="datafield">
                        <th style="border: 1px #fceed1 solid; font-size: 14px;" colspan="7">
                            <nobr>我的接收帮助</nobr>
                        </th>
                        
                    </tr>
                    <tr class="datalist">
                        <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr>编号</nobr>
                        </td>
                        <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr>交易进度</nobr>
                        </td>

                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>匹配时间</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>打款会员</nobr>
                        </td>
                       <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>倒计时</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>付款金额</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>操作</nobr>
                        </td>
                    </tr>
					<?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="datalist">
                            <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr><?php echo ($vo["cr_eg"]); ?></nobr>
                        </td>
                        <td style="border: 1px #fceed1 solid; font-size: 12px;">
                            <nobr><?php echo ($crstatus[$vo[status]]); ?></nobr>
                        </td>

                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr><?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr><?php echo ($vo["name"]); ?></nobr>
                        </td>
                         <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr>
							<?php if($vo["status"] == 2 ): ?><strong id="hour_show__<?php echo ($i); ?>" style="color:green;"><s id="h"></s>0h:</strong>
							   <strong id="minute_show__<?php echo ($i); ?>" style="color:green;"><s></s>00m:</strong>
							   <strong id="second_show__<?php echo ($i); ?>" style="color:green;"><s></s>00s</strong>
							<?php else: ?>
								<strong id="hour_show__<?php echo ($i); ?>" style="color:#d00000;"><s id="h"></s>0h:</strong>
							   <strong id="minute_show__<?php echo ($i); ?>" style="color:#d00000;"><s></s>00m:</strong>
							   <strong id="second_show__<?php echo ($i); ?>" style="color:#d00000;"><s></s>00s</strong><?php endif; ?>
								<script type="text/javascript">
                                <?php if($vo["status"] == 1 or $vo["status"] == 4 ): ?>var intDiff__<?php echo ($i); ?> =<?php echo ($vo["die_time"]); ?>;
								<?php elseif($vo["status"] == 2): ?>
								var intDiff__<?php echo ($i); ?> =<?php echo ($vo["receive_time"]); ?>;
								<?php else: ?>
								var intDiff__<?php echo ($i); ?> =0;<?php endif; ?>

                                    //var intDiff = parseInt(60);//倒计时总秒数量
                                    function timer__<?php echo ($i); ?>(intDiff__<?php echo ($i); ?>) {
                                        window.setInterval(function() {
                                            var day = 0,
                                                    hour = 0,
                                                    minute = 0,
                                                    second = 0;//时间默认值
                                            if (intDiff__<?php echo ($i); ?> > 0) {
                                                //day = Math.floor(intDiff / (60 * 60 * 24));
                                                hour = Math.floor(intDiff__<?php echo ($i); ?> / (60 * 60));
                                                minute = Math.floor(intDiff__<?php echo ($i); ?> / 60) - (hour * 60);
                                                second = Math.floor(intDiff__<?php echo ($i); ?>) - (hour * 60 * 60) - (minute * 60);
                                            }
                                            if (minute <= 9)
                                                minute = '0' + minute;
                                            if (second <= 9)
                                                second = '0' + second;
                                            //$('#day_show').html(day+"天");
                                            $('#hour_show__<?php echo ($i); ?>').html('<s id="h"></s>' + hour + 'h:');
                                            $('#minute_show__<?php echo ($i); ?>').html('<s></s>' + minute + 'm:');
                                            $('#second_show__<?php echo ($i); ?>').html('<s></s>' + second + 's');
                                            intDiff__<?php echo ($i); ?>--;
                                        }, 1000);
                                    }

                                    $(function() {
                                        timer__<?php echo ($i); ?>(intDiff__<?php echo ($i); ?>);
                                    });
                                </script>
                       
								
							</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                            <nobr><?php echo ($vo["sum"]); ?> CNY</nobr>
                        </td>
                        <td style="font-size: 12px; border: 1px #fceed1 solid;">
                             <a href='javascript:#' ' onclick='receivables("600","600","接收帮助","<?php echo U("Index/receivables",array("id"=>$vo["id"]));?>")'>详情</a>
                        </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
                <div class="clear"></div>
            </div>
<div class="right" style="width: 299px;">
                <div id="providelist">

				<?php if(is_array($rightlist)): $i = 0; $__LIST__ = $rightlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="aceptlist sup_<?php echo ($vo["style"]); ?>">
                        <div style="width: 40px; text-align: center;" class="left">
                             <img src="/Public/images/home/jt.png" alt="xxxx" />
                        </div>
                        <div style="width: 215px;" class="right">
						<?php if($vo["style"] == 1): ?><span><strong>舍：提供帮助</strong><br />
                                <strong><?php echo ($vo["eg"]); ?></strong>
                            </span>
						<?php else: ?>
							<span><strong>得：接收帮助</strong><br />
                                <strong><?php echo ($vo["eg"]); ?></strong>
                            </span><?php endif; ?>
                        </div>
                        <div class="clear"></div>
                        <div class="aceptlistinfo">
                            <p>参加者: <?php echo ($vo["name"]); ?></p>
                            <p>金额: <?php echo ($vo["money"]); ?> CNY </p>
                            <p>日期: <?php echo (date('Y-m-d H:i:s',$vo["create_date"])); ?></p>
							<?php if($vo["style"] == 1): ?><p>状况：<?php echo ($cstatus[$vo[status]]); ?></p>
							<?php else: ?>
							<p>状况：<?php echo ($rstatus[$vo[status]]); ?></p><?php endif; ?>
                        </div>
                   </div><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="clear"></div> 
			<div class='page'><?php echo ($page1); ?></div>
		</div>
		</div>
		</div>
		</div>
</body>
</html>
<script>
		/******************************************************/
		jQuery(document).ready(function ($) {

		var gdBtn = $('#gdBtn');

		var pdBtn = $('#pdBtn');

		pdBtn.click(function () {

		$(this).toggleClass('active');

		gdBtn.removeClass('active');

		$('#pdWrap').stop(true, false).slideToggle('fast');

		$('#gdWrap').stop(true, false).slideUp('fast').removeClass('open');

		return false;

		});

		// if user status is freeze or just unblock and not yet do the maintain

		gdBtn.click(function () {

		$(this).toggleClass('active');

		pdBtn.removeClass('active');

		$('#gdWrap').stop(true,false).slideToggle('fast');

		$('#pdWrap').stop(true, false).slideUp('fast').removeClass('open');

		return false;

		});

		});

</script>