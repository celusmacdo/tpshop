<?php 
//省市区模型
namespace Admin\Model;
use Think\Model;
class RegionModel extends Model {
	//查询下一级市和区
	public function getRegion($region_type,$parent_id=1){
		return $this->where('region_type='.$region_type.' and parent_id='.$parent_id)->select();
	}
}
?>