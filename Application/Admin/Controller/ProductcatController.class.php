<?php
/*
	后台产品分类控制器
*/
namespace Admin\Controller;
use Think\Controller;
class ProductcatController extends PublicController {
		//产品分类列表页
	    public function index(){
			//M('表名')->where()->order()->select();   某个表查询全部
			$perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$rs = D('Category')->showProductcat(100000000);

			$this->assign('title','麦斯威尔咖啡商城-产品分类列表');
			$this->assign('item',$this->item[''.CONTROLLER_NAME.'']);
			//模型返回的分页输出
			$this->assign('page',$rs['page']);
			//模型返回的数据输出
			$this->assign('rs',$rs['result']);
			$this->display();
	    }
		//产品分类添加
	    public function add(){
			if(IS_POST){
				//I('post.')  POST全部数据   I('get.')  GET全部数据
				$data=I('post.');
				$this->checkEmpty($data);
				//M('表名')->add(添加数据);   
				$rs=D('Category')->addData($data);
				//返回值id
				if($rs>0){
					$this->success('新增成功', 'index');
				}else{
					$this->error('新增失败');
				}
				// dump($data);exit;
			}else{
				//查询分类表的文章分类的所有二级分类
				$rs1= D('Category')->showProductcat(100000000);
				$this->assign('topcat',$rs1['result']);
				
				$attribute=M('Attribute')->select();
				$this->assign('attribute',$attribute);
				
				$this->assign('title','麦斯威尔咖啡商城-产品分类添加');
				$this->display();
			}
	    }
		//产品分类编辑
	    public function update(){
			if(IS_POST){
				$data=I('post.');
				// dump(I('post.'));exit;
				// M('表名')->save(更新数据);   注：更新数据必须包含id,不然会出错
				$rs=D('Category')->saveData($data);
				// 查看错误
				// dump(D('Category')->getDbError());exit;
				// 返回值 修改条数
				if($rs>0){
					$this->success('更新成功', 'index');
				}else{
					$this->error('更新失败');
				}
			}else{
				//M('表名')->find();   某个表查询一条数据
				$rs=D('Category')->where('id='.I('get.id'))->find();
				// dump($rs);exit;
				
				//查询分类表的文章分类的所有二级分类
				$rs1=  D('Category')->showProductcat(100000000);
				$this->assign('topcat',$rs1['result']);
				
				$categoryattr=M('CategoryAttr')->where('catid='.I('get.id'))->select();
				//dump($categoryattr);
				$temp=array();
				foreach($categoryattr AS $k=>$v){
					$temp[]=$v['attrid'];
				}
				$categoryattr=$temp;
				//dump($temp);exit;
				$this->assign('categoryattr',$categoryattr);
				
				$attribute=M('Attribute')->select();
				$this->assign('attribute',$attribute);
			
				$this->assign('title','麦斯威尔咖啡商城-产品分类修改');
				$this->assign('rs',$rs);
				$this->display();
			}
	    }
	    //产品分类删除
	    public function del(){
			//M('表名')->delete(删除数据id); 
			$rs=M('Category')->delete(I('get.id'));
			$rs1=M('CategoryAttr')->where('catid='.$data['id'])->delete();
			//查看错误
			//dump(M('adminuser')->getDbError());
			//返回值 修改条数
			if($rs>0 && $rs1>0){
				$this->success('删除成功', 'index');
			}else{
				$this->error('删除失败');
			}
	    }
	}