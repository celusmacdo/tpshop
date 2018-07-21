<?php
/*
	前台产品控制器
*/
namespace Home\Controller;
use Think\Controller;
class ProductController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
	}
	//产品列表页
    public function lists(){
		$this->assign('title','麦斯威尔咖啡商城-产品列表页');
		$this->display();
    }
	//产品详情页
	public function show(){
		$this->assign('title','麦斯威尔咖啡商城-产品详情页');
		$this->display();
    }

}