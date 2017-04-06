<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 会员模块公共控制器
 * @author 285734743
 * 
 */
class CommonController extends Controller {
	function _initialize(){
		//手机版  需要使用则去掉注释
		/*$mobile=new \Common\Plugin\Mobile_Detect();
		if($mobile->isMobile() || $mobile->isMobile() && $mobile->isTablet()){
			C('DEFAULT_V_LAYER','Mobile');
			C('TMPL_ACTION_ERROR',"./Admin/View/common/tip.html");
			C('TMPL_ACTION_SUCCESS',"./Admin/View/common/tip.html");
			C('TMPL_EXCEPTION_FILE',"./Admin/View/common/error.html");
			
		}*/	
		
		$webconfig = M('webconfig');
        $webconfig = $webconfig->where('id=1')->find();
        $basedata = json_decode($webconfig['value'], true);
		if($basedata['onoff']==0)
		{
			$this->display('Common:info');
			exit;
		}
		
		//新用户1天没排队冻结
		$this->freezenewuser();
		//N天不复投冻结
		$this->notactiveuser();
		//24小时不打款冻结
		$this->blacklist();
		//上传凭证后，对方未点击确认按钮 冻结
		$this->notoperate();
		//拒绝后到期，冻结
		$this->refuse();
		//重置每日限额
		$this->quota();

		$this->futou();




			/*判断是否登录*/
		if(session('uid')){
			$this->checkAdminSession();
			$userinfo=M('member')->field('mobile,cash,activity,frozen')->find(session('uid'));
			$this->assign('userinfo',$userinfo);

		}else{
			redirect(U('Login/index'));
		}
		
	}
	

	//重置排队限额
	function quota()
	{
		$table_webconfig=M('webconfig');
		$allow_money=$table_webconfig->find('4');
		$xianzhi=json_decode($allow_money['value'],true);
		$todayTime = mktime(0, 0, 0,date("m"),date("d"),date("Y"));
		$tomorrow=$todayTime +60*60*24;//明天凌晨
		if($xianzhi['time']<$tomorrow)
		{
			
					$data=array(
					'id'=>'4',
					'value'=>json_encode(array('time'=>$tomorrow,'allmoney'=>'0')),
					);
		
					$table_webconfig->save($data);
		
		}
	
	}

	//登录超时验证
   function checkAdminSession() {
			 //设置超时为20分
			$nowtime = time();
			$s_time = $_SESSION['logintime'];
			 if (($nowtime - $s_time) >60*60*2) {
			unset($_SESSION['logintime']);
			unset($_SESSION['uid']);
			$this->error('登录超时，请重新登录', U('Home/login'));
			exit;
			 } else {
				$_SESSION['logintime'] = $nowtime;
			 }
	 }

	  //72小时没排队的冻结新用户
	 function  freezenewuser()
	 {
			$member=M('member');
			$frozenlog_table=M('frozenlog');
			$c=M('c');
			$times=time();
		
			$data['status']=array('eq',1);
			$data['flag']=array('eq',0);//看有没有排第一单
			$data['frozentime']=array('lt',$times);
			$userlist=$member->field('id')->where($data)->select();
			for($i=0;$i<count($userlist);$i++)
			{	
				$c_rel=$c->where(array('user_id'=>$userlist[$i]['id']))->find();
				if(!$c_rel)
				{
				    $member->save(array('id'=>$userlist[$i]['id'],'status'=>'3'));

					$frozenlog_table->add(array('uid'=>$userlist[$i]['id'],'value'=>'新用户规定时间内没排单冻结','create_date'=>time()));
				}
			}
			unset($data);

	 }

	//没复投的用户冻结
	function futou()
	{

			unset($data);
			$relust=$this->bonusset();
			$member=M('member');
			$frozenlog_table=M('frozenlog');
			$times=time();
			$c_table=M('c');
			$data['status']=array('eq',1);//正常用户
			$data['cstatus']=array('eq',0);//可以排队
			$data['flag']=array('eq',1);
			//$data['countdown']=array('lt',$times);
			//$data['singletime']=array('elt', (time() - (3600 * $relust['clearancetime'])));
			$data['countdown']=array('elt', (time() - (3600 * $relust['clearancetime'])));
			$userlist=$member->field('id,recommend')->where($data)->select();
			for($i=0;$i<count($userlist);$i++)
			{
					$c_info1=$c_table->order('id desc')->field('id')->where(array('user_id'=>$userlist[$i]['id']))->find();
					$c_info2=$c_table->order('id desc')->field('id,finish_date')->where(array('user_id'=>$userlist[$i]['id'],'status'=>'5'))->find();
					if($c_info1['id']==$c_info2['id'])
					{
						if($c_info2['finish_date']+60*60*($relust['clearancetime'])<$times)
						{
							$member->save(array('id'=>$userlist[$i]['id'],'status'=>'3'));
							$this->subtractgroup($userlist[$i]['recommend']);//减组数
							subtractrecommend($userlist[$i]['recommend']);//减推荐人的直推人
							$frozenlog_table->add(array('uid'=>$userlist[$i]['id'],'value'=>'规定时间内没复投冻结..','create_date'=>time()));
						}
					}
					

			}

	}

	//复投(N天)没排队冻结
	 function notactiveuser()
	 {
			$member=M('member');
			$frozenlog_table=M('frozenlog');
			$relust=$this->bonusset();
			$times=time();
			unset($data);
			$data['status']=array('eq',1);//正常用户
			$data['cstatus']=array('eq',0);//可以排队
			//$data['countdown']=array('lt',$times);
			$data['countdown']=array('elt', ($times- (3600 * $relust['clearancetime'])));
			$data['flag']=array('eq',1);
			//$data['countdown_status']=array('eq',1);
			$userlist=$member->field('id,recommend')->where($data)->select();
		
			for($i=0;$i<count($userlist);$i++)
			{
					$member->save(array('id'=>$userlist[$i]['id'],'status'=>'3'));
					$this->subtractgroup($userlist[$i]['recommend']);//减组数
					subtractrecommend($userlist[$i]['recommend']);//减推荐人的直推人
					$frozenlog_table->add(array('uid'=>$userlist[$i]['id'],'value'=>'规定时间内没复投冻结','create_date'=>time()));
					

			}
	 }
	
	//匹配后24小时没交钱冻结该用户
	public function blacklist()
	{	$member=M('member');
		$cr=M('cr');
		$frozenlog_table=M('frozenlog');
		$list=$cr->where(array('status'=>'1'))->select();
		for($i=0;$i<count($list);$i++)
		{	
			if($list[$i]['die_time']<time())
			{	unset($info);
				unset($map);
				unset($info_c);
				
				$info['id']=$list[$i]['c_user_id'];
				$userlist=$member->field('recommend,status')->where($info)->limit(20)->find();
				if($userlist['status']==1)
				{
					$info['status']=3;//冻结该用户
					$member->save($info);
					if($userlist['estate']==1)
					{
					$this->subtractgroup($userlist['recommend']);//减组数
					subtractrecommend($userlist['recommend']);//减推荐人的直推人
						
					}
					$frozenlog_table->add(array('uid'=>$list[$i]['c_user_id'],'value'=>'规定时间内没打款冻结','create_date'=>time()));
				}
				//cr48小时过期
				$map['id']=$list[$i]['id'];
				$map['status']=5;//24小时过期
				$cr->save($map);
	
			
			}
		}
	
	
	}


	//付款后，对方未帮他点确认按钮(6小时冻结)
	public function notoperate()
		{
			$cr_table=M('cr');
			$frozenlog_table=M('frozenlog');
			$list=$cr_table->where(array('status'=>'2'))->select();
			for($i=0;$i<count($list);$i++)
			{
				if($list[$i]['receive_time']<time())
				{
					$cr_data['id']=$list[$i]['id'];
					$cr_data['status']=6;
					$cr_table->save($cr_data);
					//把收款方冻结  //管理员后台帮他解除冻结，解除冻结后可以操作该条数据，后台也可以直接确认
					$m['id']=$list[$i]['r_user_id'];
					$userlist=M('member')->field('recommend,estate,status')->where($m)->find();
					if($userlist['status']==1)
					{
						$m['status']=3;
						M('member')->save($m);
					
						if($userlist['estate']==1)
						{
						$this->subtractgroup($userlist['recommend']);//减组数
						subtractrecommend($userlist['recommend']);//减推荐人的直推人
						}
						$frozenlog_table->add(array('uid'=>$list[$i]['r_user_id'],'value'=>'规定时间内没确认冻结','create_date'=>time()));
					}
				}
			
			}
	   }

	 //拒绝记录到期后 打款方冻结
	public function refuse()
	{
		
		$cr=M('cr');
		$member_table=M('member');
		$frozenlog_table=M('frozenlog');
		$list=$cr->where(array('status'=>'4'))->select();
		for($i=0;$i<count($list);$i++)
		{	unset($map);unset($info_r);unset($info);unset($info_c);
			
			if($list[$i]['die_time']<time())
			{	
				$map['id']=$list[$i]['id'];
				$map['status']=5;//过期
				$cr->save($map);
				

				//冻结该用户
				$info['id']=$list[$i]['c_user_id'];
				$userlist=$member_table->field('recommend,status')->where($info)->find();

				if($userlist['status']==1)
				{
					$info['status']=3;
					$member_table->save($info);
					if($userlist['estate']==1)
					{
						$this->subtractgroup($userlist['recommend']);//减组数
						subtractrecommend($userlist['recommend']);//减推荐人的直推人
					}
					$frozenlog_table->add(array('uid'=>$list[$i]['c_user_id'],'value'=>'被拒绝后规定时间内没打款冻结','create_date'=>time()));
				}
				
			}
		}
	}


	  //更新上线group
   function  upline($upline_id)
	{   unset($map3);
		unset($row);
		$map3['id']=$upline_id;
		$row=M('member')->where($map3)->find(); 
		$map3['truegroup']=$row['truegroup']+1;
		M('member')->save($map3);
		if($row['recommend']!=0)
		{
		self::upline($row['recommend']);
		}
		
	} 
	//更新上线group2
   function  upline2($upline_id)
	{   unset($map3);
		unset($row);
		$map3['id']=$upline_id;
		$row=M('member')->where($map3)->find(); 
		
		$map3['group']=$row['group']+1;
		M('member')->save($map3);
		if($row['recommend']!=0)
		{
		self::upline2($row['recommend']);
		}
		
	}
	//冻结一个用户减去往上面组的人数减一，
	function subtractgroup($upline_id)
	{   unset($map3);unset($row);

		$map3['id']=$upline_id;
		$row=M('member')->field('recommend,group')->where($map3)->find(); 
		$map3['group']=$row['group']-1;
		M('member')->save($map3);
		if($row['recommend']!=0)
		{
		 self::subtractgroup($row['recommend']);
		}
		
	}

    

	//获取参数信息(奖金设置)
	function bonusset()
	{
		$table_webconfig=M('webconfig');
		$setbonus=$table_webconfig->find('2');
		$relust=json_decode($setbonus['value'],true);
		return $relust;
	}
	//获取参数信息(奖励设置)
	function rewardset()
	{
		$table_webconfig=M('webconfig');
		$setreward=$table_webconfig->find('3');
		$relust=json_decode($setreward['value'],true);
		return $relust;
	}
	//经理id对应的利息比例
	function manager_bonus()
	{
		$relust=$this->rewardset();
		$level=explode(',',rtrim($relust['level'],','));
		$manager=explode(',',rtrim($relust['manager'],','));
		$managerbonus=explode(',',rtrim($relust['managerbonus'],','));
		$manager_id=array();//经理id 和对应的比例
		
		foreach($level as $key=>$value)
		{
			foreach($manager as $k=>$v)
			{
				if($value==$v)
				{  foreach ($managerbonus as $kk=>$vv)
					{
						if($k==$kk)
						{
							$manager_id[$key]=$vv/100;
						}
					}
				}
			}
		}

		return $manager_id;
		
	}

		
	//获取经理对应的哪一代开始算经理奖
	function manager_level()
	{
		$relust=$this->rewardset();
		$level=explode(',',rtrim($relust['level'],','));
		$manager=explode(',',rtrim($relust['manager'],','));
		$star=explode(',',rtrim($relust['star'],','));
		$manager_id=array();//经理id 和对应的比例
		foreach($level as $key=>$value)
		{
			foreach($manager as $k=>$v)
			{
				if($value==$v)
				{  foreach ($star as $kk=>$vv)
					{
						if($key==$kk)
						{
							$manager_id[$key]=$vv;
						}
					}
				}
			}
		}
	
		return $manager_id;
		
	}

	
}

	
