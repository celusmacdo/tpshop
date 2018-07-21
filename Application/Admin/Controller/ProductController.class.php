<?php
/*
	后台主控制器
*/
namespace Admin\Controller;
use Think\Controller;
class ProductController extends PublicController {
		public function getcategoryattr(){
		$rs=M('CategoryAttr')->field('max_category_attr.*,max_attribute.attrname,max_attribute.attrtype')->join('max_attribute on max_category_attr.attrid=max_attribute.id')->where('max_category_attr.catid='.I('get.catid'))->select();
		if(IS_AJAX){
			$this->ajaxReturn($rs);
		    exit;			
		}else{
			return $rs;
		}
    	}
    	//产品列表页
	    public function index(){
			//M('表名')->where()->order()->select();   某个表查询全部
			$perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$rs = D(CONTROLLER_NAME)->showData($perpage);
			$this->assign('title','麦斯威尔咖啡商城-产品列表');
			$this->assign('item',$this->item[''.CONTROLLER_NAME.'']);
			//模型返回的分页输出
			$this->assign('page',$rs['page']);
			//模型返回的数据输出
			$this->assign('rs',$rs['result']);
			$this->display();
	    }
		//产品添加
	    public function add(){
			if(IS_POST){
				//I('post.')  POST全部数据   I('get.')  GET全部数据
				$data=I('post.');
				$this->checkEmpty($data);
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
				$rs1=  D('Category')->showProductcat(100000000);
				$this->assign('category',$rs1['result']);
			
				$rs2=  D('Brand')->showData(100000000);
				$this->assign('brand',$rs2['result']);
			
				$this->assign('title','麦斯威尔咖啡商城-产品添加');
				$this->display();
			}
	    }
		//产品编辑
	    public function update(){
			if(IS_POST){
				$data=I('post.');
				$data=$this->checkEmpty($data);
				//M('表名')->save(更新数据);注：更新数据必须包含id,不然会出错
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
				
				$rs3=M('CategoryAttr')
				->field('max_category_attr.*,max_attribute.attrname,max_attribute.attrtype,max_product_attr.attrvalue')
				->join('max_attribute on max_category_attr.attrid=max_attribute.id')
				->join('max_product_attr on max_product_attr.attrid=max_attribute.id')
				//产品id等于get过来id 并且 分类id等于$rs里面的分类id
				->where('max_product_attr.proid='.I('get.id').' and max_category_attr.catid='.$rs['catid'])
				->select();
				$showCategoryAttr=array();
				foreach($rs3 AS $k=>$v){
						$showCategoryAttr[$v['attrtype']][]=$v;
				}
				$temp='';
				foreach($showCategoryAttr[1] AS $k=>$v){
						$temp.=$v['attrvalue'].';';
				}
				
				$temp=substr($temp,0,-1);
				$showCategoryAttr[1]=array(
				   "catid"     => $showCategoryAttr[1][0]['catid'],
				   "attrid"    => $showCategoryAttr[1][0]['attrid'],
				   "attrname"  => $showCategoryAttr[1][0]['attrname'],
				   "attrtype"  => $showCategoryAttr[1][0]['attrtype'],
				   "attrvalue" => $temp,
				);
				//dump($showCategoryAttr);exit;
				$this->assign('showCategoryAttr',$showCategoryAttr);
				$this->assign('getcategoryattr',$rs3);
				// dump($rs);exit;
				$this->assign('title','麦斯威尔咖啡商城-产品修改');
				$this->assign('rs',$rs);
				$this->display();
			}
	    }
	    //产品删除
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
		//产品套餐列表页
		public function setlist(){
			//M('表名')->where()->order()->select();   某个表查询全部
		$perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
		$rs = D('ProductSet')->showData($perpage);
		$this->assign('title','麦斯威尔咖啡商城-产品套餐列表');
		$this->assign('item',$this->item['ProductSet']);
		//模型返回的分页输出
		$this->assign('page',$rs['page']);
		//模型返回的数据输出
		$this->assign('rs',$rs['result']);
		$this->assign('id',I('get.id'));
        $this->display();
		}
		//产品套餐添加
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
			$this->assign('title','麦斯威尔咖啡商城-产品套餐添加');
			$this->display();
		}
    }
}