<?php
   /*
   导航挂件
   */
    namespace User\Widget;
    use Think\Controller;
    class MenuWidget extends Controller {
        public function topMenu(){
			  //先查询商城帮助的id
			  $rs=D('Homemenu')->where('type=1')->order()->select();
			  
			  $html='';
			  foreach($rs as $k=>$v){
				  if($v['fun']=='member'){
					  $html.='<li><a href="'.U('User/'.$v['fun'].'/'.$v['act']).'">'.$v['namestr'].'</a></li>';	
				  }else{
					  $html.='<li><a href="'.U('Home/'.$v['fun'].'/'.$v['act']).'">'.$v['namestr'].'</a></li>';	
				  }
				  
			  }
			   echo $html;
        }
		 public function mainMenu(){
			  $rs=D('Homemenu')->where('type=2')->order()->select();
			  $html='';
			  foreach($rs as $k=>$v){
			 		$html.='<li><a href="'.U('Home/'.$v['fun'].'/'.$v['act']).'">'.$v['namestr'].'</a></li>';	
			   }
			   echo $html;
        }
    }