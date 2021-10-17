<?php
/**
 *
 *Backend Helper for Layout 
 *
 *
 */
   
    use App\Models\Backoffice\CommonModel;

	function session_current(){
	    
	    $model = new App\Models\Backoffice\CommonModel;
	   
	    $user_email             =   $model->session->get('user_email');
	    $user_id                =   $model->session->get('user_id');
	    $data   	            =   array('user_email'=>$user_email,'user_id'=>$user_id);
	    return $data;
	}
	function cat_seo($slug){
		$model = new App\Models\Backoffice\CommonModel;
		$data = $model->getRows('course_category', 'cat_page_title,cat_meta_keywords,cat_meta_description',array('cat_slug'=>$slug,'cat_status'=>1),'cat_display_order','asc');
		return $data;
	}
	
	
	function course_category(){
		$model = new App\Models\Backoffice\CommonModel;
		$joinSql = 'Select cat_slug,cat_name,id from course_category where cat_status = 1 order by cat_display_order';
		$joinData = $model->solveCustomQuery($joinSql);
		return $joinData;
	}
	
    function top_search(){
		$model = new App\Models\Backoffice\CommonModel;
		$joinSql = 'Select c.course_name,c.course_slug,p.name,p.slug,cc.cat_name,cc.cat_slug from course c JOIN parent_course p on c.parent_course_id=p.id JOIN course_category cc on p.course_category_id=cc.id
		WHERE  c.course_search=1 AND c.course_status=1';
		$Data = $model->solveCustomQuery($joinSql);
		return $Data;
	}
	
	

	function parent_course($cat_id){
		$model = new App\Models\Backoffice\CommonModel;
		$joinSql = 'Select slug,name,id from parent_course where course_category_id = '.$cat_id.' order by display_order';
		$joinData = $model->solveCustomQuery($joinSql);
		return $joinData;
	}

	function course_name($parent_id){
		$model = new App\Models\Backoffice\CommonModel;
		$joinSql = 'Select course_name,course_slug from course where parent_course_id = '.$parent_id.' AND course.course_status=1 order by course_display_order';
		$joinData = $model->solveCustomQuery($joinSql);
		return $joinData;
	}
	
	function course_name_single(){
		$model = new App\Models\Backoffice\CommonModel;
		$course_cat = $model->getRows('course_category', '*', array('cat_status'=>1),'cat_display_order','asc');
		return $course_cat;
	}
	
	function country(){
		$model = new App\Models\Backoffice\CommonModel;
		$country = $model->getRows('country', '*', array('status'=>1),'display_order','asc');
		return $country;
	}
	
	
	function course_schedule_single(){
		$model = new App\Models\Backoffice\CommonModel;
		$course_cat = $model->getRows('course_category', '*', array('cat_status'=>1),'cat_display_order','asc');
		return $course_cat;
	}
	
	
	function sideMenu($role_id){
		$model = new App\Models\Backoffice\CommonModel;
		$joinSql = 'Select menu.menu_name,menu.icon,menu.id,form_information.*,form_permission.form_view from form_information  inner join menu on menu.id = form_information.module_id inner join form_permission on form_information.form_id = form_permission.form_information_id where menu.status = 1 and form_permission.role_id ='.$role_id.' order by menu.display_order asc';
		$joinData = $model->solveCustomQuery($joinSql);
		$returnData = array();
		if(!empty($joinData)){
			foreach($joinData as $submenu){
				$returnData[$submenu['menu_name']][] = $submenu;
			}
		}
		return $returnData;
	}
	
/**************************** 	seo functions start here    ***********************/
	function home_page_seo(){
		$model = new App\Models\Backoffice\CommonModel;
		$data = $model->getRows('home_page', 'page_title,meta_keywords,meta_description',array('status'=>1),'display_order','asc');
		return $data;
	}
	
	
	function cms_page_seo($slug=''){
		$model = new App\Models\Backoffice\CommonModel;
		$data = $model->getRows('cms_page', 'page_title,meta_keywords,meta_description',array('page_slug'=>$slug,'page_status'=>1),'display_order','asc');
		return $data;
	}
	
	
		function course_page_seo($slug=''){
		$model = new App\Models\Backoffice\CommonModel;
		$data = $model->getRows('course', 'canonical,xebia_schema,course_page_title,course_meta_keywords,course_meta_description',array('course_slug'=>$slug,'course_status'=>1),'course_display_order','asc');
		return $data;
	}
	
	function landing_page_seo($slug='',$session_country=''){
		$model = new App\Models\Backoffice\CommonModel;
		
		if(!empty($slug)){
			$slug = trim($slug);
			$slugArr = explode('-',$slug);
			if(in_array('online',$slugArr)){
			   
                 $location = end($slugArr);
				 array_pop($slugArr);
				 array_pop($slugArr);
				 array_pop($slugArr);
				$new_slug = implode('-',$slugArr);
				
				$cond           = 'course_slug = "'.trim($new_slug).'" and course_status = 1';  
				//$city           = $model->getRows('city','id',array('name'=>$location,'status'=>1));
				$course_id      = $model->getRows('course','id',$cond);
				$data           = $model->getRows('landing_pages_seo', 'canonical,xebia_schema,page_title,meta_keywords,meta_description',array('country'=>$session_country,'course_id'=>$course_id[0]['id'],'status'=>1,'tranning_type'=>1),'display_order','asc');
			
				
			
			}else{
			   // echo "sharma";
				$location = end($slugArr);
				array_pop($slugArr);
				array_pop($slugArr);
				array_pop($slugArr);
				$new_slug = implode('-',$slugArr);
				$cond           = 'course_slug = "'.trim($new_slug).'" and course_status = 1';  
				$city           = $model->getRows('city','id',array('name'=>$location,'status'=>1));
				$course_id      = $model->getRows('course','id',$cond);
				$data           = $model->getRows('landing_pages_seo', 'canonical,xebia_schema,page_title,meta_keywords,meta_description',array('city'=>$city[0]['id'],'course_id'=>$course_id[0]['id'],'status'=>1,'tranning_type'=>2),'display_order','asc');
			//print_r($course_id);
			}
			return $data;
		
		}
		
	}
	
	function session_country(){
	      $ip = $_SERVER['REMOTE_ADDR'];
          // $json =  unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip"));
          //if(!$json){
                $jsondata = json_decode(file_get_contents("http://ip-api.io/json/$ip"));
                
          //}
                if($jsondata && $jsondata->country_code){
                    $json['geoplugin_countryCode']      =   $jsondata->country_code;
                    $json['geoplugin_city']             =   $jsondata->city;
                    $json['geoplugin_region']           =   $jsondata->region_name;
                    $json['geoplugin_countryName']      =   $jsondata->country_name;
                    
                }else{
                    $json['geoplugin_countryCode']      =   'IN';
                    $json['geoplugin_city']             =   '';
                    $json['geoplugin_region']           =   '';
                    $json['geoplugin_countryName']      =   'India';
                    
                }
                return $json;
         
	 }
	
	

	
	
	/**************************** 	seo functions start here    ***********************/
	
	function product_notification(){
        $model = new App\Models\Backoffice\CommonModel;
        $session = \Config\Services::session();
       
		$session_id=session_id();
		$cond = " ca.session_id ="."'$session_id' AND ca.pay_status=''";
		$schedule_cart=$model->solveCustomQuery('select c.course_name,ca.total_price,ca.id as cart_id,ca.quantity,t.name,s.start_date,s.end_date,co.name as country from schedule s join training_type t on s.tranning_type = t.id join  course c on s.course_id = c.id join  cart ca on ca.schedule_id = s.id join  country co on co.id = s.location where '.$cond);
		$total_item	=	 count($schedule_cart);
		return $total_item;
    }	
