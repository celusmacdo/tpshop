<?php
/*
	前台支付控制器
*/
namespace Home\Controller;
use Think\Controller;
class PayController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
	}
	//支付
    public function index(){
		$this->assign('title','麦斯威尔咖啡商城-支付');
		$this->display();
    }
	//支付成功
	public function success(){
		$this->assign('title','麦斯威尔咖啡商城-支付成功');
		$this->display();
	}//支付失败
	public function failure(){
		$this->assign('title','麦斯威尔咖啡商城-支付失败');
		$this->display();
	}
	
}