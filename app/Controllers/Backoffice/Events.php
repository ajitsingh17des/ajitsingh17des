<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Events extends BaseController
{
	public $session = null;
	public $data = null;
	public $model = null;
	public $validation = null;
	public $activedata = null;
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->validation =  \Config\Services::validation();
		helper(['form', 'url','render_helper']); 
		$this->model = new CommonModel();
		$this->activedata['menu'] = 8;
		$this->activedata['submenu'] = 13;
	} 
	
	
	/************************code Written By  11091994  start here********************/
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		
		$this->data = $this->model->getRows('events', '', '', 'display_order', 'ASC');
		$i=0; foreach($this->data as $data)
		{
			$event_id = $data['event_type'];
		
			$event_type = $this->model->getRows('event_type', 'title', array('id'=>$event_id));
		
			$this->data[$i]['event_title'] = $event_type[0]['title'];
		$i++; }
	
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/events/events_view', ['courseCatData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/events/events_view');
			echo view('backoffice/template/includes/footer');
		} 
	} 
	
	public function add()
	{
		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		$current_user_id = $this->session->get('admin_login_id');
		
		$event_type  = $this->model->getRows('event_type', 'id,title', array('status'=>"1"), 'display_order', 'ASC');
		$campus_type  = $this->model->getRows('campus', 'campus_id,campus_name', array('campus_status'=>"1"), 'campus_display_order', 'ASC');
		
		$this->maxdata = $this->model->getRows('events', 'max(display_order) as display_order', '', 'display_order', 'ASC');
	    $related_events = $this->model->getRows('events', '','', 'display_order', 'ASC');
		
		
		if(!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/events/add_event', ['validation' => $this->validation,'maxData'=> $this->maxdata,'related_events'=>$related_events,'campus_type'=>$campus_type,'event_type'=>$event_type]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			
			$string = strtolower($this->request->getVar('title'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			
			if($this->request->getFile('catagog_image')!=''){
				$avatar = $this->request->getFile('catagog_image');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/events/',$file_name);
				}	
			}
			$related_events    =   $this->request->getVar('related_events');
    			if($related_events){
    			    $rel_course      =   implode(',',$related_events);
    			}else{
    			    $rel_course      =   '';
    			}
    				$campus    =   $this->request->getVar('campus');
    			if($campus){
    			    $rel_campus      =   implode(',',$campus);
    			}else{
    			    $rel_campus      =   '';
    			}
		
			
			if($this->request->getFile('catagog_image1')!=''){
				$avatar1 = $this->request->getFile('catagog_image1');
				$error1 = $avatar1->getError();
				if(!$error1)
				{
					$file_name1 = $avatar1->getRandomName();
					$avatar1->move(ROOTPATH . 'uploads/events/banner_images/',$file_name1);
				}	
			}
			
			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('title')),
				'event_type'    		=> trim($this->request->getVar('event_type')),
				'campus_id' 		    => $rel_campus,
				'slug'       			=> trim($slug),
				'image'             	=> trim($file_name),
				'banner_images1'       	=> trim($file_name1),
				'event_date'    		=> trim(date('Y-m-d', strtotime($this->request->getVar('event_date')))),
				'event_and_news_month'=>trim(date('m', strtotime($this->request->getVar('event_date')))),
				'event_and_news_year'=>trim(date('Y', strtotime($this->request->getVar('event_date')))),
				'description'    		=> trim($this->request->getVar('description')),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'related_event_id' 		=> $rel_course,
				'page_title' 			=> trim($this->request->getVar('page_title')),
				'meta_keywords'    		=> trim($this->request->getVar('meta_keywords')),
				'meta_description' 		=> trim($this->request->getVar('meta_description')),
				'created_date'     		=> date('Y-m-d'),
				'created_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->saveRecord('events', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/events'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/events/add'));
			} 
		} 
	} 
	
	
	
	public function edit($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		
	
		
		$cat_id = base64_decode($id);
		$cond = array('id'=>$cat_id);
		$this->data = $this->model->getRows('events', '*', $cond, 'display_order', 'ASC');	
		$related_events = $this->model->getRows('events', '','', 'display_order', 'ASC');
		
		$event_type  = $this->model->getRows('event_type', 'id,title', array('status'=>"1"), 'display_order', 'ASC');
		$campus_type  = $this->model->getRows('campus', 'campus_id,campus_name', array('campus_status'=>"1"), 'campus_display_order', 'ASC');
		
		$act = base_url('backoffice/events/update/'.$id);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/events/add_event', ['CourseCategoryData'=>$this->data,'act'=> $act,'related_events'=>$related_events,'campus_type'=>$campus_type,'event_type'=>$event_type]);
		echo view('backoffice/template/includes/footer');
		
	}
	
	public function update($id='')
	{
		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		$current_user_id = $this->session->get('admin_login_id');
		
		
		$cat_id = base64_decode($id);
		$cond = array('id'=>$cat_id);
		
		if(!$this->validation($cat_id))
		{	        	
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/events/add_event', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{  
	
			$categorySlug = $this->model->getRows('events', 'slug', $cond, 'display_order', 'ASC');	
			$slug		 =  $categorySlug[0]['slug'];
			if($this->request->getFile('catagog_image')!='')
					{ 
						$avatar = $this->request->getFile('catagog_image');
						$error = $avatar->getError();
						if(!$error)
						{
							$file_name = $avatar->getRandomName();
							$avatar->move(ROOTPATH . 'uploads/events/',$file_name);
						}
			}else{
				$file_name = $this->request->getVar('OldCatagogImage');
			}	
			
			
			$related_events    =   $this->request->getVar('related_events');
    			if($related_events){
    			    $rel_course      =   implode(',',$related_events);
    			}else{
    			    $rel_course      =   '';
    			}
    			
    			
    			$campus    =   $this->request->getVar('campus');
    			if($campus){
    			    $rel_campus      =   implode(',',$campus);
    			}else{
    			    $rel_campus      =   '';
    			}
    			
    			
    			if($this->request->getFile('catagog_image1')!='')
					{ 
						$avatar1 = $this->request->getFile('catagog_image1');
						$error1 = $avatar1->getError();
						if(!$error1)
						{
							$file_name1 = $avatar1->getRandomName();
							$avatar1->move(ROOTPATH . 'uploads/events/banner_images/',$file_name1);
						}
			}else{
				$file_name1 = $this->request->getVar('OldCatagogImage1');
			}
			$this->data = array(
				'title'    				=> trim($this->request->getVar('title')),
				'event_type'    		=> trim($this->request->getVar('event_type')),
				'campus_id' 		    => $rel_campus,
				'slug'       			=> trim($slug),
				'image'             	=> trim($file_name),
				'banner_images1'       	=> trim($file_name1),
				'event_date'    		=> trim(date('Y-m-d', strtotime($this->request->getVar('event_date')))),
				'event_and_news_month'=>trim(date('m', strtotime($this->request->getVar('event_date')))),
				'event_and_news_year'=>trim(date('Y', strtotime($this->request->getVar('event_date')))),
				'description'    		=> trim($this->request->getVar('description')),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'related_event_id' 		=> $rel_course,
				'page_title' 			=> trim($this->request->getVar('page_title')),
				'meta_keywords'    		=> trim($this->request->getVar('meta_keywords')),
				'meta_description' 		=> trim($this->request->getVar('meta_description')),
				'updated_date'     		=> date('Y-m-d'),
				'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/events'));
			}
		} 
		}
	
	
	public function map_gallery($slug='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
	    $event_id = base64_decode($slug);
		$cond = array('event_type_id'=>$event_id);
			
		$this->data = $this->model->getRows('event_gallery', '',$cond, 'display_order', 'ASC');
		$add_data = $this->model->getRows('event_gallery', '',$cond, 'display_order', 'ASC');
	    $act    =   base_url().'backoffice/events/gallery_add/'.$slug;
		if((bool)$event_id === TRUE)
		{
		    echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/events/add_gallery', ['GalleryData'=>$this->data,'gallaet_add_data'=>$add_data,'galleryType'=> $galleryType,'act'=>$act]);
			echo view('backoffice/template/includes/footer');
	    }
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/events/add_gallery');
			echo view('backoffice/template/includes/footer');
		} 		
	}
	
	
	public function gallery_add($id)
	{	
	     
		 $gallery_id = base64_decode($id);			
	    $this->maxdata = $this->model->getRows('event_gallery', 'max(display_order) as display_order', '', 'display_order', 'ASC');
				
		
		if($imagefile = $this->request->getFiles())
        {
		 
        foreach($imagefile['gallery_image'] as $img)
        {			
        if ($img->isValid() && ! $img->hasMoved())
        {
           $newName = $img->getRandomName();
           $img->move(ROOTPATH.'uploads/event_gallery', $newName);		   	  
		  	   
		   $this->data = array(
			'event_type_id'=> $gallery_id, 
			//'gallery_title'  => $galleryname[0]['gallery_title'], 
		//	'type'           =>  $galleryname[0]['type'],
			'display_order'  => $this->maxdata[0]['display_order'],
			'gallery_value'  => $newName,
			'created_date'   => date('Y-m-d'),
			'status'         => "1",
			'created_by'     => 1
			);	
             $this->model->saveRecord('event_gallery', $this->data);
            
        }
        }
		$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
		$this->session->setFlashdata($this->msg);
		return redirect()->to(base_url('backoffice/events/map_gallery/'.$id));
		}
	}
	
	
	public function delete_view($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$gallery_id = base64_decode($id);
		
		$cond = array('id'=>$gallery_id);
		
		$this->data['event_type_id'] = $this->model->getRows('event_gallery', 'event_type_id', $cond);
		
		$event_type_id = $this->data['event_type_id'][0]['event_type_id'];
		if((bool)$this->model->deleteRecord('event_gallery', $cond) === TRUE)
		{					
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events/map_gallery/'.base64_encode($event_type_id)));
		}
	}	
	
	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}		
		$cat_id = base64_decode($id);		
		$cond     = array('id'=>$cat_id);		
		if((bool)$this->model->deleteRecord('events',$cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events'));
		}
	}
	
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = base64_decode($id);
		$cond       = array('id'=>$cat_id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = base64_decode($id);
		$cond       = array('id'=>$cat_id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events'));
		}
	}
	
	public function show_active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = base64_decode($id);
		$cond       = array('id'=>$cat_id);
		$this->data = array('show_home' => "1");
		
		if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record Update successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events'));
		}
	}	
	
	 public function show_deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = base64_decode($id);
		$cond       = array('id'=>$cat_id);
		$this->data = array('show_home' => "0");
		
		if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record Update successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events'));
		}
	}
	
	public function delete_image($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cat_id = base64_decode($id);
		$cond = array('id'=>$cat_id);
		$mediatData = $this->model->getRows('events', '*', $cond); 
		$this->data = array(
		    'image' => '', 
		);
		if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
		{
	      if(file_exists('uploads/events/'.$mediatData[0]['image'])){
             unlink('uploads/events/'.$mediatData[0]['image']);
         }        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events/edit/'.$id));
		}
	} 
	
	public function delete_logo_image1($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cat_id = base64_decode($id);
		$cond = array('id'=>$cat_id);
		$mediatData = $this->model->getRows('events', '*', $cond); 
		$this->data = array('banner_images1'=>'');
		if((bool)$this->model->updateRecord('events', $this->data, $cond) === TRUE)
		{
		    if(file_exists('uploads/events/banner_images/'.$mediatData[0]['banner_images1'])){
                unlink('uploads/events/banner_images/'.$mediatData[0]['banner_images1']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/events/edit/'.$id));
		}
	} 
	
	private function validation($id=0)
	{
		if($id)
		{
		  $validation = $this->validate([	
            'event_type' => [
				'label'  => 'event_type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Please select a type.'
				]
			],		  
			'title' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[events.title,id,'.$id.']',
				'errors' => [
					'required' => 'Title can not be empty.'
				]
			]
		  ]);	
		}
		else
		{
		  $validation = $this->validate([
		    'event_type' => [
				'label'  => 'event_type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Please select a type.'
				]
			],
			'title' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[events.title]',
				'errors' => [
					'required' => 'Title can not be empty.',
					'is_unique' => 'This title is already used.'
				]
			]
		  ]);	
		}		
        return $validation;		
	}
	/*
	public function check_event_title($event_title,$id)
	{
		echo 'fd';die;
		$cond = array('title'=>$event_title,'id!='=>$id);
		if((bool)$this->model->getRows('events','',$cond)===true){
			$this->validate('check_event_title', 'This %s is already used.');
			return false;
		}
		return true;
	}
    */
/************************code Written By  11091994 end here********************/
	

}
