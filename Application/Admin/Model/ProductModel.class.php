<?php 
//产品模型
namespace Admin\Model;
use Think\Model;
class ProductModel extends Model {
	//产品输出  $perpage每页条数
    public function showData($perpage){
		//总条数
		$count=$this
		->field('max_product.*,max_brand.brand_name,max_category.cat_name')
		->order('max_product.id desc')
		->join('max_brand on max_brand.id=max_product.brand_id')
		->join('max_category on max_category.id=max_product.catid')
		->count();// 查询满足要求的总记录数
		 //实例化调用分页
		$Page = new \Think\AdminPage($count,$perpage);// 实例化分页类 传入总记录数和每页显示的记录数(25)

		$show = $Page->show();// 分页显示输出
		
		//max_product inner join(连表) max_group  on(条件)   max_group.id = max_product.group_id'
        $result=$this
		->field('max_product.*,max_brand.brand_name,max_category.cat_name')
		->order('max_product.id desc')
		->join('max_brand on max_brand.id=max_product.brand_id')
		->join('max_category on max_category.id=max_product.catid')
		->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($result AS $k=>$v){
			foreach($v AS $key=>$value){
				$result[$k]['ctime']=date('Y-m-d',$v['ctime']);
				$result[$k]['pro_photo']='<img src="'.$v['pro_photo'].'" width="100" height="50" />';
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
	//产品添加
	public function addData($data){
		$data['ctime']=time();
		$result = $this->add($data); // 写入数据到数据库 
		if($result){
			foreach($data['product_attr'] as $k=>$v){
				//4-1   =>  4(attrid) 和  1(attrtype)
				$keyname=explode('_',$k);
				if($keyname[1]==1){
					$v=explode(';',$v);
					foreach($v AS $key=>$value){
						M('ProductAttr')->add(array(
							'attrid' =>$keyname[0],
							'proid' =>$result,
							'attrvalue' =>$value,
						)); 						 
					}

				}else{
					M('ProductAttr')->add(array(
						'attrid' =>$keyname[0],
						'proid' =>$result,
						'attrvalue' =>$v
					));					 
				}

			}
			// 如果主键是自动增长型 成功后返回值就是最新插入的值
			$insertId = $result;
			return $insertId; 
		}else{
			return false;
		}
	}
	//产品更新
    public function saveData($data){
		//更新时候删除原来图片
		if(file_exists($data['pro_photo'])){
			unlink($data['pro_photo']);
		}
		 
		$result = $this->save($data); // 写入数据到数据库 
		if($result){
			M('ProductAttr')->where('proid='.$data['id'])->delete();
			foreach($data['product_attr'] as $k=>$v){
				//4-1   =>  4(attrid) 和  1(attrtype)
				$keyname=explode('_',$k);
				if($keyname[1]==1){
					$v=explode(';',$v);
					foreach($v AS $key=>$value){
						M('ProductAttr')->add(array(
							'attrid' =>$keyname[0],
							'proid' =>$data['id'],
							'attrvalue' =>$value,
						)); 						 
					}

				}else{
					M('ProductAttr')->add(array(
						'attrid' =>$keyname[0],
						'proid' =>$data['id'],
						'attrvalue' =>$v
					));					 
				}

			}
				// 如果主键是自动增长型 成功后返回值就是最新插入的值
			$result = $this->save($data); 
			if($result !== false){
				return true;
			}else{
				return false;
			} 
		}
		return $insertId; 
	}
}
?>