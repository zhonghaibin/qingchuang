<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class RbacController extends CommonController {

	//添加规则
	public function adminpermission()
	{

		
		$power=M('power');
		if($_POST)
		{

			
			$_POST['name'] = I('post.name', '', 'trim') ? I('post.name', '', 'trim') : $this->error('节点名称不能为空', HTTP_REFERER);
			$power->create();
			$id=$power->add();
			$data['id']=$id;
			if($_POST['pid']==0)
			{	
				$data['sort']=$id;
			}
			else
			{
				$pinfo=$power->field('level,sort')->where('id='.$_POST['pid'])->find();
				$data['sort']=$pinfo['sort']."-".$id;
				$data['level']=$pinfo['level']+1;
			}
			$relust=$power->save($data);
			
			if($relust)
			{
				$this->success('提交成功');
				exit;
			}
			else
			{
				$this->error('提交失败');
				exit;
			}
		}
		else
		{	
			$count= $power->count();// 查询满足要求的总记录数
			$Page= new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show= $Page->show();//
			$list=$power->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$list1=$power->field('pid,id,name')->where('level=0')->select();
			$list2=$power->field('pid,id,name')->where('level=1')->select();
			
			$this->assign('list',$list);
			$this->assign('list1',$list1);
			$this->assign('list2',$list2);
			$this->assign('page',$show);
			$this->assign('count',$count);
			$this->display();
	    }
	}
	//修改权限
	public  function adminroleedit()
	{
		$power=M('power');
		$role=M('role');
		if(IS_POST)
		{
		    
			$power_id=trim(I('post.powerid'),',');
			if(empty($power_id))
			{
			$power_list=array();
			}
			else
			{
			$info['id']=array('in',$power_id);
			$power_list=$power->field('control_action')->where($info)->select();
			}
			$arr=array();
			for($i=0;$i<count($power_list);$i++)
			{
				$arr[]=$power_list[$i]['control_action'];
			}
			
			$prower_control_action=trim(implode(',',$arr),',');
			$data['id']=I('post.id');
			$data['rolename']=I('post.rolename');
			$data['remarks']=I('post.remarks');
			$data['power_id']=$power_id;
			$data['power_control_action']=$prower_control_action;
			
			$relust=$role->save($data);
			if($relust)
			{
				$json['status']=1;
				$json['msg']='操作成功';
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
		else
		{
	

		$id=I('get.id');
		$data['id']=$id;
		$role_row=$role->where($data)->find();
		
		$list1=$power->where('level=0')->select();
		$list2=$power->where('level=1')->select();
		$list3=$power->where('level=2')->select();
		
		$p_c_a=explode(',',$role_row['power_id']);
		
			
		$this->assign('role',$p_c_a);
		$this->assign('id',$id);
		$this->assign('role_row',$role_row);
		$this->assign('list1',$list1);
		$this->assign('list2',$list2);
		$this->assign('list3',$list3);
		$this->display();
		}
	}

	//批量用户删除
	public function datadel_admin()
	{
			$admin=M('admin');
			$str=I('get.str');
			$str=rtrim($str,',');
			$arr=explode(',',$str);
			foreach($arr as $k=>$v)
			{	if($v==1)
				unset($arr[$k]);
			};
			$str=implode(',',$arr);
			$relsult=$admin->where(array('id'=>array('in',$str)))->delete();
			if($relsult)
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
	//批量角色删除
	public function datadel_role()
	{
			$role=M('role');
			$str=I('get.str');
			$str=rtrim($str,',');
			$data['id']=array('in',$str);
			$relsult=$role->where($data)->delete();
			
			if($relsult)
			{
				$json['status']=1;
				$json['msg']='删除成功！';
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
	}//批量节点删除
	public function datadel_power()
	{
			$power=M('power');
			$str=I('get.str');
			$str=rtrim($str,',');
			$data['id']=array('in',$str);
			$relsult=$power->where($data)->delete();
			
			if($relsult)
			{
				$json['status']=1;
				$json['msg']='删除成功！';
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
	//编辑管理员信息
	public function adminedit()
	{
		$admin=M('admin');
		$code_table=M('admin_code');
		if(IS_POST)
		{
		  $username=I('post.username');
		  $uid=I('post.id');
		  $codes=I('post.code');
		  if(empty($codes))
		  {
				$json['status']=2;
				$json['msg']='请输入验证码！';
				echo json_encode($json);
				exit;	
		  }
		  else
		  {
			   $codeinfo=$code_table->where(array('uid'=>$uid))->find();
			 
			 if($codes==$codeinfo['code'])
			 {
				if($codeinfo['effectivetime']<time())
				 {
				  $json['status'] = 2;
				  $json['msg'] = '请重新获取验证码！';
				  echo json_encode($json);
				  exit;
				 }
				else
				 {
					 /*************************************/
					   $relust=$admin->where(array(
						'username'=> $username   
						))->find();
					   if(!$relust||$relust['id']==$uid)
						{
							 
							  $rel=$admin->save($_POST);
							  if($rel)
								{
								    $code_table->save(array('id'=>$codeinfo['id'],'effectivetime'=>time()-120));
									$json['status']=1;
									$json['msg']='修改成功！';
									echo json_encode($json);
									exit;	
								}
								else
								{
									$json['status']=2;
									$json['msg']='修改失败！';
									echo json_encode($json);
									exit;	
								}
						}
						else
						{
									$json['status']=2;
									$json['msg']='账号已经存在，请换一个！';
									echo json_encode($json);
									exit;	
						}
					
				 }
					
			 }
			 else
			 {
			  $json['status'] = 2;
              $json['msg'] = '验证码错误！';
			  echo json_encode($json);
			  exit;
			 }
		  
		  }
		  
		 
		}
		else{
			$id=I('get.id');
			$data['id']=$id;
			$admin_row=$admin->where($data)->find();
			$role_list=M('role')->select();
			$this->assign('id',$id);
			$this->assign('admin_row',$admin_row);
			$this->assign('role',$role_list);
			$this->display();
		}
	}

	//删除规则
	public function del()
	{
		
			$power=M('power');
			
			$relsult=$power->delete(I('get.id'));
			if($relsult)
			{
				$json['status']=1;
				$json['msg']='删除成功！';
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
	//删除角色
	public function admin_role_del()
	{
		
			$role=M('role');
			$relsult=$role->delete(I('get.id'));
			if($relsult)
			{
				$json['status']=1;
				$json['msg']='删除成功！';
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
	//删除用户
	public function admin_del()
	{
		
			$admin=M('admin');
			$id=I('get.id');
			if($id!=1)
			{
				$relsult=$admin->delete($id);
				if($relsult)
				{
					$json['status']=1;
					$json['msg']='删除成功！';
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
			else
			{
					$json['status']=2;
					$json['msg']='删除失败，不能删除超级管理员！';
					echo json_encode($json);
					exit;	
			}
		
		
	}//停用用户
	public function admin_stop()
	{
		
		$admin=M('admin');
		$id=I('get.id');
		if($id!=1)
		{
			$relsult=$admin->find($id);
			if($relsult['status']==1)
			{
				$data['id']=I('get.id');
				$data['status']=2;
				$rel1=$admin->save($data);
				if($rel1)
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
		}
		else
		{
					$json['status']=2;
					$json['msg']='不能冻结超级管理员';
					echo json_encode($json);
					exit;	
		}
			
			
		
		
	}//启用用户
	public function admin_start()
	{
		
			$admin=M('admin');
			$id=I('get.id');
			$relsult=$admin->where(array('id'=>$id))->find();
			if($relsult['status']==2)
			{
				$data['id']=I('get.id');
				$data['status']=1;
				$rel1=$admin->save($data);
				if($rel1)
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
			
			
		
		
	}
	//角色管理
	public function adminrole()
	{

		$role=M('role');
		$list=$role->select();
		$this->assign('list',$list);
		$this->assign('count',count($list));
		$this->display();
	}
	//添加角色
	public function adminroleadd()
	{
		$power=M('power');
		$role=M('role');
		if(IS_POST)
		{
			if(empty($_POST['rolename']))
			{
				$json['status']=2;
				$json['msg']='请输入角色名称！';
				echo json_encode($json);
				exit;	
			}
			$power_id=trim(I('post.powerid'),',');
			if(empty($power_id))
			{
				$power_list=array();
			}
			else
			{
			$info['id']=array('in',$power_id);
			$power_list=$power->field('control_action')->where($info)->select();
			//$dd=print_r($power_list);
			}
			$arr=array();
			for($i=0;$i<count($power_list);$i++)
			{
				$arr[]=$power_list[$i]['control_action'];
			}
			
			$prower_control_action=implode(',',$arr);
			$data['rolename']=I('post.rolename');
			$data['remarks']=I('post.remarks');
			$data['power_id']=$power_id;
			$data['power_control_action']=$prower_control_action;
			$relust=$role->add($data);
			if($relust)
			{
				$json['status']=1;
				$json['msg']='添加成功！';
				echo json_encode($json);
				exit;	
			}
			else
			{
				$json['status']=2;
				$json['msg']='添加失败！';
				echo json_encode($json);
				exit;	
			}
		}
		else
		{
			
			$list1=$power->where('level=0')->select();
			$list2=$power->where('level=1')->select();
			$list3=$power->where('level=2')->select();
			$this->assign('list1',$list1);
			$this->assign('list2',$list2);
			$this->assign('list3',$list3);
			$this->display();
		}
	}
	//后台管理员列表
	public function adminlist()
	{	
		$admin=M('admin');
		if(IS_POST)
		{
			if(empty($_POST['username'])&&empty($_POST['password']))
			{
					$this->error('请填写账号和密码！');
					exit;
			}
		  $userinfo=$admin->field('username')->where(array('username'=>$_POST['username']))->find();
		  if($userinfo)
		  {
				$this->error('账号已经存在，请换一个！');
				exit;	
		  }
			$_POST['regtime']=time();
			$_POST['password']= md5(I('post.password', '', 'trim').md5('bxsh'));
			$data['username']=$_POST['username'];
			$relust=$admin->where($data)->find();
			if(!$relust)
			{
				$rel=$admin->add($_POST);
				if($rel)
				{
					$this->success('添加成功');
					exit;
				}
				else
				{
					$this->error('添加失败');
					exit;
				}
			}
			else
			{
					$this->error('用户名已经被注册过了');
					exit;
			}

		}
		else
		{
		$role=M('role');
		$rolelist=$role->select();
		$list=$admin->select();
		for($i=0;$i<count($list);$i++)
		{
			$data['id']=$list[$i]['groupid'];
			$rolename=$role->where($data)->find();
			$list[$i]['groupname']=$rolename['rolename'];
		}
		$this->assign('role',$rolelist);
		$this->assign('count',count($list));
		$this->assign('list',$list);
		$this->display();
		}
	}

	//编辑节点信息
	public function poweredit()
	{
		$power=M('power');
		if(IS_POST)
		{
		
			
			$relust=$power->save($_POST);
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
					$json['msg']='操作成功！';
					echo json_encode($json);
					exit;	
				}
		
		}
		else
		{
		$id=I('get.id');
		$data['id']=$id;
		$power_row=$power->where($data)->find();
		$this->assign('power',$power_row);
		$this->assign('id',$id);
		$this->display();
		}
	}

	//修改管理员密码
	public function adminpasswordedit()
	{

		if(IS_POST)
		{
			$code_table=M('admin_code');
			$id=I('post.id', '', 'trim');
			$codes=I('post.code', '', 'trim');
			$newpwd=I('post.newpassword', '', 'trim');
			
			 if(empty($codes))
		  {
				$json['status']=2;
				$json['msg']='请输入验证码！';
				echo json_encode($json);
				exit;	
		  }
		  else
		  {
			   $codeinfo=$code_table->where(array('uid'=>$id))->find();
			 
			 if($codes==$codeinfo['code'])
			 {
				if($codeinfo['effectivetime']<time())
				 {
				  $json['status'] = 2;
				  $json['msg'] = '请重新获取验证码！';
				  echo json_encode($json);
				  exit;
				 }
				else
				 {
					 if(!empty($newpwd))
						{	$data['id']=$id;
							$data['password']=md5($newpwd.md5('bxsh'));;
							$relust=M('admin')->save($data);
							if($relust)
							{
								  $code_table->save(array('id'=>$codeinfo['id'],'effectivetime'=>time()-120));
								$json['status']=1;
								$json['msg']='修改成功！';
								echo json_encode($json);
								exit;	
							}
							else
							{
								$json['status']=2;
								$json['msg']='修改失败！';
								echo json_encode($json);
								exit;	
							}
							
						}
						else
						{
								$json['status']=2;
								$json['msg']='密码不能为空！';
								echo json_encode($json);
								exit;
						}


					
				 }
					
			 }
			 else
			 {
			  $json['status'] = 2;
              $json['msg'] = '验证码错误！';
			  echo json_encode($json);
			  exit;
			 }
		  
		  }



			
		
		}
		else
		{

		 $id=I('get.id');
		 $this->assign('id',$id);
		 $this->display();
		}
	}

	public function loginlog()
	{
		$loginlog_table=M('loginlog');
		$admin_table=M('admin');
		$count=$loginlog_table->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list=$loginlog_table->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$acount=count($list);
		for($i=0;$i<$acount;$i++)
		{
			$re_info=$admin_table->field('username')->find($list[$i]['uid']);
			$list[$i]['username']=$re_info['username'];
			if($list[$i]['area']=='')
			{
			$list[$i]['area']='无';
			}
		}
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->display();
	}

		//发送验证码
	public function set_code()
	{ 
	 	if(IS_POST)
		{
		 $id = I('post.id', '', 'htmlspecialchars'); 
		 $admin_tb=M('admin')->field('mobile')->find($id);
		 
			if($admin_tb)
			{
				 $relust=set_code_sms($admin_tb['mobile'],'6','3','admin_code','admin','2');
			}
			else
			{
					$json['status']=2;
					$json['msg']='账号不存在';
					echo json_encode($json);
					exit;
			}
		}
	
	}

}