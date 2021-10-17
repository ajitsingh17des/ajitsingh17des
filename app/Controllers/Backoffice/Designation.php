<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
/*
Class Name : designation
Description : Used for designation section in Backoffice
Written By: DEV-17121986
Created At: 09 Oct 2021
*/
class Designation extends BaseController
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
		$this->activedata['menu'] = 2;
		$this->activedata['submenu'] = 16;
		$this->permission = $this->session->get('admin_permission')[16];
	}
	
	public function index()
	{			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}		
		$designation_data = $this->model->getRows('designation','*','','display_order','ASC');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/faculty/designation_view', ['designation_data'=>$designation_data,'permission_data'=> $this->permission]);
		echo view('backoffice/template/includes/footer');		
	}
	
	public function add()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->permission['add'] == 1){
			$this->maxdata = $this->model->getRowArray('designation', 'max(display_order) as total_order', '');
			$act = base_url('backoffice/designation/save_designation');
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_designation',['act'=>$act,'maxdata'=>$this->maxdata,'validation'=>$this->validation]);
			echo view('backoffice/template/includes/footer');	
		}else{
			return redirect()->to(base_url());
		}
	}

	public function save_designation(){
		if($this->designation_validate()){
			$adminData = $this->session->get('admin_login_id');
			$this->data = array(
				'designation_name'      => $this->request->getVar('designation_name'),
				'display_order'  => $this->request->getVar('display_order'),
				'status'         => $this->request->getVar('status'),
				'created_date'   => date('Y-m-d H:i:s'),
				'created_by'     => $current_user_id
			);
			
			if((bool)$this->model->saveRecord('designation', $this->data) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/designation'));
			}
			else
			{
							
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/designation/add'));
			}
		}else{
			return $this->add();
		}
	}


	public function designation_validate()
	{ 
		return $this->validate([
			'designation_name' => [
				'label'  => 'designation Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'designation name can not be empty.'
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
			$cond = array('designation_id'=>$id);
			$this->data = $this->model->getRowArray('designation','*',$cond);		
			$act = base_url('backoffice/designation/update/'.$id);
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_designation',['act'=>$act,'validation'=>$this->validation,'designationData'=>$this->data]);
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
		$cond = array('designation_id'=>$id);
		if($this->designation_validate())
		{
			$this->data = array(
					'designation_name'      => $this->request->getVar('designation_name'),
					'display_order'  => $this->request->getVar('display_order'),
					'status'         => $this->request->getVar('status')
				);
				
			if((bool)$this->model->updateRecord('designation', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/designation'));
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
			$cond = array('designation_id'=>$id);
			$this->data = array('status'=>1);			
			if((bool)$this->model->updateRecord('designation',$this->data,$cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/designation'));
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
			$cond = array('designation_id'=>$id);
			$this->data = array('status'=>"0");			
			if((bool)$this->model->updateRecord('designation',$this->data,$cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record deacivate successfully!','msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/designation'));
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
			$cond = array('designation_id'=>$id);
			
			if((bool)$this->model->deleteRecord('designation',$cond)=== TRUE)
			{
				$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/designation'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}
	
	
}
