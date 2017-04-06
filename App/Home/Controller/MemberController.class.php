<?php

namespace Home\Controller;

use Home\Controller\CommonController;

class MemberController extends CommonController {

    //检测银行账号是否存在
	public function check_bankno(){
        $bankno = I('post.bankno', '', 'htmlspecialchars');
		$uid=session('uid');
        if (!$bankno) {
            $json['status'] = 0;
            $json['msg'] = '请输入银行账号!';
            echo json_encode($json);
            exit;
        } else {
          
            $res = M('member')->field('id')->where(array('bankno'=>$bankno))->find();
			if(!empty($res))
			{
				if ($uid!=$res['id']) {
					$json['status'] = 1;
					$json['msg'] = '银行账号已经被注册过了，请换一个！';
				} else {
					$json['status'] = 0;
					$json['msg'] = '';
				}
				echo json_encode($json);
				exit;
			}
			else
			{
					$json['status'] = 0;
					$json['msg'] = '';
					echo json_encode($json);
					exit;
			}
        }
    }

	/* 检测手机号是否存在 */
    public function check_mobile() {
		$uid=session('uid');
        $mobile = I('post.mobile','', 'htmlspecialchars');
        if (!$mobile) {
            $json['status'] = 0;
            $json['msg'] = '请输入手机号!';
            echo json_encode($json);
            exit;
        } else {
           
            $res = M('member')->field('id')->where(array('mobile'=>$mobile))->find();
            if (!empty($res)) {
				if($res["id"]!=$uid){
                $json['status'] = 1;
                $json['msg'] = '手机号已经被注册过了!';
				}
				else
				{
				$json['status'] = 0;
                $json['msg'] = '';
				}
            } else {
                $json['status'] = 0;
                $json['msg'] = '';
            }
            echo json_encode($json);
            exit;
        }
    }

	/* 检测支付宝是否存在 */
    public function check_alipay(){
		$uid=session('uid');
		$member_table=M('member');
		$alipay = I('post.alipay','', 'htmlspecialchars');
		if (!$alipay){
			$json['status'] =1;
			$json['msg'] = '请输入支付宝!';
			echo json_encode($json);
			exit;
        } else {
			$res =$member_table->field('id')->where(array('alipay'=>$alipay))->find();
			if (!empty($res)) {
				if($res["id"]!=$uid){
						$json['status'] = 1;
						$json['msg'] = '支付宝已经被注册过了!';
						
					}
					else
					{
						$json['status'] =0;
						$json['msg'] = '';
						
					}
            } else {
					$json['status'] =0;
					$json['msg'] = '';
					
				}
				echo json_encode($json);
				exit;
			}
		}
	   //档案管理
	public function archives()
	{
		
		$uid=session('uid');
		$member_table=M('member');
		$userinfo=$member_table->field('name,mobile,wechat,alipay,bankno,bank,email')->where(array('id'=>$uid))->find();
		$bank_table=M('bank');
		$bank_list=$bank_table->order('sort desc')->where(array('is_hied'=>'1'))->select();
		$this->assign('banklist',$bank_list);
		$this->assign('userinfo',$userinfo);
		$this->display();
	}

	//更新档案
	public function userinfo()
	{
	
		if(IS_POST)
		{
			
			

			$uid=session('uid');
			$member_table=M('member');
			$allowsaveuserinfo_table=M('allowsaveuserinfo');
			$relust=$allowsaveuserinfo_table->where(array('uid'=>$uid))->find();
			if($relust)
			{
				$json['status'] = 2;
				$json['msg'] = '你的修改次数已经用完了！';
				echo json_encode($json);
				exit;
			}
			else
			{
				$saveuserinfo=array(
					'uid'=>	$uid,
					'frequency'=>1,
				);
				$allowsaveuserinfo_table->add($saveuserinfo);
			}
			$towlevelpassword=I('post.towpwd', '', 'htmlspecialchars');
			$towlevelpassword= md5($towlevelpassword . md5('bxsh'));
			
			$password=$member_table->field('towlevelpassword')->find($uid);
			if($password['towlevelpassword']!=$towlevelpassword)
			{
				$json['status'] = 2;
				$json['msg'] = '二级密码错误，修改失败！';
				echo json_encode($json);
				exit;
			}
			$data['id']=$uid;
			$data['name']=I('post.name', '', 'htmlspecialchars');
			$mobile=I('post.mobile', '', 'htmlspecialchars');
			$ergm = "/^(1)[0-9]{10}$/";
			if ($mobile) {
				if (preg_match($ergm, $mobile)) {
					$data['mobile']=$mobile;
					$data['username']=$mobile;
				} else {
					$json['status'] = 2;
					$json['msg'] = '手机号码格式不正确';
					echo json_encode($json);
					exit;
				}
			} else {
					$json['status'] = 2;
					$json['msg'] = '请输入手机号码';
					echo json_encode($json);
					exit;
			}

			$bank=I('post.bank', '', 'htmlspecialchars');
			if ($bank) {
				$data['bank']=$bank;
			} else {
				$json['status'] = 2;
				$json['msg'] = '请选择银行名称！';
				echo json_encode($json);
				exit;
			}
			$bankno=I('post.bankno', '', 'htmlspecialchars');
			$ergbk="/^[0-9]+$/";
			if ($bankno) {
				if(preg_match($ergbk, $bankno))
				{
				$data['bankno'] = $bankno;
				}
			} else {
			   
				$json['status'] = 2;
				$json['msg'] = '请输入银行账号！';
				echo json_encode($json);
				exit;
			}
			$alipay=I('post.alipay', '', 'htmlspecialchars');
			$ergma = "/^(1)[0-9]{10}$/";
			$ergea = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
			 if ($alipay) {
				if (preg_match($ergma, $alipay)||preg_match($ergea, $alipay)) {
					$data['alipay']=$alipay;
				} else {
					$json['status'] = 2;
					$json['msg'] = '支行宝格式不正确！';
					echo json_encode($json);
					exit;
				}
			} else {
				$json['status'] = 2;
				$json['msg'] = '请输入支付宝！';
				echo json_encode($json);
				exit;
			}
			$res=$member_table->save($data);
			if($res)
			{
				$json['status'] = 1;
				$json['msg'] = '更新成功！';
				echo json_encode($json);
				exit;
			}
			else
			{
				$json['status'] = 2;
				$json['msg'] = '更新失败！';
				echo json_encode($json);
				exit;
			}
		
		}
	}

	//修改二级密码
	public function towpassword_save()
	{
		if(IS_POST)
		{   
			$uid=session('uid');
			$member_table=M('member');
			$oldtowpassword=I('post.oldtowpassword', '', 'htmlspecialchars');
			$towpassword=I('post.towpassword', '', 'htmlspecialchars');
			$towrepassword =I('post.towrepwd', '', 'htmlspecialchars');
			$ergp="/^[A-Za-z0-9]{6,12}$/";
			if ($towpassword) {
				if (preg_match($ergp, $towpassword) && strlen($towpassword)>= 6 &&strlen($towpassword)<=12) {
				} else {
					$json['status'] = 2;
					$json['msg'] = '只能输入6-12位的二级密码';
					echo json_encode($json);
					exit;
				}
			} else {
				$json['status'] = 2;
				$json['msg'] = '只能输入6-12位的二级密码';
				echo json_encode($json);
				exit;
			}
			if ($towrepassword) {
				if (preg_match($ergp,$towrepassword) && strlen($towrepassword) >=6 && strlen($towrepassword)<=12 && $towpassword === $towrepassword) {
					$data['towlevelpassword'] = md5($towpassword . md5('bxsh'));
				} else {
					$json['status'] = 2;
					$json['msg'] = '只能输入6-12位的确认密码';
					echo json_encode($json);
					exit;
				}
			} else {
				$json['status'] = 2;
				$json['msg'] = '只能输入6-12位的确认密码';
				echo json_encode($json);
				exit;
			}
			$data['id']=$uid;
	
			$userinfo=$member_table->field('towlevelpassword')->find($uid);
			if($userinfo['towlevelpassword']==md5($oldtowpassword . md5('bxsh')))
			{
					$rel=$member_table->save($data);
					if($rel)
					{
						$json['status'] =1;
						$json['msg'] = '修改成功！';
						echo json_encode($json);
						exit;
					}
					else
					{
						$json['status'] = 2;
						$json['msg'] = '修改失败！';
						echo json_encode($json);
						exit;
					}
			}
			else
			{
				$json['status'] = 2;
				$json['msg'] = '旧二级密码不正确,操作失败！';
				echo json_encode($json);
				exit;
			}

		
		}
	}
	//修改密码
	public function password_save()
	{		
		if(IS_POST)
		{
			$uid=session('uid');
			
			$member_table=M('member');
			$oldpassword=I('post.oldpassword', '', 'htmlspecialchars');
			$password=I('post.password', '', 'htmlspecialchars');
			$repassword=I('post.repwd', '', 'htmlspecialchars');
			$ergp="/^[A-Za-z0-9]{6,12}$/";
			if ($password) {
				if (preg_match($ergp, $password) && strlen($password)>= 6 &&strlen($password)<=12) {
				} else {
					$json['status'] = 2;
					$json['msg'] = '只能输入6-12位的密码';
					echo json_encode($json);
					exit;
				}
			} else {
				$json['status'] = 2;
				$json['msg'] = '只能输入6-12位的密码';
				echo json_encode($json);
				exit;
			}
			if ($repassword) {
				if (preg_match($ergp, $repassword) && strlen($repassword) >=6 && strlen($password)<=12 && $password === $repassword) {
					$data['password'] = md5($password . md5('bxsh'));
				} else {
					$json['status'] = 2;
					$json['msg'] = '只能输入6-12位的确认密码';
					echo json_encode($json);
					exit;
				}
			} else {
				$json['status'] = 2;
				$json['msg'] = '只能输入6-12位的确认密码';
				echo json_encode($json);
				exit;
			}

			$data['id']=$uid;
		    $userinfo=$member_table->field('password')->find($uid);
			if($userinfo['password']==md5($oldpassword. md5('bxsh')))
			{
					$rel=$member_table->save($data);
					if($rel)
					{
						$json['status'] =1;
						$json['msg'] = '修改成功！';
						echo json_encode($json);
						exit;
					}
					else
					{
						$json['status'] = 2;
						$json['msg'] = '修改失败！';
						echo json_encode($json);
						exit;
					}
			}
			else
			{
				$json['status'] = 2;
				$json['msg'] = '旧密码不正确,操作失败！';
				echo json_encode($json);
				exit;
			}
		}
	}

	 //查找该用户是否在自己线下，并返回值
    public function finduserinfo($id) {
        $member = M('member');
        $list = $member->field('recommend')->find($id);
        if ($list['recommend'] == session('uid')) {
            return true;
            exit;
        } else {
            if ($list['recommend'] != 0) {
                $rel = self::finduserinfo($list['recommend']);
                return $rel;
            } else {
                return false;
                exit;
            }
        }
    }
	//我的团队
	public function myteam()
	{
			$member_table=M('member');
			$userid=session('uid');
			if(IS_GET&&!empty($_GET['mobile']))
			{
			
				$mobile=I('get.mobile','','trim');
				$info=$member_table->field('id')->where(array('username'=>$mobile))->find();
				$rel=$this->finduserinfo($info['id']);
				if($rel)
				{
					$uid=$info['id'];
				}
				else
				{		

						$this->error('用户不是你的下线');
						exit;
				}
			
			}
			else
			{
				$uid=$userid;
			}


			$relust=$this->rewardset();
			$level=explode(',',$relust['level']);
			$this->assign('star',$level);
			$userinfo=$member_table->field('truedirectnum')->find($uid);
			$count =$member_table->where(array('recommend'=>$uid))->count();
			$Page =new \Think\Page($count,20);
			$show = $Page->show();
			$list= $member_table->order('regtime desc')->field('name,mobile,recommend,regtime,truedirectnum,star,status')->where(array('recommend'=>$uid))->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('userinfo',$userinfo);
			$this->assign('list',$list);
			$this->assign('page',$show);
			$this->assign('status',C('MEMBER_STATUS'));
            $this->display();
	
	}
	//团队得与舍
	public function group()
	{
			$uid=session('uid');
			$member_table=M('member');
			$c_table=M('c');
			$r_table=M('r');
			$cstatus=C('CSTATUS');
			$rstatus=C('RSTATUS');
			$offline=$member_table->field('id')->where(array('recommend'=>$uid))->select();
			$count=count($offline);
			for($i=0;$i<$count;$i++)
			{
				$str_id.=$offline[$i]['id'].",";
			}
			$xiaxianid=rtrim($str_id,',');
			$count =$c_table->where(array('user_id'=>array('in',$xiaxianid)))->count();
			$Page =new \Think\Page($count,10);
			$show= $Page->show();
			$c_list=$c_table->where(array('user_id'=>array('in',$xiaxianid)))->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$c_count=count($c_list);
			for($i=0;$i<$c_count;$i++)
			{
				$userinfo=$member_table->field('name')->find($c_list[$i]['user_id']);
				$c_list[$i]['name']=$userinfo['name'];
			}
			$this->assign('c_list',$c_list);
			$this->assign('page',$show);
			$this->assign('cstatus',$cstatus);
			$countr =$r_table->where(array('user_id'=>array('in',$xiaxianid)))->count();
			$Pages =new \Think\Pages($countr,10);
			$shows= $Pages->show();
			$r_list=$r_table->where(array('user_id'=>array('in',$xiaxianid)))->limit($Pages->firstRow . ',' . $Pages->listRows)->select();
			$r_count=count($r_list);
		
			for($i=0;$i<$r_count;$i++)
			{
				$userinfo=$member_table->field('name')->find($r_list[$i]['user_id']);
				$r_list[$i]['name']=$userinfo['name'];
			}
		
			$this->assign('r_list',$r_list);
			$this->assign('pages',$shows);
			$this->assign('rstatus',$rstatus);
			$this->display();
	}
}
