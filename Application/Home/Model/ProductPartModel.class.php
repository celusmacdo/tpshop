<?php 
//产品配件模型
namespace Home\Model;
use Think\Model;
class ProductPartModel extends Model {
	
	//产品配件输出  $perpage每页条数
     public function showData($perpage=1){
		 //总条数
		 $count=$this
		 ->field('max_product_part.*,max_brand.brand_name,max_category.cat_name')
		 ->order('max_product_part.id desc')
		 ->join('max_brand on max_brand.id=max_product_part.part_brand_id')
		 ->join('max_category on max_category.id=max_product_part.part_catid')
		 ->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page       = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show       = $Page->show();// 分页显示输出
		 //max_product inner join(连表) max_group  on(条件)   max_group.id = max_product.group_id'
         $result=$this
		 ->field('max_product_part.*,max_brand.brand_name,max_category.cat_name')
		 ->order('max_product_part.id desc')
		 ->join('max_brand on max_brand.id=max_product_part.part_brand_id')
		 ->join('max_category on max_category.id=max_product_part.part_catid')
		 ->limit($Page->firstRow.','.$Page->listRows)->select();
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
	//产品配件添加
     public function addData($data){
		 //dump($data);exit;
		 $data['part_ctime']=time();
		 $result = $this->add($data); // 写入数据到数据库 
         if($result){
				// 如果主键是自动增长型 成功后返回值就是最新插入的值
				$insertId = $result;
				return $insertId; 
		 }else{
			    return false;
		 }		 
	 }
	//产品配件更新
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
		  $result = $this->save($data); // 写入数据到数据库 
		  if($result){
				return true; 
		 }else{
			    return false;
		 }		 
	 }
}
?>