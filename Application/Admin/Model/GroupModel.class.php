<?php 
//权限模型
namespace Admin\Model;
use Think\Model;
class GroupModel extends Model {
   	//权限查找
    public function groupFind($id){
        return $this->where('id='.$id)->find();
    }
	//权限输出  $perpage每页条数
    public function showData($perpage){
		//总条数
		$count=$this->order('max_group.id desc')->count();// 查询满足要求的总记录数
		//实例化调用分页
		$Page = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		$show = $Page->show();// 分页显示输出
		//vor_group inner join(连表) vor_group  on(条件)   vor_group.id = vor_group.group_id'
        $result=$this->order('max_group.id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($result AS $k=>$v){
			foreach($v AS $key=>$value){
				if(empty($value)){
					$result[$k][$key]='暂无数据';
				}
			}
		}
		return array(
		    'page'=>$show,     
		    'result'=>$result,
		);
	}
	//权限添加
    public function addData($data){
		$result = $this->add($data); // 写入数据到数据库 
		if($result){
				// 如果主键是自动增长型 成功后返回值就是最新插入的值
				$insertId = $result;
			return $insertId; 
		}else{
			return false;
		}
	}
	//权限更新
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