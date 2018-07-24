<?php 
//产品库存模型
namespace Admin\Model;
use Think\Model;
class StockModel extends Model {
	
	//产品库存输出  $perpage每页条数
     public function showData($perpage=1,$where=''){
		 //总条数
		 $count=$this
		 ->field('max_stock.id as sid,max_stock.pro_attr,max_stock.amount,max_stock.set_id,max_stock.attr_id,max_product.*,max_brand.brand_name,max_category.cat_name,max_product_set.set_name,max_attribute.attrname')
		 ->order('max_stock.id asc')
		 ->join('max_product on max_product.id=max_stock.pro_id')
		 ->join('max_brand on max_brand.id=max_product.brand_id')
		 ->join('max_category on max_category.id=max_product.catid')
		 ->join('max_product_set on max_product_set.id=max_stock.set_id')
		 ->join('max_attribute on max_attribute.id=max_stock.attr_id')
		 ->where($where)
		 ->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page       = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show       = $Page->show();// 分页显示输出
		 //max_product inner join(连表) max_group  on(条件)   max_group.id = max_product.group_id'
         $result=$this
		  ->field('max_stock.id as sid,max_stock.pro_attr,max_stock.amount,max_stock.set_id,max_stock.attr_id,max_product.*,max_brand.brand_name,max_category.cat_name,max_product_set.set_name,max_attribute.attrname')
		 ->order('max_stock.id asc')
		 ->join('max_product on max_product.id=max_stock.pro_id')
		 ->join('max_brand on max_brand.id=max_product.brand_id')
		 ->join('max_category on max_category.id=max_product.catid')
		 ->join('max_product_set on max_product_set.id=max_stock.set_id')
		 ->join('max_attribute on max_attribute.id=max_stock.attr_id')
		 ->where($where)
		 ->limit($Page->firstRow.','.$Page->listRows)
		 ->select();
		 //dump($result);exit;
		 foreach($result AS $k=>$v){
			 //查出套餐关联的配件
			 foreach($v AS $key=>$value){
				 $result[$k]['part_ctime']=date('Y-m-d H:i:s',$v['part_ctime']);
				 $result[$k]['part_photo']='<img src="'.$v['part_photo'].'" width="100" height="50" />';
			 }
		 }
		 return array(
		    'page'=>$show,     
		    'result'=>$result,
		 );
	 }
	//产品库存添加
     public function addData($data){
		 $data['attr_id']=implode(',',array_keys($data['pro_attr']));
		 $data['pro_attr']=implode(';',$data['pro_attr']);
		 $result = $this->add($data); // 写入数据到数据库 
         if($result){
				
			    //添加库存后要更新产品表的库存字段
			    D('Product')->save(array(
				     'gtype'=>$this->where('pro_id='.I('post.pro_id'))->sum('amount'),
				     'id'=>I('post.pro_id'),
				));
				// 如果主键是自动增长型 成功后返回值就是最新插入的值
				$insertId = $result;
				return $insertId; 
		 }else{
			    return false;
		 }
		  
	 }
	//产品库存更新
     public function saveData($data){
		 //清除空的
		 foreach($data AS $k=>$v){
			 if(empty($v)){
				 unset($data[$k]);
			 }
		 }
		 $result = $this->save($data); // 写入数据到数据库 
		  if($result){
			    //添加库存后要更新产品表的库存字段
			    D('Product')->save(array(
				     'gtype'=>$this->where('pro_id='.I('post.pro_id'))->sum('amount'),
				     'id'=>I('post.pro_id'),
				));
				return true; 
		 }else{
			    return false;
		 }
	 }
}
?>