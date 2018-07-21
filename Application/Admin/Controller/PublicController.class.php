<?php
/*
	公共控制器
*/
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
	public $item=array(
	   'Adminuser'    =>array('管理员编号','账号名称','管理员昵称','管理员性别','所属组别','创建时间','头像'),
	   'Ad'           =>array('广告编号','广告名称','广告链接','广告描述','广告分类'),
	   'Adminmenu'    =>array('导航编号','导航名称'),
	   'Articlecat'   =>array('分类编号','分类名称'),
	   'Article'      =>array('文章编号','文章标题','文章描述','文章分类'),
	   'Attribute'    =>array('属性编号','属性名称','属性类型'),
	   'Brand'        =>array('品牌编号','品牌名称','品牌LOGO','官网地址','品牌简介'),
	   'Group'        =>array('管理员编号','角色名称','权限描述','权限分配'),
	   'Homemenu'     =>array('导航编号','导航名称','所属导航'),
	   'Imgrun'       =>array('轮播编号','轮播名称','轮播链接','轮播图片','轮播分类'),
	   'Productcat'   =>array('分类编号','分类名称'),
	   'Product'      =>array('产品编号','产品名称','所属分类','所属品牌','本店价','库存数量','产品图片','新品上市','精品推荐','热销商品','发布时间'),
	   'ProductSet'   =>array('套餐编号','产品名称','所属分类','所属品牌','套餐价','套餐名称','产品图片','套餐配件'),
	   'ProductPart'  =>array('配件编号','配件名称','价值','配件图片','所属品牌','所属分类','发布时间'),
	   'Stock'        =>array('库存编号','商品名称','商品属性','库存数量','关联套餐'),
	   'System'       =>array('系统编号','系统中文名称','系统内容','内容类型'),
	 
	);
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
		$this->assign('coname',CONTROLLER_NAME);
		if(IS_POST){
			foreach($_FILES AS $k=>$v){
				if(is_array($v['error'])){
					$error=0;
					foreach($v['error'] AS $k1=>$v1){
						if($v1==0){
							$error++;
						}
					}
					if($error==0){
						$this->upload();
					}
				}elseif($v['error']==0){
					$this->upload();
				}
			}
		}
	}
	//检查数据是否为空
	public function checkEmpty($data){
		//遍历数组
		foreach($data AS $k=>$v){
			//判断是不是二维数组
			if(is_array($v)){
				foreach($v AS $key=>$value){
					if(empty($value)){
						unset($data[$k][$key]);
					}					
				}
			}else{
				if(empty($v)){
					unset($data[$k]);
				}
			}
		}
		return $data;
	}
	//省市区联动获取下一级
	public function getnextregion(){
		if(IS_AJAX){
			//ajax返回
			$this->ajaxReturn(D('Region')->getRegion(I('get.region_type'),I('get.parent_id')));
		}
	}
	//上传
	public function upload(){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			$upload->savePath  =     ''; // 设置附件上传（子）目录
			// 上传文件 
			$info   =   $upload->upload();
			if(!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			}else{// 上传成功
				 if(count($info)<2){
					 foreach($info as $k=>$v){
						$_POST[$k]='/Uploads/'.$v['savepath'].$v['savename'];
					 }
				 }else{
					 foreach($info as $k=>$v){
						 $_POST[$k][]='/Uploads/'.$v['savepath'].$v['savename'];
					 }
				 }
			}
    }
		
}