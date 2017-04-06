<?php

namespace Home\Controller;

use Home\Controller\NotinController;

class LoginController extends NotinController {

    public function index() {



        $this->display();
    }
	/*public function aa()
	{
		 set_time_limit(0);
	     $member_table=M('member');
		$userlist=$member_table->field('id,singletime')->where(array('status'=>'1'))->select();
		$count=count($userlist);
		for($i=0;$i<$count;$i++)
		{
			$member_table->save(array('id'=>$userlist[$i]['id'],'countdown'=>$userlist[$i]['singletime']));
		}
	}*/

    /* 检测手机号是否存在 */

    public function check_mobile() {
        $mobile = I('param.mobile', '', 'htmlspecialchars');
        if (!$mobile) {
            $json['status'] = 0;
            $json['msg'] = '请输入手机号';
            echo json_encode($json);
            exit;
        } else {

            $res = M('member')->field('id')->where(array('mobile' => $mobile))->find();
            if (!empty($res)) {
                $json['status'] = 0;
                $json['msg'] = '';
            } else {
                $json['status'] = 1;
                $json['msg'] = '手机号不存在！';
            }
            echo json_encode($json);
            exit;
        }
    }

    //短信验证码修改密码
    public function petpwd() {
        if (IS_POST) {
            $member_table = M('member');
            $code_table = M('code');
            $mobile = I('post.mobile', '', 'htmlspecialchars');
            $codes = I('post.codes', '', 'htmlspecialchars');
            $password = I('post.password', '', 'htmlspecialchars');
            $password = md5($password . md5('bxsh'));
            $userinfo = $member_table->field('id')->where(array('mobile' => $mobile))->find();
            if ($userinfo) {
                $codeinfo = $code_table->where(array('uid' => $userinfo['id']))->find();

                if ($codes == $codeinfo['code']) {
                    if ($codeinfo['effectivetime'] < time()) {
                        $json['status'] = 2;
                        $json['msg'] = '请重新获取验证码！';
                        echo json_encode($json);
                        exit;
                    } else {
                        $rel = $member_table->save(array('id' => $userinfo['id'], 'password' => $password));
                        if ($rel) {
                            $code_table->save(array('id' => $codeinfo['id'], 'effectivetime' => time() - 120));
                            $json['status'] = 1;
                            $json['msg'] = '修改成功！';
                            echo json_encode($json);
                            exit;
                        } else {
                            $json['status'] = 2;
                            $json['msg'] = '修改失败！';
                            echo json_encode($json);
                            exit;
                        }
                    }
                } else {
                    $json['status'] = 2;
                    $json['msg'] = '验证码错误！';
                    echo json_encode($json);
                    exit;
                }
            } else {
                $json['status'] = 2;
                $json['msg'] = $mobile;
                echo json_encode($json);
                exit;
            }
        }



        $this->display();
    }

    //发送验证码
    public function set_code() {
        if (IS_POST) {
            $mobile = I('post.mobile', '', 'htmlspecialchars');
            $relust = set_code_sms($mobile, '6', '3', 'code', 'member', '2');
        }
    }

    public function ajax_login() {
        if (IS_AJAX) {
            $username = I('post.username', '', 'htmlspecialchars');
            $pwd = I('post.pwd', '', 'htmlspecialchars');
            $code = I('post.code', '', 'htmlspecialchars');
            $ergm = "/^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$/";
            $verify = new \Think\Verify();
            if (!$verify->check($code)) {
                $json['status'] = 0;
                $json['type'] = 3;
                $json['msg'] = '验证码错误！';
                echo json_encode($json);
                exit;
            }
            if (!$username) {
                $json['status'] = 0;
                $json['type'] = 1;
                $json['msg'] = '请输入账号！';
                echo json_encode($json);
                exit;
            }
            if (!$pwd) {
                $json['status'] = 0;
                $json['type'] = 2;
                $json['msg'] = '请输入密码!';
                echo json_encode($json);
                exit;
            }//验证是否冻结

            $user_info = M('member')->where(array('username' => $username))->find();
            if ($user_info['status'] == 3) {
                $json['status'] = 0;
                $json['type'] = 2;
                $json['msg'] = '账号被冻结了!';
                echo json_encode($json);
                exit;
            }



            $map['username'] = $username;
            $map['password'] = md5($pwd . md5('bxsh'));
            $map['status'] = array('neq', 2);
            $res = M('member')->where($map)->find();
            if (!empty($res)) {
                $data['logtime'] = time();
                $data['logip'] = get_client_ip(0, true);
                $data['lognum'] = $res['lognum'] + 1;
                $data['id'] = $res['id'];
                M('member')->save($data);
                session('logintime', time());
                session('uid', $res['id']);

                $json['status'] = 1;
                $json['msg'] = '';
                $json['url'] = U('/Home');
            } else {
                $json['status'] = 0;
                $json['type'] = 2;
                $json['msg'] = '账号或者密码错误！';
            }
        } else {
            $json['status'] = 0;
            $json['type'] = 2;
            $json['msg'] = '非法操作！';
        }
        echo json_encode($json);
        exit;
    }

    /* 退出登录 */

    public function logout() {
        session("uid", NULL);
        redirect(U('/Home/Login'));
    }

    public function qrcode() {

        $webconfig = M('webconfig');
        $webconfig = $webconfig->where('id=1')->find();
        $arr = json_decode($webconfig['value'], true);
        Vendor('Phpqrcode.Phpqrcode');
        //生成二维码图片
        $object = new \QRcode();
        $url = $arr['weburl']; //网址或者是文本内容
        $level = 3;
        $size = 4;
        $errorCorrectionLevel = intval($level); //容错级别
        $matrixPointSize = intval($size); //生成图片大小
        ob_clean();
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
    }

    public function contact() {

        if (IS_AJAX) {
            $table_message = M('message');

            $_POST['addtime'] = time();
            $rel = $table_message->add($_POST);
            if ($rel) {
                $json['status'] = 1;
            } else {
                $json['status'] = 2;
            }
            echo json_encode($json);
            exit;
        }
        $this->display();
    }

    /*     * 验证码* */

    public function code() {
        $config = array(
            'fontSize' => 14, // 验证码字体大小
            'length' => 4, // 验证码位数  
            'useNoise' => false, // 关闭验证码杂点
            'useCurve' => false,
            'imageW' => '100',
            'imageH' => '30',
        );
        ob_clean();
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    public function implement() {
        set_time_limit(0);
        $this->QueueInterest();
        $this->InterestFreeze();
        $this->recommend();
        $this->manager();
        $this->achievement();
    }

    ///计划任务执行的方法（计算每日排队期利息）
    public function QueueInterest() {
        $relust = $this->bonusset();
        $interestrate = $relust['dailyinterest'] / 100; //利率
        $c_table = M('c');
        $times = time();
        $info['status'] = 1;
        $info['interest_date'] = array('lt', $times);
        $list = $c_table->field('id,money,interest,lineup_date,lineup_interest')->where($info)->limit(100)->select(); //每次执行只取满足条件的一百条数据
        $count = count($list);

        for ($i = 0; $i < $count; $i++) {
            //增加排单利息
            $interest = $list[$i]['money'] * $interestrate; //利息

            $c_table->save(array(
                'id' => $list[$i]['id'],
                'interest' => $list[$i]['interest'] + $interest,
                'lineup_date' => $list[$i]['lineup_date'] + 1,
                'lineup_interest' => $list[$i]['lineup_interest'] + $interest,
                'interest_date' => time() + 60 * 60 * 24,
            ));
        }

        unset($info);
    }

    ///计划任务执行的方法（计算冻结期利息）
    public function InterestFreeze() {
        $relust = $this->bonusset();
        $interestrate = $relust['interestfreeze'] / 100; //利率
        $freezeday = $relust['freezingdays']; //冻结天数
        $c_table = M('c');
        $bonus_table = M('bonus');
        $member_table = M('member');
        $times = time();
        $info['status'] = 5;
        $info['interest_date'] = array('lt', $times);
        $info['finish_time_flag'] = array('lt', $times);
        $info['flag'] = 1;
        $list = $c_table->field('id,user_id,money,interest,frozen_date,frozen_interest')->where($info)->limit(100)->select();
        $count = count($list);
        for ($i = 0; $i < $count; $i++) {

            if ($list[$i]['frozen_date'] < $freezeday) {
                //增加排单利息
                $interest = $list[$i]['money'] * $interestrate; //利息

                $c_table->save(array(
                    'id' => $list[$i]['id'],
                    'interest' => $list[$i]['interest'] + $interest,
                    'frozen_date' => $list[$i]['frozen_date'] + 1,
                    'frozen_interest' => $list[$i]['frozen_interest'] + $interest,
                    'interest_date' => time() + 60 * 60 * 24,
                ));
                //转入现金钱袋流水
                if ($list[$i]['frozen_date'] + 1 == $freezeday) {
                    $c_table->save(array('id' => $list[$i]['id'], 'flag' => '2'));
                    $userinfo = $member_table->field('cash')->find($list[$i]['user_id']);
                    $settlement = $list[$i]['interest'] + $list[$i]['money'] + $interest;
                    $userallmoney = $userinfo['cash'] + $settlement;
                    $member_table->save(array('id' => $list[$i]['user_id'], 'cash' => $userallmoney,'countdown_status' => '1'));
                    //生成流水记录
                    $bonus_table->add(array(
                        'user_id' => $list[$i]['user_id'],
                        'type' => 1,
                        'create_date' => time(),
                        'sum' => $settlement,
                        'export' => 0,
                        'balance' => $userallmoney,
                        'status' => 1,
                        'explain' => '返还本金利息'
                    ));
                }
            }
        }

        unset($info);
    }

    //计划任务执行的方法 (每日转移推荐奖)
    function recommend() {
        $todayTime = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

        $relust = $this->bonusset();
        $member_limitmoney = explode(',', $relust['member_limitmoney']);
        $recommend_limitmoney = explode(',', $relust['recommend_limitmoney']);
        $limitmoney = array_merge($member_limitmoney, $recommend_limitmoney);


        $member_table = M('member');
        $bonus_table = M('bonus');


        $userlist = $member_table->query('select id,frozen,cash,star from web_member where ((endtime is NULL or endtime!=' . $todayTime . ') and frozen>0  ) limit 50');

        $count = count($userlist);
        for ($i = 0; $i < $count; $i++) {
            $sum = $limitmoney[$userlist[$i]['star']]; //限制额度

            if ($userlist[$i]['frozen'] > $sum) {
                $allowmoney = $sum;
            } else {
                $allowmoney = $userlist[$i]['frozen'];
            }


            //推荐奖转移到现金钱袋
            if ($allowmoney > 0) {
                //增加现金钱袋 减去推荐奖
                $userallcashmoney = $userlist[$i]['cash'] + $allowmoney;
                $userallfrozenmoney = $userlist[$i]['frozen'] - $allowmoney;
                $member_table->save(array('id' => $userlist[$i]['id'], 'cash' => $userallcashmoney, 'frozen' => $userallfrozenmoney, 'endtime' => $todayTime));
                //生成现金流水

                $bonus_table->add(array(
                    'user_id' => $userlist[$i]['id'],
                    'type' => 1,
                    'create_date' => time(),
                    'sum' => $allowmoney,
                    'export' => 0,
                    'balance' => $userallcashmoney,
                    'status' => 1,
                    'explain' => '来自推荐钱包',
                ));

                //生成推荐奖流水

                $bonus_table->add(array(
                    'user_id' => $userlist[$i]['id'],
                    'type' => 3,
                    'create_date' => time(),
                    'sum' => 0,
                    'export' => $allowmoney,
                    'balance' => $userallfrozenmoney,
                    'status' => 2,
                    'explain' => '转移到钱包',
                ));
            }
        }
        unset($info);
    }

    //计划任务执行的方法 (每30天转移经理奖)
    function manager() {
        $todayTime = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $thirtytime = $todayTime + 60 * 60 * 24 * 30; //每个用户每隔三十天执行一次
        $relust = $this->manager_allowmoney();
        $times = time();
        $member_table = M('member');
        $bonus_table = M('bonus');
        $userlist = $member_table->query('select id,activity,cash,star from web_member where ((endday is NULL or endday<=' . $times . ') and activity>0  ) limit 50');
        $count = count($userlist);

        for ($i = 0; $i < $count; $i++) {
            $sum = $relust[$userlist[$i]['star']]; //限制额度
            if (!empty($sum)) {
                if ($userlist[$i]['activity'] > $sum) {
                    $allowmoney = $sum;
                } else {
                    $allowmoney = $userlist[$i]['activity'];
                }


                //推荐奖转移到现金钱袋
                if ($allowmoney > 0) {
                    //增加现金钱袋 减去推荐奖
                    $userallcashmoney = $userlist[$i]['cash'] + $allowmoney;
                    $userallactivitymoney = $userlist[$i]['activity'] - $allowmoney;
                    $member_table->save(array('id' => $userlist[$i]['id'], 'cash' => $userallcashmoney, 'activity' => $userallactivitymoney, 'endday' => $thirtytime));
                    //生成现金流水

                    $bonus_table->add(array(
                        'user_id' => $userlist[$i]['id'],
                        'type' => 1,
                        'create_date' => time(),
                        'sum' => $allowmoney,
                        'export' => 0,
                        'balance' => $userallcashmoney,
                        'status' => 1,
                        'explain' => '来自经理钱包',
                    ));

                    //生成经理奖流水

                    $bonus_table->add(array(
                        'user_id' => $userlist[$i]['id'],
                        'type' => 2,
                        'create_date' => time(),
                        'sum' => 0,
                        'export' => $allowmoney,
                        'balance' => $userallactivitymoney,
                        'status' => 2,
                        'explain' => '转移到钱包',
                    ));
                }
            }
        }
    }

    //获取参数信息(奖金设置)
    function bonusset() {
        $table_webconfig = M('webconfig');
        $setbonus = $table_webconfig->find('2');
        $relust = json_decode($setbonus['value'], true);
        return $relust;
    }

    //获取参数信息(奖励设置)
    function rewardset() {
        $table_webconfig = M('webconfig');
        $setreward = $table_webconfig->find('3');
        $relust = json_decode($setreward['value'], true);
        return $relust;
    }

    //经理id对应的限制钱数
    function manager_allowmoney() {
        $relust = $this->rewardset();
        $relust1 = $this->bonusset();
        $level = explode(',', rtrim($relust['level'], ','));
        $manager = explode(',', rtrim($relust['manager'], ','));
        $manager_limitmoney = explode(',', rtrim($relust1['manager_limitmoney'], ','));
        $manager_id = array(); //经理id 和对应的比例
        foreach ($level as $key => $value) {
            foreach ($manager as $k => $v) {
                if ($value == $v) {
                    foreach ($manager_limitmoney as $kk => $vv) {
                        if ($k == $kk) {
                            $manager_id[$key] = $vv;
                        }
                    }
                }
            }
        }

        return $manager_id;
    }

    public function back_login($m) {
        if (isset($_SESSION['userid'])) {

            $m = base64_decode($m);
            session('uid', $m);
            session('logintime', time());
            redirect(U('/Home'));
        } else {
            redirect(U('/Home/'));
            exit;
        }
    }

    /*
      //递归函数
      public function dg($userid,$num)
      {
      unset($data);
      $member=M('member');
      $data['recommend']=$userid;
      $list=$member->field('id')->where($data)->select();
      $row=$member->field('id')->where(array('status'=>'1','recommend'=>$userid))->select();
      $num+=count($row);
      $count=count($list);
      for($i=0;$i<$count;$i++)
      {
      $num=self::dg($list[$i]['id'],$num);

      }
      return $num;

      }


      public function aa()
      {
      $member_table=M('member');
      $userinfo=$member_table->field('id')->select();
      $count=count($userinfo);
      for($i=0;$i<$count;$i++)
      {
      $relust=$this->dg($userinfo[$i]['id'],$num);
      echo 'id:'.$userinfo[$i]['id'].'结果：'. $relust.'<br/>';
      $member_table->save(array('id'=>$userinfo[$i]['id'],'group'=>$relust));
      }

      }

      //递归函数
      public function bdg($userid,$num)
      {
      unset($data);
      $member=M('member');
      $data['recommend']=$userid;
      $list=$member->field('id')->where($data)->select();
      $count=count($list);
      $num+=$count;

      for($i=0;$i<$count;$i++)
      {
      $num=self::bdg($list[$i]['id'],$num);

      }
      return $num;

      }
      public function bb()
      {
      $member_table=M('member');
      $userinfo=$member_table->field('id')->select();
      $count=count($userinfo);
      for($i=0;$i<$count;$i++)
      {
      $relust=$this->bdg($userinfo[$i]['id'],$num);
      echo 'id:'.$userinfo[$i]['id'].'结果：'. $relust.'<br/>';
      $member_table->save(array('id'=>$userinfo[$i]['id'],'truegroup'=>$relust));
      }

      }

      public function cdg($userid,$num)
      {
      unset($data);
      $member=M('member');
      $data['recommend']=$userid;
      $relist=$member->field('id')->where(array('recommend'=>$userid))->select();
      $num=count($relist);

      return $num;

      }
      public function  cc()
      {

      $member_table=M('member');
      $userinfo=$member_table->field('id')->select();
      $count=count($userinfo);
      for($i=0;$i<$count;$i++)
      {
      $relust=$this->cdg($userinfo[$i]['id'],$num);
      echo 'id:'.$userinfo[$i]['id'].'结果：'. $relust.'<br/>';
      $member_table->save(array('id'=>$userinfo[$i]['id'],'truedirectnum'=>$relust));
      }


      }

      public function ddg($userid,$num)
      {
      unset($data);
      $member=M('member');
      $data['recommend']=$userid;
      $relist=$member->field('id')->where(array('recommend'=>$userid,'status'=>'1'))->select();
      $num=count($relist);

      return $num;

      }
      public function dd()
      {

      $member_table=M('member');
      $userinfo=$member_table->field('id')->select();
      $count=count($userinfo);
      for($i=0;$i<$count;$i++)
      {
      $relust=$this->ddg($userinfo[$i]['id'],$num);
      echo 'id:'.$userinfo[$i]['id'].'结果：'. $relust.'<br/>';
      $member_table->save(array('id'=>$userinfo[$i]['id'],'directnum'=>$relust));
      }



      }
     */

    //获取参数信息(时间)
    function setime() {
        $table_webconfig = M('webconfig');
        $setreward = $table_webconfig->find('5');
        $relust = $setreward['value'];
        return $relust;
    }

    //每月转移业绩一次到（achievement表）
    public function achievement() {
        $relust = $this->setime();
        $times = time();
        $date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('n'), date('t'), date('Y')));
        $times1 = strtotime($date); //本月最后一天
        $times2 = strtotime(date('Y-m-d H:i:s', strtotime(date('Y-m-01', $times1) . ' +1 month '))); //下个月第一天凌晨0时0分0秒

        $webconfig = M('webconfig');
        $total_copy_table = M('total_copy');
        $achievement_table = M('achievement');
        $total_info = $total_copy_table->select();
        $count = count($total_info);
        if ($times > $relust) {
            $data = array(
                'id' => '5',
                'value' => $times2,
            );
            $webconfig->save($data);


            for ($i = 0; $i < $count; $i++) {
               
                $achievement_table->add(array(
                    'create_date' => $times1,
                    'uid' => $total_info[$i]['user_id'],
                    'selfmoney' => $total_info[$i]['self_money'],
                    'groupmoney' => $total_info[$i]['group_money'],
                ));
              
                $total_copy_table->save(array(
                    'id' => $total_info[$i]['id'],
                    'self_money' => 0,
                    'group_money' => 0,
                ));
            }
        }
    }

}
