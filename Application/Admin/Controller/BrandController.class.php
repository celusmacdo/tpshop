<?php
/*
	后台主控制器
*/
namespace Admin\Controller;
use Think\Controller;
class BrandController extends PublicController {
	   //产品品牌列表页
	    public function index(){
			//M('表名')->where()->order()->select();   某个表查询全部
			$perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$rs = D(CONTROLLER_NAME)->showData($perpage);
			$this->assign('title','麦斯威尔咖啡商城-产品品牌列表');
			$this->assign('item',$this->item[''.CONTROLLER_NAME.'']);
			//模型返回的分页输出
			$this->assign('page',$rs['page']);
			//模型返回的数据输出
			$this->assign('rs',$rs['result']);
			$this->display();
	    }
		//产品品牌添加
	    public function add(){
			if(IS_POST){
				//I('post.')  POST全部数据   I('get.')  GET全部数据
				$data=I('post.');
				// dump($data);exit;
				$this->checkEmpty($data);
				//M('表名')->add(添加数据);   
				$rs=D(CONTROLLER_NAME)->addData($data);

				//返回值id
				if($rs>0){
					$this->ajaxReturn(1);
					exit;
				}else{
					$this->ajaxReturn(0);
					exit;
				}
			}else{
				$this->assign('province',D('Region')->getRegion(1));
				$this->assign('title','麦斯威尔咖啡商城-产品品牌添加');
				$this->display();
			}
	    }
		//产品品牌编辑
	    public function update(){
				if(IS_POST){
					$data=I('post.');
					//M('表名')->save(更新数据);   注：更新数据必须包含id,不然会出错
					$rs=D(CONTROLLER_NAME)->saveData($data);
					//查看错误
					//dump(M('adminuser')->getDbError());
					//返回值 修改条数
					if($rs>0){
						//$this->success('更新成功', 'index');
						$this->ajaxReturn(1);
						exit;
					}else{
						//$this->error('更新失败');
						$this->ajaxReturn(0);
						exit;
						}
					}else{
					//M('表名')->find();   某个表查询一条数据
					$rs=D(CONTROLLER_NAME)->where('id='.I('get.id'))->find();
					// dump($rs);exit;
					$this->assign('title','麦斯威尔咖啡商城-产品品牌修改');
					$this->assign('rs',$rs);
					$this->display();
				}
	    }
	    //产品品牌删除
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