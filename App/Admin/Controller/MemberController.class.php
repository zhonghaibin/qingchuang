<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class MemberController extends CommonController {

	/***
	*
	*会员中心
	*/
    public function index(){
		
		   $member_table=M('member');
           $newscount= $member_table->where(array('regtime'=>array('egt', (time() - (3600 * 24 * 7)))))->count();
           $this->assign('newscount', $newscount);
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
            $map['regtime'] = array('between', $times);
            //$timespan = strtotime(urldecode($_REQUEST['start_time'])) . "," . strtotime(urldecode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['regtime'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['regtime'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_username']))
			{
			$map['username']=$_REQUEST['search_username'];
			$search['search_username'] = $_REQUEST['search_username'];
			}
			if(!empty($_REQUEST['search_status']))
			{
			$map['status']=$_REQUEST['search_status'];
			$search['search_status'] = $_REQUEST['search_status'];
			}
			else
			{
				$map['status']=1;
				$search['search_status'] =1;
			}
			
		
		$relust=$this->rewardset();
		$level=explode(',',$relust['level']);
	
		$count=$member_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list=$member_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$allcount=count($list);
		
		for($i=0;$i<$allcount;$i++)
		{
			$list[$i]['star']=$level[$list[$i]['star']];
			$re_info=$member_table->field('username,name')->find($list[$i]['recommend']);
			
			if($re_info){
			$list[$i]['recommend']=$re_info['username'];
			$list[$i]['recommendname']=$re_info['name'];
			}else
			{
				$list[$i]['recommend']='无';
				$list[$i]['recommendname']='无';
			}
			
		}
		
		
		$this->assign('page',$show);
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('arr',$search);
		$this->display();
		
    }

	public function manager()
	{
		
		$member_table=M('member');
		$relust=$this->rewardset();
		$level=explode(',',$relust['level']);
		if(empty($_REQUEST['search_star']))
		{
			$_REQUEST['search_star']=1;
		}

		if($_REQUEST['search_star']==1)//检索出需要升级为M2的用户 (star=1) （条件说明：直推7人，团队25人）
		{
			$list1=$member_table->field('id,star')->where(array('star'=>array('eq','0'),'truedirectnum'=>array('egt','7'),'truegroup'=>array('egt','25')))->select();
			$count1=count($list1);
			for($i=0;$i<$count1;$i++)
			{
					$str1_id.=$list1[$i]['id'].',';
			}
			
			$str1_id=rtrim($str1_id,',');
			
		
		}
		else if($_REQUEST['search_star']==2)//检索出需要升级为M2的用户 (star=2) (条件说明：直推13个人，直推中有5个m2或者3个m2达到167人)
		{
			$list1=$member_table->field('id,star')->where(array('star'=>array('eq','1'),'truedirectnum'=>array('egt','13'),'truegroup'=>array('egt','167')))->select();
			$list2=$member_table->field('id,star')->where(array('star'=>array('eq','1'),'truedirectnum'=>array('egt','13')))->select();
			$count1=count($list1);
			$count2=count($list2);
			
			for($i=0;$i<$count1;$i++)
			{
					$rlista1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','1')))->select();
					$counta1=count($rlista1);
					if($counta1>=3)
					{
							$str1_id.=$list1[$i]['id'].',';
					}
			}
			
			for($i=0;$i<$count2;$i++)
			{
					$rlistb1=$member_table->field('star')->where(array('recommend'=>$list2[$i]['id'],'star'=>array('egt','1')))->select();
					$countb1=count($rlistb1);
					if($countb1>=5)
					{
						$str1_id.=$list2[$i]['id'].',';
					}
			}
		
			$str1_id=rtrim($str1_id,',');
			$str1_id=explode(',',$str1_id);
			$str1_id=array_unique($str1_id);
			$str1_id=implode(',',$str1_id);	
		}
		else if($_REQUEST['search_star']==3)//检索出需要升级为经理的用户 （star=3）（条件说明：直推20个人，其中有2个m3和3个m2）
		{
			$list1=$member_table->field('id,star')->where(array('truedirectnum'=>array('egt','20'),'star'=>array('eq','2')))->select();
			$count1=count($list1);
			for($i=0;$i<$count1;$i++)
			{
					$rlista1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','1')))->select();
					$rlistb1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','2')))->select();
					$counta1=count($rlista1);
					$countb1=count($rlistb1);
				
					if($counta1>=3&&$countb1>=2)
					{
						if($list1[$i]['star']<3)
						{
						$str1_id.=$list1[$i]['id'].',';
						}
					}	
					
			}

			$str1_id=rtrim($str1_id,',');
		}
		else if($_REQUEST['search_star']==4)//检索出需要升级为高级的用户 （star=4） （条件说明：直推中有2个经理和2个m3，或者1个经理和5个m3）
		{
			$list1=$member_table->field('id,star')->where(array('star'=>array('eq','3')))->select();
			$count1=count($list1);
			for($i=0;$i<$count1;$i++)
			{
					$rlista1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','3')))->select();
					$rlistb1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','2')))->select();
					$counta1=count($rlista1);
					$countb1=count($rlistb1);
					if(($counta1>=2&&$countb1>=2)||($counta1>=1&&$countb1>=5))
					{
						
							$str1_id.=$list1[$i]['id'].',';
						
					}	
			}
			$str1_id=rtrim($str1_id,',');
			

		}
		else if($_REQUEST['search_star']==5)//检索出需要升级为高级的用户 （star=5）（条件说明：直推中有2个高级和3个经理和3个m3，或者1个高级和五个经理和5个m3）
		{
			$list1=$member_table->field('id,star')->where(array('star'=>array('eq','4')))->select();
			$count1=count($list1);
			for($i=0;$i<$count1;$i++)
			{
					$rlista1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','4')))->select();
					$rlistb1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','3')))->select();
					$rlistc1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','2')))->select();
					$counta1=count($rlista1);
					$countb1=count($rlistb1);
					$countc1=count($rlistc1);
					if(($counta1>=2&&$countb1>=3&&$countc1>=3)||($counta1>=1&&$countb1>=5&&$countc1>=5))
					{
						
							$str1_id.=$list1[$i]['id'].',';
						
					}	
			}
			$str1_id=rtrim($str1_id,',');
			
		}
		else if($_REQUEST['search_star']==6)//检索出需要升级为高级的用户 （star=6）  条件说明（直推中3个总监升级为董事）
		{
			$list1=$member_table->field('id,star')->where(array('star'=>array('eq','5')))->select();
			$count1=count($list1);
			for($i=0;$i<$count1;$i++)
			{
					$rlista1=$member_table->field('star')->where(array('recommend'=>$list1[$i]['id'],'star'=>array('egt','5')))->select();
					$counta1=count($rlista1);
					if(($counta1>=3))
					{
						
							$str1_id.=$list1[$i]['id'].',';
						
					}	
			}
			$str1_id=rtrim($str1_id,',');
			
		}
		else
		{
				$str1_id='';
		}
		$search['search_star'] = $_REQUEST['search_star'];

	    $map['id']=array('in',$str1_id);

		$relust=$this->rewardset();
		$level=explode(',',$relust['level']);
		$count=$member_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list=$member_table->field('username,name,recommend,star,directnum,truedirectnum,status,id,regtime')->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$allcount=count($list);
		for($i=0;$i<$allcount;$i++)
		{
			$list[$i]['star']=$level[$list[$i]['star']];
			$re_info=$member_table->field('username,name')->find($list[$i]['recommend']);
			
			if($re_info){
			$list[$i]['recommend']=$re_info['username'];
			$list[$i]['recommendname']=$re_info['name'];
			}else
			{
				$list[$i]['recommend']='无';
				$list[$i]['recommendname']='无';
			}
		}
		
		
		$this->assign('page',$show);
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('arr',$search);
		$this->display();
	
	}

	//修改用户等级
	public function manageredit()
	{
		$member=M('member');

		if(IS_POST)
		{

		  $rel=$member->save($_POST);
		  if($rel)
			{
				$json['status']=1;
				$json['msg']='修改成功';
				echo json_encode($json);
				exit;	
			}
			else
			{
				$json['status']=2;
				$json['msg']='修改失败';
				echo json_encode($json);
				exit;	
			}
		}
		else{


			$id=I('get.id');
			$member_row=$member->field('star')->where($data)->find($id);
			$relust=$this->rewardset();
			$level=explode(',',$relust['level']);

			$this->assign('level',$level);
			$this->assign('id',$id);
			$this->assign('member_row',$member_row);
			$this->display();
		}
	}

	public function clearbonus()
	{
		$times=time();
	
		$member_table=M('member');
		$map['status']=array('eq',3);//冻结用户用户
		$map['cstatus']=array('eq',0);//可以排队
		$map['countdown']=array('lt',$times);
	
		$count=$member_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list=$member_table->field('username,name,recommend,star,cash,activity,frozen,regtime,status,id')->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$allcount=count($list);
		$relust=$this->rewardset();
		$level=explode(',',$relust['level']);
		for($i=0;$i<$allcount;$i++)
		{
			$list[$i]['star']=$level[$list[$i]['star']];
			$re_info=$member_table->field('username,name')->find($list[$i]['recommend']);
			
			if($re_info){
			$list[$i]['recommend']=$re_info['username'];
			$list[$i]['recommendname']=$re_info['name'];
			}else
			{
				$list[$i]['recommend']='无';
				$list[$i]['recommendname']='无';
			}
		}
		
		
		$this->assign('page',$show);
		$this->assign('count',$count);
		$this->assign('list',$list);
		$this->display();
		

	}

	public function bonus_del()
	{
		
		$member_table=M('member');
		$bonus_table=M('bonus');
		$bonus_table->startTrans();
		if(IS_POST)
		{
			$id = I('post.id', '', 'htmlspecialchars');
			$userinfo=$member_table->where('cash,activity,frozen')->find($id);
			$flag1=0;
			$flag2=0;
			//清空经理奖
			if($userinfo['activity']>0)
			{
				$rel1=$member_table->save(array('id'=>$id,'activity'=>'0','status'=>'2'));


				//生成经理奖流水
				$activity_data = array(
					'user_id' =>$id,
					'type' =>2,
					'create_date' => time(),
					'sum' => 0,
					'export' => $userinfo['activity'],
					'balance' => 0,
					'status' => 2,
					'explain' => '奖金清零',
				);
				$rel2=$bonus_table->add($activity_data);
				$flag1=1;
			}
		 
			// 清空推荐奖
			if($userinfo['frozen']>0)
			{
				$rel3=$member_table->save(array('id'=>$id,'frozen'=>'0','status'=>'2'));
				//生成经理奖流水
				$frozen_data = array(
					'user_id' =>$id,
					'type' =>2,
					'create_date' => time(),
					'sum' => 0,
					'export' => $userinfo['frozen'],
					'balance' => 0,
					'status' => 2,
					'explain' => '奖金清零',
				);
				$rel4=$bonus_table->add($frozen_data);
				$flag=1;
			}
			if($flag1==1&&$flag2==1)
			{
				if($rel1&&$rel2&&$rel3&&$rel4)
				{
					$bonus_table->commit();
					$json['status']=1;
					$json['msg']='清空成功';
					echo json_encode($json);
					exit;	
					
				}
				else
				{
					$bonus_table->rollback();
					$json['status']=2;
					$json['msg']='清空失败';
					echo json_encode($json);
					exit;	
					
				}
			}
			else if($flag1==1)
			{
				if($rel1&&$rel2)
				{
					$bonus_table->commit();
					$json['status']=1;
					$json['msg']='清空经理钱包成功';
					echo json_encode($json);
					exit;	
					
				}
				else
				{
					$bonus_table->rollback();
					$json['status']=2;
					$json['msg']='清空失败';
					echo json_encode($json);
					exit;	
					
				}
			}
			else if($flag2==1)
			{
				if($rel3&&$rel4)
				{
					$bonus_table->commit();
					$json['status']=1;
					$json['msg']='清空推荐奖钱包成功';
					echo json_encode($json);
					exit;	
					
				}
				else
				{
					$bonus_table->rollback();
					$json['status']=2;
					$json['msg']='清空失败';
					echo json_encode($json);
					exit;	
					
				}

			}else
			{
					$json['status']=2;
					$json['msg']='奖金已经为空，无需操作';
					echo json_encode($json);
					exit;	
			}

		




		}

	}

	//冻结日志
	   public function frozenlog(){
		$member_table=M('member');
		$frozenlog_table=M('frozenlog');
		if(!empty($_REQUEST['search_username']))
		{
		$userinfo=$member_table->field('id')->where(array('username'=>$_REQUEST['search_username']))->find();
		$map['uid']=$userinfo['id'];
		$search['search_username'] = $_REQUEST['search_username'];
		}
		$count=$frozenlog_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list=$frozenlog_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$allcount=count($list);
		for($i=0;$i<$allcount;$i++)
		{
		
			$u_info=$member_table->field('username,name')->find($list[$i]['uid']);
			$list[$i]['name']=$u_info['name'];
			$list[$i]['username']=$u_info['username'];
		}
		
		
		$this->assign('page',$show);
		$this->assign('list',$list);
		$this->assign('count',$allcount);
		$this->assign('arr',$search);
		$this->display();
		
    }

	//下载Excel
	public function downloadexcel()
	{
		$status=array('1'=>'正常','2'=>'删除','3'=>'冻结');
		$relust=$this->rewardset();
		$level=explode(',',$relust['level']);
		$member_table=M('member');		
		$xlsName  = "用户列表"; //设置要导出excel的表头 
		$xlsCell  = array(
		array('id','会员id'), 
		array('username','账号'),
		array('name','账户姓名'),
		array('bankno','银行卡号'),
		array('bank','银行名称'),
		array('mobile','手机号码'),
		array('recommend','推荐人'),
		array('recommendname','推荐人姓名'),
		array('directnum','直线人数'),
		array('truedirectnum','直线人数（实）'),
		array('truegroup','组数（实）'),
		array('group','组数'),
		array('cash','现金钱袋'),
		array('activity','经理奖'),
		array('frozen','推荐奖'),
		array('regtime','注册时间'),
		array('status','状态'),
		);
		$xlsModel = M('member');
		$xlsData=$xlsModel->Field('id,username,name,bankno,bank,mobile,recommend,directnum,truedirectnum,truegroup,group,cash,activity,frozen,regtime,status')->select();
		$xlscount=count($xlsData);
		for($i=0;$i<$xlscount;$i++)
		{
			$xlsData[$i]['star']=$level[$xlsData[$i]['star']];
			$userinfo=$member_table->field('username,name')->find($xlsData[$i]['recommend']);
			$xlsData[$i]['recommend']=$userinfo['username'];
			$xlsData[$i]['recommendname']=$userinfo['name'];
			$xlsData[$i]['bankno']=' '.$xlsData[$i]['bankno'];
			$xlsData[$i]['regtime']=date('Y-m-d H:i:s',$xlsData[$i]['regtime']);
			$xlsData[$i]['status']=$status[$xlsData[$i]['status']];
		}
		$this->exportExcel($xlsName,$xlsCell,$xlsData);
			
	}
		
	//删除用户
	public function user_del()
	{
			$member_table=M('member');
			$id=I('get.id');
			$userinfo=$member_table->field('estate,recommend,status')->find($id);
			$relust=$member_table->save(array('id'=>$id,'status'=>'2'));
			if($relust)
			{
				if($userinfo['status']==1)
				{
					if($userinfo['estate']==1)
					{
					$this->subtractgroup($userinfo['recommend']);
					subtractrecommend($userinfo['recommend']);
					}
				}
				$json['status']=1;
				$json['msg']='已经删除！';
				echo json_encode($json);
				exit;	
			}
			else
			{
				$json['status']=2;
				$json['msg']='删除失败！';
				echo json_encode($json);
				exit;	
			}
	}
	

	//修改用户密码
	public function userpasswordedit()
	{
		if(IS_POST)
		{
			$id=I('post.id');
			$newpwd=I('post.newpassword', '', 'trim');
			if(!empty($newpwd))
			{	$data['id']=$id;
				$data['password']=md5($newpwd.md5('bxsh'));
				$relust=M('member')->save($data);
				if($relust)
				{
					$json['status']=1;
					$json['msg']='操作成功！';
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['status']=2;
					$json['msg']='操作失败！';
					echo json_encode($json);
					exit;	
				}
				
			}
			else
			{
					$json['status']=2;
					$json['msg']='密码不能为空!';
					echo json_encode($json);
					exit;
			}
		
		}
		else
		{

		 $id=I('get.id');
		 $this->assign('id',$id);
		 $this->display();
		}
	}
	//修改用户二级密码
	public function usertowpasswordedit()
	{
		if(IS_POST)
		{
			$id=I('post.id');
			$newpwd=I('post.townewpassword', '', 'trim');
			if(!empty($newpwd))
			{	$data['id']=$id;
				$data['towlevelpassword']=md5($newpwd.md5('bxsh'));
				$relust=M('member')->save($data);
				if($relust)
				{
					$json['status']=1;
					$json['msg']='操作成功！';
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['status']=2;
					$json['msg']='操作失败！';
					echo json_encode($json);
					exit;	
				}
				
			}
			else
			{
					$json['status']=2;
					$json['msg']='密码不能为空!';
					echo json_encode($json);
					exit;
			}
		
		}
		else
		{

		 $id=I('get.id');
		 $this->assign('id',$id);
		 $this->display();
		}
	}

	//修改用户信息
	public function useredit()
	{
		$member=M('member');

		if(IS_POST)
		{

		  
		  $mobile_info=$member->field('id,mobile')->where(array('mobile'=>$_POST['mobile']))->find();
		  $_POST['username']=$_POST['mobile'];
		  if($mobile_info)
			{
				  if($mobile_info['id']!=$_POST['id'])
				  {
						$json['status']=0;
						$json['msg']='手机号已经存在，请换一个';
						echo json_encode($json);
						exit;	
				  }
			}
			$alipay_info=$member->field('id,alipay')->where(array('alipay'=>$_POST['alipay']))->find();
			if( $alipay_info)
			{	  if($alipay_info['id']!=$_POST['id'])
				  {
						$json['status']=0;
						$json['msg']='支付宝已经存在，请换一个';
						echo json_encode($json);
						exit;	
				  }
			}
		  $bankno_info=$member->field('id,bankno')->where(array('bankno'=>$_POST['bankno']))->find();
		  if( $bankno_info)
			{
				  if($bankno_info['id']!=$_POST['id'])
				  {
						$json['status']=0;
						$json['msg']='银行号已经存在，请换一个';
						echo json_encode($json);
						exit;	
				  }
			}
		  $rel=$member->save($_POST);
		  if($rel)
			{
				$json['status']=1;
				$json['msg']='修改成功';
				echo json_encode($json);
				exit;	
			}
			else
			{
				$json['status']=2;
				$json['msg']='修改失败';
				echo json_encode($json);
				exit;	
			}
		}
		else{


			$id=I('get.id');
			$data['id']=$id;
			$member_row=$member->where($data)->find();
			
			$bank_table=M('bank');
			$bank_list=$bank_table->order('sort desc')->where(array('is_hied'=>'1'))->select();
			$this->assign('banklist',$bank_list);

			$relust=$this->rewardset();
			$level=explode(',',$relust['level']);

			$this->assign('level',$level);
			$this->assign('id',$id);
			$this->assign('member_row',$member_row);
			$this->display();
		}
	}

	//用户详情
	public function usershow()
	{
			$member_table=M('member');
			$id=I('get.id');
			$data['id']=$id;
			$member_row=$member_table->where($data)->find();
			$re_info=$member_table->field('username')->find($member_row['recommend']);
			if($re_info){
				$member_row['recommend']=$re_info['username'];
			}else
			{
				$member_row['recommend']='无';
			}
				
			$this->assign('member_row',$member_row);
			$this->display();
	}


	//停用用户
	public function user_stop()
	{
		
			$member=M('member');
			$id=I('get.id'); 
			$relsult=$member->where(array('id'=>$id))->find();
			if($relsult['status']==1)
			{
				$data['id']=$id;
				$data['status']=3;
				$rel1=$member->save($data);
				if($rel1)
				{

				if($relsult['estate']==1)
				{
				$this->subtractgroup($relsult['recommend']);
				subtractrecommend($relsult['recommend']);
				}

					$json['status']=1;
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['status']=2;
					$json['msg']='操作失败';
					echo json_encode($json);
					exit;	
				
				}

			}
			
			
		
		
	}//启用用户
	public function user_start()
	{
		    $bonusrelust=$this->bonusset();
			$member=M('member');
			$id=I('get.id'); 
			$relsult=$member->find($id);
			if($relsult['status']==3 or $relsult['status']==2)
			{
				$data['id']=$id;
				$data['frozentime']=time()+60*60*72;
				$data['countdown']=time()+60*60*$bonusrelust['clearancetime'];
				$data['status']=1;
				$rel1=$member->save($data);
				if($rel1)
				{
					
					if($relsult['estate']==1)
					{
					$this->addgroup($relsult['recommend']);
					addrecommend($relsult['recommend']);
					}


					$json['status']=1;
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['status']=2;
					$json['msg']='操作失败';
					echo json_encode($json);
					exit;	
						
				}

			}
			
			
		
		
	}
	//添加用户
	public function useradd()
	{
		$member_table=M('member');
		$member_table->startTrans();
		if(IS_POST)
		{
		  $_POST['regtime']=time();
		  $_POST['password']=md5($_POST['password'].md5('bxsh'));
		  $_POST['towlevelpassword']=md5($_POST['towlevelpassword'].md5('bxsh'));
		  $_POST['username']=$_POST['mobile']; 
		  $_POST['regip'] = get_client_ip(0, true);
		  $_POST['estate']=1;
		  $_POST['frozentime']=time()+60*60*72;
		  $mobile_info=$member_table->field('mobile')->where(array('mobile'=>$_POST['mobile']))->find();
		  if($mobile_info)
		  {
				$json['status']=0;
				$json['msg']='手机号已经存在，请换一个';
				echo json_encode($json);
				exit;	
		  }
		  $alipay_info=$member_table->field('alipay')->where(array('alipay'=>$_POST['alipay']))->find();
		  if($alipay_info)
		  {
				$json['status']=0;
				$json['msg']='支付宝已经存在，请换一个';
				echo json_encode($json);
				exit;	
		  }
		  $bankno_info=$member_table->field('bankno')->where(array('bankno'=>$_POST['bankno']))->find();
		  if($bankno_info)
		  {
				$json['status']=0;
				$json['msg']='银行号已经存在，请换一个';
				echo json_encode($json);
				exit;	
		  }
		
		  $m_rel=$member_table->add($_POST);
		 
		  if($m_rel)
			{
				$member_table->commit(); //成功则提交
				$json['status']=1;
				$json['msg']='注册成功';
				echo json_encode($json);
				exit;	
			}
			else
			{	$member_table->rollback();
				$json['status']=0;
				$json['msg']='注册失败';
				echo json_encode($json);
				exit;	
			}
		}
		else{

			$bank_table=M('bank');
			$bank_list=$bank_table->order('sort desc')->where(array('is_hied'=>'1'))->select();
			$this->assign('banklist',$bank_list);
			$this->display();
		}
	
	}
	
	public function check_member_username()
	{
		$id=I('get.id');
		$member_table=M('member');
		$member_table->find($id);
	
	}



	//冻结一个用户减去往上面组的人数减一，
	public function subtractgroup($upline_id)
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
		
//冻结一个用户加去往上面组的人数加1，
	public function addgroup($upline_id)
	{   unset($map3);unset($row);

		$map3['id']=$upline_id;
		$row=M('member')->field('recommend,group')->where($map3)->find(); 
		$map3['group']=$row['group']+1;
		M('member')->save($map3);
		if($row['recommend']!=0)
		{
		 self::addgroup($row['recommend']);
		}
		
	}


	public function usertree()
	{

		$this->display();
	}

	//异步加载节点
	public function mytree()
	{
		if(IS_AJAX)
		{
			$pId = "0";
			$pName = "";
			$pLevel = "";
			$pCheck = "";
			if(array_key_exists( 'id',$_REQUEST)) {
				$pId=$_REQUEST['id'];
			}
			if(array_key_exists( 'lv',$_REQUEST)) {
				$pLevel=$_REQUEST['lv'];
			}
			if(array_key_exists('n',$_REQUEST)) {
				$pName=$_REQUEST['n'];
			}
			if(array_key_exists('chk',$_REQUEST)) {
				$pCheck=$_REQUEST['chk'];
			}
			
			if ($pId==null || $pId=="") $pId = "0";
			if ($pLevel==null || $pLevel=="") $pLevel = "0";
			if ($pName==null) $pName = "";
			else $pName = $pName.".";
			$member_table=M('member');
			$list=$member_table->field('id,recommend,name')->where(array('recommend'=>$pId))->select();
			$count=count($list);
			echo '[';
			for ($i=1; $i<=$count; $i++) {
					$nId = $list[$i-1]['id'];
					$nName = $list[$i-1]['name'];
					$info=$member_table->field('id')->where(array('recommend'=>$nId ))->select();
					$flag='false';
					if($info)
					{
						$flag='true';
					}
					$url='usertreeinfo?id='.$nId;
					echo "{ id:'".$nId."',	name:'".$nName."',	file:'".$url."',	isParent:'".$flag."'}";
					if ($i<$count) {
						echo ",";
					}

			}
			echo ']';
		  
		 
		}
	}
	public function usertreeinfo()
	{
		$meber_table=M('member');
		$relust=$this->rewardset();
		$level=explode(',',$relust['level']);
		if(isset($_GET['id']))
		{
			$id=I('get.id');
			$rinfo=$meber_table->field('id,username,name,mobile,regtime,cash,group,truegroup,activity,frozen,directnum,truedirectnum,star,pin,status')->where(array('recommend'=>$id))->select();
		   
			$this->assign('level',$level);
			$this->assign('list',$rinfo);
		}
		$this->display();
	}
	
	/*
	//一次性加载所有节点
	public function usertree()
	{
		
		if(IS_POST)
		{
	
		    //父节点数组
	            $arr=array();
	            $arr_str = array("name" =>'首个用户','file'=>'usertreeinfo?id=1','children'=>$this->SelectSon(1));       //父节点  Pid=1;
	            array_push($arr, $arr_str);
	            echo(json_encode($arr)); //这是最后返回给页面，也就是返回给AJAX请求后所得的返回数据 JSON数据
			exit;
		}
		$this->display();
	} 
	*/

   //查找子节点        Pid=父节点ID
  /*private function SelectSon($Pid){
		$member_table=M('member');

		if(($info=$member_table->field('id,name')->where("recommend='$Pid'")->select())) //查找该父ID下的子ID
		{
			$data=array();
			$count=count($info) ;
			for ($i=0; $i <$count ; $i++) 
			{ 
				$da=array("name" =>$info[$i]['name'],'file'=>'usertreeinfo?id='.$info[$i]["id"].'','children'=>$this->SelectSon($info[$i]['id']));  //递归算法！
				array_push($data, $da);//加入子节点数组
			};
			return $data;//一次性返回子节点数组，他们成为同级子节点。
		}
		else
		{
			return null;
		}
		
	}
	*/
	
}