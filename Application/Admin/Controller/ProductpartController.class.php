<?php
/*
	产品配件控制器
*/
namespace Admin\Controller;
use Think\Controller;
class ProductpartController extends PublicController {
	//产品配件列表页
    public function setlist(){
        //M('表名')->where()->order()->select();   某个表查询全部
		$perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
		$rs = D('ProductSet')->showData($perpage);
		$this->assign('title','福维克商城-产品套餐列表');
		$this->assign('item',$this->item['ProductSet']);
		//模型返回的分页输出
		$this->assign('page',$rs['page']);
		//模型返回的数据输出
		$this->assign('rs',$rs['result']);
		$this->assign('id',I('get.id'));
        $this->display();
    }
	//产品配件添加
    public function setadd(){
		if(IS_POST){
			//I('post.')  POST全部数据   I('get.')  GET全部数据
			$data=I('post.');
			$data=$this->checkEmpty($data);
			//M('表名')->add(添加数据);   
			$rs=D(CONTROLLER_NAME)->addData($data);
			//返回值id
			if($rs>0){
				$this->success('新增成功', 'index');
			}else{
				$this->error('新增失败');
			}
			// dump($data);exit;
		}else{	
		    $perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$part=D('ProductPart')->showData($perpage);
            $this->assign('partresult',$part['result']);	
            $this->assign('partpage',$part['page']);	
			
		    $this->assign('id',I('get.id'));		
			$this->assign('title','福维克商城-产品套餐添加');
			$this->display();
		}
    }
	//产品配件删除
    public function del(){
		    //M('表名')->delete(删除数据id); 
			$rs=M(CONTROLLER_NAME)->delete(I('get.id'));
			//查看错误
			//dump(M('adminuser')->getDbError());
			//返回值 修改条数
			if($rs>0){
				$this->success('删除成功', 'index');
			}else{
				$this->error('删除失败');
			}
    }
}