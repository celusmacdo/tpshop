<?php
/*
	前台公共控制器
*/
namespace User\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function __construct(){
		//引入父类的构造函数
		parent::__construct();
		$this->assign('base_url','http://www.maxwell.com/');
		//调用类的方法
		$this->assign('system',$this->getSystem());
	}

	//省市区联动获取下一级
	public function getnextregion(){
		if(IS_AJAX){
			//ajax返回
			$this->ajaxReturn(D('Region')->getRegion(I('get.region_type'),I('get.parent_id')));
			exit;
		}
	}
	//查询系统信息
    public function getSystem(){
       $rs= D('System')->select();
	   $data=array();
	   foreach($rs as $k=>$v){
		   $data[$v['name_en']]=$v;
	   }
       return $data;
	}
	
	/*

	   上传操作

	*/

    public function get_upload()

	{

		$path = 'Public/User/img/';

		if(!file_exists($path)) {

			mkdir($path, 0777, true);

			$path = rtrim($path, '/').'/';

		}

		$config = array(

			//限制文件上传的大小

    		'maxSize'    =>    3145728,

    		//设置保存目录

    		'rootPath'   =>    $path,

    		//上传文件的保存名字

    		'saveName'   =>    array('uniqid',''),

    		//允许上传图片的格式类型

    		'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),

    		'autoSub'    =>    true,

    		'subName'    =>    array('date','Ymd'),

		);

		$upload = new \Think\Upload($config);// 实例化上传类

		//文件上传，支持多文件上传

		$info = $upload->upload();

        //dump($info);exit;

		if (!$info) {

			//上传不成功

			$this->error($upload->getError());

		}else{

            if(count($info)>1){

                    //上传成功

                    $result = [];

                    foreach($info as $val) {

                        $result[] = $path.$val['savepath'].$val['savename'];

                    }



            }else{

                    foreach($info as $val) {

                        $result = $path.$val['savepath'].$val['savename'];

                    }

            }



			return $result;

		}

	}

	/*

	   缩略图操作

	*/

	public function get_thumb($path,$size)

	{

		$savePath = substr($path, 0, strrpos($path, '/')+1).$size.'_'.substr($path, strrpos($path, '/')+1);

		//实例化图像类

		$image = new \Think\Image();

		//open方法打开图像文件

		$image->open($path);

		$image->thumb($size,$size)->save($savePath);

		return $savePath;

	}

    /*

    递归获取父级分类

     */

    public function get_list($pid = 0, $spac = 0)

    {

        static $data = array();

        $spac += 4;

        $category = M('category');

        $result = $category->where(array('pid'=>$pid,'cattype'=>'product'))->select();

        if($result) {

            foreach($result as $val) {

                $data[] = $val;

                $this->get_list($val['category_id'], $spac);

            }

        }

        return $data;

    }
}