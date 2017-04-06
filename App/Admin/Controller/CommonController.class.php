<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 会员模块公共控制器
 * @author 285734743
 * 
 */
class CommonController extends Controller {
	function _initialize(){
		

		 $this->check_login();
		 $this->verify();
		 $this->reseterrorlogin();
		
		 $webconfig=M('webconfig')->where('id=1')->find();
		 $basedata=json_decode($webconfig['value'],true);
		 
		 $ip=get_client_ip(0, true);
		if(!empty($basedata['ip'])){
		 $relust=check_ip($basedata['ip'],$ip);
		 if(!$relust)
		 {
				$this->display('Common:error');
				die;
		 }
		}
		if( session("userid") > 0){
			    $this->checkAdminSession();
				$userinfo=$this->userinfo(session("userid"));//管理员信息
				$role=M('role')->where(array('id'=>session('groupid')))->find();
				$this->assign('role',$role);
				$this->assign('config',$basedata);
				$this->assign('userinfo',$userinfo);
		
		}
		
		
	}
	//重置登录错误次数和时间
	function reseterrorlogin()
	{
		$admin_table=M('admin');
		$list=$admin_table->field('id,errorlognum,errorlogtime')->where(array('errorlognum'=>array('neq','0')))->select();
		$count=count($list);
		for($i=0;$i<$count;$i++)
		{
			if($list[$i]['errorlogtime']<time())
			{
				$admin_table->save(array('id'=>$list[$i]['id'],'errorlognum'=>'0','errorlogtime'=>'0'));
			}
		}
	}

	//登录超时验证
   function  checkAdminSession(){
			 //设置超时为20分
			$nowtime = time();
			$s_time = $_SESSION['timeout'];
			 if (($nowtime - $s_time) >60*60*2) {
			unset($_SESSION['timeout']);
			unset($_SESSION['userid']);
			$this->error('登录超时，请重新登录', U('Index/login'));
			exit;
			 } else {
				$_SESSION['timeout'] = $nowtime;
			 }
	 }
	
	
	final public function check_login()
	{
		
		if(CONTROLLER_NAME =='Index' && in_array(ACTION_NAME, array('login', 'code')) ) {
			return true;
		}
		
		if(!isset($_SESSION['userid'])||empty($_SESSION['userid']))
		{
			$this->redirect('/Admin/Index/login');
		}
	}
     public function verify()
	{
		$control_action=CONTROLLER_NAME.'/'.ACTION_NAME;
		$role=M('role')->where(array('id'=>session('groupid')))->find();
		$role=explode(',',$role['power_control_action']); 
		$allower=array(
			    'Index/welcome',
				'Index/code',
				'Index/index',
				'Index/login',
				'Index/logout',
				'Text/c_check_sum',
				'Text/r_check_sum',
				'Rbac/set_code',
				'Member/usertreeinfo',
			    'Member/mytree',
			    
			    
		);
	    $allpower=array_merge($allower,$role);
		if(in_array($control_action,$allpower,false)||$_SESSION['userid']==1)
		{
		
				return true;	
			
		}
		else
		{
			
			
			exit('<div style="position: absolute;top:40%;text-align:center;width:95%;color:red;font-size: 24px;">权限不足，无法操作
			//</div>');
			
		}
	
	}

	public function userinfo($uid)
	{
		$userinfo=M('admin')->find($uid);
		return $userinfo;
	}

	//Execl方法调用
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName =date('EXcel_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        import("Org.Util.PHPExcel");
       
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  下载时间:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        } 
        ob_clean();
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
      	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');             
		$objWriter->save('php://output'); //文件通过浏览器下载         
        exit;   
    }

	//获取参数信息(奖金设置)
	function bonusset()
	{
		$table_webconfig=M('webconfig');
		$setbonus=$table_webconfig->find('2');
		$relust=json_decode($setbonus['value'],true);
		return $relust;
	}
	//获取参数信息(奖励设置)
	function rewardset()
	{
		$table_webconfig=M('webconfig');
		$setreward=$table_webconfig->find('3');
		$relust=json_decode($setreward['value'],true);
		return $relust;
	}
	
	

	

	
}
