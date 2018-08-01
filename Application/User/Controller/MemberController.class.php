<?php
/*
	前台会员中心主控制器	
*/
namespace User\Controller;
use Think\Controller;
class MemberController extends PublicController {
	
	public function __construct(){
		parent::__construct();
		if(!session('?HomeUser')){
			$this->error('请登陆',U('User/Index/login'));
		}
	}
	
	//ajax查询密码是否正确
	
	public function checkpwd(){
		$rs=M('Member')->where(array(
			'id'=>I('get.id'),
			'password'=>md5($_GET['password'])
		))->find();
		
		if(!empty($rs)){
			$this->ajaxReturn('ok');
		}else{
			$this->ajaxReturn('no');
		}
	}

	//会员中心首页
	public function center(){
		$this->assign('title','福维克商城-会员中心首页');
		$this->display('Member:center');
	}
	
	//保存和修改会员信息
	public function update(){
		if(IS_POST){
			$data=I('post.');
			$rs=D('Member')->saveInfo($data);
			//dump($rs);exit;
			if(IS_AJAX){
				if(!empty($rs)){
					//更新session会员信息
					session('HomeUser',null);
					$this->ajaxReturn('ok');
				}else{
					$this->ajaxReturn('error');
				}
			}else{
				if(!empty($rs)){
					//更新session会员信息
					session('HomeUser',null);
					$this->success('保存成功,请重新登录',U('User/Index/login'));
				}else{
					$this->success('保存失败');
				}
			}
		}else{
			//dump(session('HomeUser'));exit;
			
			$this->assign('province',M('Region')->where(array(

                        'parent_id'=>1,

                        'region_type'=>1,

            ))->select());
			
			$this->assign('city',M('Region')->where(array(

                        'parent_id'=>session('HomeUser.province'),

                        'region_type'=>2,

            ))->select());
			
			$this->assign('district',M('Region')->where(array(

                        'parent_id'=>session('HomeUser.city'),

                        'region_type'=>3,

            ))->select());
			$this->assign('title','福维克商城-会员中心设置及账号信息');
			$this->display('Member:update'); 
		}
	}
	
	//负责查市和区
	
	public function checkregion(){

        $this->ajaxReturn(M('Region')->where(array(

            'parent_id'=>I('get.parent_id'),

        ))->select());

    }
	
	public function changepwd(){
		$this->assign('title','福维克商城-会员中心修改密码');
        $this->display('Member:changepwd');

     }
	
	//修改会员登录密码
	
	public function savepwd(){

         if(IS_POST){

    		$data = $_POST;

            $rs=D('Member')->savePassword($data);

    		// dump($data);exit;

            if(IS_AJAX){

                if($rs=='ok'){

                    $this->ajaxReturn('ok');

                }else{

                    $this->ajaxReturn('error');

                }

            }else{

                if($rs=='ok'){

                    $this->success('修改成功',U('User/Index/login'));

                }else{

                    $this->success('修改失败');

                }              

            }

    		

    	}else{

        	$this->display('Index:reg');

    	}    

        

    }
	
	//修改默认收货地址

    public function changedefaultaddress(){

        

        //先清除所有默认地址

        M('OrderAddress')->where('id<1000000000000000000 and member_id='.I('get.member_id'))->save(array(

           'is_default'=>0,

        ));

        $rs=M('OrderAddress')->where('id='.I('get.id').' and member_id='.I('get.member_id'))->save(array(

           'is_default'=>1,

        ));

        if($rs>0){

            $this->ajaxReturn('ok');

        }else{

            $this->ajaxReturn('error'); 

        }

    }

    //添加收货地址
    public function address(){

        if(IS_POST){

            $data=I('post.');

            $rs=D('Member')->addAddress($data);           

            if(IS_AJAX){

                if(!empty($rs)){

                    $this->ajaxReturn('ok');

                }else{

                    $this->ajaxReturn('error');

                }

            }else{

                if(!empty($rs)){

                    $this->success('添加成功',U('User/Member/address'));

                }else{

                    $this->success('添加失败');

                }              

            }

        }else{

            $this->assign('province',M('Region')->where(array(

						'parent_id'=>1,

                        'region_type'=>1,

            ))->select());

            $this->assign('city',M('Region')->where(array(

                        'parent_id'=>session('HomeUser.province'),

                        'region_type'=>2,

            ))->select());

            $this->assign('district',M('Region')->where(array(

                        'parent_id'=>session('HomeUser.city'),

                        'region_type'=>3,

            ))->select());

            $result=M('OrderAddress')->where(array(

                        'member_id'=>session('HomeUser.id'),

            ))->select();  

            $this->assign('result',$result);

            
			$this->assign('title','福维克商城-会员中心订单地址管理');
            $this->display('Member:address');

            } 

    }
    //修改收货地址

    public function addressupdate(){

        if(IS_POST){

            $rs=D('Member')->updateAddress(I('post.'));

             if(IS_AJAX){

                if(!empty($rs)){

                    $this->ajaxReturn('ok');

                }else{

                    $this->ajaxReturn('error');

                }

            }else{

                if(!empty($rs)){

                    $this->success('修改成功',U('User/Member/address'));

                }else{

                    $this->success('修改失败失败');

                }              

            }

        }else{

            $res=M('OrderAddress')->find(I('get.id'));

            //dump($res);exit;

            $this->assign('province',M('Region')->where(array(

                        'parent_id'=>1,

                        'region_type'=>1,

            ))->select());

            $this->assign('city',M('Region')->where(array(

                        'parent_id'=>$res['province'],

                        'region_type'=>2,

            ))->select());

            $this->assign('district',M('Region')->where(array(

                        'parent_id'=>$res['city'],

                        

                        'region_type'=>3,

            ))->select());

            

            $this->assign('res',$res);

            $this->display('Member:addressupdate');

        }

    }

    public function addressdel(){

		$rs=D('Member')->delAddress(I('get.id'));

        if(!empty($rs)){

                    $this->success('删除成功',U('User/Member/address'));

                }else{

                    $this->success('删除失败');

                }              

    }
	
	//会员中心我的订单
	public function order(){
		$this->assign('title','福维克商城-会员中心我的订单');
		$this->display();
	}
	//会员中心我的收藏
	public function collection(){
		
		$this->assign('title','福维克商城-会员中心我的收藏');
		$this->display();
	}
	//会员中心我的现金卷
	public function coupon(){
		$this->assign('title','福维克商城-会员中心我的现金卷');
		$this->display();
	}
	//会员中心我的会员等级
	public function level(){
		$this->assign('title','福维克商城-会员中心我的会员等级');
		$this->display();
	}
	//会员中心我的余额
	public function balance(){
		$acount=D('Member')->select();
		//dump($acount);exit;
		$this->assign('title','福维克商城-会员中心我的余额');
		$this->display();
	}
	//会员中心我的礼品
	public function gift(){
		$this->assign('title','福维克商城-会员中心我的礼品');
		$this->display();
	}
	//会员中心我的售后与服务
	public function service(){
		$this->assign('title','福维克商城-会员中心我的售后与服务');
		$this->display();
	}
	//会员中心退款
	public function refund(){
		$this->assign('title','福维克商城-会员中心退款');
		$this->display();
	}	
}