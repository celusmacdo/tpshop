<?php
/*
	前台公共控制器
*/
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
		//调用类的方法
		$this->assign('system',$this->getSystem());
	}

	//省市区联动获取下一级
	public function getnextregion(){
		if(IS_AJAX){
			//ajax返回
			$this->ajaxReturn(D('Region')->getRegion(I('get.region_type'),I('get.parent_id')));
		}
	}
	//查询系统信息
    public function getSystem(){
       $rs= D('System')->select();
	   $data=array();
	   foreach($rs as $k=>$v){
		   $data[$v['name_en']]=$v;
	   }
       return $data;
	}
	/*
	$num 查询数量
	*/
    public function indexGoods($limit,$key){
		return D('Product')->showLimitData($limit,$key.'=2');
	}
}