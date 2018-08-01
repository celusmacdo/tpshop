<?php
/*
	前台会员主控制器	
*/
namespace User\Controller;
use Think\Controller;
class IndexController extends PublicController {

	//会员登录
	public function login(){
		if(IS_POST){
			// dump($_POST);exit;
			//假设一开始是允许
			$allow=1;
			preg_match('/^[1](3|5|8)[0-9]{9}$/', $_POST['username'], $matches1, PREG_OFFSET_CAPTURE);
			if(empty($matches1)){
				preg_match('/^.*@.*$/', $_POST['username'], $matches2, PREG_OFFSET_CAPTURE);
				if(empty($matches2)){
					preg_match('/^[A-Za-z0-9]{6,}$/', $_POST['username'], $matches2, PREG_OFFSET_CAPTURE);
					if(empty($matches3)){
						$allow=0;
						$this->error('输入错误，必须输入用户名，邮箱或手机中的一个信息');
						exit;
					}
				}
			}
			$data=$_POST;
			$rs=D('Index')->findMember($data);
			//dump($rs);exit;
			
			if(is_array($rs)){
				session('HomeUser',$rs);
				cookie('HomeUser',$rs['id'],time()+3600);
				$this->success('登陆成功',U('User/Member/center'));
			}else{
				$this->success('登陆失败',U('User/Index/login'));
			}
		}else{
			//输出模板
			$this->assign('title','福维克商城-会员登录');
			$this->display('Index:login');
		}
	}
	//会员注册
	public function register(){
		if(IS_POST){

    		preg_match('/^[1](3|5|8)[0-9]{9}$/', $_POST['username'], $matches1, PREG_OFFSET_CAPTURE);

			if(empty($matches1)){

				preg_match('/^.*@.*$/', $_POST['username'], $matches2, PREG_OFFSET_CAPTURE);

				if(empty($matches2)){

					preg_match('/^[A-Za-z0-9]{6,}$/', $_POST['username'], $matches3, PREG_OFFSET_CAPTURE);

					if(empty($matches3)){

						// $allow=0;

						$this->error('输入错误，必须输入用户名，邮箱或手机中的一个信息');

						exit;
					}
				}
			}
			$data=$_POST;
			$rs=D('Index')->addMember($data);
			//dump($data);exit;
			
			if(IS_AJAX){
				if($rs=='ok'){
					$this->ajaxReturn('ok');
				}else{
					$this->ajaxReturn('error');
				}
			}else{
				if($rs=='ok'){
					$this->success('注册成功',U('User/Index/login'));
				}else{
					$this->success('注册失败');
				}
			}
		}else{
			$this->assign('title','福维克商城-会员注册');
			$this->display('Index:register');
		}
		
	}
	//会员退出
	public function logout(){
		session('HomeUser',null);
		
		cookie('HomeUser',null);
		
		$this->success('退出成功',U('Home/index/index'));
	}
	
	//生成验证码的方法
	
	public function verify(){
		
		$config =    array(

		    'fontSize'    =>    15,    // 验证码字体大小

		    'length'      =>    4,     // 验证码位数

		    'useNoise'    =>    false, // 关闭验证码杂点

		    'codeSet'     =>    '0123456789',

		);

    	$Verify = new \Think\Verify($config);

		$Verify->entry();
	}
}