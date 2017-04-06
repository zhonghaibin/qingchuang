<?php
namespace Home\Controller;
use Home\Controller\NotinController;
class RegController extends CommonController {
    public function index(){
	 $uid=session('uid');
	 $table_member=M('member');
	 $username=$table_member->field('username')->find($uid);
	 $bank_table=M('bank');
	 $bank_list=$bank_table->order('sort desc')->where(array('is_hied'=>'1'))->select();
	 $this->assign('banklist',$bank_list);
	 $this->assign('username',$username['username']);
     $this->display();
    }
	/* 检测手机号是否存在 */
    public function check_mobile() {
        $mobile = I('param.mobile', '', 'htmlspecialchars');
        if (!$mobile) {
            $json['status'] = 0;
            $json['msg'] = '请输入账号!';
            echo json_encode($json);
            exit;
        } else {
           
            $res = M('member')->field('id')->where(array('mobile'=>$mobile))->find();
            if (!empty($res)) {
                $json['status'] = 1;
                $json['msg'] = '账号已经被注册过了!';
            } else {
                $json['status'] = 0;
                $json['msg'] = '';
            }
            echo json_encode($json);
            exit;
        }
    }
	/* 检测支付宝是否存在 */
    public function check_alipay() {
        $alipay = I('param.alipay', '', 'htmlspecialchars');
        if (!$alipay) {
            $json['status'] = 0;
            $json['msg'] = '请输入支付宝!';
            echo json_encode($json);
            exit;
        } else {
           
            $res = M('member')->field('id')->where(array('alipay'=>$alipay))->find();
            if (!empty($res)) {
                $json['status'] = 1;
                $json['msg'] = '支付宝已经被注册过了!';
            } else {
                $json['status'] = 0;
                $json['msg'] = '';
            }
            echo json_encode($json);
            exit;
        }
    }
	//检测银行账号是否存在
	public function check_bankno(){
        $bankno = I('param.bankno', '', 'htmlspecialchars');
        if (!$bankno) {
            $json['status'] = 0;
            $json['msg'] = '请输入银行账号!';
            echo json_encode($json);
            exit;
        } else {
          
            $res = M('member')->where(array('bankno'=>$bankno))->find();
            if (!empty($res)) {
                $json['status'] = 1;
                $json['msg'] = '银行账号已经被注册过了，请换一个！';
            } else {
                $json['status'] = 0;
                $json['msg'] = '';
            }
            echo json_encode($json);
            exit;
        }
    }
    /* 处理注册数据 */

    public function register() {
       

		
        if (IS_POST) {
		$uid=session('uid');
        $member_table=M('member');
		$pin_table=M('pin');
		$pin_table->startTrans();
	 
		$user_info=$member_table->field('pin,truedirectnum,username,directnum')->find($uid);
		  if (!$member_table->autoCheckToken($_POST)) {
				$json['status'] = 2;
				$json['msg'] = '非法操作';
				echo json_encode($json);
				exit;
			}

		if($user_info['pin']<1)
		{
			$json['status'] = 2;
			$json['msg'] = '激活码不足，无法注册！';
			echo json_encode($json);
			exit;
		}

				

    

		$mobile = I('post.mobile', '', 'htmlspecialchars');
        $ergm = "/^(1)[0-9]{10}$/";
        if ($mobile) {
            if (preg_match($ergm, $mobile)) {
                $data['mobile'] = $mobile;
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

        $password = I('post.password', '', 'htmlspecialchars');
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

        $repassword = I('post.repwd', '', 'htmlspecialchars');
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
		$towpassword = I('post.towpassword', '', 'htmlspecialchars');
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

        $towrepassword = I('post.towrepwd', '', 'htmlspecialchars');
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
	
       

        $tname = I('post.tname', '', 'htmlspecialchars');
        if ($tname) {
            $data['name'] = $tname;
        } else {
            
			$json['status'] = 2;
			$json['msg'] = '请输入姓名！';
			echo json_encode($json);
			exit;
        }

        $bankno = I('post.bankno', '', 'htmlspecialchars');
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
        $bankname = I('post.bankname', '', 'htmlspecialchars');
        if ($bankname) {
            $data['bank'] = $bankname;
        } else {
			$json['status'] = 2;
			$json['msg'] = '请选择银行名称！';
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
		
		
        $data['regip'] = get_client_ip(0, true);
        $data['regtime'] = time();
        $data['status'] = 1;
        $data['logintime'] = 0;
        $data['logip'] = 0;
        $data['lognum'] = 0;
		$data['recommend']=$uid;
		$data['frozentime']=time()+60*60*72;
		$data['estate']=1;
        $id =$member_table->add($data);
		
		//扣除激活码
		
		$balance_self = $user_info['pin'] - 1;
		$self_data = array(
			'pin' => $balance_self,
			'id' => $uid,
		);           
		$rel2 = $member_table->save($self_data);
		//生成自己的流水号
		$self_pin_data = array(
			'pin' => '0',
			'export' =>1,
			'balance' => $balance_self,
			'user_id' => $uid,
			'create_date' => time(),
			'status' => '2',
			'explain' => '注册账号:'.$data["mobile"].'消耗',
		);
		$rel3 = $pin_table->add($self_pin_data);
		//更新该用户的推荐人的直推人数和组的总人数
		if (!empty($uid)) {
			//更新组的总人数
			$this->upline2($uid);
			//直线数目
			$rel4=$member_table->save(array('id'=>$uid,'truedirectnum'=>$user_info['truedirectnum'] + 1,'directnum'=>$user_info['directnum'] + 1));
			//更新组数
			$this->upline($uid);

		}

		
		if ($id&&$rel2&&$rel3&&$rel4) {
				$pin_table->commit();
				$this->encourage($id);//新用户注册赠送现金钱袋
				//注册成功，发送短信
				$this->sms($mobile);
				
			  	$json['status'] = 1;
				$json['msg'] = '恭喜你注册成功';
				echo json_encode($json);
			
				exit;
			 
			


            //发送邮件
			/*
			  $webconfig = M('webconfig');
			  $webconfig = $webconfig->where('id=1')->find();
			  $basedata = json_decode($webconfig['value'], true);
              $body="<h3>注册信息!</h3>
              <div>尊敬的用户:".$data['username']."，您在".$basedata['webname']."的注册信息如下：</div>
              <div style='margin:10px 0;'>您的注册信息如下： </div>
              <div><span style='display:inline-block;width:232px;margin-right:2px;'>你的账号：</span>: <span style='color:#d00000;' >".$data['username']."</span></div>
              <div style='margin:10px 0;'><span style='display:inline-block;width:232px;margin-right:2px;'>你的银行账户持有人信息</span>: <span style='color:#d00000;'>".$data['name']."</span> </div>
              <div><span style='display:inline-block;width:232px;margin-right:2px;'>你的推荐人：</span>: <span style='color:#d00000;'>".$res['username']."</span></div>
              <div style='margin:10px 0;'>================你的登录信息============</div>
              <div><span style='display:inline-block;width:70px;'>网址：</span>: <a href='http://".$basedata['weburl']."/Home/Login' style='color:#d00000;' target='_blank'>http://".$basedata['weburl']."/Home/Login</a></div>
              <div style='margin:10px 0;'><span style='display:inline-block;width:70px;'>邮箱：</span>: <span style='color:#d00000;'>".$data['email']."</span></div>
              <div><span style='display:inline-block;width:70px;'>密码</span>: <span style='color:#d00000;'>".$password."</span></div>
              <div style='margin:10px 0;'>============================================</div>
              <div> 祝你万事如意!</div>
              <div style='margin:10px 0;'>谢谢</div>
              <div style='margin:10px 0;'> <a href=http://".$basedata['weburl']." >".$basedata['webname']."</a></div>";
			  send_email($data['email'],$basedata['smtpuser'],'祝贺你注册成功',$body,'HTML');
			  */
	
			 
          
        } else {
            $pin_table->rollback();
			$json['status'] = 2;
			$json['msg'] = '对不起，注册失败!';
			echo json_encode($json);
			exit;
			 
       }
		

        unset($data);
        unset($_POST);

	   }
    }

	//发短信
	public function sms($mobile)
	{
		send_sms( $mobile, '恭喜您，您已成功注册5.4青创会员。');
	}
	//新用户奖励金额
	public function encourage($id)
	{
		$table_member=M('member');
		$table_bonus=M('bonus');
		$relust=$this->bonusset();

		if($relust['newuserreward']!=0)
		{
				//更新钱袋
			$userinfo=$table_member->field('cash')->find($id);
			$allmoney=$userinfo['cash']+$relust['newuserreward'];
			$rel=$table_member->save(array('id'=>$id,'cash'=>$allmoney));
			//生成流水

			$data=array(

			'user_id' => $id,
			'type' => 1,
			'create_date' => time(),
			'sum' => $relust['newuserreward'],
			'export' => 0,
			'balance' => $allmoney,
			'status' => 1,
			'explain' => '注册新用户赠送',
			
			);
			$table_bonus->add($data);

		
		}

			
	}


}