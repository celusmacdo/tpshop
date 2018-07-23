<?php
/*
	产品配件控制器
*/
namespace Admin\Controller;
use Think\Controller;
class ProductPartController extends PublicController {
	//产品配件列表页
    public function index(){
        //M('表名')->where()->order()->select();   某个表查询全部
		$perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
		$rs = D('ProductPart')->showData($perpage);
		$this->assign('title','麦斯威尔商城-产品配件列表');
		$this->assign('item',$this->item['ProductPart']);
		//模型返回的分页输出
		$this->assign('page',$rs['page']);
		//模型返回的数据输出
		$this->assign('rs',$rs['result']);
		$this->assign('id',I('get.id'));
        $this->display();
    }
	//产品配件添加
    public function add(){
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
			
			$rs1=  D('Category')->showProductcat(100000000);
			$this->assign('category',$rs1['result']);
			
			$rs2=  D('Brand')->showData(100000000);
			$this->assign('brand',$rs2['result']);
			// dump($rs2);exit;
		    $this->assign('id',I('get.id'));		
			$this->assign('title','麦斯威尔商城-产品配件添加');
			$this->display();
		}
    }
	//产品配件编辑
    public function update(){
		if(IS_POST){
			$data=I('post.');
			// $data=$this->checkEmpty($data);
			//M('表名')->save(更新数据);   注：更新数据必须包含id,不然会出错
			$rs=D(CONTROLLER_NAME)->saveData($data);
			//查看错误
			//dump(M('adminuser')->getDbError());
			//返回值 修改条数
			if($rs>0){
				$this->success('更新成功', 'index');
			}else{
				$this->error('更新失败');
			}
		}else{
			//M('表名')->find();   某个表查询一条数据
			$rs=D(CONTROLLER_NAME)->where('id='.I('get.id'))->find();

			
			$rs1 = D('Category')->showProductcat(100000000);
			$this->assign('category',$rs1['result']);
			
			$rs2 = D('Brand')->showData(1000000000);
			$this->assign('brand',$rs2['result']);
			
			$this->assign('title','麦斯威尔商城-产品配件修改');
			$this->assign('rs',$rs);
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