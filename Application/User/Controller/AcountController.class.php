<?php
namespace User\Controller;
use Think\Controller;
class AcountController extends PublicController {
    public function balance(){
        $this->assign('acount',M('MemberAcount')
        $this->display('Acount:balance');
    }
    public function chargehistoty(){
       
    }
    public function charge(){
        $this->assign('pay1',M('Pay')->where(array(
                    'pay_type'=>1,
        ))->select());
        $this->assign('pay2',M('Pay')->where(array(
                    'pay_type'=>0,
        ))->select());
        $this->display('Acount:charge');
    }
    
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
    
    public function changepaypwd(){
        $this->display('Acount:changepaypwd');
    }
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