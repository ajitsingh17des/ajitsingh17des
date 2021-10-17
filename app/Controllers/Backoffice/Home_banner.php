<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Home_banner extends BaseController
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
		$this->activedata['menu'] = 5;
		$this->activedata['submenu'] = 8;
	} 
	
	
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		
		$this->data = $this->model->getRows('home_banner', '', '', 'display_order', 'ASC');
		
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/home_banner/home_banner_view', ['courseCatData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/home_banner/home_banner_view');
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
		
		
		$this->maxdata = $this->model->getRows('home_banner', 'max(display_order) as display_order', '', 'display_order', 'ASC');
	    
		if (!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/home_banner/add_banner', ['validation' => $this->validation,'maxData'=> $this->maxdata]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			
			$string = strtolower($this->request->getVar('name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			
			if($this->request->getFile('catagog_image')!=''){
				$avatar = $this->request->getFile('catagog_image');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/home/banner_images/',$file_name);
				}	
			}
			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('name')),
				'sub_title'    			=> trim($this->request->getVar('sub_title')),
				'slug'       			=> trim($slug),
				'banner_images'       	=> trim($file_name),
				'alt_tag'    				=> trim($this->request->getVar('alt_tag')),
				'description'    		=> trim($this->request->getVar('description')),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'page_title' 			=> trim($this->request->getVar('page_title')),
				'meta_keywords'    		=> trim($this->request->getVar('meta_keywords')),
				'meta_description' 		=> trim($this->request->getVar('meta_description')),
				'created_date'     		=> date('Y-m-d'),
				'created_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->saveRecord('home_banner', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/home_banner'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/home_banner/add'));
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
		$this->data = $this->model->getRows('home_banner', '*', $cond, 'display_order', 'ASC');	
		$act = base_url('backoffice/home_banner/update/'.$id);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/home_banner/add_banner', ['CourseCategoryData'=>$this->data,'act'=> $act]);
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
		
		if (!$this->validation())
		{
			
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/home/add_banner', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{  
	
			$categorySlug = $this->model->getRows('home_banner', 'slug', $cond, 'display_order', 'ASC');	
			$slug		 =  $categorySlug[0]['slug'];
			if($this->request->getFile('catagog_image')!='')
					{ 
						$avatar = $this->request->getFile('catagog_image');
						$error = $avatar->getError();
						if(!$error)
						{
							$file_name = $avatar->getRandomName();
							$avatar->move(ROOTPATH . 'uploads/home/banner_images/',$file_name);
						}
			}else{
				$file_name = $this->request->getVar('OldCatagogImage');
			}	
			
			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('name')),
				'sub_title'    			=> trim($this->request->getVar('sub_title')),
				'slug'       			=> trim($slug),
				'banner_images'       	=> trim($file_name),
				'alt_tag'    				=> trim($this->request->getVar('alt_tag')),
				'description'    	=> trim($this->request->getVar('description')),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'page_title' 			=> trim($this->request->getVar('page_title')),
				'meta_keywords'    		=> trim($this->request->getVar('meta_keywords')),
				'meta_description' 		=> trim($this->request->getVar('meta_description')),
				'updated_date'     		=> date('Y-m-d'),
				'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('home_banner', $this->data, $cond) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/home_banner'));
			}
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
		
		if((bool)$this->model->deleteRecord('home_banner', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/home_banner'));
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
		
		if((bool)$this->model->updateRecord('home_banner', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/home_banner'));
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
		
		if((bool)$this->model->updateRecord('home_banner', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/home_banner'));
		}
	}
	
	public function delete_logo_image($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cat_id = base64_decode($id);
		$cond = array('id'=>$cat_id);
		$mediatData = $this->model->getRows('home_banner', '*', $cond); 
		$this->data = array(
		    'banner_images' => '', 
		);
		if((bool)$this->model->updateRecord('home_banner', $this->data, $cond) === TRUE)
		{
		    if(file_exists('uploads/home/banner_images/'.$mediatData[0]['banner_images'])){
                unlink('uploads/home/banner_images/'.$mediatData[0]['banner_images']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/home_banner/edit/'.$id));
		}
	} 
	
	public function validation()
	{
		return $this->validate([
					
			
			'name' => [
				'label'  => 'title',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Title can not be empty.'
				]
			]
		]); 
	}


	

}
