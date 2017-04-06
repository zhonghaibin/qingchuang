<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class AdddataController extends CommonController {

	/***
	*
	*系统设置
	*/   
		public function add_c(){
	
	
		$table_c=M('c');
		$table_member=M('member');
		$table_webconfig=M('webconfig');
		$table_member->startTrans();
		if(IS_AJAX)
		{
			$username= I('post.username', '', 'trim');
			$relust=$table_member->field('id,cstatus')->where(array('username'=>$username))->find();
			
			if(!$relust)
			{
				$json['status']=2;
				$json['msg']='账号不存在！';
				echo json_encode($json);
				exit;
			}
			if($relust['cstatus']==1)
			{
				$json['status']=2;
				$json['msg']='该用户有一条记录在排队中！';
				echo json_encode($json);
				exit;
			}
			$money= I('post.money', '', 'trim');
			if( !is_numeric($money)||$money<=0)
			{
					$json['status'] =2;
					$json['msg']='请输入大于0数字！';
					echo json_encode($json);
					exit;
			}

			$relust_=$this-> bonusset();
			$allow_money=$table_webconfig->find('4');
			$xianzhi=json_decode($allow_money['value'],true);
			if(($xianzhi['allmoney']+$money)>$relust_['providehelplimit'])
			{
				$json['status'] = 2;
                $json['msg'] = '操作失败,超出排队金额限制！';
                echo json_encode($json);
                exit;
			
			}
			else
			{
			
					$data=array(
					'id'=>'4',
					'value'=>json_encode(array('time'=>$xianzhi['time'],'allmoney'=>$xianzhi['allmoney']+$money)),
					);
		
					 $table_webconfig->save($data);
			}

			$data=array(
			'eg'=>build_order_no(),
			'user_id'=>$relust['id'],
			'create_date'=>time(),
			'money'=>$money,
			'sum'=>$money,
			'style'=>1,
			'action'=>2,
			'interest_date'=>time()+60*60*24,
			'zffs1'=>1,
			'zffs2'=>1,
			);
			$rel=$table_c->add($data);
			$m_rel=$table_member->save(array('id'=>$relust['id'],'cstatus'=>'1'));
			if($rel&&$m_rel){
				$table_member->commit(); 
				$json['status']=1;
				$json['msg']='添加成功！';
				echo json_encode($json);
				exit;
			}
			else{
				$table_member->rollback();
				$json['status']=2;
				$json['msg']='添加失败';
				echo json_encode($json);
				exit;
			}
		
		
		}
		
		$this->display();
    }
		
    public function add_r(){
		
		$table_r=M('r');
		$table_member=M('member');
		$table_bonus=M('bonus');
		$table_r->startTrans();
		if(IS_AJAX)
		{
			$username= I('post.username', '', 'trim');
			$userinfo=$table_member->field('id,cash')->where(array('username'=>$username))->find();
		
			if(!$userinfo)
			{
				$json['status']=2;
				$json['msg']='账号不存在！';
				echo json_encode($json);
				exit;
			}
			$money= I('post.money', '', 'trim');
			if( !is_numeric($money)||$money<=0)
			{
					$json['status'] =2;
					$json['msg']='请输入大于0的数字！';
					echo json_encode($json);
					exit;
			}
			if($userinfo['cash']>=$money)
			{		
					$userallmoney=$userinfo['cash']-$money;
					$m_rel=$table_member->save(array('id'=>$userinfo['id'],'cash'=>$userallmoney));
					 $cash_data=array(
						 'user_id'=>$userinfo['id'],
						 'type'=>1,
						 'create_date'=>time(),
						 'sum'=>0,
						 'export'=>$money,
						 'balance'=>$userallmoney,
						 'status'=>2,
						 'explain'=>'申请帮助支出',
					 );
					$b_rel=$table_bonus->add($cash_data);
					$r_data=array(
					'eg'=>build_order_no(),
					'user_id'=>$userinfo['id'],
					'create_date'=>time(),
					'money'=>$money,
					'sum'=>$money,
					'type'=>1,
					'style'=>2,
					'action'=>2,
					);
					$r_rel=$table_r->add($r_data);
					
					if($r_rel && $b_rel && $m_rel){
					   $table_r->commit();
						$json['status']=1;
						$json['msg']='添加成功！';
						echo json_encode($json);
						exit;
					}else{
						$table_r->rollback();
						$json['status']=2;
						$json['msg']='添加失败';
						echo json_encode($json);
						exit;
					}

			}
			else{
				$json['status']=2;
				$json['msg']='现金钱袋金额不足，添加失败！';
				echo json_encode($json);
				exit;
			}
		
		}
		
		$this->display();
    }
		
	public function add_cash(){
		
		
		$table_member=M('member');
		$bonus_table=M('bonus');
		$recharge_table=M('recharge');
		$table_member->startTrans();

		if(IS_AJAX)
		{
			$username= I('post.username', '', 'trim');
			$relust=$table_member->field('id,cash')->where(array('username'=>$username))->find();
			if(!$relust)
			{
				$json['status']=2;
				$json['msg']='账号不存在！';
				echo json_encode($json);
				exit;
			}
			$money= I('post.money', '', 'trim');
			if( !is_numeric($money)||$money<=0)
			{
					$json['status'] =2;
					$json['msg']='添加失败';
					echo json_encode($json);
					exit;
			}
			$userallmoney=$relust['cash']+$money;
			$data=array(
			'id'=>$relust['id'],
			'cash'=>$userallmoney,
			);
			$rel=$table_member->save($data);
				//生成流水记录
					 $cash_data=array(
						 'user_id'=>$relust['id'],
						 'type'=>1,
						 'create_date'=>time(),
						 'sum'=>$money,
						 'export'=>0,
						 'balance'=>$userallmoney,
						 'status'=>1,
						 'explain'=>'平台充值',
					 );
			$b_rel=$bonus_table->add($cash_data);
			//生成充值明细
					 $recharge_data=array(
						 'user_id'=>$relust['id'],
						 'type'=>1,
						 'create_date'=>time(),
						 'num'=>$money,
						 'admin_id'=>$_SESSION['userid'],
					 );
			$recharge_rel=$recharge_table->add($recharge_data);


			if($rel&&$b_rel&&$recharge_rel){
				$table_member->commit();
				$json['status']=1;
				$json['msg']='添加成功';
				echo json_encode($json);
				exit;
			}
			else{
				$table_member->rollback();
				$json['status']=2;
				$json['msg']='添加失败';
				echo json_encode($json);
				exit;
			}
		
		
		}
		$this->display();
		
    }	 

public function add_pin()
{

	
		$table_member=M('member');
		$pin_table=M('pin');
		$recharge_table=M('recharge');
		$table_member->startTrans();

		if(IS_AJAX)
		{
			$username= I('post.username', '', 'trim');
			$relust=$table_member->field('id,pin')->where(array('username'=>$username))->find();
			if(!$relust)
			{
				$json['status']=2;
				$json['msg']='账号不存在！';
				echo json_encode($json);
				exit;
			}
			$pin= I('post.pin', '', 'trim');
			if( !is_numeric($pin)||$pin<=0)
			{
					$json['status'] =2;
					$json['msg']='添加失败';
					echo json_encode($json);
					exit;
			}
			$userallpin=$relust['pin']+$pin;
			$data=array(
			'id'=>$relust['id'],
			'pin'=>$userallpin,
			);
			$rel=$table_member->save($data);
				//生成流水记录
					 $pin_data=array(
						 'user_id'=>$relust['id'],
						 'create_date'=>time(),
						 'pin'=>$pin,
						 'export'=>0,
						 'balance'=>$userallpin,
						 'status'=>1,
						 'explain'=>'平台充值',
					 );
			$b_rel=$pin_table->add($pin_data);
			//生成充值明细
					 $recharge_data=array(
						 'user_id'=>$relust['id'],
						 'type'=>2,
						 'create_date'=>time(),
						 'num'=>$pin,
						 'admin_id'=>$_SESSION['userid'],
					 );
			$recharge_rel=$recharge_table->add($recharge_data);


			if($rel&&$b_rel&&$recharge_rel){
				$table_member->commit();
				$json['status']=1;
				$json['msg']='添加成功';
				echo json_encode($json);
				exit;
			}
			else{
				$table_member->rollback();
				$json['status']=2;
				$json['msg']='添加失败';
				echo json_encode($json);
				exit;
			}
		
		
		}	

	$this->display();

}

	public function del_cash()
	{


		
		$table_member=M('member');
		$bonus_table=M('bonus');
		$recharge_table=M('recharge');
		$table_member->startTrans();

		if(IS_AJAX)
		{
			$username= I('post.username', '', 'trim');
			$relust=$table_member->field('id,cash')->where(array('username'=>$username))->find();
			if(!$relust)
			{
				$json['status']=2;
				$json['msg']='账号不存在！';
				echo json_encode($json);
				exit;
			}
			$money= I('post.money', '', 'trim');
			if( !is_numeric($money)||$money<=0)
			{
					$json['status'] =2;
					$json['msg']='操作失败';
					echo json_encode($json);
					exit;
			}
			$userallmoney=$relust['cash']-$money;
			$data=array(
			'id'=>$relust['id'],
			'cash'=>$userallmoney,
			);
			$rel=$table_member->save($data);
				//生成流水记录
					 $cash_data=array(
						 'user_id'=>$relust['id'],
						 'type'=>1,
						 'create_date'=>time(),
						 'sum'=>0,
						 'export'=>$money,
						 'balance'=>$userallmoney,
						 'status'=>2,
						 'explain'=>'平台扣除',
					 );
			$b_rel=$bonus_table->add($cash_data);
			//生成支出明细
					 $recharge_data=array(
						 'user_id'=>$relust['id'],
						 'type'=>1,
						 'create_date'=>time(),
						 'num'=>$money,
						 'status'=>2,//支出
						 'admin_id'=>$_SESSION['userid'],
					 );
			$recharge_rel=$recharge_table->add($recharge_data);


			if($rel&&$b_rel&&$recharge_rel){
				$table_member->commit();
				$json['status']=1;
				$json['msg']='扣除成功';
				echo json_encode($json);
				exit;
			}
			else{
				$table_member->rollback();
				$json['status']=2;
				$json['msg']='扣除失败';
				echo json_encode($json);
				exit;
			}
		
		
		}
		$this->display();

	}
	public function del_pin()
	{	

		$table_member=M('member');
		$pin_table=M('pin');
		$recharge_table=M('recharge');
		$table_member->startTrans();

		if(IS_AJAX)
		{
			$username= I('post.username', '', 'trim');
			$relust=$table_member->field('id,pin')->where(array('username'=>$username))->find();
			if(!$relust)
			{
				$json['status']=2;
				$json['msg']='账号不存在！';
				echo json_encode($json);
				exit;
			}
			$pin= I('post.pin', '', 'trim');
			if( !is_numeric($pin)||$pin<=0)
			{
					$json['status'] =2;
					$json['msg']='操作失败';
					echo json_encode($json);
					exit;
			}
			$userallpin=$relust['pin']-$pin;
			$data=array(
			'id'=>$relust['id'],
			'pin'=>$userallpin,
			);
			$rel=$table_member->save($data);
				//生成流水记录
					 $pin_data=array(
						 'user_id'=>$relust['id'],
						 'create_date'=>time(),
						 'pin'=>0,
						 'export'=>$pin,
						 'balance'=>$userallpin,
						 'status'=>2,
						 'explain'=>'平台扣除',
					 );
			$b_rel=$pin_table->add($pin_data);
			//生成充值明细
					 $recharge_data=array(
						 'user_id'=>$relust['id'],
						 'type'=>2,
						 'create_date'=>time(),
						 'num'=>$pin,
						 'status'=>2,
						 'admin_id'=>$_SESSION['userid'],
					 );
			$recharge_rel=$recharge_table->add($recharge_data);


			if($rel&&$b_rel&&$recharge_rel){
				$table_member->commit();
				$json['status']=1;
				$json['msg']='扣除成功';
				echo json_encode($json);
				exit;
			}
			else{
				$table_member->rollback();
				$json['status']=2;
				$json['msg']='扣除失败';
				echo json_encode($json);
				exit;
			}
		
		
		}	
		$this->display();

	}

}