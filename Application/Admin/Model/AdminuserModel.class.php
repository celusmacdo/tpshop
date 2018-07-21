<?php 
//管理员模型
namespace Admin\Model;
use Think\Model;
class AdminuserModel extends Model {
	//管理员输出  $perpage每页条数
    public function showData($perpage){
		//总条数
		$count = $this->field('max_adminuser.*,max_group.namestr')->order('max_adminuser.id desc')->join('max_group ON max_group.id = max_adminuser.group_id')->count();// 查询满足要求的总记录数
		 //实例化调用分页
		$Page = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		$show = $Page->show();// 分页显示输出
		
		//max_adminuser inner join(连表) max_group  on(条件)   max_group.id = max_adminuser.group_id'
        $result = $this->field('max_adminuser.*,max_group.namestr')->order('max_adminuser.id desc')->join('max_group ON max_group.id = max_adminuser.group_id')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($result AS $k=>$v){
			foreach($v AS $key=>$value){
				if(empty($value)){
					$result[$k][$key]='暂无数据';
				}
			}
			//去权限模型查找权限数据
			$group=D('Group')->groupFind($v['group_id']);
			$result[$k]['group_name']=$group['namestr'];
			$result[$k]['ctime']=date('Y-m-d',$v['ctime']);
			$result[$k]['sex']=$v['sex']==0?'男':'女';
		}
		return array(
		    'page'=>$show,     
		    'result'=>$result,
		 ); 
	}
	//管理员添加
	public function addData($data){
		$data['password']=md5($data['password']);
		$data['ctime']=time();
		$result = $this->add($data); 
		if($result){
			// 如果主键是自动增长型 成功后返回值就是最新插入的值
			$insertId = $result;
			return $insertId; 
		}else{
			return false;
		}
	}
	//管理员更新
    public function saveData($data){
		if(!empty($data['password'])){
			$data['password']=md5($data['password']);
		}else{
			unset($data['password']);
		}
		$data['password']=md5($data['password']);
		$result = $this->save($data); 
			if($result !== false){
				return true;
			}else{
				return false;
			} 
	}
}
?>