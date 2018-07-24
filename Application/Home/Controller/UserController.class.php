<?php
/*
	前台用户中心控制器
*/
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
	}
	//用户中心
    public function index(){
		$this->assign('title','麦斯威尔咖啡商城-用户中心');
		$this->display();
    }
	//会员注册
	public function register(){
		$this->assign('title','麦斯威尔咖啡商城-会员注册');
		$this->display();
	}
	//登录
	public function login(){
		$this->assign('title','麦斯威尔咖啡商城-登录');
		$this->display();
	}

}