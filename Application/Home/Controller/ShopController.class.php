<?php
/*
	前台购物车控制器
*/
namespace Home\Controller;
use Think\Controller;
class Shop_cartsController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
	}
	//购物车
    public function carts(){
		$this->assign('title','麦斯威尔咖啡商城-购物车');
		$this->display();
    }
	//商品列表
	public function lists(){
		$this->assign('title','麦斯威尔咖啡商城-商品列表');
		$this->display();
	}

}