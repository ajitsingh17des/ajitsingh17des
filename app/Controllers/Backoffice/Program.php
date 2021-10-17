<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
/*
Class Name : Program
Description : Used for Program Type for course program in Backoffice
Written By: DEV-11091994
Created At: 09 Oct 2021 

START HERE
*/
class Program extends BaseController
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
		$this->activedata['menu'] = 12;
		$this->activedata['submenu'] = 23;
		$this->permission = $this->session->get('admin_permission')[23];
	}

	public function index()
	{			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['listing_data'] = $this->model->getRows('program','*','','display_order','ASC');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/program/program_view',['listing_data'=>$this->data['listing_data'],'permission_data'=> $this->permission]);
		echo view('backoffice/template/includes/footer');
	}
	
	public function add()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$maxdata = $this->model->getRowArray('program','max(display_order) as display_order');
		$act = base_url('backoffice/program/save');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/program/add_program',['act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation]);
		echo view('backoffice/template/includes/footer');	
	}

	public function save(){
		if($this->campus_validate()){
			$current_user_id = $this->session->get('admin_login_id');			
			$string = strtolower($this->request->getVar('name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			
			$this->data = array(
				'name'           => $this->request->getVar('name'),
				'slug'       	 => trim($slug),
				'display_order'  => $this->request->getVar('display_order'),
				'status'         => $this->request->getVar('status'),
				'created_date'   => date('Y-m-d H:i:s'),
				'created_by'     => $current_user_id
			);
			
			if((bool)$this->model->saveRecord('program',$this->data) === TRUE)
			{				
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/program'));
			}
			else
			{							
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/program/add'));
			}
		}else{
			return $this->add();
		}
	}


	public function campus_validate($id='')
	{ 
	
	if($id)
		{
		$validation = $this->validate([
			'name' => [
				'label'  => ' Name',
				'rules'  => 'required|is_unique[program.name,id,'.$id.']',
				'errors' => [
					'required' => ' Name can not be empty.'
				]
			]
		]);
		}else{
			$validation = $this->validate([
			'name' => [
				'label'  => ' Name',
				'rules'  => 'required|is_unique[program.name]',
				'errors' => [
					'required' => ' Name can not be empty.'
				]
			]
		]);
		}
		return $validation;		
			
	}	
	public function edit($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}		
		$cond = array('id'=>$id);
		$this->data = $this->model->getRowArray('program', '*',$cond);		
		$act = base_url('backoffice/program/update/'.$id);
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/program/add_program',['act'=>$act,'validation'=>$this->validation,'editData'=>$this->data]);
		echo view('backoffice/template/includes/footer');	
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('id'=>($id));
		$adminData = $this->session->get('admin_data');
		$categorySlug = $this->model->getRows('program', 'slug', $cond, 'display_order', 'ASC');	
			$slug		 =  $categorySlug[0]['slug'];
		if($this->campus_validate($id))
		{
			$this->data = array(
				    'name'           => $this->request->getVar('name'),
					'slug'       	 => trim($slug),
					'display_order'  => $this->request->getVar('display_order'),
					'status'         => $this->request->getVar('status'),
					'updated_date'   => date('Y-m-d H:i:s'),
					'updated_by'     => $adminData->id
				);
				
			if((bool)$this->model->updateRecord('program', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/program'));
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
		
		$id = ($id);
		$cond = array('id'=>$id);
		$this->data = array(
		'status' => "1"	
		);
		
		if((bool)$this->model->updateRecord('program', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/program'));
		}
	}
	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$id = ($id);
		$cond = array('id'=>$id);
		$this->data = array(
		'status' => "0"
		);
		
		if((bool)$this->model->updateRecord('program', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/program'));
		}
	}

	
	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$id = ($id);
		$cond = array('id'=>$id);
		
		if((bool)$this->model->updateRecord('program',array('delete_status'=>"Deleted"), $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/program'));
		}
	}
	
/*
Class Name : program
Description : Used for program Type for course program in Backoffice
Written By: DEV-11091994
Created At: 09 Oct 2021 

END HERE
*/
}
