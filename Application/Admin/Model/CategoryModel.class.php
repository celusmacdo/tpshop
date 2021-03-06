<?php 
//分类模型
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model {
	//文章分类输出  $perpage每页条数
     public function showArticlecat($perpage){
		 //总条数
		 $count=$this->order('id desc')->where('cattype="article"')->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page  = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show   = $Page->show();// 分页显示输出

     $result=$this->order('id desc')->where('cattype="article"')->limit($Page->firstRow.','.$Page->listRows)->select();
		 //初始化数组
		 $cat=array();
		 foreach($result AS $k=>$v){
			 if($v['pid']==0){
				 $cat[]=$v;
				 foreach($result as $k1=>$v1){
					 if($v1['pid']==$v['id']){
						 $v1['cat_name']='<font color="red">|----|----</font>'.$v1['cat_name'];
						 $cat[]=$v1;
						 foreach($result as $k2=>$v2){
							 if($v2['pid']==$v1['id']){
							  $v2['cat_name']='<font color="red">|----|----|----</font>'.$v2['cat_name'];
							  $cat[]=$v2;
							 }	
						 }
					 }
				 }
			 }
		 }
		 return array(
		    'page'=>$show,     
		    'result'=>$cat,
		 );
	 }
	 //产品分类输出  $perpage每页条数
     public function showProductcat($perpage){
		 //总条数
		 $count=$this->order('id desc')->where('cattype="product"')->count();// 查询满足要求的总记录数
		 //实例化调用分页
		 $Page  = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		 $show  = $Page->show();// 分页显示输出
         $result=$this->order('id asc')->where('cattype="product"')->limit($Page->firstRow.','.$Page->listRows)->select();
		 //初始化数组
		 $cat=array();
		 foreach($result AS $k=>$v){
			if($v['pid']==0){
				$v['cat_name']='<font color="red">|----</font>'.$v['cat_name'];
				$cat[]=$v;
				foreach($result as $k1=>$v1){
					if($v1['pid']==$v['id']){
						$v1['cat_name']='<font color="red">|----|----</font>'.$v1['cat_name'];
						$cat[]=$v1;
						foreach($result as $k2=>$v2){
							if($v2['pid']==$v1['id']){
								$v2['cat_name']='<font color="red">|----|----|----</font>'.$v2['cat_name'];
								$cat[]=$v2;
							}
						}
					}
				}
			}
            if ($v['pid']==$v['id']) {
	           $v['pid']=$v['cat_name'];
            }
		 }
         
//         foreach($cat as $k => $v){
//            $res = M('Category')->where(array(
//                'id'=>$v['pid'],
//            ))->find();
//            //dump($res);exit;
//            if($res){
//                $cat[$k]['pid'] = $res['cat_name'];
//                //dump($cat);exit;
//            }else{
//                $cat[$k]['pid'] = "顶级分类";
//            }
//         }
		 return array(
		    'page'=>$show,     
		    'result'=>$cat,
		 );
	 }
	//分类添加
	public function addData($data){
// 			$data['pid']=$_POST['catid'];
// 			$data['level']=$v["level"];
			// dump($data['pid']);exit;
		$result = $this->add($data); 
		if($result>0){
			//插入新的数据
			foreach($data['attrid'] as $k=>$v){
			M('CategoryAttr')->add(array(
				'catid'=>$result,
				'attrid'=>$v,
			));
		}
		// 如果主键是自动增长型 成功后返回值就是最新插入的值
		$insertId = $result;
		return $insertId; 
		}else{
			return false;
		}
	}
	//分类更新
    public function saveData($data){
// 			$rs1= D('Category')->showProductcat(100000000);
// 			foreach($rs1['result'] as $k=>$v){
// 				$data['pid']=$_POST['catid'];
// 				$data['level']=$v["level"];
// 				dump($data);exit;
// 			}
			$result = $this->save($data);
			// dump($data);exit;
			//先删除分类属性表的分类关联的数据
			if($result>0){
						M('CategoryAttr')->where('catid='.$data['id'])->delete();
					//插入新的数据
						foreach($data['attrid'] as $k=>$v){
							M('CategoryAttr')->add(array(
								'catid'=>$data['id'],
								'attrid'=>$v,
							));
						}
			}else{
				M('CategoryAttr')->where('catid='.$data['id'])->delete();
				foreach($data['attrid'] as $k=>$v){
					M('CategoryAttr')->add(array(
						'catid'=>$data['id'],
						'attrid'=>$v,
					));
				}
			}
			if($result !== false){
				return true;
			}else{
				return false;
			} 
	}
	//分类删除
		public function delData(){
			M('CategoryAttr')->where('catid='.$data['id'])->delete();
		}

}
?>