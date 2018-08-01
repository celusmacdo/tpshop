<?php
   /*
   产品列表页分类导航挂件
   */
    namespace User\Widget;
    use Think\Controller;
    class ProductCatWidget extends Controller {
        public function show(){
			  //先查询商城帮助的id
			  $rs=D('Category')->where('cattype="product" and pid!=0')->order()->select();
			  $html='';
			  foreach($rs as $k=>$v){
				  if($v['level']==2){
					    $html.='<dt><span></span>'.$v['cat_name'].'</dt>';
						foreach($rs as $k1=>$v1){
							  if($v1['level']==3 && $v1['pid']==$v['id']){
						          $html.='<dd class="on"><a href="'.U('Home/product/search').'?catid='.$v1['id'].'">'.$v1['cat_name'].'</a></dd>';
							  }
						}
				  }
			  }
			   echo $html;
        }
    }