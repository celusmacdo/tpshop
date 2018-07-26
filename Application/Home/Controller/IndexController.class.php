<?php
/*
	前台主控制器
*/
namespace Home\Controller;
use Think\Controller;
class IndexController extends PublicController {
	//前台首页
    public function index(){
		$this->assign('title','麦斯威尔咖啡商城-首页');
		$this->display();
    }

}