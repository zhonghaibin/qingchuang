<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class ReportController extends CommonController {

	/***
	*
	*报告管理
	*/
    public function index(){
		
		    $member_table=M('member');
			if (!empty($_REQUEST['search_starttime']) && !empty($_REQUEST['search_endtime'])) {
            $startime = strtotime($_REQUEST['search_starttime']);
            $endtime = strtotime($_REQUEST['search_endtime']);

            if ($startime <= $endtime) {
                $times = (strtotime($_REQUEST['search_starttime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_starttime'];
                $search['search_endtime'] = $_REQUEST['search_endtime'];
            } else {
                $times = (strtotime($_REQUEST['search_endtime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_endtime'];
                $search['search_endtime'] = $_REQUEST['search_starttime'];
            }
            $map['create_date'] = array('between', $times);
            //$timespan = strtotime(urldecode($_REQUEST['start_time'])) . "," . strtotime(urldecode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['create_date'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['create_date'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_username']))
			{
			
			$info=$member_table->field('id')->where(array('username'=>$_REQUEST['search_username']))->find();
			$map['user_id']=$info['id'];
			$search['search_username'] = $_REQUEST['search_username'];
			}
			if(!empty($_REQUEST['search_status']))
			{
			$map['status']=$_REQUEST['search_status'];
			$search['search_status'] = $_REQUEST['search_status'];
			}
		
		
		$c_table=M('c');
		$searchmoney=$c_table->where($map)->sum('money');
		$count=$c_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,50);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();
		$list=$c_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$ccount=count($list);
		for($i=0;$i<$ccount;$i++)
		{
		    $userinfo=$member_table->field('username,name')->find($list[$i]['user_id']);
			$list[$i]['username']=$userinfo['username'];
			$list[$i]['name']=$userinfo['name'];
			$list[$i]['allday']=$list[$i]['lineup_date']+$list[$i]['frozen_date'];
		}
		
		
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->assign('arr',$search);
		$this->assign('searchmoney',$searchmoney);
		$this->assign('status',C('CSTATUS'));
		$this->display();
		
    }

		//下载提供帮助Excel
	public function providedownloadexcel()
	{
		
		$status=C('CSTATUS');
		$member_table= M('member');		
		$xlsName  = "提供帮助报告"; //设置要导出excel的表头 
		$xlsCell  = array(
		array('id','ID'), 
		array('eg','流水号'),
		array('username','账号'),
		array('name','姓名'),
		array('money','本金'),
		array('sum','未匹配金额'),
		array('lineup_date','排队天数'),
		array('lineup_interest','排队利息'),
		array('frozen_date','冻结天数'),
		array('frozen_interest','冻结利息'),
		array('allday','总天数'),
		array('interest','总利息'),
		array('status','状态'),
		array('create_date','创建日期'),
		
		);
		$xlsModel =M('c');
		$xlsData=$xlsModel->Field('id,user_id,eg,money,sum,lineup_date,lineup_interest,frozen_date,frozen_interest,interest,status,create_date')->select();
		$xlscount=count($xlsData);
		for($i=0;$i<$xlscount;$i++)
		{
	
			$userinfo=$member_table->field('username,name')->find($xlsData[$i]['user_id']);
			$xlsData[$i]['username']=$userinfo['username'];
			$xlsData[$i]['name']=$userinfo['name'];
			$xlsData[$i]['create_date']=date('Y-m-d H:i:s',$xlsData[$i]['create_date']);
			$xlsData[$i]['status']=$status[$xlsData[$i]['status']];
			$xlsData[$i]['allday']=$xlsData[$i]['lineup_date']+$xlsData[$i]['frozen_date'];

		}
		$this->exportExcel($xlsName,$xlsCell,$xlsData);
			
	}
		//下载接收帮助Excel
	public function applydownloadexcel()
	{
		
		$status=C('RSTATUS');
		$member_table= M('member');		
		$xlsName  = "申请帮助报告"; //设置要导出excel的表头 
		$xlsCell  = array(
		array('id','ID'), 
		array('eg','流水号'),
		array('username','账号'),
		array('name','姓名'),
		array('money','本金'),
		array('sum','未匹配金额'),
		array('status','状态'),
		array('create_date','创建日期'),
		
		);
		$xlsModel =M('r');
		$xlsData=$xlsModel->Field('id,user_id,eg,money,sum,status,create_date')->select();
		$xlscount=count($xlsData);
		for($i=0;$i<$xlscount;$i++)
		{
	
			$userinfo=$member_table->field('username,name')->find($xlsData[$i]['user_id']);
			$xlsData[$i]['username']=$userinfo['username'];
			$xlsData[$i]['name']=$userinfo['name'];
			$xlsData[$i]['create_date']=date('Y-m-d H:i:s',$xlsData[$i]['create_date']);
			$xlsData[$i]['status']=$status[$xlsData[$i]['status']];
			$xlsData[$i]['allday']=$xlsData[$i]['lineup_date']+$xlsData[$i]['frozen_date'];

		}
		$this->exportExcel($xlsName,$xlsCell,$xlsData);
			
	}
	 public function rewards(){
		
			$member_table=M('member');
			if (!empty($_REQUEST['search_starttime']) && !empty($_REQUEST['search_endtime'])) {
            $startime = strtotime($_REQUEST['search_starttime']);
            $endtime = strtotime($_REQUEST['search_endtime']);

            if ($startime <= $endtime) {
                $times = (strtotime($_REQUEST['search_starttime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_starttime'];
                $search['search_endtime'] = $_REQUEST['search_endtime'];
            } else {
                $times = (strtotime($_REQUEST['search_endtime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_endtime'];
                $search['search_endtime'] = $_REQUEST['search_starttime'];
            }
            $map['create_date'] = array('between', $times);
            //$timespan = strtotime(urlderode($_REQUEST['start_time'])) . "," . strtotime(urlderode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['create_date'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['create_date'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_username']))
			{
			
			$info=$member_table->field('id')->where(array('username'=>$_REQUEST['search_username']))->find();
			$map['user_id']=$info['id'];
			$search['search_username'] = $_REQUEST['search_username'];
			}
			if(!empty($_REQUEST['search_status']))
			{
			$map['status']=$_REQUEST['search_status'];
			$search['search_status'] = $_REQUEST['search_status'];
			}
		
		
		
		$r_table=M('r');
		$searchmoney=$r_table->where($map)->sum('money');
		$count=$r_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($rount,50);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();
		$list=$r_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$rcount=count($list);
		for($i=0;$i<$rcount;$i++)
		{
		    $userinfo=$member_table->field('username,name')->find($list[$i]['user_id']);
			$list[$i]['username']=$userinfo['username'];
			$list[$i]['name']=$userinfo['name'];
			
		}
		
		$this->assign('searchmoney',$searchmoney);
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->assign('arr',$search);
		$this->assign('status',C('RSTATUS'));
		$this->display();
		
    }

	 public function transaction(){
		
	
			if (!empty($_REQUEST['search_starttime']) && !empty($_REQUEST['search_endtime'])) {
            $startime = strtotime($_REQUEST['search_starttime']);
            $endtime = strtotime($_REQUEST['search_endtime']);

            if ($startime <= $endtime) {
                $times = (strtotime($_REQUEST['search_starttime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_starttime'];
                $search['search_endtime'] = $_REQUEST['search_endtime'];
            } else {
                $times = (strtotime($_REQUEST['search_endtime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_endtime'];
                $search['search_endtime'] = $_REQUEST['search_starttime'];
            }
            $map['create_date'] = array('between', $times);
            //$timespan = strtotime(urlderode($_REQUEST['start_time'])) . "," . strtotime(urlderode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['create_date'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['create_date'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_status']))
			{
			$map['status']=$_REQUEST['search_status'];
			$search['search_status'] = $_REQUEST['search_status'];
			}
		
		
		
		$cr_table=M('cr');
		$member_table=M('member');
		$count=$cr_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,50);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();
		$list=$cr_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$crcount=count($list);
		for($i=0;$i<$crcount;$i++)
		{
		    $cuserinfo=$member_table->field('username,name,recommend')->find($list[$i]['c_user_id']);
			$list[$i]['c_username']=$cuserinfo['username'];
			$list[$i]['c_name']=$cuserinfo['name'];
			$ruserinfo=$member_table->field('username,name')->find($list[$i]['r_user_id']);
			$list[$i]['r_username']=$ruserinfo['username'];
			$list[$i]['r_name']=$ruserinfo['name'];
			$list[$i]['recommend']=$cuserinfo['recommend'];
			
		}
		
		
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->assign('arr',$search);
		$this->assign('status',C('CRSTATUS'));
		$this->display();
		
    }	
	 
	  public function detailed(){
		
			$member_table=M('member');
			if (!empty($_REQUEST['search_starttime']) && !empty($_REQUEST['search_endtime'])) {
            $startime = strtotime($_REQUEST['search_starttime']);
            $endtime = strtotime($_REQUEST['search_endtime']);

            if ($startime <= $endtime) {
                $times = (strtotime($_REQUEST['search_starttime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_starttime'];
                $search['search_endtime'] = $_REQUEST['search_endtime'];
            } else {
                $times = (strtotime($_REQUEST['search_endtime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_endtime'];
                $search['search_endtime'] = $_REQUEST['search_starttime'];
            }
            $map['create_date'] = array('between', $times);
            //$timespan = strtotime(urlderode($_REQUEST['start_time'])) . "," . strtotime(urlderode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['create_date'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['create_date'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_status']))
			{
			$map['status']=$_REQUEST['search_status'];
			$search['search_status'] = $_REQUEST['search_status'];
			}
			if(!empty($_REQUEST['search_type']))
			{
				
			$map['type']=$_REQUEST['search_type'];
			$search['search_type'] = $_REQUEST['search_type'];
			}
		
			if(!empty($_REQUEST['search_username']))
			{
			$info=$member_table->field('id')->where(array('username'=>$_REQUEST['search_username']))->find();
			$map['user_id']=$info['id'];
			$search['search_username'] = $_REQUEST['search_username'];
			}
		
	
		$bonus_table=M('bonus');
		$count=$bonus_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,50);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();
		$list=$bonus_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$bcount=count($list);
		for($i=0;$i<$bcount;$i++)
		{   

			if(!empty($list[$i]['from_id']))
			{
			$frominfo=$member_table->field('username')->find($list[$i]['from_id']);
			$list[$i]['fromname']=$frominfo['username'];
			}
			else
			{
				$list[$i]['fromname']='无';
			}
			if(!empty($list[$i]['from_scale']))
			{
			$list[$i]['from_scale']=($list[$i]['from_scale']*100).'%';
			}
			else
			{
				$list[$i]['from_scale']='无';
			}
		    $userinfo=$member_table->field('username')->find($list[$i]['user_id']);
			$list[$i]['username']=$userinfo['username'];
		
			if(!empty($list[$i]['settlement_id']))
			{
			$settlement=$member_table->field('username')->find($list[$i]['settlement_id']);
			$list[$i]['settlementname']=$settlement['username'];
			}
			else
			{
				$list[$i]['settlementname']='无';
			}
			
		}
		
		
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->assign('arr',$search);
		$this->display();
		
    }	


   public function recharge(){
	
		$member_table=M('member');
		if (!empty($_REQUEST['search_starttime']) && !empty($_REQUEST['search_endtime'])) {
		$startime = strtotime($_REQUEST['search_starttime']);
		$endtime = strtotime($_REQUEST['search_endtime']);

		if ($startime <= $endtime) {
			$times = (strtotime($_REQUEST['search_starttime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime'] . '23:59:59'));
			$search['search_starttime'] = $_REQUEST['search_starttime'];
			$search['search_endtime'] = $_REQUEST['search_endtime'];
		} else {
			$times = (strtotime($_REQUEST['search_endtime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime'] . '23:59:59'));
			$search['search_starttime'] = $_REQUEST['search_endtime'];
			$search['search_endtime'] = $_REQUEST['search_starttime'];
		}
		$map['create_date'] = array('between', $times);
		//$timespan = strtotime(urlderode($_REQUEST['start_time'])) . "," . strtotime(urlderode($_REQUEST['end_time']));
		} elseif (!empty($_REQUEST['search_starttime'])) {
		$xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
		$map['create_date'] = array("egt", $xtime);
		$search['search_starttime'] = $_REQUEST['search_starttime'];
		 } elseif (!empty($_REQUEST['search_endtime'])) {
		$xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
		$map['create_date'] = array("elt", $xtime);
		$search['search_endtime'] = $_REQUEST['search_endtime'];
		}
		if(!empty($_REQUEST['search_status']))
		{	
		$map['status']=$_REQUEST['search_status'];
		$search['search_status'] = $_REQUEST['search_status'];
		}
		if(!empty($_REQUEST['search_type']))
		{
			
		$map['type']=$_REQUEST['search_type'];
		$search['search_type'] = $_REQUEST['search_type'];
		}
		if(!empty($_REQUEST['search_username']))
		{
		
		$info=$member_table->field('id')->where(array('username'=>$_REQUEST['search_username']))->find();
		$map['user_id']=$info['id'];
		$search['search_username'] = $_REQUEST['search_username'];
		}
	

	$recharge_table=M('recharge');
	$count=$recharge_table->where($map)->count();// 查询满足要求的总记录数
	$Page= new \Think\Page($count,50);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	$show= $Page->show();
	$list=$recharge_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
	$rcount=count($list);
	for($i=0;$i<$rcount;$i++)
	{
		$userinfo=$member_table->field('username')->find($list[$i]['user_id']);
		$list[$i]['username']=$userinfo['username'];
		$admininfo=M('admin')->field('username')->find($list[$i]['admin_id']);
		$list[$i]['adminname']=$admininfo['username'];
		
		
	}
	
	
	$this->assign('list',$list);
	$this->assign('count',$count);
	$this->assign('page',$show);
	$this->assign('arr',$search);
	$this->display();
		
    }	
	//撤单 c 记录
	public function cancel_c()
	{
		$c_table=M('c');
		$member_table=M('member');
		$member_table->startTrans();
		$id=I('get.id');
		$c_info=$c_table->field('user_id,splitno')->find($id);
		if($c_info['splitno']==0)
		{
			$relsult=$c_table->delete($id);
			$m_relust=$member_table->save(array('id'=>$c_info['user_id'],'cstatus'=>'0'));
			if($relsult&&$m_relust)
			{
				$member_table->commit(); 
				$json['status']=1;
				$json['msg']='撤单成功';
				echo json_encode($json);
				exit;	
			}
			else
			{	$member_table->rollback();
				$json['status']=0;
				$json['msg']='撤单失败';
				echo json_encode($json);
				exit;	
			}
		}else
		{
				$json['status']=0;
				$json['msg']='已经参与匹配，无法撤单！';
				echo json_encode($json);
				exit;	
		}
	}
	//撤单 r 记录
	public function cancel_r()
	{
		$r_table=M('r');
		$member_table=M('member');
		$bonus_table=M('bonus');
		$member_table->startTrans();
		$id=I('get.id');
		$r_info=$r_table->field('user_id,type,money,splitno')->find($id);
		if($r_info['splitno']==0)
		{	$userinfo=$member_table->field('cash,activity')->find($r_info['user_id']);
			$money=$userinfo['cash']+$r_info['money'];
			if($r_info['type']==1)
			{
			$m_result=$member_table->save(array('id'=>$r_info['user_id'],'cash'=>$money));
			}else if($r_info['type']==2)
			{
			$m_result=$member_table->save(array('id'=>$r_info['user_id'],'activity'=>$money));
			}
			//生成流水记录
				 $data=array(
					 'user_id'=>$r_info['user_id'],
					 'type'=>$r_info['type'],
					 'create_date'=>time(),
					 'sum'=>$r_info['money'],
					 'export'=>0,
					 'balance'=>$money,
					 'status'=>1,
					 'explain'=>'撤单返款',
				 );
			$b_rel=$bonus_table->add($data);

			$relsult=$r_table->delete($id);
			if($relsult&&$m_result&&$b_rel)
			{
		
				$member_table->commit(); 
				$json['status']=1;
				$json['msg']='撤单成功';
				echo json_encode($json);
				exit;	
			}
			else
			{	$member_table->rollback();
				$json['status']=0;
				$json['msg']='撤单失败';
				echo json_encode($json);
				exit;	
			}
		}else
		{
				$json['status']=0;
				$json['msg']='已经参与匹配，无法撤单！';
				echo json_encode($json);
				exit;	
		}
	}
	
	//撤单 cr 记录
	public function cancel_cr()
	{
		$r_table=M('r');
		$cr_table=M('cr');
		$c_table=M('c');
		$cr_table->startTrans();
		$id=I('get.id');
		$cr_info=$cr_table->field('c_id,r_id,status,sum')->find($id);
		if($cr_info['status']!=3)
		{	
			$c_info=$c_table->field('sum,splitno')->find($cr_info['c_id']);
			$c_rel=$c_table->save(array('id'=>$cr_info['c_id'],'sum'=>$c_info['sum']+$cr_info['sum'],'splitno'=>$c_info['splitno']-1,'status'=>'1'));
			$r_info=$r_table->field('sum,splitno')->find($cr_info['r_id']);
			$r_rel=$r_table->save(array('id'=>$cr_info['r_id'],'sum'=>$r_info['sum']+$cr_info['sum'],'splitno'=>$r_info['splitno']-1,'status'=>'1'));


			$relsult=$cr_table->delete($id);
			if($relsult&&$c_rel&&$r_rel)
			{
		
				$cr_table->commit(); 
				$json['status']=1;
				$json['msg']='撤单成功';
				echo json_encode($json);
				exit;	
			}
			else
			{	$cr_table->rollback();
				$json['status']=0;
				$json['msg']='撤单失败';
				echo json_encode($json);
				exit;	
			}
		}else
		{
				$json['status']=0;
				$json['msg']='已经交易完成，无法撤单！';
				echo json_encode($json);
				exit;	
		}
	}

	//罚款
	public function fine()
	{		
			$relust=$this->bonusset();
			$fine=explode(',',$relust['fine']);
			$finecount=count($fine);
			
		
			$member_table=M('member');
			$illegal_table=M('illegal');
			$bonus_table=M('bonus');
			
			$rid=I('get.rid');//推荐人id
			$uid=I('get.uid');//用户id
			$info=$member_table->field('username,mobile')->find($uid);
			$userinfo=$member_table->field('cash')->find($rid);
			$illegalinfo=$illegal_table->where(array('uid'=>$rid))->find();
			$flag=0;
			
			if(!$illegalinfo)
			{
				$t_id=$illegal_table->add(array('uid'=>$rid));
				$flag=1;
			}
			else{
				$flag=2;
			}
			if($flag==2)
			{
			$userid=explode(',',rtrim($illegalinfo['other_id'],','));
			$allowid=in_array($uid,$userid);
			$key=count($userid)-1;
			$sum=0;
				if($allowid)
				{
					$json['status']=0;
					$json['msg']='该用户已经罚过推荐人的款，无需操作！';
					echo json_encode($json);
					exit;	
				}
			}
		
				 //罚款金额

				 if(empty($fine[$key]))
				 {
					$sum=  $fine[$finecount-1];//最后一个值
				 }
				 else
				 {
					$sum= $fine[$key];//对应的值
				 }
				 
				 $finemoney=$userinfo['cash']-$sum;
			
				 $member_table->save(array('id'=>$rid,'cash'=>$finemoney));
				  //生成流水记录
                  $cash_data = array(
                        'user_id' => $rid,
                        'type' => 1,
                        'create_date' => time(),
                        'sum' => 0,
                        'export' =>$sum,
                        'balance' =>$finemoney,
                        'status' => 2,
                        'explain' => '玩家：不打款扣除',
                    );
                   $bonus_table->add($cash_data);
					if($flag==1)
					{
						$illegal_table->save(array('id'=>$t_id,'other_id'=>$uid));
					}
					else if($flag==2)
					{
						$illegal_table->save(array('id'=>$illegalinfo['id'],'other_id'=>$illegalinfo['other_id'].",".$uid));
					}

					$json['status']=1;
					$json['msg']='操作成功';
					echo json_encode($json);
					exit;	
					


	}
}