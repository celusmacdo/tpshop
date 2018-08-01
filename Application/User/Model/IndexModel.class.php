<?php
/*

前台会员首页主控制器

*/
namespace User\Model;
use Think\Model;
class IndexModel extends Model{
	
	public $tableName='member';//定义表名
	
	public function findMember($data){
		
		//对密码进行MD5处理
		$data['password']=MD5($data['password']);
		
		$rs=$this->where($data)->find();
		
		// $MemberLevel=M('MemberLevel')->where($rs['group_name'].' > min_point AND '.$rs['group_name'].' < max_point')->find();
		
		// $rs['level_name']=$MemberLevel['member_level'];
		
		//dump($this->getLastSql());
        //dump($rs);exit;
		
		if($rs!=null){
			return $rs;
		}else{
			return 'false';
		}
	}
	public function addMember($data){

			//对密码进行MD5处理

			$data['password']=md5($data['password']);

			$data['addtime']=time();

			$rs=$this->add($data);

			if($rs>0){

			    //注册成功后，开通账户

			    $acount_id=M('MemberAcount')->add(array(

                   'acount_pwd'=>md5('123456'),

                   'money_balance'=>10,

                   'member_id'=>$rs,

                   'charge_total'=>0,

                ));

                if($acount_id>0){

                     $this->save(array(

                       'id'=>$rs,

                       'acount_id'=>$acount_id, 

                     ));

                }

				return 'ok';

			}else{

				return 'false';

			}



	}
	public function saveMember($data)

	{

		    //不需要修改密码默认是不填写的，因此只对填写了密码进行MD5处理

			if(!empty($data['pwd'])){

			  $data['pwd']=md5($data['pwd']);

			}else{

			  unset($data['pwd']);

			}

			//D(表名)->save(更新数据)  更新成功返回受影响条数  失败返回false

			$rs=$this->save($data);

			/*

			dump($this->getDbError());//查看sql语句是否有错

			dump($this->getLastSql());

			dump($rs);

			*/

			if($rs>0){

				return 'ok';

			}else{

				return 'false';

			}

	}
	public function delManage($id)

	{

		    //D(表名)->delete()  删除成功返回删除条数  失败返回false

			$rs=$this->where('id='.$id)->delete();



			//dump($this->getDbError());//查看sql语句是否有错

			//dump($this->getLastSql());

			//dump($rs);



			if($rs>0){

				return 'ok';

			}else{

				return 'false';

			}

	}
}
