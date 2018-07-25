<?php
   /*
   帮助文章挂件
   */
    namespace Home\Widget;
    use Think\Controller;
    class HelpWidget extends Controller {
        public function show(){
			  //先查询商城帮助的id
			  $help=D('Category')->where('cat_name="商城帮助"')->order()->find();
			  $rs=D('Category')->where('cattype="article" and pid!=0')->select();
			  $html='';
			  foreach($rs as $k=>$v){
			  if($v['pid']==$help['id']){
				   $html.='<div class="col-xs-3 text-center">';
								$html.='<ul class="list-unstyled ">';
										$html.='<li><a href="javascript:;">'.$v['cat_name'].'</a></li>';
										foreach($rs as $k1=>$v1){
											if($v1['pid']==$v['id']){
												$html.='<li><a href="javascript:;">'.$v1['cat_name'].'</a></li>';
											}
										}
								$html.='</ul>';
									
					$html.='</div>';								
					}				
			   }
			   echo $html;
        }
    }