<?php
   /*
   文章分类挂件
   */
    namespace Admin\Widget;
    use Think\Controller;
    class ArticlecatWidget extends Controller {
        public function show(){
			  $group=D('Category')->where('cattype="article" and level=3')->select();
			  $html='';
                $html.='<div class="form-group">';
                    $html.='<label class="col-sm-3 control-label no-padding-right" for="form-field-7">';
                        $html.='<font color="red">*</font>文章分类:</label>';
                    $html.='<div class="col-sm-9">';
                        $html.='<select id="form-field-7" name="group_id">';
                            $html.='<option>..请选择</option>';
                            foreach($group AS $k=>$v){
                            $html.='<option value='.$v['id'].'">'.$v['cat_name'];
                            $html.='</option>';
                            }
                        $html.='</select>';
                    $html.='</div>';
               $html.='</div>';
			   echo $html;
        }
    }