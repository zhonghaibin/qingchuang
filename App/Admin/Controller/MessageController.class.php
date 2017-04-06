<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class MessageController extends CommonController {

	/***
	*
	*留言
	*/
    public function index(){
		
		
			if (!empty($_REQUEST['search_starttime']) && !empty($_REQUEST['search_endtime'])) {
            $startime = strtotime($_REQUEST['search_starttime']);
            $endtime = strtotime($_REQUEST['search_endtime']);

            if ($startime <= $endtime) {
                $times = (strtotime($_REQUEST['search_starttime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_endtime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_starttime'];
                $search['search_endtime'] = $_REQUEST['search_endtime'];
            } else {
                $times = (strtotime($_REQUEST['search_endtime'] . '00:00:00') . ',' . strtotime($_REQUEST['search_starttime'] . '23:59:59'));
                $search['search_starttime'] = $_REQUEST['search_endtime'];
                $search['search_endtime'] = $_REQUEST['search_starttime'];
            }
            $map['addtime'] = array('between', $times);
            //$timespan = strtotime(urldecode($_REQUEST['start_time'])) . "," . strtotime(urldecode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['addtime'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['addtime'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_username']))
			{
			$user=M('member')->field('id')->where(array('username'=>$_REQUEST['search_username']))->find();
			$map['uid']=$user['id'];
			$search['search_username'] = $_REQUEST['search_username'];
			}
			if(!empty($_REQUEST['search_type']))
			{
			$map['type']=$_REQUEST['search_type'];
			$search['search_type'] = $_REQUEST['search_type'];
			}
		
		$type=array('1'=>'不打款','2'=>'不确认','3'=>'其他');
		
		$message_table=M('message');
		$member_table=M('member');
		$count=$message_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();
		$list=$message_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$fcount=count($list);
		for($i=0;$i<$fcount;$i++)
		{
			$userinfo=$member_table->field('username,name,mobile,email')->find($list[$i]['uid']);
			$list[$i]['username']=$userinfo['username'];
			$list[$i]['name']=$userinfo['name'];
			$list[$i]['mobile']=$userinfo['mobile'];
			$list[$i]['email']=$userinfo['email'];
			$list[$i]['type']=$type[$list[$i]['type']];
		}

	
		$this->assign('page',$show);
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('arr',$search);
		$this->display();
		
    }
	//删除留言
	public function message_del()
	{
			$message_table=M('message');
			$relsult=$message_table->where('id='.I('get.id'))->delete();
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
	//批量删除留言
	public function datadel_message()
	{
			$member=M('message');
			$str=I('get.str');
			$str=rtrim($str,',');
			unset($data);
			$data['id']=array('in',$str);
			$relsult=$member->where($data)->delete();
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



	//查看留言
	public function messageedit()
	{
			$message_table=M('message');
			$member_table=M('member');
			
			if(IS_GET)
			{	$id=I('get.id');
				$data['id']=$id;
				$message_table->save(array('id'=>$id,'status'=>'2'));
			}
			if(IS_POST)
			{
				$id=I('post.id');
				$data['id']=$id;
				$reply=I('post.reply');
				$result=$message_table->save(array('id'=>$id,'status'=>'3','reply'=>$reply));
				if($result)
				{
					$json['status']=1;
					$json['msg']='回复成功！';
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['status']=2;
					$json['msg']='回复失败！';
					echo json_encode($json);
					exit;	
				}
			}
			$message_row=$message_table->field('id,subject,content,reply')->where($data)->find();
			$userinfo=$member_table->field('username')->find($message_row['uid']);
			$this->assign('userinfo',$userinfo);
			$this->assign('message_row',$message_row);
			$this->display();
			
		
	}
	 

	
}