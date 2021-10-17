<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Event_type extends BaseController
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
		$this->activedata['submenu'] = 12;
	} 
	
	
/************************code Written By  11091994 start here********************/	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		
		$this->data = $this->model->getRows('event_type', '', '', 'display_order', 'ASC');
		
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/event_type/event_type_view', ['courseCatData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/event_type/event_type_view');
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
		
		
		$this->maxdata = $this->model->getRows('event_type', 'max(display_order) as display_order', '', 'display_order', 'ASC');
	
		if (!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/event_type/add_event_type', ['validation' => $this->validation,'maxData'=> $this->maxdata]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			
			$string = strtolower($this->request->getVar('name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			
			
			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('name')),
				'slug'       			=> trim($slug),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'created_date'     		=> date('Y-m-d'),
				'created_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->saveRecord('event_type', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/event_type'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/event_type/add'));
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
		$this->data = $this->model->getRows('event_type', '*', $cond, 'display_order', 'ASC');	
		$act = base_url('backoffice/event_type/update/'.$id);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/event_type/add_event_type', ['CourseCategoryData'=>$this->data,'act'=> $act]);
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
			echo view('backoffice/event_type/add_event_type', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{  
	
			$categorySlug = $this->model->getRows('event_type', 'slug', $cond, 'display_order', 'ASC');	
			$slug		 =  $categorySlug[0]['slug'];
			
			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('name')),
				'slug'       			=> trim($slug),
				'status'     			=> trim($this->request->getVar('status')),
			    'updated_date'     		=> date('Y-m-d'),
				'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('event_type', $this->data, $cond) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/event_type'));
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
		
		if((bool)$this->model->deleteRecord('event_type', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/event_type'));
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
		
		if((bool)$this->model->updateRecord('event_type', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/event_type'));
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
		
		if((bool)$this->model->updateRecord('event_type', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/event_type'));
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

/************************code Written By  11091994 end here********************/
	

}
