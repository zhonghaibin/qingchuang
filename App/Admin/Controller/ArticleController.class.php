<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class ArticleController extends CommonController {

	/***
	*
	*文章中心
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
            $map['art_time'] = array('between', $times);
            //$timespan = strtotime(urldecode($_REQUEST['start_time'])) . "," . strtotime(urldecode($_REQUEST['end_time']));
			} elseif (!empty($_REQUEST['search_starttime'])) {
            $xtime = strtotime($_REQUEST['search_starttime'] . '00:00:00');
            $map['art_time'] = array("egt", $xtime);
            $search['search_starttime'] = $_REQUEST['search_starttime'];
			 } elseif (!empty($_REQUEST['search_endtime'])) {
            $xtime = strtotime($_REQUEST['search_endtime'] . '23:59:59');
            $map['art_time'] = array("elt", $xtime);
            $search['search_endtime'] = $_REQUEST['search_endtime'];
			}
			if(!empty($_REQUEST['search_title']))
			{
			$map['art_title']=array('like', '%'.$_REQUEST['search_title'].'%');
			$search['search_title'] = $_REQUEST['search_title'];
			}
			if(!empty($_REQUEST['search_art_type']))
			{
			$map['art_type']=array('eq', $_REQUEST['search_art_type']);
			$search['search_type'] = $_REQUEST['search_type'];
			}
		$article_table=M('article');
		$count=$article_table->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list=$article_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$list1=M('articleclass')->select();
		$art_class=$this->order($list1);
		$this->assign('page',$show);
		$this->assign('list',$list);
		$this->assign('list1',$art_class);
		$this->assign('count',$count);
		$this->assign('arr',$search);
		$this->display();
    }

	//分类递归
	public function order($array,$pid=0){
    $arr = array();
    foreach($array as $v){
        if($v['pid']==$pid){
            $arr[] =$v;
            $arr = array_merge($arr,self::order($array,$v['id']));
        }
    }
    return $arr;
	}
    //分类管理
	public function articleclass()
	{$art_class_table=M('articleclass');
		if(IS_POST)
		{	
			if(empty($_POST['art_class_name']))
			{
				$this->error('请输入分类名称');
				exit;
			}
			$pid=I('post.pid');
			
			if($pid>0)
			{
				$level=$art_class_table->where(array('id'=>$pid))->find();
				$_POST['level']=$level['level']+1;
				
			}
			
			$relust=$art_class_table->add($_POST);
			if($relust)
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

		$list1=$art_class_table->select();
		$art_class=$this->order($list1);
		$count=$art_class_table->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();//
		$list3=$art_class_table->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);
		$this->assign('list3',$list3);
		$this->assign('list1',$art_class);
		$this->assign('count',$count);
		$this->display();
	}//编辑分类
	public function articleclassedit()
	{	
		

		$art_class_table=M('articleclass');
		if(IS_POST)
		{	$pid=I('post.pid');
			if($pid>0)
			{
				$level=$art_class_table->where(array('id'=>$pid))->find();
				$_POST['level']=$level['level']+1;
				
			}
			
			$result=$art_class_table->save($_POST);
			if($result)
			{
				$json['status']=1;
				$json['msg']='编辑成功';
				echo json_encode($json);
				exit;	
			}
			else
			{
				$json['status']=2;
				$json['msg']='编辑失败';
				echo json_encode($json);
				exit;	
			}
		}

		$id=$_GET['id'];
		$ss=M('articleclass')->where(array('id'=>$id))->find();
		$list1=M('articleclass')->select();
		$art_class=$this->order($list1);
		for($i=0;$i<count($art_class);$i++)
		{
			if($art_class[$i]['id']==$id)
			{
				unset($art_class[$i]);
			}
		}
		$this->assign('id',$id);
		$this->assign('name',$ss['art_class_name']);
		$this->assign('list1',$art_class);
		$this->display();
	}
	//删除分类
	public function article_class_del()
	{
			$articleclass_table=M('articleclass');
			$relsult=$articleclass_table->where('id='.I('get.id'))->delete();
			if($relsult)
			{
				$json['status']=1;
				$json['msg']='已经删除！';
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
	

	//添加咨讯
	public function articleadd()
	{
		
		$article_table=M('article');
		if(IS_POST)
		{
		 
			$_POST['art_content']=$_POST['editorvalue'];
			$_POST['art_time']=time();
			
			$relust=$article_table->add($_POST);
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
				$json['msg']='操作失败！';
				echo json_encode($json);
				exit;	
			}
			

			
		
		}else
		{
	
		$list1=M('articleclass')->select();
		$art_class=$this->order($list1);
		$this->assign('list1',$art_class);
		$this->display();
		}
	}
	//编辑咨讯
	public function articleedit()
	{
		
		$article_table=M('article');
		if(IS_POST)
		{
		
			$_POST['art_content']= $_POST['editorvalue'];
			$_POST['art_time']=time();
			
			$relust=$article_table->save($_POST);
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
				$json['msg']='操作失败！';
				echo json_encode($json);
				exit;	
			}
		
		}
	
		$id=I('get.id');
		$article_row=$article_table->where(array('id'=>$id))->find();
		$list1=M('articleclass')->select();
		$art_class=$this->order($list1);
		$this->assign('list1',$art_class);
		$this->assign('article_row',$article_row);
		$this->assign('id',$id);
		$this->display();
	}

	public function articlezhang()
	{
		if(IS_GET)
		{
			$id=I('get.id');
			$data['id']=$id;
			$article_row=M('article')->where($data)->find();

		
		}

		$this->assign('article_row',$article_row);
		$this->display();
		
	}
	//删除文章
	public function article_del()
	{
			$article_table=M('article');
			$relsult=$article_table->where('id='.I('get.id'))->delete();
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

		//批量删除文章
	public function datadel_article()
	{
			$article_table=M('article');
			$str=I('get.str');
			$str=rtrim($str,',');
			unset($data);
			$data['id']=array('in',$str);
			$relsult=$article_table->where($data)->delete();
			if($relsult)
			{
				$json['status']=1;
				$json['msg']='删除失败！';
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
	//下架
	public function article_stop()
	{
		
			$article_table=M('article');
			$relsult=$article_table->where('id='.I('get.id'))->find();
			if($relsult['art_status']==1)
			{
				$data['id']=I('get.id');
				$data['art_status']=2;
				$rel1=$article_table->save($data);
				if($rel1)
				{
					$json['art_status']=1;
					$json['msg']='操作成功！';
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['art_status']=2;
					$json['msg']='操作失败！';
					echo json_encode($json);
					exit;	
				}

			}
			
			
		
		
	}//上架
	public function article_start()
	{
		
			$article_table=M('article');
			$relsult=$article_table->where('id='.I('get.id'))->find();
			if($relsult['art_status']==2)
			{
				$data['id']=I('get.id');
				$data['art_status']=1;
				$rel1=$article_table->save($data);
				if($rel1)
				{
					$json['art_status']=1;
					$json['msg']='操作成功！';
					echo json_encode($json);
					exit;	
				}
				else
				{
					$json['art_status']=2;
					$json['msg']='操作失败！';
					echo json_encode($json);
					exit;	
				}

			}
			
			
		
		
	}
}