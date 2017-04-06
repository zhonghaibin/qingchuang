<?php

namespace Home\Controller;

use Home\Controller\CommonController;

class TransactionController extends CommonController {

    //激活币转账
    public function activation() {
        $uid = session('uid');
        $member_table = M('member');
        $pin_table = M('pin');
        $pin_table->startTrans();
        $userinfo = $member_table->field('pin,mobile')->find($uid);
	  
        if (IS_POST) {
            $mobile = I('post.mobile', '', 'htmlspecialchars');
            $pin = I('post.pin', '', 'htmlspecialchars');
			
            $ergm = "/^(1)[0-9]{10}$/";
            $erg= "/^[0-9]*$/";
		    if (!$member_table->autoCheckToken($_POST)) {
				$json['status'] = 2;
				$json['msg'] = '非法操作';
				echo json_encode($json);
				exit;
			}
            if ($mobile) {
                if (preg_match($ergm, $mobile) && preg_match($erg, $pin)) {
                    if ($userinfo['pin'] < $pin) {
                        $json['status'] = 2;
                        $json['msg'] = "激活币不足";
                        echo json_encode($json);
                        exit;
                    }

                    $res = $member_table->field('id,pin,mobile')->where(array('mobile' => $mobile))->find();
                    if (!empty($res)) {
                        if ($res['id'] != $uid) {
                            //减去自己的激活币
                            $balance_self = $userinfo['pin'] - $pin;
                            $self_data = array(
                                'pin' => $balance_self,
                                'id' => $uid,
                            );

                            $rel1 = $member_table->save($self_data);
                            //加上自己的激活币
                            $balance_other = $res['pin'] + $pin;
                            $other_data = array(
                                'pin' => $balance_other,
                                'id' => $res['id'],
                            );
                            $rel2 = $member_table->save($other_data);
                            //生成自己的流水号
                            $self_pin_data = array(
                                'pin' => '0',
                                'export' => $pin,
                                'balance' => $balance_self,
                                'user_id' => $uid,
                                'other_id' => $res['id'],
                                'create_date' => time(),
                                'status' => '2',
                                'explain' => '转账给:' . $res['mobile'],
                            );
                            $rel3 = $pin_table->add($self_pin_data);

                            //生成对方的流水号
                            $other_pin_data = array(
                                'pin' => $pin,
                                'export' => '0',
                                'balance' => $balance_other,
                                'user_id' => $res['id'],
                                'other_id' => $uid,
                                'create_date' => time(),
                                'status' => '1',
                                'explain' => '来自于:' . $userinfo['mobile'],
                            );
                            $rel4 = $pin_table->add($other_pin_data);

                            if ($rel1 && $rel2 && $rel3 && $rel4) {
                                $pin_table->commit();
                                $json['status'] = 1;
                                $json['msg'] = "转账成功";
                                echo json_encode($json);
                                exit;
                            } else {
                                $pin_table->rollback();
                                $json['status'] = 2;
                                $json['msg'] = "转账失败";
                                echo json_encode($json);
                                exit;
                            }
                        } else {
                            $json['status'] = 2;
                            $json['msg'] = "不能自己转给自己";
                            echo json_encode($json);
                            exit;
                        }
                    } else {
                        $json['status'] = 2;
                        $json['msg'] = "未找到该用户";
                        echo json_encode($json);
                        exit;
                    }
                } else {

                    //
                    $json['status'] = 2;
                    $json['msg'] = "格式不正确";
                    echo json_encode($json);
                    exit;
                }
            }
        } else {
            $this->assign('userinfo', $userinfo);
            $this->display();
        }
    }

    //检测转账用户
    public function check_mobile() {
        if (IS_POST) {
            $uid = session('uid');
            $mobile = I('param.mobile', '', 'htmlspecialchars');
            if (!$mobile) {
                $json['status'] = 0;
                $json['msg'] = '请输入手机号!';
                echo json_encode($json);
                exit;
            } else {

                $res = M('member')->field('id,name')->where(array('mobile' => $mobile))->find();
                if (!empty($res)) {
                    if ($res['id'] != $uid) {
                        $json['status'] = 1;
                        $json['msg'] = "<span style='color:#02610A;'>{$res['name']}</span>";
                    } else {
                        $json['status'] = 0;
                        $json['msg'] = "<span style='color:#d00000;'>不能自己转给自己！</span>";
                    }
                } else {
                    $json['status'] = 0;
                    $json['msg'] = "<span style='color:#d00000;'>未找到该用户！</span>";
                }
                echo json_encode($json);
                exit;
            }
        }
    }
   
	public function pinlist()
	{
			$uid=session('uid');
			$pin_table = M('pin');
			$count =$pin_table->where(array('user_id'=>$uid))->count();
			$Page =new \Think\Page($count,20);
			$show = $Page->show();
			$list= $pin_table->order('create_date desc')->where(array('user_id'=>$uid))->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$this->assign('list',$list);
			$this->assign('page',$show);
            $this->display();
	}

	public function cash() {
        $uid = session('uid');
        $table_bonus = M('bonus');
		$count =$table_bonus->where(array('user_id'=>$uid,'type'=>'1'))->count();
		$Page =new \Think\Page($count,20);
		$show = $Page->show();
        $list = $table_bonus->order('id desc')->where(array('user_id' => $uid, 'type' => '1'))->select();
        $this->assign('list', $list);
        $this->display();
    }

    public function activity() {
        $uid = session('uid');
        $table_bonus = M('bonus');
		 $member_table = M('member');
        $list = $table_bonus->order('id desc')->where(array('user_id' => $uid, 'type' => '2'))->select();
		$count=count($list);
		for($i=0;$i<$count;$i++)
		{
			if(!empty($list[$i]['from_scale']))
				{
					$list[$i]['from_scale']=($list[$i]['from_scale']*100).'%';
				}else
				{
					$list[$i]['from_scale']='无';
				}
					if(!empty($list[$i]['from_id']))
				{
					$frominfo = $member_table->find($list[$i]['from_id']); 
					$list[$i]['from'] = $frominfo['username'];

				}
				else
				{
					$list[$i]['from'] ='无';
				}
				if(!empty($list[$i]['settlement_id']))
				{
				$userinfo = $member_table->find($list[$i]['settlement_id']);
                $list[$i]['settlement'] = $userinfo['username'];
				}
				else
				{
					$list[$i]['settlement'] ='无';
				}
				if(empty($list[$i]['from_money']))
				{
					$list[$i]['from_money']='无';
				}
				if(empty($list[$i]['settlement_money']))
				{
					$list[$i]['settlement_money']='无';
				}
		}
        $this->assign('list', $list);
		$this->assign('page',$show);
        $this->display();
    }

    public function frozen() {
        $uid = session('uid');
        $table_bonus = M('bonus');
        $member_table = M('member');
		$count =$table_bonus->where(array('user_id'=>$uid,'type'=>'3'))->count();
		$Page =new \Think\Page($count,20);
		$show = $Page->show();
        $list = $table_bonus->order('id desc')->where(array('user_id' => $uid, 'type' => '3'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $count = count($list);
        for ($i = 0; $i < $count; $i++) {
				if(!empty($list[$i]['from_scale']))
				{
					$list[$i]['from_scale']=($list[$i]['from_scale']*100).'%';
				}else
				{
					$list[$i]['from_scale']='无';
				}
				if(!empty($list[$i]['from_id']))
				{
					$frominfo = $member_table->find($list[$i]['from_id']); 
					$list[$i]['from'] = $frominfo['username'];

				}
				else
				{
					$list[$i]['from'] ='无';
				}
				if(!empty($list[$i]['settlement_id']))
				{
				$userinfo = $member_table->find($list[$i]['settlement_id']);
                $list[$i]['settlement'] = $userinfo['username'];
				}
				else
				{
					$list[$i]['settlement'] ='无';
				}
				if(empty($list[$i]['from_money']))
				{
					$list[$i]['from_money']='无';
				}
				if(empty($list[$i]['settlement_money']))
				{
					$list[$i]['settlement_money']='无';
				}

				
                
              
        }
        $this->assign('list', $list);
		$this->assign('page',$show);
        $this->display();
    }

	public function provide()
	{
	
		$uid = session('uid');
        $table_c = M('c');
		$table_cr=M('cr');
		$table_member=M('member');
		$count =$table_c->where(array('user_id'=>$uid))->count();
		$Page =new \Think\Page($count,20);
		$show = $Page->show();
        $list = $table_c->order('id desc')->where(array('user_id' => $uid))->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$list_cr=$table_cr->where(array('c_user_id'=>$uid))->select();
		$crcount=count($list_cr);
		for($i=0;$i<$crcount;$i++)
		{
			$userinfo=$table_member->field('username,name')->find($list_cr[$i]['r_user_id']);
			$list_cr[$i]['name']=$userinfo['name'];
			$list_cr[$i]['username']=$userinfo['username'];
			$list_cr[$i]['die_time']=$list_cr[$i]['die_time']-time();
			$list_cr[$i]['receive_time']=$list_cr[$i]['receive_time']-time();
		}
		$this->assign('status', C('CSTATUS'));
        $this->assign('list', $list);
		$this->assign('listcr', $list_cr);
		$this->assign('crstatus', C('CRSTATUS'));
		$this->assign('page',$show);
        $this->display();
	
	}

	public function apply()
	{
	
		$uid = session('uid');
        $table_r = M('r');
		$table_cr=M('cr');
		$table_member=M('member');
		$count =$table_r->where(array('user_id'=>$uid))->count();
		$Page =new \Think\Page($count,20);
		$show = $Page->show();
        $list = $table_r->order('id desc')->where(array('user_id' => $uid))->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$list_cr=$table_cr->where(array('r_user_id'=>$uid))->select();
		$crcount=count($list_cr);
		for($i=0;$i<$crcount;$i++)
		{
			$userinfo=$table_member->field('username,name')->find($list_cr[$i]['c_user_id']);
			$list_cr[$i]['name']=$userinfo['name'];
			$list_cr[$i]['username']=$userinfo['username'];
			$list_cr[$i]['die_time']=$list_cr[$i]['die_time']-time();
			$list_cr[$i]['receive_time']=$list_cr[$i]['receive_time']-time();
		}
        $this->assign('status', C('RSTATUS'));
        $this->assign('list', $list);
		$this->assign('listcr', $list_cr);
		$this->assign('crstatus', C('CRSTATUS'));
		$this->assign('page',$show);
        $this->display();
	
	}

	
    public function playmoney() {
        if (IS_GET && !empty($_GET['id'])) {

            $id = $_GET['id'];
            $cr_table = M('cr');
            $crinfo = $cr_table->where(array('id' => $id))->find();
            $member_table = M('member');
            $userinfo = $member_table->find($crinfo['r_user_id']);
            $reinfo = $member_table->find($userinfo['recommend']);
            if (!$reinfo) {
                $reinfo = array(
                    'username' => '无',
                    'name' => '无',
                    'mobile' => '无',
                );
            }
            $this->assign('userinfo', $userinfo);
            $this->assign('reinfo', $reinfo);
            $this->assign('crinfo', $crinfo);
        }

        $this->display();
    }


	  public function receivables() {

        if (IS_GET && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $cr_table = M('cr');
            $crinfo = $cr_table->find($id);
            $member_table = M('member');
            $userinfo = $member_table->find($crinfo['c_user_id']);
            $reinfo = $member_table->find($userinfo['recommend']);
            if (!$reinfo) {
                $reinfo = array(
                    'username' => '无',
                    'name' => '无',
                    'mobile' => '无',
                );
            }
            $this->assign('userinfo', $userinfo);
            $this->assign('reinfo', $reinfo);
            $this->assign('crinfo', $crinfo);
        }
        $this->display();
    }
}
