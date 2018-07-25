<?php 
//产品套餐模型
namespace Home\Model;
use Think\Model;
class ProductSetModel extends Model {
	

     public function showData($perpage=1,$where=''){
		 //总条数
		 $count=$this
		 ->field('max_product_set.id as pid,max_product_set.set_name,max_product_set.set_price,max_product_set.partid,max_product.*,max_brand.brand_name,max_category.cat_name')
		 ->order('max_product_set.id asc')
		 ->join('max_product on max_product.id=max_product_set.proid')
		 ->join('max_brand on max_brand.id=max_product.brand_id')
		 ->join('max_category on max_category.id=max_product.catid')
		 ->where($where)
		 ->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page       = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show       = $Page->show();// 分页显示输出
		 //max_product inner join(连表) max_group  on(条件)   max_group.id = max_product.group_id'
         $result=$this
         ->field('max_product_set.id as pid,max_product_set.set_name,max_product_set.set_price,max_product_set.partid,max_product.*,max_brand.brand_name,max_category.cat_name')
		 ->order('max_product_set.id asc')
		 ->join('max_product on max_product.id=max_product_set.proid')
		 ->join('max_brand on max_brand.id=max_product.brand_id')
		 ->join('max_category on max_category.id=max_product.catid')
		 ->where($where)
		 ->limit($Page->firstRow.','.$Page->listRows)
		 ->select();
		    foreach($result AS $k=>$v){
				 //查出套餐关联的配件
				 foreach($v AS $key=>$value){
					 $result[$k]['ctime']=date('Y-m-d H-i-s',$v['ctime']);
					 $result[$k]['pro_photo']='<img src="'.$v['pro_photo'].'" width="100" height="50" />';
					 if(!empty($v['partid'])){
						 $result[$k]['part_list']=M('ProductPart')->where('id in('.$v['partid'].')')->select();
					 }else{
						 $result[$k]['part_list']='没有关联配件';
					 }
				 }
			 }
		 return array(
		    'page'=>$show,     
		    'result'=>$result,
		 );
	 }
	 public function findData($id){
         $result=$this
         ->field('max_product_set.id as pid,max_product_set.set_name,max_product_set.set_price,max_product_set.partid,max_product.*,max_brand.brand_name,max_category.cat_name')
		 ->order('max_product_set.id asc')
		 ->join('max_product on max_product.id=max_product_set.proid')
		 ->join('max_brand on max_brand.id=max_product.brand_id')
		 ->join('max_category on max_category.id=max_product.catid')
		 ->where('max_product.id='.$id)
		 ->find();
		 foreach($result AS $k=>$v){
			 //查出套餐关联的配件
			 foreach($v AS $key=>$value){
				 $result[$k]['ctime']=date('Y-m-d H-i-s',$v['ctime']);
				 $result[$k]['pro_photo']='<img src="'.$v['pro_photo'].'" width="100" height="50" />';
				 if(!empty($v['partid'])){
					 $result[$k]['part_list']=M('ProductPart')->where('id in('.$v['partid'].')')->select();
				 }else{
					 $result[$k]['part_list']='没有关联配件';
				 }
			 }
		 }
		 return $result;
	 }
	//产品添加
     public function addData($data){
         $data['partid']=implode(',',$data['partid']);
		 $result = $this->add($data); // 写入数据到数据库 
		 if($result){
			$insertId = $result;
		 }
		 return $insertId; 
	 }
	//产品更新
     public function saveData($data){
		 //更新时候删除原来图片
		 if(file_exists($data['old_photo'])){
			 unlink($data['old_photo']);
		 } 
		 //清除空的
		 foreach($data AS $k=>$v){
			 if(empty($v)){
				 unset($data[$k]);
			 }
		 }
		 $data['partid']=implode(',',$data['partid']);
		 $result = $this->save($data); // 写入数据到数据库 
		  if($result){
				return true; 
		 }else{
			    return false;
		 } 
	 }
}
?>