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
		$rs = D('ProductSet')->showData($perpage,'proid='.I('get.id'));
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
			$rs=D('ProductSet')->addData($data);
			//返回值id
			if($rs>0){
				$this->success('新增成功', U('Admin/Product/setlist').'?id='.$data['proid']);
			}else{
				$this->error('新增失败');
			}
			// dump($data);exit;
		}else{
			//查询需要添加的商品信息
			$product=D('Product')->findData(I('get.id'));
            $this->assign('product',$product);
		    $perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$part=D('ProductPart')->showData($perpage);
            $this->assign('partresult',$part['result']);	
            $this->assign('partpage',$part['page']);	
			
		    $this->assign('id',I('get.id'));		
			$this->assign('title','麦斯威尔咖啡商城-产品套餐添加');
			$this->display();
		}
    }
		//产品套餐编辑
    public function setupdate(){
		if(IS_POST){
			$data=I('post.');
			$data=$this->checkEmpty($data);
			//M('表名')->save(更新数据);   注：更新数据必须包含id,不然会出错
			$rs=D('ProductSet')->saveData($data);
			//返回值 修改条数
			if($rs>0){
				$this->success('更新成功', U('Admin/Product/setlist').'?id='.$data['proid']);
			}else{
				$this->error('更新失败');
			}
		}else{
		    //查询需要添加的商品信息
			$product=D('Product')->findData(I('get.id'));
            $this->assign('product',$product);	
			
		    $perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$part=D('ProductPart')->showData($perpage);
            $this->assign('partresult',$part['result']);	
            $this->assign('partpage',$part['page']);	
			
            $rs=D('ProductSet')->where('id='.I('get.part_id'))->find();
			$rs['partid']=explode(',',$rs['partid']);
			$this->assign('rs',$rs);
			
		    $this->assign('id',I('get.id'));		
			$this->assign('title','麦斯威尔咖啡商城-产品套餐编辑');		
			$this->display();
		}
    }
	//产品套餐删除
    public function setdel(){
		    //M('表名')->delete(删除数据id); 
			$rs=M('ProductSet')->delete(I('get.part_id'));
			//查看错误
			//dump(M('adminuser')->getDbError());
			//返回值 修改条数
			if($rs>0){
				$this->success('删除成功', U('Admin/Product/setlist').'?id='.I('get.id').'&part_id='.I('get.part_id'));
			}else{
				$this->error('删除失败');
			}
    }
	//产品库存列表页
    public function stocklist(){
		$rs = D('Stock')->showData(10,'proid='.I('get.id'));
		$this->assign('title','麦斯威尔咖啡商城-产品库存列表');
		$this->assign('item',$this->item['Stock']);
		//模型返回的分页输出
		$this->assign('page',$rs['page']);
		//模型返回的数据输出
		$this->assign('rs',$rs['result']);
		$this->assign('id',I('get.id'));
        $this->display();
    }
	//产品库存添加
    public function stockadd(){
		if(IS_POST){
			//I('post.')  POST全部数据   I('get.')  GET全部数据
			$data=I('post.');
			$data=$this->checkEmpty($data);
			//M('表名')->add(添加数据);   
			$rs=D('Stock')->addData($data);
			//返回值id
			if($rs>0){
				$this->success('新增成功', U('Admin/Product/Stocklist').'?id='.$data['pro_id']);
			}else{
				$this->error('新增失败');
			}
			// dump($data);exit;
		}else{	
		    $perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			//查询需要添加的商品信息
			$product=D('Product')->findData(I('get.id'));
            $this->assign('product',$product);	

			//查询要选择的属性信息
			$ProductAttr=M('ProductAttr')
			->join('max_attribute on max_product_attr.attrid=max_attribute.id')
			->where('max_product_attr.proid='.I('get.id'))->select();
			//dump($ProductAttr);exit;
			$temp=array();
			foreach($ProductAttr AS $k=>$v){
				$temp[$v['attrtype']][$v['attrid']][]=$v;
			}
			$ProductAttr=$temp;
            $this->assign('ProductAttr',$ProductAttr);	

			$productSet=D('ProductSet')->showData(10000000,'max_product.id='.I('get.id'));
            $this->assign('productSet',$productSet['result']);

			
		    $this->assign('id',I('get.id'));		
			$this->assign('title','麦斯威尔咖啡商城-产品库存添加');
			$this->display();
		}
    }
	//产品库存编辑
    public function stockupdate(){
		if(IS_POST){
			$data=I('post.');
			$data=$this->checkEmpty($data);
			//M('表名')->save(更新数据);   注：更新数据必须包含id,不然会出错
			$rs=D('Stock')->saveData($data);
			//返回值 修改条数
			if($rs>0){
				$this->success('更新成功', U('Admin/Product/Stocklist').'?id='.$data['pro_id']);
			}else{
				$this->error('更新失败');
			}
		}else{
			$product=D('Product')->findData(I('get.id'));
            $this->assign('product',$product);	
			// dump($product);exit;
		    $perpage=isset($_GET['perpage'])?$_GET['perpage']:10;
			$part=D('ProductPart')->showData($perpage);
            $this->assign('partresult',$part['result']);	
            $this->assign('partpage',$part['page']);	
			
            $rs=D('Stock')->where('id='.I('get.id'))->find();
			//dump($rs);exit;
			$rs['partid']=explode(',',$rs['id']);
			$this->assign('rs',$rs);
			
		    $this->assign('id',I('get.id'));		
			$this->assign('title','麦斯威尔咖啡商城-产品库存编辑');		
			$this->display();
		}
    }
	//产品库存删除
    public function stockdel(){
		    //M('表名')->delete(删除数据id); 
			$rs=M('Stock')->delete(I('get.sid'));
			//查看错误
			//dump(M('adminuser')->getDbError());
			//返回值 修改条数
			if($rs>0){
				//删除库存后要更新产品表的库存字段
			    D('Product')->save(array(
				     'gtype'=>$this->where('pro_id='.I('post.pro_id'))->sum('amount'),
				     'id'=>I('get.id'),
				));
				$this->success('删除成功',U('Admin/Product/Stocklist').'?id='.I('get.id').'&sid='.I('get.sid'));
			}else{
				$this->error('删除失败');
			}
    }
}