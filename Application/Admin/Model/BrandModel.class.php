<?php 
//产品品牌模型
namespace Admin\Model;
use Think\Model;
class BrandModel extends Model {
	//产品品牌输出  $perpage每页条数
	    public function showData($perpage=10){
			//总条数
			$count = $this->order('max_brand.id desc')->count();// 查询满足要求的总记录数
			 //实例化调用分页
			$Page = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	
			$show = $Page->show();// 分页显示输出
			
			//max_brand inner join(连表) max_group  on(条件)   max_group.id = max_brand.group_id'
	        $result = $this->order('max_brand.id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach($result AS $k=>$v){
				foreach($v AS $key=>$value){
					if(empty($value)){
						$result[$k][$key]='暂时没有数据';
					}
					$result[$k]['brand_logo']='<img height="60" src="'.$v['brand_logo'].'"/>';
			}
				
			}
			return array(
			    'page'=>$show,
			    'result'=>$result,
			 ); 
		}
		//产品品牌添加
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
		//产品品牌更新
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
			$result = $this->save($data); 
			if($result !== false){
				return true;
			}else{
				return false;
			}
		}
	
}
?>