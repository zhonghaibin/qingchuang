<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class TextController extends CommonController {

	/***
	*
	*
	*/
	


    public function index(){
		
		$c_table=M('c');
		$r_table=M('r');
		$member_table=M('member');
		if(IS_POST)
		{
			
			if($_POST['flag']=='matching')
			{
				  $c_id=implode($_POST['c_id'],',');
				  $r_id=implode($_POST['r_id'],',');
				  if(empty($c_id)||empty($r_id))
				  {
					$this->error('两边勾选后有数据方可操作');
					exit;
				  }

				  $map1['id']=array('in',$c_id);
				  $map2['id']=array('in',$r_id);
				  $money_c=$c_table->where($map1)->sum('sum');
				  $money_r=$r_table->where($map2)->sum('sum');
				  if($money_c<$money_r)
				  {
					$this->error('舍要大于得！');
					exit;
				  }

				
				$list_c=$c_table->field('id,eg,user_id,sum,splitno')->where(array('id'=>array('in',$c_id)))->select();
				$list_r=$r_table->field('id,eg,user_id,sum,splitno')->where(array('id'=>array('in',$r_id)))->select();
				$this->splic($list_c,$list_r);
				$this->success('匹配完成');
				$this->getmember($list_c,$list_r);
				unset($list_c);unset($list_r);
				exit;
			}

		}
			
		//筛选C表数据
		if (!empty($_REQUEST['search_starttime_c']) && !empty($_REQUEST['search_endtime_c'])) {
            $startime = strtotime($_REQUEST['search_starttime_c']);
            $endtime = strtotime($_REQUEST['search_endtime_c']);

            if ($startime <= $endtime) {
               
				 $times = (strtotime($_REQUEST['search_starttime_c'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime_c'] . '23:59:59'));
                $search['search_starttime_c'] = $_REQUEST['search_starttime_c'];
                $search['search_endtime_c'] = $_REQUEST['search_endtime_c'];
            } else {
				 $times = (strtotime($_REQUEST['search_endtime_c'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime_c'] . '23:59:59'));
                $search['search_starttime_c'] = $_REQUEST['search_endtime_c'];
                $search['search_endtime_c'] = $_REQUEST['search_starttime_c'];
            }
            $map['create_date'] = array('between', $times);
        } elseif (!empty($_REQUEST['search_starttime_c'])) {
            $xtime = strtotime($_REQUEST['search_starttime_c'] . '00:00:00');
            $map['create_date'] = array("egt", $xtime);
            $search['search_starttime_c'] = $_REQUEST['search_starttime_c'];
        } elseif (!empty($_REQUEST['search_endtime_c'])) {
             $xtime = strtotime($_REQUEST['search_endtime_c'] . '23:59:59');
            $map['create_date'] = array("elt", $xtime);
            $search['search_endtime_c'] = $_REQUEST['search_endtime_c'];
        }
		

		
		if (!empty($_REQUEST['search_starttime_r']) && !empty($_REQUEST['search_endtime_r'])) {
            $startime2 = strtotime($_REQUEST['search_starttime_r']);
            $endtime2 = strtotime($_REQUEST['search_endtime_r']);

            if ($startime2 <= $endtime2) {
               $times2 = (strtotime($_REQUEST['search_starttime_r'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime_r'] . '23:59:59'));
                $search['search_starttime_r'] = $_REQUEST['search_starttime_r'];
                $search['search_endtime_r'] = $_REQUEST['search_endtime_r'];
            } else {
              
				  $times2 = (strtotime($_REQUEST['search_endtime_r'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime_r'] . '23:59:59'));
                $search['search_starttime_r'] = $_REQUEST['search_endtime_r'];
                $search['search_endtime_r'] = $_REQUEST['search_starttime_r'];
            }
            $map2['create_date'] = array('between', $times2);
        } elseif (!empty($_REQUEST['search_starttime_r'])) {
          
		    $xtime2 = strtotime($_REQUEST['search_endtime_r'] . '00:00:00');
            $map2['create_date'] = array("egt", $xtime2);
            $search['search_starttime_r'] = $_REQUEST['search_starttime_r'];
        } elseif (!empty($_REQUEST['search_endtime_r'])) {
           
			 $xtime2 = strtotime($_REQUEST['search_endtime_r'] . '23:59:59');
            $map2['create_date'] = array("elt", $xtime2);
            $search['search_endtime_r'] = $_REQUEST['search_endtime_r'];
        }
		
		
		$map['status']=array('in','1,3');
		$map2['status']=array('eq','1');
		$list_c= $c_table->where($map)->field('id,sum,money,create_date,user_id')->order('id desc')->select();
		$list_r = $r_table->where($map2)->field('id,sum,money,create_date,user_id')->order('id desc')->select();
		$count_c=count($list_c);
		$count_r=count($list_r);
		$allow_c_table=array();
		$allow_r_table=array();
		$sum_c=0;
		$sum_r=0;
		for($i=0;$i<$count_c;$i++)
		{
			$userinfo_c=$member_table->field('id,username,name,status,stars')->find($list_c[$i]['user_id']);
			if($userinfo_c['status']==1)
			{
				$list_c[$i]['username']=$userinfo_c['username'];
				$list_c[$i]['stars']=$userinfo_c['stars'].'星';
				$list_c[$i]['name']=$userinfo_c['name'];
				$allow_c_table[]=$list_c[$i];
				$sum_c+=$list_c[$i]['sum'];
			}
			
		}
	
		for($j=0;$j<$count_r;$j++)
		{
			$userinfo_r=$member_table->field('id,username,name,status,stars')->find($list_r[$j]['user_id']);
			if($userinfo_r['status']==1)
			{
				$list_r[$j]['username']=$userinfo_r['username'];
				$list_r[$j]['stars']=$userinfo_r['stars'].'星';
				$list_r[$j]['name']=$userinfo_r['name'];
				$allow_r_table[]=$list_r[$j];
				$sum_r+=$list_r[$j]['sum'];
			}
			
		}
		
		$allow_c_count=count($allow_c_table);
		$allow_r_count=count($allow_r_table);
		$this->assign('search_c',$search_c);
		$this->assign('search_r',$search_r);
		$this->assign('count_c',$allow_c_count);
		$this->assign('count_r',$allow_r_count);
		$this->assign('sum_c',$sum_c);
		$this->assign('sum_r',$sum_r);
		$this->assign('list_c',$allow_c_table);
		$this->assign('list_r',$allow_r_table);
		$this->assign('arr',$search);
        $this->display();

			

		
		
    }

	public function getmember($list1,$list2)
	{
			//获取舍的用户ID
		    $user1=array();
		    for($i=0;$i<count($list1);$i++)
		   {
			 $user1[]=$list1[$i]['user_id'];
		   }
		   $user1=array_unique($user1);
		   //匹配完成后给舍发短信 
		   $this->sms_c($user1);
		  
		  //获取得的用户ID
		   $user2=array();
		   for($j=0;$j<count($list2);$j++)
		   {
			 $user2[]=$list2[$j]['user_id'];
		   }
		  $user2=array_unique($user2);
		  //匹配完成后给得发短信 
		  $this->sms_r($user2);
	}

	public function sms_c($u)
	{
		$member=M('member');
		 foreach($u as $k=>$v)
		  {
				$user=$member->field('name,mobile')->where(array('id'=>$v))->find();
				if (preg_match('#^(1)[0-9]{10}$#',$user['mobile'])) 
				{
					send_sms($user['mobile'],'尊敬的会员：您提供帮助的订单已匹配成功，请及时登录完成订单。');
				}
			 
		  }

		  unset($u);
	
	}
	public function sms_r($u)
	{
		$member=M('member');
		 foreach($u as $k=>$v)
		  {
				$user=$member->field('name,mobile')->where(array('id'=>$v))->find();
				if (preg_match('#^(1)[0-9]{10}$#',$user['mobile'])) 
				{
					send_sms($user['mobile'],'尊敬的会员：您得到帮助的订单已匹配成功，请及时登录完成订单。');
				}
			 
		  }
		  unset($u);
	
	}

	
	public function splic($c, $r){
		
		$c_table=M('c');
		$r_table=M('r');
		$cr_table=M('cr');
		$relust=$this->bonusset();
		if(empty($relust['playingtime'])||!is_numeric($relust['playingtime']))//格式不对，默认24小时
		{
			$relust['playingtime']=24;
		}
		$second=60*60*$relust['playingtime'];
		$j=0;
		$r_count=count($r);
		$c_count=count($c);
		for($i=0;$i<$r_count;$i++)
		{
			if($r[$i]['sum']>$c[$j]['sum']){
				
				$r[$i]['sum']=$r[$i]['sum']-$c[$j]['sum'];//余额
				
				//生成匹配数据
				$cr_1_data['cr_eg']=build_order_no();
				$cr_1_data['c_eg']=$c[$j]['eg'];
				$cr_1_data['r_eg']=$r[$i]['eg'];
				$cr_1_data['c_id']=$c[$j]['id'];
				$cr_1_data['r_id']=$r[$i]['id'];
				$cr_1_data['c_user_id']=$c[$j]['user_id'];
				$cr_1_data['r_user_id']=$r[$i]['user_id'];
				$cr_1_data['sum']=$c[$j]['sum'];
				$cr_1_data['create_date']=time();
				$cr_1_data['die_time']=time()+$second;
				$cr_table->add($cr_1_data);

				//查询C表的分割次数
				$c_1_map['id']=$c[$j]['id'];
				$c_1_list=$c_table->field('splitno')->where($c_1_map)->find();
				//更新C表的余额和分割次数
				$c_1_map['sum']=0;
				$c_1_map['splitno']=$c_1_list['splitno']+1;
				$c_1_map['status']=2;
				$c_table->save($c_1_map);

				//查询R表的分割次数
				$r_1_info['id']=$r[$i]['id'];
				$r_1_list=$r_table->field('splitno')->where($r_1_info)->find();
				//更新R表的余额和分割次数
				$r_1_info['sum']=$r[$i]['sum'];
				$r_1_info['splitno']=$r_1_list['splitno']+1;
				$r_1_info['status']=2;
				$r_table->save($r_1_info);
				unset($cr_1_data);unset($c_1_map);unset($r_1_info);
				$j++;
				if($j<$c_count)
				{
						

						while($r[$i]['sum']>$c[$j]['sum'])
						{

							$r[$i]['sum']=$r[$i]['sum']-$c[$j]['sum'];//余额
							
							//生成匹配数据
							$cr_2_data['cr_eg']=build_order_no();
							$cr_2_data['c_eg']=$c[$j]['eg'];
							$cr_2_data['r_eg']=$r[$i]['eg'];
							$cr_2_data['c_id']=$c[$j]['id'];
							$cr_2_data['r_id']=$r[$i]['id'];
							$cr_2_data['c_user_id']=$c[$j]['user_id'];
							$cr_2_data['r_user_id']=$r[$i]['user_id'];
							$cr_2_data['sum']=$c[$j]['sum'];
							$cr_2_data['create_date']=time();
							$cr_2_data['die_time']=time()+$second;
							
							$cr_table->add($cr_2_data);

							//查询C表的分割次数
							$c_2_map['id']=$c[$j]['id'];
							$c_2_list=$c_table->field('splitno')->where($c_2_map)->find();
							//更新C表的余额和分割次数
							$c_2_map['sum']=0;
							$c_2_map['splitno']=$c_2_list['splitno']+1;
							$c_2_map['status']=2;
							$c_table->save($c_2_map);

							//查询R表的分割次数
							$r_2_info['id']=$r[$i]['id'];
							$r_2_list=$r_table->field('splitno')->where($r_2_info)->find();
							//更新R表的余额和分割次数
							$r_2_info['sum']=$r[$i]['sum'];
							$r_2_info['splitno']=$r_2_list['splitno']+1;
							$r_2_info['status']=2;
							$r_table->save($r_2_info);
							unset($cr_2_data);unset($c_2_map);unset($r_2_info);	
							if($j<$c_count)
							{
								$j++;
							}
						}

						if($c[$j]['sum']>$r[$i]['sum'])
						{
							$c[$j]['sum']=$c[$j]['sum']-$r[$i]['sum'];//余额
							
							
							//生成匹配数据
							$cr_3_data['cr_eg']=build_order_no();
							$cr_3_data['c_eg']=$c[$j]['eg'];
							$cr_3_data['r_eg']=$r[$i]['eg'];
							$cr_3_data['c_id']=$c[$j]['id'];
							$cr_3_data['r_id']=$r[$i]['id'];
							$cr_3_data['c_user_id']=$c[$j]['user_id'];
							$cr_3_data['r_user_id']=$r[$i]['user_id'];
							$cr_3_data['sum']=$r[$i]['sum'];
							$cr_3_data['create_date']=time();
							$cr_3_data['die_time']=time()+$second;
							$cr_table->add($cr_3_data);

							//查询C表的分割次数
							$c_3_map['id']=$c[$j]['id'];
							$c_3_list=$c_table->field('splitno')->where($c_3_map)->find();
							//更新C表的余额和分割次数
							$c_3_map['sum']=$c[$j]['sum'];
							$c_3_map['splitno']=$c_3_list['splitno']+1;
							$c_3_map['status']=3;//未匹配完
							$c_table->save($c_3_map);

							//查询R表的分割次数
							$r_3_info['id']=$r[$i]['id'];
							$r_3_list=$r_table->field('splitno')->where($r_3_info)->find();
							//更新R表的余额和分割次数
							$r_3_info['sum']=0;
							$r_3_info['splitno']=$r_3_list['splitno']+1;
							$r_3_info['status']=2;
							$r_table->save($r_3_info);
							unset($cr_3_data);unset($c_3_map);unset($r_3_info);
						
						}
						else
						{
								$c[$j]['sum']=$c[$j]['sum']-$r[$i]['sum'];//余额
								
								//生成匹配数据
								$cr_6_data['cr_eg']=build_order_no();
								$cr_6_data['c_eg']=$c[$j]['eg'];
								$cr_6_data['r_eg']=$r[$i]['eg'];
								$cr_6_data['c_id']=$c[$j]['id'];
								$cr_6_data['r_id']=$r[$i]['id'];
								$cr_6_data['c_user_id']=$c[$j]['user_id'];
								$cr_6_data['r_user_id']=$r[$i]['user_id'];
								$cr_6_data['sum']=$r[$i]['sum'];
								$cr_6_data['create_date']=time();
								$cr_6_data['die_time']=time()+$second;
								$cr_table->add($cr_6_data);

								//查询C表的分割次数
								$c_6_map['id']=$c[$j]['id'];
								$c_6_list=$c_table->field('splitno,status')->where($c_6_map)->find();
								//更新C表的余额和分割次数
								$c_6_map['sum']=0;
								$c_6_map['splitno']=$c_6_list['splitno']+1;
								$c_6_map['status']=2;
								$c_table->save($c_6_map);

								//查询R表的分割次数
								$r_6_info['id']=$r[$i]['id'];
								$r_6_list=$r_table->field('splitno')->where($r_6_info)->find();
								//更新R表的余额和分割次数
								$r_6_info['sum']=0;
								$r_6_info['splitno']=$r_6_list['splitno']+1;
								$r_6_info['status']=2;
								$r_table->save($r_6_info);
								unset($cr_6_data);unset($c_6_map);unset($r_6_info);
								if($j<$c_count)
								{
									$j++;
								}
						}
				}
				



			}
			else if($r[$i]['sum']<$c[$j]['sum']){
				
				$c[$j]['sum']=$c[$j]['sum']-$r[$i]['sum'];//余额
					
					
					//生成匹配数据
					$cr_4_data['cr_eg']=build_order_no();
					$cr_4_data['c_eg']=$c[$j]['eg'];
					$cr_4_data['r_eg']=$r[$i]['eg'];
					$cr_4_data['c_id']=$c[$j]['id'];
					$cr_4_data['r_id']=$r[$i]['id'];
					$cr_4_data['c_user_id']=$c[$j]['user_id'];
					$cr_4_data['r_user_id']=$r[$i]['user_id'];
					$cr_4_data['sum']=$r[$i]['sum'];
					$cr_4_data['create_date']=time();
					$cr_4_data['die_time']=time()+$second;
					$cr_table->add($cr_4_data);

					//查询C表的分割次数
					$c_4_map['id']=$c[$j]['id'];
					$c_4_list=$c_table->field('splitno')->where($c_4_map)->find();
					//更新C表的余额和分割次数
					$c_4_map['sum']=$c[$j]['sum'];
					$c_4_map['splitno']=$c_4_list['splitno']+1;
					$c_4_map['status']=3;//未匹配完
					$c_table->save($c_4_map);

					//查询R表的分割次数
					$r_4_info['id']=$r[$i]['id'];
					$r_4_list=$r_table->field('splitno')->where($r_4_info)->find();
					//更新R表的余额和分割次数
					$r_4_info['sum']=0;
					$r_4_info['splitno']=$r_4_list['splitno']+1;
					$r_4_info['status']=2;
					$r_table->save($r_4_info);
					unset($cr_4_data);unset($c_4_map);unset($r_4_info);

			}
			else{
			
					$c[$j]['sum']=$c[$j]['sum']-$r[$i]['sum'];//余额
					
					//生成匹配数据
					$cr_5_data['cr_eg']=build_order_no();
					$cr_5_data['c_eg']=$c[$j]['eg'];
					$cr_5_data['r_eg']=$r[$i]['eg'];
					$cr_5_data['c_id']=$c[$j]['id'];
					$cr_5_data['r_id']=$r[$i]['id'];
					$cr_5_data['c_user_id']=$c[$j]['user_id'];
					$cr_5_data['r_user_id']=$r[$i]['user_id'];
					$cr_5_data['sum']=$r[$i]['sum'];
					$cr_5_data['create_date']=time();
					$cr_5_data['die_time']=time()+$second;
					$cr_table->add($cr_5_data);

					//查询C表的分割次数
					$c_5_map['id']=$c[$j]['id'];
					$c_5_list=$c_table->field('splitno')->where($c_5_map)->find();
					//更新C表的余额和分割次数
					$c_5_map['sum']=0;
					$c_5_map['splitno']=$c_5_list['splitno']+1;
					$c_5_map['status']=2;
					$c_table->save($c_5_map);

					//查询R表的分割次数
					$r_5_info['id']=$r[$i]['id'];
					$r_5_list=$r_table->field('splitno')->where($r_5_info)->find();
					//更新R表的余额和分割次数
					$r_5_info['sum']=0;
					$r_5_info['splitno']=$r_5_list['splitno']+1;
					$r_5_info['status']=2;
					$r_table->save($r_5_info);
					unset($cr_5_data);unset($c_5_map);unset($r_5_info);
					if($j<$c_count)
					{
						$j++;
					}
			
			}



		}

		unset($c);unset($r);
	
	}
	
	public function c_check_sum() {
        $checkids= $_GET['c_check'];
		$checkids=explode('c_id%5B%5D=',$checkids);
		$str='';
		for($i=0;$i<count($checkids);$i++)
		{
			$str.=$checkids[$i];	
		}
		$str=str_replace("&",",",$str);
		$data['id']=array('in',$str);
		$sum=M('c')->field('sum')->where($data)->sum('sum');
        if ($checkids) {
			if($sum){
				$json['msg'] ='当前选中金额为：'.$sum;
			}else{
				$json['msg'] ='';
			}
            echo json_encode($json);
            exit;
        }
		else
		{
            $json['msg'] ="" ;
            echo json_encode($json);
            exit;
		}
           
    }
	public function r_check_sum() {
        $checkids= $_GET['r_check'];
		$checkids=explode('r_id%5B%5D=',$checkids);
		$str='';
		for($i=0;$i<count($checkids);$i++)
		{
			$str.=$checkids[$i];	
		}
		unset($data);
		$str=str_replace("&",",",$str);
		$data['id']=array('in',$str);
		$sum=M('r')->field('sum')->where($data)->sum('sum');
	
        if ($checkids) {
			if($sum){
					$json['msg'] ='当前选中金额为：'.$sum;
			}else{
				$json['msg'] ='';
			}
            echo json_encode($json);
            exit;
        }
		else
		{
			
            $json['msg'] ="" ;
            echo json_encode($json);
            exit;
		}
           
    }

	
	


}