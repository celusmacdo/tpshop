<?php
/*
	后台主控制器
*/
namespace Admin\Controller;
use Think\Controller;
class IndexController extends PublicController {
	//后台首页
    public function index(){
		$totalProduct = M('Product')->count();
		$this->assign('total',$totalProduct);
		$this->assign('title','麦斯威尔咖啡商城-后台首页');
        $this->display();
    }
	//登录处理
    public function actlogin(){
        
    }
	//后台登录
    public function login(){
		$this->assign('title','麦斯威尔咖啡商城-后台登录页');
        $this->display();
    }
    //后台退出
    public function logout(){
        
    }
}