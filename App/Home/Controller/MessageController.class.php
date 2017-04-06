<?php

namespace Home\Controller;

use Home\Controller\CommonController;

class MessageController extends CommonController {

    
	//信件列表
	public function messagebox()
	{

		$uid=session('uid');
		$message_table=M('message');
		$count=$message_table->where(array('uid'=>$uid))->count();
		$Page = new \Think\Page($count,10);
        $show = $Page->show();
        $list= $message_table->order('addtime desc')->where(array('uid'=>$uid))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('page',$show);
		$this->assign('list',$list);
		$this->display();
	}
	//发件箱
	public function message()
	{
		if(IS_POST)
		{
			$message_table=M('message');
			$_POST['uid']=session('uid');
			$_POST['addtime']=time();
			$result=$message_table->add($_POST);
			if ($result) {
                $json['status'] = 1;
                $json['msg'] = '添加成功';
				
            } else {
                $json['status'] = 2;
                $json['msg'] = '添加失败';
				
            }
				echo json_encode($json);
				exit;
		}else
		{

		$this->display();
		}
	}
	//内容页
	public function messagepage()
		{
			if(IS_GET)
			{
				$message_table=M('message');
				$id=$bankno = I('get.id', '', 'htmlspecialchars');
				$result=$message_table->find($id);
				$this->assign('relust',$result);
				
			}

			$this->display();
			
		}

}
