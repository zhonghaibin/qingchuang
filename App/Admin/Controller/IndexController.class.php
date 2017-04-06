<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class IndexController extends CommonController {

	/***
	*
	*框架
	*/
    public function index(){
		
		//左侧菜单
		
		$data['id']=session('groupid');
		$role_row=M('role')->where($data)->find();
		if(session('userid')==1){
		$list1=M('power')->order('sort desc')->where(array('level'=>0))->select();
		$list2=M('power')->where(array('level'=>1))->select();
		}	
		else if(!empty($role_row['power_id']))
		{
		$map['level']=0;
		$map['id']=array('in',$role_row['power_id']);
		$list1=M('power')->order('sort desc')->where($map)->select();
		$info['level']=1;
		$info['id']=array('in',$role_row['power_id']);
		$list2=M('power')->where($info)->select();
		}
		$this->assign('list1',$list1);
		$this->assign('list2',$list2);
		
		$this->display();
    }

	public function welcome(){
	
		$systeminfo=getSystemInfo();
		$this->assign('systeminfo',$systeminfo);
		$this->display();
	}
		


	/**
	 * 用户登录
	 */
	public function login(){
		if( session("userid") > 0){
			$this->redirect('index');
			exit;
		}
		if(IS_AJAX){

			$data['username'] = I('post.username', '', 'trim') ? I('post.username', '', 'trim') : $this->error('账号不能为空', HTTP_REFERER);
			$data['password'] = I('post.password', '', 'trim') ? md5(I('post.password', '', 'trim').md5('bxsh')) : $this->error('密码不能为空', HTTP_REFERER);
			$code= I('post.code', '', 'trim') ? I('post.code', '', 'trim') : $this->error('验证码不能为空', HTTP_REFERER);
			$verify = new \Think\Verify(); 
			$rel=M('admin')->where(array('username'=>$data['username']))->find();
			$webconfig=M('webconfig')->where('id=1')->find();
			$basedata=json_decode($webconfig['value'],true);
			if($verify->check($code))
			{
				
				$admin=M('admin')->field('id,lognum,status,groupid')->where($data)->find();
				$Ip = new \Org\Net\IpLocation('UTFWry.dat');
				$location = $Ip->getlocation(get_client_ip()); // 获取某个IP地址所在的位置
				if(!empty($admin)){
				
					if($rel['errorlognum']<$basedata['num']){
					if($admin['status']==1)
					{
		
						$data['id']=$admin['id'];
						$data['lognum']=$admin['lognum']+1;
						//$data['logip']=get_client_ip(0, true);
						$data['errorlognum']=0;
						$data['errorlogtime']=0;
						$rel=M('admin')->save($data);
						if($rel)
						{
						session('userid',$admin['id']);
						session('groupid',$admin['groupid']);
						session('timeout',time());
						
						
						$location['uid']=$admin['id'];
						$location['create_date']=date('Y-m-d H:i:s');
						M('loginlog')->add($location);
						$json['status'] = 1;
						$json['url']=U('index');
						$json['msg'] = '';
						echo json_encode($json);
						exit;
						}
					}else
					{	

					   	

							$json['type']=3;
							$json['msg']='账号被冻结了';
							echo json_encode($json);
							exit;
						
					}
					}else
					{
									$json['type']=3;
									$json['msg']='登录错误超过最大次数';
									echo json_encode($json);
									exit;
					}

				}else{	
					
					
		 
							if($rel)
							{
								if($rel['errorlognum']<$basedata['num'])
								{	$location['uid']=$rel['id'];
									$location['create_date']=date('Y-m-d H:i:s');
									$location['status']=2;
									M('loginlog')->add($location);
									M('admin')->save(array('id'=>$rel['id'],'errorlognum'=>$rel['errorlognum']+1,'errorlogtime'=>time()+60*60*1));
								}
								else
								{
									$json['type']=3;
									$json['msg']='登录错误超过最大次数';
									echo json_encode($json);
									exit;
								}
							}
					
					$json['type']=1;
					$json['msg']='账号或密码不对';
					echo json_encode($json);
					exit;
				}
			}
			else
			{
					
				$json['type']=2;
				$json['msg']='验证码错误';
				echo json_encode($json);
				exit;
			}
			
			
		}
		else
		{
			
			$this->assign('config',$basedata);
			$this->display();
	    }

	}

	
	
   /**验证码**/
   public function code()
	{
		$config =    array(  
		'fontSize'    =>    30,    // 验证码字体大小
		'length'      =>    4,     // 验证码位数  
		'useNoise'    =>    true, // 关闭验证码杂点
		'useCurve'	  =>	false,
		);
		ob_clean();
		$Verify =     new \Think\Verify($config);
		$Verify->entry();
   
	}
	
	/**
	 * 退出登录
	 */
	public function logout() {

		$this->add_ip_lasttime( session('userid'));
		$vo = array("userid", "roleid");
        foreach ($vo as $v) {
            session("$v", NULL);
        }
        redirect(U('Admin/Index/login'));
	}
	//更新退出的时间和ip
	public function add_ip_lasttime($id)
	{
		$data['id']=$id;
		$data['logip']=get_client_ip();
		$data['lasttime']=time();
		M('admin')->save($data);
		
	}


	


}