<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
/*
Class Name : School
Description : Used for School Type for in Backoffice
Written By: DEV-17121986
Created At: 09 Oct 2021 

START HERE
*/
class School extends BaseController
{
	public $session = null;
	public $data = null;
	public $validation = null;
	public $model = null;
	public $activedata = null;
	
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->validation =  \Config\Services::validation();
		helper(['form', 'url', 'validation']); 
		$this->model = new CommonModel();
		$this->activedata['menu'] = 2;
		$this->activedata['submenu'] = 17;
		$this->permission = $this->session->get('admin_permission')[17];
	}

	public function index()
	{			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['listing_data'] = $this->model->getRows('college','','','display_order','ASC');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/college/college_view', ['listing_data'=>$this->data['listing_data'],'permission_data'=> $this->permission]);
		echo view('backoffice/template/includes/footer');
	 }
	
	public function add()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$maxdata = $this->model->getRowArray('designation', 'max(display_order) as total_order', '');
		$act = base_url('backoffice/school/save');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/college/add_college',['act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation]);
		echo view('backoffice/template/includes/footer');	
	}
    
    public function save()
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}	
		$activedata['active'] = 4;
		$this->maxdata = $this->model->getRowArray('designation', 'max(display_order) as total_order', '');
		if(!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/college/add_college', ['validation' => $this->validation,'maxData'=> $this->maxdata]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			$string = strtolower($this->request->getVar('name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			$current_user_id = $this->session->get('admin_login_id');
			$this->data = array(
				'name'           => $this->request->getVar('name'),
				'slug'       	 => trim($slug),
				'display_order'  => $this->request->getVar('display_order'),
				'status'         => $this->request->getVar('status'),
				'created_date'   => date('Y-m-d H:i:s'),
				'created_by'     => $current_user_id
			);		
			
			if((bool)$this->model->saveRecord('college',$this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/school'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/school/add'));
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
		
		$cond = array('id'=>$id);
		$this->data = $this->model->getRowArray('college','*',$cond);		
		$act = base_url('backoffice/school/update/'.$id);
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/college/add_college',['act'=>$act,'validation'=>$this->validation,'editData'=>$this->data]);
		echo view('backoffice/template/includes/footer');	
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond         = array('id'=>$id);
		$adminData    = $this->session->get('admin_data');
		$categorySlug = $this->model->getRowArray('college', 'slug', $cond);	
		$slug		  =  $categorySlug['slug'];
		if($this->validation($id))
		{
			$this->data = array(
			    'name'           => $this->request->getVar('name'),
				'slug'       	 => trim($slug),
				'display_order'  => $this->request->getVar('display_order'),
				'status'         => $this->request->getVar('status'),
				'updated_date'   => date('Y-m-d H:i:s'),
				'updated_by'     => $adminData->id
			);
				
			if((bool)$this->model->updateRecord('college', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/school'));
			}
		}else{
			return $this->edit($id);
		}
		
	}

	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('id'=>$id);
		$this->data = array('status'=>1);
		
		if((bool)$this->model->updateRecord('college',$this->data,$cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/school'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cond = array('id'=>$id);
		$this->data = array('status'=>0);		
		if((bool)$this->model->updateRecord('college',$this->data,$cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/school'));
		}
	}
	
	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cond = array('id'=>$id);		
		if((bool)$this->model->deleteRecord('college',$cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/school'));
		}
	}

	private function validation($id=0)
	{
		if($id)
		{
		  $validation = $this->validate([            
			'name' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[college.name,id,'.$id.']',
				'errors' => [
					'required' => 'Name can not be empty.'
				]
			]
		  ]);	
		}
		else
		{
		  $validation = $this->validate([
			'name' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[college.name]',
				'errors' => [
					'required' => 'Name can not be empty.',
					'is_unique' => 'This Name is already used.'
				]
			]
		  ]);	
		}		
    return $validation;		
	}
	
/*
Class Name : School
Description : Used for School Type for in Backoffice
Written By: DEV-11091994
Created At: 01 Oct 2021 

END HERE
*/
}
