<?php
namespace User\Controller;
use Think\Controller;
class AcountController extends PublicController {	//会员账户信息
    public function balance(){
        $this->assign('acount',M('MemberAcount')		->join('max_member on max_member.acount_id=max_member_acount.acount_id')		->where('max_member.id='.session('HomeUser.id'))		->find());
        $this->display('Acount:balance');
    }
    public function chargehistoty(){
       
    }	//支付页面
    public function charge(){
        $this->assign('pay1',M('Pay')->where(array(
                    'pay_type'=>1,
        ))->select());
        $this->assign('pay2',M('Pay')->where(array(
                    'pay_type'=>0,
        ))->select());
        $this->display('Acount:charge');
    }
    	//检查会员支付密码
    public function checkpaypwd(){
        $rs=M('Member')->where(array(
            'id'=>I('get.id'),
            'pay_password'=>md5($_GET['pay_password'])
        ))->find();
        if(!empty($rs)){
            $this->ajaxReturn('ok');
        }else{
            $this->ajaxReturn('no');          
        }
    }
    	//会员支付密码修改
    public function changepaypwd(){
        $this->display('Acount:changepaypwd');
    }	//修改会员支付密码
    public function savepaypwd(){
         if(IS_POST){
    		$data = $_POST;
            $rs=D('Acount')->savePwd($data);
    		// dump($data);exit;
            if(IS_AJAX){
                if($rs=='ok'){
                    $this->ajaxReturn('ok');
                }else{
                    $this->ajaxReturn('error');
                }
            }else{
                if($rs=='ok'){
                    $this->success('修改成功',U('User/Member/center'));
                }else{
                    $this->success('修改失败');
                }              
            }
    		
    	}else{
        	$this->display('Member:center');
    	}    
        
    }
}
