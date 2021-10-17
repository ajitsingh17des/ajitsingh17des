<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\FacultyModel;
/*
Class Name : Faculty_type
Description : Used for Faculty_type section in Backoffice
Written By: DEV-17121986
Created At: 09 Oct 2021  
*/
class Faculty_type extends BaseController
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
		$this->model = new FacultyModel();
		$this->activedata['menu'] = 9;
		$this->activedata['submenu'] = 15;
		$this->permission = $this->session->get('admin_permission')[15];
	}
	
	public function check()
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
	}

	public function index()
	{
			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->permission['view'] == 1){
			$this->data['faculty_type_data'] = $this->model->getRows(
				'faculty_type', 
				'*', 
				array('faculty_type_delete_status'=>'Active'), 
				'faculty_type_display_order', 
				'ASC'
			);
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/faculty_type_view', ['facultyType_data'=>$this->data['faculty_type_data'],'permission_data'=> $this->permission]);
			echo view('backoffice/template/includes/footer');
		}else{
			return redirect()->to(base_url());
		}
	   
		
	}
	
	public function add()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->permission['add'] == 1){
			$maxdata = $this->model->getRows('faculty_type', 'max(faculty_type_display_order) as faculty_type_display_order', '', 'faculty_type_display_order', 'ASC');
			$act = base_url('backoffice/faculty_type/save_faculty_type');
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_faculty_type',['act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation]);
			echo view('backoffice/template/includes/footer');
		}else{
			return redirect()->to(base_url());
		}	
	}

	public function save_faculty_type(){
		if($this->faculty_type_validate()){
			$adminData = $this->session->get('admin_data');
			$string = strtolower($this->request->getVar('faculty_type'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			$this->data = array(
				'faculty_type_name'      => $this->request->getVar('faculty_type'),
				'faculty_type_slug' => $slug,
				'faculty_type_display_order'  => $this->request->getVar('display_order'),
				'faculty_type_status'         => $this->request->getVar('status'),
				'created_date'   => date('Y-m-d H:i:s'),
				'created_by'     => $adminData->id
			);
			
			if((bool)$this->model->saveData('faculty_type', $this->data) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty_type'));
			}
			else
			{
							
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty_type/add'));
			}
		}else{
			return $this->add();
		}
	}


	public function faculty_type_validate()
	{ 
		return $this->validate([
			'faculty_type' => [
				'label'  => 'Faculty Type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Faculty Type can not be empty.'
				]
			],
			'display_order' => [
				'label'  => 'Display Order',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Display order can not be empty.'
				]
			]
		]); 
	}	
	public function edit($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->permission['edit'] == 1){
			$cond = array('faculty_type_id'=>base64_decode($id),'faculty_type_delete_status'=> 'Active');
			$this->data = $this->model->getRows('faculty_type', '*', $cond);		
			$act = base_url('backoffice/faculty_type/update/'.$id);
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_faculty_type',['act'=>$act,'validation'=>$this->validation,'facultyTypeData'=>$this->data]);
			echo view('backoffice/template/includes/footer');	
		}else{
			return redirect()->to(base_url());
		}
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('faculty_type_id'=>base64_decode($id));
		if($this->faculty_type_validate())
		{
			$adminData = $this->session->get('admin_data');
			$string = strtolower($this->request->getVar('faculty_type'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			$this->data = array(
					'faculty_type_name'      => $this->request->getVar('faculty_type'),
					'faculty_type_slug' => $slug,
					'faculty_type_display_order'  => $this->request->getVar('display_order'),
					'faculty_type_status'         => $this->request->getVar('status')
				);
				
			if((bool)$this->model->updateRecord('faculty_type', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty_type'));
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
		if($this->permission['edit'] == 1){
			$id = base64_decode($id);
			$cond = array('faculty_type_id'=>$id);
			$this->data = array(
			'faculty_type_status' => "1"	
			);
			
			if((bool)$this->model->updateRecord('faculty_type', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty_type'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}
	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		if($this->permission['edit'] == 1){
			$id = base64_decode($id);
			$cond = array('faculty_type_id'=>$id);
			$this->data = array(
			'faculty_type_status' => "0"
			);
			
			if((bool)$this->model->updateRecord('faculty_type', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty_type'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}

	
	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		if($this->permission['delete'] == 1){
			$id = base64_decode($id);
			$cond = array('faculty_type_id'=>$id);
			
			if((bool)$this->model->updateRecord('faculty_type',array('faculty_type_delete_status'=>"Deleted"), $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty_type'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}
	
	
}
