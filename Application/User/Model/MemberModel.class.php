<?php
/*

前台会员中心主控制器

*/
namespace User\Model;
use Think\Model;
class MemberModel extends Model{
	
	//保存会员更改密码
    public function savePassword($data){
            $data['password']=md5($data['password']);
			//D(表名)->save(更新数据)  更新成功返回受影响条数  失败返回false
			$rs=$this->save($data);
			if($rs>0){
				return 'ok';
			}else{
				return 'false';
			}
	}

    //保存更新会员信息
    public function saveInfo($data){     
			//D(表名)->save(更新数据)更新成功返回受影响条数  失败返回false
			$rs=$this->save($data);
			
            //dump($this->getLastsql());

            //dump($this->getDbError());

            //dump($rs);exit;
			if($rs>0){
			    //会员信息修改后，更新session信息
                $update=$this->find($data['id']);
                session('HomeUser',$update);
				return $update;
			}else{
				return 'false';
			}
	}

    public function addAddress($data){   
        $data['member_id'] = session('HomeUser.id');
        $rs=M('OrderAddress')->add($data);// 写入数据到数据库 
    	if($rs>0){
           return 'ok';
		}else{
			return 'false';
		}
    }

    public function updateAddress(){
        $data=I('post.');
        $rs=M('OrderAddress')->save($data);
        if($rs>0){
           return 'ok';
		}else{
			return 'false';
		}
    }
	
    public function delAddress(){       
            $id=I('get.id');
        	$rs=M('OrderAddress')->where('id='.$id)->delete();
			if($rs>0){
				return 'ok';
			}else{
				return 'false';
			}
    }
	
	//会员中心我的收藏
	public function collection(){
		$rs=D('MemberCollection')
		->join('max_member_collection on max_member_collection.proid=max_product.id')
		->join('max_member_collection on max_member_collection.memberid=max_member.id')
		->select();
		
	}
}