<?php

namespace Home\Controller;

use Home\Controller\CommonController;

class ArticleController extends CommonController {

    
	//新闻列表
	public function newslist()
	{
		$article_table=M('article');
		$count=$article_table->where(array('art_status'=>'1'))->count();
		$Page = new \Think\Page($count,20);
        $show = $Page->show();
        $list= $article_table->order('art_time desc')->where(array('art_status'=>'1'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('page',$show);
		$this->assign('list',$list);
		$this->display();
	}
	//新闻内页
	public function newspage()
	{
		if(IS_GET)
		{
		
			$id=I('get.id', '', 'htmlspecialchars');
			$article_table=M('article');
			$relust=$article_table->where(array('id'=>$id))->find();
			$this->assign('relust',$relust);
			$this->display();
		
		}
	
	}

}
