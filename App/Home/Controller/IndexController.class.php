<?php

namespace Home\Controller;

use Home\Controller\CommonController;

class IndexController extends CommonController {

    public function index() {
		$uid=session('uid');
        $table_member = M('member');
        $table_cr = M('cr');
		$table_picture=M('picture');
		
        //$member_count = $table_member->count();
       // $this->assign('member_count', $member_count);//总人数

		$selfinfo=$table_member->where('star,cash')->find($uid);
		$this->assign('selfinfo',$selfinfo);
		//获取参数
		$relust=$this->bonusset();
		$this->assign('relust',$relust);
		//级别
		$level=$this->rewardset();
		$star=explode(',',$level['level']);
		$this->assign('star',$star);
		/*******************************************************************************************************/
        //左边1
        $info['c_user_id'] = $uid;
		$info['status']=array('neq','3');
        $count1 =$table_cr->where($info)->count();
        $Page = new \Think\Page($count1,20);
        $show = $Page->show();
        $list1= $table_cr->order('create_date desc')->where($info)->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$forcount1=count($list1);
		for($i=0;$i<$forcount1;$i++)
		{  
			$userinfo=$table_member->field('username,name')->find($list1[$i]['r_user_id']);
			$list1[$i]['die_time']=$list1[$i]['die_time']-time();
			$list1[$i]['receive_time']=$list1[$i]['receive_time']-time();
			$list1[$i]['name']=$userinfo['name'];
		
	
		}
		$this->assign('list1',$list1);
		$this->assign('page',$page);
	
		//左边2
        $map['r_user_id'] = $uid;
		$map['status']=array('neq','3');
        $count2 =$table_cr->where($map)->count();
        $Page2 = new \Think\Page($count2,20);
        $show2 = $Page2->show();
        $list2= $table_cr->order('create_date desc')->where($map)->limit($Page2->firstRow . ',' . $Page2->listRows)->select();
		$forcount2=count($list2);
		for($i=0;$i<$forcount2;$i++)
		{
			$userinfo=$table_member->field('username,name')->find($list2[$i]['c_user_id']);
			$list2[$i]['die_time']=$list2[$i]['die_time']-time();
			$list2[$i]['receive_time']=$list2[$i]['receive_time']-time();
			$list2[$i]['name']=$userinfo['name'];
		}
		$this->assign('list2',$list2);
		$this->assign('page2',$show2);
	   /*******************************************************************************************************/

        //右边
        $sql_r_count = "select user_id,eg,style,sum,money,create_date,status from web_c where user_id=" . $uid . " union all select user_id,eg,style,sum,money,create_date,status  from web_r where user_id=" . $uid . " ";
        $rel_r_count = M()->query($sql_r_count);
        $count_num = count($rel_r_count);
        $Page1 = new \Think\Pages($count_num,4);
        $rsql = "select user_id,eg,style,sum,money,create_date,status from web_c where user_id=" . $uid . "  union all select user_id,eg,style,sum,money,create_date,status  from web_r where user_id=" . $uid . " order by create_date desc limit " . $Page1->firstRow . ',' . $Page1->listRows;
        $rightlist = M()->query($rsql);
		$allcount=count( $rightlist);
		for($i=0;$i<$allcount;$i++)
		{
			$userinfo=$table_member->field('name')->find($rightlist[$i]['user_id']);
		
			$rightlist[$i]['name']=$userinfo['name'];
		}
        $this->result = $rightlis;
        $page1 = $this->show = $Page1->show();
        $this->assign('page1', $page1);
        $this->assign('rightlist', $rightlist);
        $this->assign('cstatus', C('CSTATUS'));
        $this->assign('rstatus', C('RSTATUS'));
		$this->assign('crstatus', C('CRSTATUS'));
		//banner图片
		$bannerlist=$table_picture->where(array('status'=>1))->limit(3)->select();	
		$this->assign('bannerlist', $bannerlist);
        $this->display();
    }

   

   
   

    public function provide() {
        $webconfig = M('webconfig');
        $webconfig = $webconfig->where('id=1')->find();
        $basedata = json_decode($webconfig['value'], true);
        $this->assign('interst', $basedata['interst'] * 100);
        $this->display();
    }

    public function provide_add() {

			
        if (IS_AJAX) {
            $table_c = M('c');
            $member_table = M('member');
			$table_webconfig=M('webconfig');
            $table_c->startTrans();
            $uid = session('uid');
            $userinfo = $member_table->where('star,status,cstatus,singletime')->find($uid);
			
			

            if ($userinfo['status'] != 1) {
                $json['status'] = 2;
                $json['msg'] = '操作失败，账号已经冻结或者删除了！';
                echo json_encode($json);
                exit;
            }
			if ($userinfo['cstatus'] != 0) {
                $json['status'] = 2;
                $json['msg'] = '操作失败，你有一条记录正在排队中！';
                echo json_encode($json);
                exit;
            }

			$zffs1=I('post.zffs1', '', 'trim');
			$zffs2=I('post.zffs2', '', 'trim');
            $money = I('post.money', '', 'trim');
            if (!is_numeric($money) || $money <= 0) {
                $json['status'] = 2;
                $json['msg'] = '操作失败！';
                echo json_encode($json);
                exit;
            }
			
			


			//获取参数
		    $relust=$this->bonusset();

			if($relust['star_status']==1)
			{
			$zuidi=explode(',',$relust['zuidi']);
			$zuigao=explode(',',$relust['zuigao']);
			//判断排队的有效范围
			if($money>=$zuidi[$userinfo['star']]&&$money<=$zuigao[$userinfo['star']])
			{}
			else
			{
				$json['status'] = 2;
                $json['msg'] = '操作失败，只允许：'.$zuidi[$userinfo["star"]].'到'.$zuigao[$userinfo["star"]].'范围内排单';
                echo json_encode($json);
                exit;
			}
			}


			//第二次排队要等24小时
			if(!empty($userinfo['singletime']))
			{
				$overalltime=$userinfo['singletime']+60*60*24;
				if($overalltime>time())
				{   
					$overtime=$this->dataformat($overalltime-time());

					$json['status'] = 2;
					$json['msg'] = '等'.$overtime.'方可排单';
					echo json_encode($json);
					exit;
				}
			}

		
			//判断必须？元的整数倍
			if($money%$relust['multipleofextraction']!=0)
			{
					  $json['status'] = 2;
					  $json['msg'] = '操作失败，必须'.$relust['multipleofextraction'].'的整数倍';
					  echo json_encode($json);
					  exit;
			}

			//判断最低排单额度
			if($money<$relust['minimumamount'])
			{
					  $json['status'] = 2;
					  $json['msg'] = '操作失败，最低只能排'.$relust['minimumamount'].'元';
					  echo json_encode($json);
					  exit;
			}

			//新用户
			if($userinfo['star']==0)
			{
				if($relust['newuserqueuelimit']<$money)
				{
					  $json['status'] = 2;
					  $json['msg'] = '操作失败，最高只能排'.$relust['newuserqueuelimit'].'元';
					  echo json_encode($json);
					  exit;
				}
			}
			else
			{
				//每升一级增加？元
				$allowmoney=$userinfo['star']*$relust['increaseamount']+$relust['newuserqueuelimit'];
				if($allowmoney<$money)
				{
					  $json['status'] = 2;
					  $json['msg'] = '操作失败，最高只能排'.$allowmoney.'元';
					  echo json_encode($json);
					  exit;
				}

			}



            if (!$member_table->autoCheckToken($_POST)) {
                $json['status'] = 2;
                $json['msg'] = '非法操作';
                echo json_encode($json);
                exit;
            }
			$allow_money=$table_webconfig->find('4');
			$xianzhi=json_decode($allow_money['value'],true);
			if(($xianzhi['allmoney']+$money)>$relust['providehelplimit'])
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
			
           
			
            $date = array(
                'user_id' => session('uid'),
                'eg' => build_order_no(),
                'create_date' => time(),
                'money' => $money,
                'sum' => $money,
                'style' => 1,
                'action' => 1,
				'interest_date'=>time()+60*60*24,
				'zffs1'=>$zffs1,
				'zffs2'=>$zffs2,

            );
            $m_rel = $member_table->save(array('id' => $uid, 'cstatus' => '1','flag'=>'1','countdown_status'=>'0'));
            $rel = $table_c->add($date);
            if ($rel && $m_rel) {
                $table_c->commit(); //成功则提交

                $json['msg'] = '操作成功！';
                $json['status'] = 1;
            } else {
                $table_c->rollback();
                $json['msg'] = '操作失败！';
                $json['status'] = 2;
            }
            echo json_encode($json);
            exit;
        }
    }

	
    function dataformat($num) {
        $hour = floor($num / 3600);
        $minute = floor(($num - 3600 * $hour) / 60);
        $second = floor((($num - 3600 * $hour) - 60 * $minute) % 60);
        return $hour . '小时' . $minute . '分钟' . $second . '秒';
    }

    public function apply_add() {

		
        if (IS_AJAX) {
            $member_table = M('member');
            $bonus_table = M('bonus');
            $r_table = M('r');
			$apply_table=M('apply');
			
            $member_table->startTrans();
            $uid = session('uid');
            $userinfo = $member_table->where('status,cstatus')->find($uid);
            if ($userinfo['status'] != 1) {
                $json['status'] = 2;
                $json['msg'] = '操作失败，账号已经冻结或者删除了！';
                echo json_encode($json);
                exit;
            }
            if (!$member_table->autoCheckToken($_POST)) {
                $json['status'] = 2;
                $json['msg'] = '非法操作';
                echo json_encode($json);
                exit;
            }
			$zffs1=I('post.zffs3', '', 'trim');
			$zffs2=I('post.zffs4', '', 'trim');
            $money = I('post.sum', '', 'trim');
            if (!is_numeric($money) || $money <= 0) {
                $json['status'] = 2;
                $json['msg'] = '操作失败！';
                echo json_encode($json);
                exit;
            }




			
				//获取参数
			$relust=$this->bonusset();
			$applay_rel=$apply_table->where(array('uid'=>$uid))->find();
			

			//判断必须？元的整数倍
			if($money%$relust['multipleofextraction']!=0)
			{
					  $json['status'] = 2;
					  $json['msg'] = '操作失败，必须'.$relust['multipleofextraction'].'的整数倍';
					  echo json_encode($json);
					  exit;
			}

			//判断最低排单额度
			if($money<$relust['receivinglimit'])
			{
					  $json['status'] = 2;
					  $json['msg'] = '操作失败，最低只能排'.$relust['receivinglimit'].'元';
					  echo json_encode($json);
					  exit;
			}
				$userinfo = $member_table->find($uid);
				if ($userinfo['cash'] < $money) {
                    $json['status'] = 2;
                    $json['msg'] = '操作失败，你没有这么多钱！';
                    echo json_encode($json);
                    exit;
                }


			$todayTime = mktime(0, 0, 0,date("m"),date("d"),date("Y"));
			$falg=0;
			if(!empty($applay_rel))
			{
				
				//初始化用户次数
				if($todayTime!=$applay_rel['create_date'] )
				{
						$apply_table->save(array('id'=>$applay_rel['id'],'frequency'=>'0','create_date'=>$todayTime));
						$falg=1;
				}

				//判断满不满足提现次数
				if($applay_rel['frequency']>=$relust['frequency']&&$falg==0)
				{
					$json['status'] = 2;
					$json['msg'] = '操作失败！,每天只能接收帮助'.$relust['frequency'].'次';
					echo json_encode($json);
					exit;
				}
				else
				{
					if($falg==1)
					{
					$apply_table->save(array('id'=>$applay_rel['id'],'frequency'=>1,'create_date'=>$todayTime));
					}
					else
					{
					$apply_table->save(array('id'=>$applay_rel['id'],'frequency'=>$applay_rel['frequency']+1,'create_date'=>$todayTime));
					}
				}

			}
			else
			{
			        
				$apply_table->add(array('uid'=>$uid,'frequency'=>'1','create_date'=>$todayTime));
			
			}


       
			
               
                    $userallmoney = $userinfo['cash'] - $money;
                    $m_rel = $member_table->save(array('id' => $uid, 'cash' => $userallmoney));

                    //生成流水记录
                    $cash_data = array(
                        'user_id' => $uid,
                        'type' => 1,
                        'create_date' => time(),
                        'sum' => 0,
                        'export' => $money,
                        'balance' => $userallmoney,
                        'status' => 2,
                        'explain' => '申请帮助支出',
                    );
                    $b_rel = $bonus_table->add($cash_data);
                    //生成R记录
                    $r_data = array(
                        'user_id' => $uid,
                        'type' => 1,
                        'eg' => build_order_no(),
                        'create_date' => time(),
                        'money' => $money,
                        'sum' => $money,
                        'style' => 2,
                        'action' => 1,
						'zffs1'=>$zffs1,
						'zffs2'=>$zffs2,
                    );
                    $r_rel = $r_table->add($r_data);

                    if ($m_rel && $b_rel && $r_rel) {
                        $member_table->commit(); //成功则提交
                        $json['status'] = 1;
                        $json['msg'] = '操作成功！';
                        echo json_encode($json);
                        exit;
                    } else {
                        $member_table->rollback();
                        $json['status'] = 2;
                        $json['msg'] = '操作失败！';
                        echo json_encode($json);
                        exit;
                    }
               
		}
         
    }

    public function playmoney() {
        if (IS_GET && !empty($_GET['id'])) {
			$id=$_GET['id'];
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
		
			$id=$_GET['id'];
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

    public function addpromote() {

        /*
         * 1:成功上传
         * -1:文件超过规定大小
         * -2:文件类型不符
         * -3:移动文件出错
         */
        $member_table = M('member');
        $cr_table = M('cr');
        $uid = session('uid');
        if (IS_POST) {
            $cr_info = $cr_table->find(I('post.id', '', 'htmlspecialchars'));
            $userinfo = $member_table->where('status,cstatus')->find($uid);
			if($cr_info['c_user_id']!=$uid)
			{
				  echo '-4';
				  exit;
			}
        }
        if ($userinfo['status'] != 1) {
            echo '-4';
            exit;
        }

        if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {

            $photo_types = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/gif', 'image/bmp', 'image/x-png'); //定义上传格式
            $max_size = 1700000;    //上传照片大小限制,默认700k
            $photo_folder = C('MEMBER_UPLOAD_DIR') . '/bank/' . $cr_info['c_user_id'] . "/";
            ///////////////////////////////////////////////////开始处理上传
            if (!file_exists($photo_folder)) {//检查照片目录是否存在
                mkdir($photo_folder, 0777, true);  //mkdir("temp/sub, 0777, true);
            }

            $upfile = $_FILES['upfile'];
            $name = $upfile['name'];
            $type = $upfile['type'];
            $size = $upfile['size'];
            $tmp_name = $upfile['tmp_name'];

            $file = $_FILES["upfile"];
            $photo_name = $file["tmp_name"];
            //echo $photo_name;
            $photo_size = getimagesize($photo_name);

            if ($max_size < $file["size"]) {//检查文件大小
                echo "-1";
                exit;

                //echo "<script>alert('对不起，文件超过规定大小!');history.go(-1);</script>";
            }
            if (!in_array($file["type"], $photo_types)) {//检查文件类型
                echo "-2";
                exit;       //echo "<script>alert('对不起，文件类型不符!');history.go(-1);</script>";
            }
            if (!file_exists($photo_folder)) {//照片目录
                mkdir($photo_folder);
            }
            $pinfo = pathinfo($file["name"]);
            $photo_type = $pinfo['extension']; //上传文件扩展名
            $time = time();
            $photo_server_folder = $photo_folder . $time . "." . $photo_type; //以当前时间和7位随机数作为文件名，这里是上传的完整路径


            if (!move_uploaded_file($photo_name, $photo_server_folder)) {
                echo "-3"; //echo "移动文件出错";
                exit;
            } else {
                $pinfo = pathinfo($photo_server_folder);
                $fname = $pinfo['basename'];

				$relust=$this->bonusset();
				if(empty($relust['collectiontime'])||!is_numeric($relust['collectiontime']))//格式不对，默认24小时
				{
					$relust['collectiontime']=24;
				}
                //保存数据
                $_POST['upload_doc'] = $time . "." . $photo_type;
                $_POST['receive_time'] = time() + 60 * 60 *$relust['collectiontime']; //对方确认倒计时
                $_POST['c_time'] = time(); //上传的时间
                $_POST['status'] = 2;
                $relust = $cr_table->save($_POST);

				
                echo "1";   //echo " 已经成功上传：".$photo_server_folder."<br />";
                exit;
            }
        }
    }

    public function fake() {
        $id = I('post.id');
        $cr_table = M('cr');
		$menber_table=M('member');
        $promoteinfo = $cr_table->find($id);
        if (!$cr_table->autoCheckToken($_POST)) {
            $json['status'] = 2;
            $json['msg'] = '非法操作';
            echo json_encode($json);
            exit;
        }
        if ($promoteinfo['status'] == 2) {
            $member_table = M('member');
            $gg['id'] = $id;
            $gg['upload_doc'] = "";
            $gg['status'] = 4; //拒绝
            $result = $cr_table->save($gg);
            if ($result) {

			
                unlink(C('MEMBER_UPLOAD_DIR') . '/bank/' . $promoteinfo['c_user_id'] . "/" . $promoteinfo['upload_doc']);
                $json['status'] = 1;
                $json['msg'] = '操作成功';
            } else {
                $json['status'] = 2;
                $json['msg'] = '操作失败';
            }
        } else {
            $json['status'] = 2;
            $json['msg'] = '操作失败';
        }
        echo json_encode($json);
        exit;
    }

    public function affirm() {

	
        $uid = session('uid');
        $member_table = M('member');
        $bonus_table = M('bonus');
        $webconfig_table = M('webconfig');
        $cr_table = M('cr');
        $c_table = M('c');
        $r_table = M('r');
        $total_table = M('total');
		$total_copy_table=M('total_copy');
        $cr_table->startTrans();
        $id = I('post.id', '', 'htmlspecialchars');
        if (!$member_table->autoCheckToken($_POST)) {
            $json['status'] = 2;
            $json['msg'] = '非法操作';
            echo json_encode($json);
            exit;
        }
        $cr_info = M('cr')->where(array('id' => $id, 'r_user_id' => $uid))->find();
        if (!$cr_info) {
            $json['status'] = 2;
            $json['msg'] = '无法操作';
            echo json_encode($json);
            exit;
        }
        if ($cr_info['status'] != 2 || $cr_info['id'] != $id || $cr_info['r_user_id'] != $uid) {
            $json['status'] = 2;
            $json['msg'] = '无法操作';
            echo json_encode($json);
            exit;
        }

        //更新cr表状态
        $cr_rel_list = $cr_table->save(array('id' => $id, 'status' => '3', 'r_time' => time(), 'finish_date' => time()));
        //更新c表次数
        $c_info = $c_table->where(array('id' => $cr_info['c_id']))->find();
        $c_rel_list = $c_table->save(array('id' => $cr_info['c_id'], 'user_id' => $cr_info['c_user_id'], 'done' => $c_info['done'] + 1));
        //更新r表次数
        $r_info = $r_table->where(array('id' => $cr_info['r_id']))->find();
        $r_rel_list = $r_table->save(array('id' => $cr_info['r_id'], 'user_id' => $cr_info['r_user_id'], 'done' => $r_info['done'] + 1));

        if ($cr_rel_list && $c_rel_list && $r_rel_list) {
            $cr_table->commit(); //成功则提交

            if ($c_info['done'] + 1 == $c_info['splitno'] && $c_info['status'] == 2) {
                $c_table->save(array('id' => $c_info['id'],'status' => 5, 'finish_date' => time(),'flag'=>'1','finish_time_flag'=>time()+60*60*24));
                
               //获取参数
				$relust_time=$this->bonusset();
                //更新状态
                $userinfo = $member_table->find($cr_info['c_user_id']);
                $member_table->save(array('id' => $cr_info['c_user_id'],'cstatus' => '0', 'actmoney' => $c_info['money'],'singletime'=>time(),'countdown_status'=>'0','countdown' => time()));
               
                //计算推荐奖
                if ($userinfo['recommend'] != 0) {
                    $level =1;
                    $this->recommend($userinfo['recommend'], $c_info['money'], $level,$cr_info['c_user_id'],$userinfo['username'],$cr_info['c_id']);
                }

				//计算经理奖
				if ($userinfo['recommend'] != 0) {
                    $levels =1;
                    $this->managerbonus($userinfo['recommend'],$c_info['money'],$userinfo['username'],$cr_info['c_user_id'],$levels,$cr_info['c_id']);
                }

              

                //更新自己的钱和组的钱数（总业绩）
              $total_info = $total_table->where(array('user_id' => $cr_info['c_user_id']))->find();
                if (!$total_info) {
                    $total_data = array(
                        'user_id' => $cr_info['c_user_id'],
                        'self_money' => $c_info['money'],
                    );
                    $total_table->add($total_data); //更新自己的钱
                    $this->group_money($cr_info['c_user_id'], $c_info['money']); //更新下线玩的钱
                } else {
                    $total_data = array(
                        'id' => $total_info['id'],
                        'user_id' => $cr_info['c_user_id'],
                        'self_money' => $c_info['money'] + $total_info['self_money'],
                    );
                    $total_table->save($total_data);
                    $this->group_money($cr_info['c_user_id'], $c_info['money']); //更新下线玩的钱
                }


				//更新自己的钱和组的钱数（月业绩）
			    $total_copy_info = $total_copy_table->where(array('user_id' => $cr_info['c_user_id']))->find();
                if (! $total_copy_info) {
                    $total_copy_data = array(
                        'user_id' => $cr_info['c_user_id'],
                        'self_money' => $c_info['money'],
                    );
                    $total_copy_table->add($total_copy_data); //更新自己的钱
                    $this->group_copy_money($cr_info['c_user_id'], $c_info['money']); //更新下线玩的钱
                } else {
                    $total_copy_data = array(
                        'id' => $total_copy_info['id'],
                        'user_id' => $cr_info['c_user_id'],
                        'self_money' => $c_info['money'] + $total_copy_info['self_money'],
                    );
                    $total_copy_table->save($total_copy_data);
                    $this->group_copy_money($cr_info['c_user_id'], $c_info['money']); //更新下线玩的钱
                }
            
			
			}

			


			//得完成
            if ($r_info['done'] + 1 == $r_info['splitno'] && $r_info['status'] == 2) {
                $r_table->save(array('id' => $r_info['id'], 'status' => 3, 'finish_date' => time()));
            }

		

            $json['status'] = 1;
            $json['msg'] = '操作成功';
            echo json_encode($json);
            exit;
        } else {
            $cr_table->rollback();
            $json['status'] = 2;
            $json['msg'] = '操作失败';
            echo json_encode($json);
            exit;
        }
    }

    public function group_money($user_id, $money) {
        $member_table = M('member');
        $total_table = M('total');
        $member_info = $member_table->field('recommend')->find($user_id);

        if ($member_info['recommend'] != 0) {
            $total_info = $total_table->where(array('user_id' => $member_info['recommend']))->find();
            if (!$total_info) {
                $total_data_group = array(
                    'user_id' => $member_info['recommend'],
                    'group_money' => $money,
                );
                $total_table->add($total_data_group); //更新自己的钱
                self::group_money($member_info['recommend'], $money);
            } else {
                $total_data_group = array(
                    'id' => $total_info['id'],
                    'user_id' => $member_info['recommend'],
                    'group_money' => $money + $total_info['group_money'],
                );
                $total_table->save($total_data_group);
                self::group_money($member_info['recommend'], $money);
            }
        }
    }
  public function group_copy_money($user_id, $money) {
        $member_table = M('member');
        $total_copy_table = M('total_copy');
        $member_info = $member_table->field('recommend')->find($user_id);

        if ($member_info['recommend'] != 0) {
            $total_info = $total_copy_table->where(array('user_id' => $member_info['recommend']))->find();
            if (!$total_info) {
                $total_data_group = array(
                    'user_id' => $member_info['recommend'],
                    'group_money' => $money,
                );
                $total_copy_table->add($total_data_group); //更新自己的钱
                self::group_copy_money($member_info['recommend'], $money);
            } else {
                $total_data_group = array(
                    'id' => $total_info['id'],
                    'user_id' => $member_info['recommend'],
                    'group_money' => $money + $total_info['group_money'],
                );
                $total_copy_table->save($total_data_group);
                self::group_copy_money($member_info['recommend'], $money);
            }
        }
    }
    public function recommend($id,$money,$level,$uid,$uname,$c_id) {
        $member_table = M('member');
        $bonus_table = M('bonus');
		$c_table=M('c');
		//获取推荐奖比例
		$relust=$this->rewardset();
		$recommendedaward=explode(',',$relust['recommendedaward']);
		foreach($recommendedaward as $key=>$value)
		{
			$recommendedaward[$key]=$value/100;
		}
		$allownum_list=explode(',',$relust['star']);
		$allownum=count($recommendedaward);
		
	
		//烧伤系数
		$other_info=$c_table->order('id desc')->field('id,money')->where(array('user_id'=>$id))->find();
		if($other_info){
			if($other_info['money']<$money)
			{
				$rewardmoney=$other_info['money'];
				$rewardid=$id;
				$c_table_id=$other_info['id'];
			}
			else
			{
				$rewardmoney=$money;
				$rewardid=$uid;
				$c_table_id=$c_id;
			}
		}
		//推荐人没玩第一局没有推荐奖
		/*else
		{
				$rewardmoney=$money;
				$rewardid=$uid;
				$c_table_id=$c_id;
		}*/
		$recommend_info = $member_table->field('recommend,frozen,star')->find($id);
			

		if(($allownum_list[$recommend_info['star']])>=$level)
		{   


			$scale=$recommendedaward[$level-1];
			$sum = $rewardmoney*$scale;


			$userallmoney = $recommend_info['frozen'] + $sum;
			$m_rel = $member_table->save(array('id' => $id, 'frozen' => $userallmoney));

			//生成流水记录
			$frozen_data = array(
				'user_id' => $id,
				'type' => 3,
				'create_date' => time(),
				'sum' => $sum,
				'export' => 0,
				'balance' => $userallmoney,
				'status' => 1,
				'explain' => '来自：'.$uname.'第'. $level . '代推荐奖',
				'from_id' => $uid,//来自谁的推荐奖
				'from_money' => $money,//下家玩的金额
				'from_scale' => $scale,//按多少比例结算
				'settlement_id'=>$rewardid,//根据烧伤系数，判断用谁的钱作为结算id （取小值）
				'settlement_money'=>$rewardmoney,//根据烧伤系数，判断用谁的钱作为结算金额（取小值）
				'level'=>$level,//第几代推荐奖
				'c_id'=>$c_table_id,//根据烧伤系数结算金额对应的c表id号
				'recommend_money'=>$other_info['money'],//推荐人玩的金额
				'from_c_id'=>$c_id,//下家玩的c表id
				'recommend_c_id'=>$other_info['id'],//推荐人玩的c表id号
			);
			 $bonus_table->add($frozen_data);
		}
        if ($recommend_info['recommend'] != 0 && $level < ($allownum+1)) {
            $level++;
            self::recommend($recommend_info['recommend'], $money, $level, $uid,$uname,$c_id);
        }
    }
	//经理奖
	//rid  推荐人ID
    public function managerbonus($rid,$money,$uname,$uid,$level,$c_id)
	{
	
		$member_table=M('member');
		$bonus_table=M('bonus');
		$manager_id=$this->manager_bonus();//经理id对应利息比例
		$manager_level=$this->manager_level();//经理id对应开始算经理奖的层数
		$userinfo=$member_table->field('star,recommend,activity')->find($rid);
		
		if($level>$manager_level[$userinfo['star']]&&!empty($manager_level[$userinfo['star']]))
		{

		
			if(!empty($manager_id[$userinfo['star']]))
			{

				$sum=$money*$manager_id[$userinfo['star']];
				$userallmoney=$userinfo['activity']+$sum;
				$member_table->save(array('id'=>$rid,'activity'=>$userallmoney));
				
				//生成流水记录
				$activity_data = array(
					'user_id' => $rid,
					'type' => 2,
					'create_date' => time(),
					'sum' => $sum,
					'export' => 0,
					'balance' => $userallmoney,
					'status' => 1,
					'explain' => '来自：'.$uname.'第'. $level . '代经理奖',
					'from_id' => $uid,//来自谁的经理奖
					'from_money' => $money,//下家玩的金额
					'from_scale' => $manager_id[$userinfo['star']],//按多少比例结算
					'level'=>$level,//第几代经理奖
					'from_c_id'=>$c_id,//下家玩的c表id
				);
				 $bonus_table->add($activity_data);
				
			}
		}
		
		if($userinfo['recommend']!=0)
		{
			$level++;
		    self::managerbonus($userinfo['recommend'],$money,$uname,$uid,$level,$c_id);
		
		}


	}
	



	

}
