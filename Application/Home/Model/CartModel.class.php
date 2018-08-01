<?php
//购物车模型
namespace Home\Model;
use Think\Model;
class CartModel extends Model {
	public function index($perpage=1,$where=''){
		$count=$this
		->field('max_cart.*,max_product.pro_name,max_product.shop_price,max_product.market_price,max_stock.pro_attr,max_stock.amount')
		->order('max_cart.id desc')
		->join('max_product on max_product.id=max_cart.pro_id')
		->join('max_stock on max_stock.id=max_cart.stock_id')
		->where($where)
		->count();
		
		$Page = new\Think\HomePage($count,$perpage);
		
		$shop = $Page->show();
		
		$result=$this
		->field('max_cart.*,max_product.pro_name,max_product.shop_prict,max_prodcut.market_price,max_stock.pro_attr,max_stock.amount')
		->order('max_cart.id desc')
		->join('max_product on max_product.id=maxcart.pro_id')
		->join('max_stock on max_stock.id=max_cart.stock_id')
		->where($where)
		->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($result AS $k=>$v){
			foreach($v AS $key=>$value){
				
			}
		}
		return array(
			'page'=>$shop,
			'result'=>$result,
		);
		dump($result);exit;
	}
	
	
}