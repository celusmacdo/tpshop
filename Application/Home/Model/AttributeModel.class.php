<?php 
//产品属性模型
namespace Home\Model;
use Think\Model;
class AttributeModel extends Model {
	//产品属性输出  $perpage每页条数
     public function showData($id){
         $result=$this
		 ->join('max_product_attr on max_product_attr.attrid=max_attribute.id')
		 ->join('max_category_attr on max_category_attr.attrid=max_attribute.id')
		 ->where('max_product_attr.proid='.$id)
		 ->order('max_attribute.id asc')
		 ->select();
		 //初始化一个数组
		 $data=array();
		 //遍历查出的结果
		 foreach($result AS $k=>$v){
			 if($v['attrtype']==1){
				 //相同关键字作为下标合并
				 $data[$v['attrtype']][$v['attrname']][$v['attrvalue']]=$v;
			 }else{
				 $data[$v['attrtype']][$v['attrid']]=$v;
			 }
			 
		 }
		 return $data;
	 }
	//产品属性添加
     public function addData($data){
		 $result = $this->add($data); // 写入数据到数据库 
		 if($result){
				// 如果主键是自动增长型 成功后返回值就是最新插入的值
				$insertId = $result;
		 }
		 return $insertId; 
	 }
	//产品属性更新
     public function saveData($data){
		 $result = $this->save($data); // 写入数据到数据库 
		  if($result){
				return true; 
		 }else{
			    return false;
		 }
	 }
}
?>