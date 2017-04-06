<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class WebconfigController extends CommonController {

	/***
	*
	*系统设置
	*/
    public function index(){
		
		$webconfig=M('webconfig');
		if(IS_POST)
		{

		
		$arr=array(
			'id'=>'1',
			'value'=>json_encode($_POST),	
		);
		
		$rel=$webconfig->save($arr);
		if($rel)
			{
			$json['status']=1;
			$json['msg']='修改成功！';
			echo json_encode($json);
			exit;
		}
		else
			{$json['status']=2;
			$json['msg']='修改失败！';
			echo json_encode($json);
			exit;}
		
		
		}
		$webconfig=$webconfig->where('id=1')->find();
		$arr=json_decode($webconfig['value'],true);
		$this->assign('config',$arr);
		$this->display();
    }


	public function banklist()
	{
		$bank_table=M('bank');
		$bank_list=$bank_table->order('sort desc')->select();
		$count=count($bank_list);
		$this->assign('count',$count);
		$this->assign('banklist',$bank_list);
		$this->display();
	}

	public function bank_start()
	{
			$bank_table=M('bank');
			$relsult=$bank_table->where(array('id'=>I('get.id')))->find();
			if($relsult['is_hied']==2)
			{
				$data['id']=I('get.id');
				$data['is_hied']=1;
				$rel=$bank_table->save($data);
				if($rel)
				{
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
    public function bank_stop()
	{
			$bank_table=M('bank');
			$id=I('get.id');
			$result=$bank_table->where(array('id'=>$id))->find();
			if($result['is_hied']==1)
			{
				$data['id']=$id;
				$data['is_hied']=2;
				$rel=$bank_table->save($data);
				if($rel)
				{
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
	public function bankadd()
	{
		 if(isset($_POST['bankname'])&&!empty($_POST['bankname']))
		{
			$bank_table=M('bank');
			$bankname=I('post.bankname');
			$sort=I('post.sort');
			$relust=$bank_table->add(array('bankname'=>$bankname,'sort'=>$sort));
			if($relust)
			{
				$json['status']=1;
				$json['msg']='添加成功';
				echo json_encode($json);
				exit;
			}
			else
			{
				$json['status']=2;
				$json['msg']='添加失败';
				echo json_encode($json);
				exit;	
			
			}
		}else{
			$this->display();
		}
			
	}

	public function bankedit()
	{
			
		if(isset($_POST['id'])&&!empty($_POST['id']))
		{
			$bank_table=M('bank');
			$id=I('post.id');
			$bankname=I('post.bankname');
			$sort=I('post.sort');
			$relust=$bank_table->save(array('id'=>$id,'bankname'=>$bankname,'sort'=>$sort));
			if($relust)
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
		}else{
		
			$bank_table=M('bank');
			$id=I('get.id');
			$bankinfo=$bank_table->find($id);
			$this->assign('bankinfo',$bankinfo);
			$this->assign('id',$id);
			$this->display();
		}
		
			
	}

	public function bankdel()
	{
			
		if(isset($_GET['id'])&&!empty($_GET['id']))
		{	$bank_table=M('bank');
			$id=$_GET['id'];
			$relust=$bank_table->delete($id);
			if($relust)
			{
				$json['status']=1;
				$json['msg']='删除成功';
				echo json_encode($json);
				exit;
			}
			else
			{
				$json['status']=2;
				$json['msg']='删除失败';
				echo json_encode($json);
				exit;	
			
			}

		}
	
	}

	public function setbonus()
	{
		$webconfig=M('webconfig');
		$setreward=$webconfig->where('id=3')->find();
		$relust=json_decode($setreward['value'],true);
		$level=explode(',',rtrim($relust['level'],','));
		$manager=explode(',',rtrim($relust['manager'],','));
		$star=$level;
		foreach ($manager as $k=>$v)
		{
			foreach ($level as $kk=>$vv)
			{
				if($vv==$v)
				{
					unset($level[$kk]);
				}
			}
		}
		

		if(IS_POST)
		{
			
			foreach($level as $kk=>$vv)
			{
			$_POST['member_limitmoney'].=$_POST['member_'.$kk].',';
			unset($_POST['member_'.$kk]);
			}
			$_POST['member_limitmoney']=rtrim($_POST['member_limitmoney'],',');
		
			foreach($manager as $key=>$value)
			{
			$_POST['recommend_limitmoney'].=$_POST['recommend_'.$key].',';
			unset($_POST['recommend_'.$key]);
			$_POST['manager_limitmoney'].=$_POST['manager_'.$key].',';
			unset($_POST['manager_'.$key]);
			}
			foreach($star as $kk=>$vv)
			{
			$_POST['zuidi'].=$_POST['zuidi_'.$kk].',';
			$_POST['zuigao'].=$_POST['zuigao_'.$kk].',';
			unset($_POST['zuidi_'.$kk]);
			unset($_POST['zuigao_'.$kk]);
			}
		
			//$_POST['zuidi']=rtrim($_POST['zuidi'],',');
			//$_POST['zuigao']=rtrim($_POST['zuigao'],',');
			$_POST['zuidi']=substr($_POST['zuidi'],0,strlen($_POST['zuidi'])-1);
			$_POST['zuigao']=substr($_POST['zuigao'],0,strlen($_POST['zuigao'])-1);
			//$_POST['recommend_limitmoney']=rtrim($_POST['recommend_limitmoney'],',');
			//$_POST['manager_limitmoney']=rtrim($_POST['manager_limitmoney'],',');
			$_POST['recommend_limitmoney']=substr($_POST['recommend_limitmoney'],0,strlen($_POST['recommend_limitmoney'])-1);
			$_POST['manager_limitmoney']=substr($_POST['manager_limitmoney'],0,strlen($_POST['manager_limitmoney'])-1);
			$data=array(
			'id'=>'2',
			'value'=>json_encode($_POST),
			);
		
			$rel=$webconfig->save($data);
			if($rel)
			{
				$this->success('修改成功！');
				exit;
			}
			else
			{
				$this->error('修改失败！');
				exit;
			}
			
			

		}
		$setallowmoney=$webconfig->where('id=4')->find();
		$allowmoney=json_decode($setallowmoney['value'],true);
		$allowmoney['time']=$allowmoney['time']-60*60*24;
		$this->assign('allowmoney',$allowmoney);
		$setbonus=$webconfig->where('id=2')->find();
		$relust=json_decode($setbonus['value'],true);
		$zuidi=explode(',',rtrim($relust['zuidi'],','));
		$zuigao=explode(',',rtrim($relust['zuigao'],','));
		$member_dai=explode(',',rtrim($relust['member_limitmoney'],','));
		$recommend_dai=explode(',',rtrim($relust['recommend_limitmoney'],','));
		$manager_dai=explode(',',rtrim($relust['manager_limitmoney'],','));
		$this->assign('member_dai',$member_dai);
		$this->assign('recommend_dai',$recommend_dai);
		$this->assign('manager_dai',$manager_dai);
		$this->assign('level',$level);
		$this->assign('manager',$manager);
		$this->assign('setbonus',$relust);
		$this->assign('star',$star);
		$this->assign('zuidi',$zuidi);
		$this->assign('zuigao',$zuigao);
		C('TOKEN_ON',false);
		$this->display();
	}
	public function setreward()
	{
		$webconfig=M('webconfig');
		if(IS_POST)
		{    
		    $star=explode(',',rtrim($_POST['level'],','));
			foreach($star as $k=>$v)
			{
				$_POST['star'].=$_POST[$k].',';
				unset($_POST[$k]);
			}
			$_POST['star']=rtrim($_POST['star'],',');
			$data=array(
			'id'=>'3',
			'value'=>json_encode($_POST),
			);
		
			$rel=$webconfig->save($data);
			
			if($rel)
			{
				$this->success('修改成功！');
				exit;
			}
			else
			{
				$this->error('修改失败！');
				exit;
			}
		
		}

		$setreward=$webconfig->where('id=3')->find();
		$relust=json_decode($setreward['value'],true);
		$level=explode(',',rtrim($relust['level'],','));
		$this->assign('level',$level);
		$dai=explode(',',rtrim($relust['star'],','));
		$this->assign('setreward',$relust);
		$this->assign('dai',$dai);
		C('TOKEN_ON',false);
		$this->display();
		
	}
}