<?php
   /*
   分类导航挂件
   */
    namespace Home\Widget;
    use Think\Controller;
    class CategoryWidget extends Controller {
        public function show(){
			  //先查询商城帮助的id
			  $rs=D('Category')->where('cattype="product" and pid!=0')->order()->select();
			  $html='';
			  foreach($rs as $k=>$v){
				  if($v['level']==2){
					   $html.='<dt>'.$v['cat_name'].'<i>&rang;</i></dt>';
						$html.='<dd>';
							foreach($rs as $k1=>$v1){
								if($v1['level']==3 && $v1['pid']==$v['id']){
									$html.='<a href="'.U('Home/product/search').'?catid='.$v1['id'].'">'.$v1['cat_name'].'</a>';
								}		
							}
						$html.='</dd>';
				  }
			  }
			   echo $html;
        }
    }