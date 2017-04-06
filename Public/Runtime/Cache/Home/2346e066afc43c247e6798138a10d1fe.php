<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title></title>
<meta name="Keywords">
<meta name="description">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="expires" content="0">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width,maximum-scale=1.0,initial-scale=1.0,user-scalable=0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link type="text/css" rel="stylesheet" href="/Public/style/home/style.css">
<style type="text/css">
  .Prompt_con dd {padding:20px 0;margin:0;display:inline-block;float:left;}
</style>
<script type="text/javascript">
function Jump(){
    window.location.href = '<?php echo ($jumpUrl); ?>';
}
document.onload = setTimeout("Jump()" , <?php echo ($waitSecond); ?>* 1000);
</script>
<base target="_self" />
</head><body>
<?php if(($status) == "1"): ?><div class="Prompt">
  <div class="Prompt_top"></div>
  <div class="Prompt_con">
    <dl>
      <dt>TIPS</dt>
      <dd><span class="Prompt_ok"></span></dd>
      <dd>
        <h2 style='padding:30px 0 0 25px;'><?php echo ($message); ?></h2>
        <?php if(isset($closeWin)): ?><!--<p>系统将在 <span style="color:blue;font-weight:bold"><?php echo ($waitSecond); ?></span> 秒后自动关闭，如果不想等待,直接点击 <a href="{$jumpUrl}">这里</a> 关闭</p>--><?php endif; ?>
        <?php if(!isset($closeWin)): ?><!--<p>系统将在 <span style="color:blue;font-weight:bold"><?php echo ($waitSecond); ?></span> 秒后自动跳转,如果不想等待,直接点击 <a href="{$jumpUrl}">这里</a> 跳转</p>--><?php endif; ?>
      </dd>
    </dl>
    <div class="c"></div>
    </div>
    <div class="Prompt_btm"></div>
  </div><?php endif; ?>
<?php if(($status) == "0"): ?><div class="Prompt">
    <div class="Prompt_top"></div>
  <div class="Prompt_con">
    <dl>
      <dt>TIPS</dt>
      <dd><span class="Prompt_x"></span></dd>
      <dd>
      <h2 style="color:#d00000;padding:30px 0 0 25px;"><?php echo ($error); ?></h2>
        <?php if(isset($closeWin)): ?><!--<p>系统将在 <span style="color:blue;font-weight:bold"><?php echo ($waitSecond); ?></span> 秒后自动关闭，如果不想等待,直接点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 关闭</p>--><?php endif; ?>
      <?php if(!isset($closeWin)): ?><!--<p>系统将在 <span style="color:blue;font-weight:bold"><?php echo ($waitSecond); ?></span> 秒后自动跳转,如果不想等待,直接点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 跳转<br/>
          或者 <a href="/">返回首页</a></p>--><?php endif; ?>
      </dd>
    </dl>
    <div class="c"></div>
    </div>
    <div class="Prompt_btm"></div>
  </div><?php endif; ?>
</body>
</html>