<?php
/*
模型自动用 xxxxxModel 的xxxx作表名
*/
namespace User\Model;
use Think\Model;
class AcountModel extends Model
{
    protected $tableName = 'Member';
    public function savePwd($data)
	{
            $data['pay_password']=md5($data['pay_password']);
			//D(表名)->save(更新数据)  更新成功返回受影响条数  失败返回false
			$rs=$this->save($data);
			if($rs>0){
				return 'ok';
			}else{
				return 'false';
			}
	}
}