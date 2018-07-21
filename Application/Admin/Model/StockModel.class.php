<?php 
//产品库存模型
namespace Admin\Model;
use Think\Model;
class StockModel extends Model {
	
	//产品库存输出  $perpage每页条数
     public function showData($perpage=1,$where=''){
		 //总条数
		 $count=$this
		 ->field('vor_stock.id as sid,vor_stock.pro_attr,vor_stock.amount,vor_stock.set_id,vor_stock.attr_id,vor_product.*,vor_brand.brand_name,vor_category.cat_name,vor_product_set.set_name,vor_attribute.attrname')
		 ->order('vor_stock.id asc')
		 ->join('vor_product on vor_product.id=vor_stock.pro_id')
		 ->join('vor_brand on vor_brand.id=vor_product.brand_id')
		 ->join('vor_category on vor_category.id=vor_product.catid')
		 ->join('vor_product_set on vor_product_set.id=vor_stock.set_id')
		 ->join('vor_attribute on vor_attribute.id=vor_stock.attr_id')
		 ->where($where)
		 ->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page       = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show       = $Page->show();// 分页显示输出
		 //vor_product inner join(连表) vor_group  on(条件)   vor_group.id = vor_product.group_id'
         $result=$this
		  ->field('vor_stock.id as sid,vor_stock.pro_attr,vor_stock.amount,vor_stock.set_id,vor_stock.attr_id,vor_product.*,vor_brand.brand_name,vor_category.cat_name,vor_product_set.set_name,vor_attribute.attrname')
		 ->order('vor_stock.id asc')
		 ->join('vor_product on vor_product.id=vor_stock.pro_id')
		 ->join('vor_brand on vor_brand.id=vor_product.brand_id')
		 ->join('vor_category on vor_category.id=vor_product.catid')
		 ->join('vor_product_set on vor_product_set.id=vor_stock.set_id')
		 ->join('vor_attribute on vor_attribute.id=vor_stock.attr_id')
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