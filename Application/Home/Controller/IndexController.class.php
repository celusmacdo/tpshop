<?php
/*
	前台主控制器
*/
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
	}
	//前台首页
    public function index(){
		$this->assign('title','麦斯威尔咖啡商城-首页');
		$this->display();
    }

}