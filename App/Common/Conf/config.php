<?php
return array(
	//'配置项'=>'配置值'
	//'MODULE_DENY_LIST'      => array('Home'),//禁用的分组
	'DEFAULT_MODULE'       =>    'Home',
	'MODULE_ALLOW_LIST'     => array('Home','Admin'),//允许的分组


	/* 数据库设置 */
	'DB_TYPE'               => 'mysql',      // 数据库类型
	'DB_HOST'               => '127.0.0.1',   // 服务器地址
	'DB_NAME'               => 'qingchuang',         // 数据库名
	'DB_USER'               => 'qingchuang',        // 用户名
	'DB_PWD'                => 'cy937055707*@%#',            // 密码
	'DB_PORT'               => '5056',        // 端口
	'DB_PREFIX'             => 'web_',       // 数据库表前缀
	/* 数据库设置  end*/
	
	/* 模板解析设置 */
		'TMPL_PARSE_STRING' => array(
			'./Public/upload/'  => '/Public/upload/',
			'__PUBLIC__'        => '/Public',
			'__STYLE__'        =>'/Public/style',
			'__IMG__'        => '/Public/images',
			'__JS__'        => '/Public/js',
			'__FONT__'        => '/Public/font',
		),
	
	'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
    'TOKEN_NAME'    =>    'token',    // 令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
	
	'MEMBER_UPLOAD_DIR'=>'Public/upload/',
	/* 模板解析设置 end */
	'DEFAULT_FILTER'        => 'htmlspecialchars',//设置字符过滤方法
	'TMPL_L_DELIM'          => '<{',         // 模板引擎普通标签开始标记
	'TMPL_R_DELIM'          => '}>',         // 模板引擎普通标签结束标记
	'TMPL_ACTION_ERROR' =>"./App/Admin/View/Common/tip.html",//操作错误提示
	'TMPL_ACTION_SUCCESS' =>"./App/Admin/View/Common/tip.html",//操作正确提示
	'TMPL_EXCEPTION_FILE'=>'./App/Admin/View/Common/error.html',//系统错误页面
	//'URL_ROUTER_ON'   => true,




	'CSTATUS'=>array(
		'1'=>'等待匹配',
		'2'=>'完成匹配',
		'3'=>'继续匹配',
		'4'=>'',//48小时没付款
		'5'=>'完成打款',
		'6'=>'',
		'7'=>'完成交易',
	 ),
	 
	'RSTATUS'=>array(
		'1'=>'等待匹配',
		'2'=>'完成匹配',
		'3'=>'完成收款',
	),
	'CRSTATUS'=>array(
		'1'=>'等待打款',
		'2'=>'等待确认',
		'3'=>'完成收款',
		'6'=>'未确认过期',
		'5'=>'未打款过期',
		'4'=>'拒绝',
		
	),

	 
);