<?php
/*
	前台购物车控制器
*/
namespace Home\Controller;
use Think\Controller;
class CartController extends PublicController {
    //添加购物车
    public function addcart(){
        $rs=M('Cart')->add(array(
		    'pro_id'=>I('get.pro_id'),
			'stock_id'=>I('get.stock_id'),
			'pro_price'=>I('get.pro_price'),
			'number'=>I('get.number'),
			'add_time'=>time(),
		));
		if($rs>0){
			$this->ajaxReturn('ok');
		}else{
			$this->ajaxReturn('error');
		}
	}
	//购物车列表页
    public function index(){
		$cart=M('Cart')->select();
		foreach($cart AS $k=>$v){
			$stock=D('Stock')->findData(array(
			   'max_stock.id'=>$v['stock_id'],
			));		
            $cart[$k]['pro_info_list']=$stock;
          	$cart[$k]['totalBuy']=$v['pro_price']*$v['number'];//计算单项目、总值
		}
        $this->assign('cart',$cart);
		$this->assign('title','麦斯威尔咖啡商城-购物车');
        $this->display();
    }
	//购物车删除
	public function del(){
		    //M('表名')->delete(删除数据id); 
			$rs=M('Cart')->delete(I('get.id'));
			//查看错误
			//返回值 修改条数
			if($rs>0){
				$this->success('删除成功', U('Home/Cart/index').'?id='.I('get.id'));
			}else{
				$this->error('删除失败');
			}
    }
	//购物车修改
	public function update(){
		    //M('表名')->delete(删除数据id); 
			$rs=M('Cart')->where('id='.I('get.cart_id'))->save(array(
			   'number'=>I('get.number')
			));
			//查看错误
			//返回值 修改条数
			if($rs>0){
				$this->ajaxReturn('ok');
			}else{
				$this->ajaxReturn('error');
			}
    }
}