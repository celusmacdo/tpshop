<?php
/*
	前台产品控制器
*/
namespace Home\Controller;
use Think\Controller;
class ProductController extends PublicController {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('line',$this->attributeGrouping('线长'));
		$this->assign('color',$this->attributeGrouping('颜色分类'));
		$this->assign('shopPriceGrouping',$this->shopPriceGrouping(5,'shop_price'));
		$this->assign('brand',D('Brand')->showData(10000));
		// $this->assign('indexHot',$this->indexGoods(3,'is_hot'));
	}
	//属性组合筛选
	public function attributeGrouping($attrname){
	     $result=D('Attribute')
		 ->field('max_attribute.*,max_product_attr.attrid,max_product_attr.proid,max_product_attr.attrvalue')
		 ->join('max_product_attr on max_attribute.id=max_product_attr.attrid')
		 ->where('max_attribute.attrname="'.$attrname.'"')
		 ->group('max_product_attr.attrvalue')
         ->select();
		 return $result;
     // dump($result);exit;		 
	}
	//简单价格区间  $num 区间数  $keyItem 统计字段
	public function shopPriceGrouping($num,$keyItem){
		//最小价
		$minPrice=D('Product')->min($keyItem);
		//最大价
		$maxPrice=D('Product')->max($keyItem);
		//算出平均值
		$averagePrice=($maxPrice-$minPrice)/$num;
		$shopPriceGrouping=array();
		//初始化最小价
		$temMin=0;
		//初始化最大价
		$temMax=0;
		//循环10次
		for($i=1;$i<=$num;$i++){
			//每一次最大价=当前最小价+平均值
			$temMax=$temMin+$averagePrice;
			//把当前最小价和当前最大价保存到数组里面
			$shopPriceGrouping[$i]=array(
			    'temMin'=>$temMin,
			    'temMax'=>$temMax,				
			);
			//更新当前最小价
			$temMin=$temMax;
		}
        return $shopPriceGrouping;
	}
	//检查库存
    public function checkstock(){
		$rs=D('Stock')->findData(array(
		   'max_stock.pro_attr'=>I('get.pro_attr'),
		   'max_stock.pro_id'=>I('get.pro_id'),
		));
		return  $this->ajaxReturn($rs);
	}
	//产品列表页
    public function lists(){
		$perpage=isset($GET['perpage'])?$_GET['perpage']:6;
		$rs=D('Product')->showData($perpage);
		$this->assign('page',$rs['page']);
		$this->assign('rs',$rs['result']);
		// dump($rs['result']);exit;
		$this->assign('title','麦斯威尔咖啡商城-产品列表页');
		$this->display();
    }
	//会员专区
	public function memberarea(){
		$this->assign('title','麦斯威尔咖啡商城-会员专区');
		$this->display();
	}
	//产品搜索
	public function search(){
		$this->assign('title','麦斯威尔咖啡商城-产品搜索');
		$this->display();
	}	
	//产品详情页
	public function show(){
		$rs=D('Product')->findData(I('get.id'));
		$rs['discountPrice']=$rs['shop_price']*0.8;
		
		//产品属性
		$attribute=D('Attribute')->showData(I('get.id'));
		//dump($attribute);exit;
		$this->assign('attribute',$attribute);
		
		//产品套餐
		$productSet=D('ProductSet')->showData(1000000,'max_product_set.proid='.I('get.id'));
		$productcat=D('Category')->showProductcat();
		
		$catNav=D('Category')->getTopCat($productcat,$rs['cat_pid']);
		$catNav=array_reverse($catNav);
			//dump($rs);exit;
		$this->assign('catNav',$catNav);
		$this->assign('productSet',$productSet['result']);
		$this->assign('rs',$rs);
		// dump($rs);exit;
		$this->assign('title','麦斯威尔咖啡商城-产品详情页');
		$this->display();
    }

}