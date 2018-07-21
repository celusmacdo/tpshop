<?php
/*
	前台订单列表控制器
*/
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
	}
	//订单列表
    public function lists(){
		$this->assign('title','麦斯威尔咖啡商城-订单列表');
		$this->display();
    }
	//订单详情
	public function details(){
		$this->assign('title','麦斯威尔咖啡商城-订单详情');
		$this->display();
	}
	//核对订单
	public function Confirm(){
		$this->assign('title','麦斯威尔咖啡商城-核对订单');
		$this->display();
	}
	//收货地址
	public function address(){
		$this->assign('title','麦斯威尔咖啡商城-收货地址');
		$this->display();
	}
	//我的评价
	public function comment(){
		$this->assign('title','麦斯威尔咖啡商城-我的评价');
		$this->display();
	}

}