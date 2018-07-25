<?php 
//分类模型
namespace Home\Model;
use Think\Model;
class CategoryModel extends Model {
	//获取上级分类
	 public function getTopCat($result,$id,$cat=array()){
		 foreach($result AS $k=>$v){
			 /*
			 id=79
			 */
			 if($v['id']==$id){
				 $cat[]=$v;
				 $cat=$this->getTopCat($result,$v['pid'],$cat);
			 }
		 }
		 return $cat;
	 }
	 //分类整理   
	 public function sortCat($result,$cat=array(),$pid=0){
		  //遍历分类数组
		  foreach($result AS $k=>$v){
			  if($v['pid']==$pid){
				  $v['cat_name']=$v['cat_name'];
				  /*
				  pid=0  level=1
				  pid=6   $cat  $result
				  pid=7   $cat  $result
				  pid=12  $cat  $result
				  */
				  $cat[]=$v;
				  $cat=$this->sortCat($result,$cat,$v['id']);
			  }
		  }
		  return $cat;
	 }
	//文章分类输出  $perpage每页条数
     public function showArticlecat($perpage=1){
		 //总条数
		 $count=$this->order('id desc')->where('cattype="article"')->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page  = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show   = $Page->show();// 分页显示输出

         $result=$this->order('id desc')->where('cattype="article"')->limit($Page->firstRow.','.$Page->listRows)->select();
		 $cat=$this->sortCat($result);
		 return array(
		    'page'=>$show,     
		    'result'=>$cat,
		 );
	 }
	 //产品分类输出  $perpage每页条数
     public function showProductcat(){
         $result=$this->order('id desc')->where('cattype="product"')->select();
		 $cat=$this->sortCat($result); 
		 return $cat;
	 }
	
}
?>