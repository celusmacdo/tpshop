<?php 
//产品属性模型
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model {
	//产品属性输出  $perpage每页条数
	    public function showData($perpage='10'){
			//总条数
			$count = $this->order('max_attribute.id desc')->count();// 查询满足要求的总记录数
			 //实例化调用分页
			$Page = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	
			$show = $Page->show();// 分页显示输出
			
			//max_attribute inner join(连表) max_group  on(条件)   max_group.id = max_attribute.group_id'
	        $result=$this->order('max_attribute.id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		 foreach($result AS $k=>$v){
			 foreach($v AS $key=>$value){
				 if(empty($value)){
					 $result[$k][$key]='暂时没有数据';
				 }else{
					 if($key=='attrtype'){
						 if($value==1){
							 $result[$k][$key]='可选属性';
						 }else{
							 $result[$k][$key]='固定属性';
						 }
					 }
				 }
			 }
		 }
			return array(
			    'page'=>$show,     
			    'result'=>$result,
			 ); 
		}
		//产品属性添加
		public function addData($data){
			$result = $this->add($data); 
			if($result){
				// 如果主键是自动增长型 成功后返回值就是最新插入的值
				$insertId = $result;
				return $insertId; 
			}else{
				return false;
			}
		}
		//产品属性更新
	    public function saveData($data){
			$result = $this->save($data); 
			if($result !== false){
				return true;
			}else{
				return false;
			}
		}
	
}
?>