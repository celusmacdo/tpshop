<?php
   /*
   权限挂件
   */
    namespace Admin\Widget;
    use Think\Controller;
    class GroupWidget extends Controller {
        public function show($id){
			  $group=D('Group')->select();
			  $html='';
                $html.='<div class="form-group">';
                    $html.='<label class="col-sm-3 control-label no-padding-right" for="form-field-7">';
                        $html.='<font color="red">*</font>权限设置:</label>';
                    $html.='<div class="col-sm-9">';
                        $html.='<select id="form-field-7" name="group_id">';
                            $html.='<option>..请选择</option>';
                            foreach($group AS $k=>$v){
														   if($id==$v['id']){
																 	$selected='selected=selected'; 
															 }else{
																  $selected='';
															 }	 
                               $html.='<option value="'.$v['id'].'" '.$selected.'>'.$v['namestr'].'</option>';
                            }
                        $html.='</select>';
                    $html.='</div>';
               $html.='</div>';
			   echo $html;
        }
    }