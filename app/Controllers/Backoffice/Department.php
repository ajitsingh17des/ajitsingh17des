<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
/*
Class Name : Department
Description : Used for Department section in Backoffice
Written By: DEV-17121986
Created At: 09 Oct 2021
*/
class Department extends BaseController
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
		$this->activedata['submenu'] = 15;
		$this->permission = $this->session->get('admin_permission')[15];
	}	

	public function index()
	{			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['department_data'] = $this->model->getRows('department','*','','display_order','ASC');
		$i=0; 
		foreach($this->data['department_data'] as $data)
		{
		  $college_id = $data['college_id'];		
		  $collegeData = $this->model->getRowArray('college','name',array('id'=>$college_id));
		  $this->data['department_data'][$i]['college_name'] = $collegeData['name'];
		  $i++; 
		}
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/faculty/department_view',['department_data'=>$this->data['department_data'],'permission_data'=> $this->permission]);
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
			$maxdata = $this->model->getRowArray('department', 'max(display_order) as total_order', '');
			$college  = $this->model->getRows('college', 'id,name',array('status'=>1),'display_order','ASC');
			$act = base_url('backoffice/department/save_department');
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_department',['act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation,'college'=>$college]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			return redirect()->to(base_url());
		}
	}

	public function save_department(){
		if($this->department_validate()){
			$current_user_id = $this->session->get('admin_login_id');
			$string = strtolower($this->request->getVar('department_name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			if($this->request->getFile('image')!=''){
				$avatar = $this->request->getFile('image');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/department_image/',$file_name);
				}	
			}		
			$this->data = array(
				'department_name'      => $this->request->getVar('department_name'),
				'slug'       		   => trim($slug),
				'college_id'           => $this->request->getVar('college_id'),
				'display_order'        => $this->request->getVar('display_order'),
				'status'               => $this->request->getVar('status'),
				'banner_tag_line'      => $this->request->getVar('banner_tag_line'),
				'short_code'           => $this->request->getVar('short_code'),
				'show_on_home_page'    => $this->request->getVar('show_on_home_page'),
				'image'                => $file_name,			
				'created_date'         => date('Y-m-d H:i:s'),
				'created_by'           => $current_user_id
			);
			
			if((bool)$this->model->saveRecord('department',$this->data) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/department'));
			}
			else
			{
							
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/department/add'));
			}
		}else{
			return $this->add();
		}
	}

	public function department_validate($id='')
	{ 	
	    if($id)
		{
		  $validation = $this->validate([
			'department_name' => [
				'label'  => 'department Name',
				
				'rules'  => 'required|is_unique[department.department_name,department_id,'.$id.']',
				'errors' => [
					'required' => 'department name can not be empty.'
				]
			],'college_id' => [
				'label'  => 'College',
				'rules'  => 'required',
				'errors' => [
					'required' => 'College name can not be empty.'
				]
			]
		]); 
		}else{
			$validation = $this->validate([
			'department_name' => [
				'label'  => 'department Name',
				'rules'  => 'required|is_unique[department.department_name]',
				'errors' => [
					'required' => 'department name can not be empty.'
				]
			],'college_id' => [
				'label'  => 'College',
				'rules'  => 'required',
				'errors' => [
					'required' => 'College name can not be empty.'
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
		if($this->permission['edit'] == 1){
			$cond = array('department_id'=>$id);
			$college  = $this->model->getRows('college', 'id,name',array('status'=>1),'display_order', 'ASC');
			$this->data = $this->model->getRowArray('department','*',$cond);		
			$act = base_url('backoffice/department/update/'.$id);
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_department',['act'=>$act,'validation'=>$this->validation,'departmentData'=>$this->data,'college'=>$college]);
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
		$cond = array('department_id'=>$id);
		if($this->department_validate($id))
		{
		    if($this->request->getFile('image')!='')
		    {
				$avatar = $this->request->getFile('image');
				$error = $avatar->getError();
				if(!$error)
				{   $oldImg = $this->request->getVar('OldImage');
					if(file_exists('uploads/department_image/'.$oldImg) && $oldImg!=''){
			             unlink('uploads/department_image/'.$oldImg);
			         }
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/department_image/',$file_name);
				}	
			}
			else
			{
				$file_name = $this->request->getVar('OldImage');
			}
			$this->data = array(
				'department_name'    => $this->request->getVar('department_name'),
				'college_id'         => $this->request->getVar('college_id'),
				'display_order'      => $this->request->getVar('display_order'),
				'status'             => $this->request->getVar('status'),
				'banner_tag_line'    => $this->request->getVar('banner_tag_line'),
				'short_code'         => $this->request->getVar('short_code'),
				'show_on_home_page'  => $this->request->getVar('show_on_home_page'),
				'image'              => $file_name,				
				);
				
			if((bool)$this->model->updateRecord('department', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/department'));
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
			$cond = array('department_id'=>$id);
			$this->data = array('status'=>1);			
			if((bool)$this->model->updateRecord('department', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/department'));
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
			$cond = array('department_id'=>$id);
			$this->data = array('status'=>0);			
			if((bool)$this->model->updateRecord('department', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record deacivate successfully!','msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/department'));
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
			$cond = array('department_id'=>$id);
			$get_data = $this->model->getRowArray('department','*',$cond);			
			if((bool)$this->model->deleteRecord('department',$cond) === TRUE)
			{
				if(file_exists('uploads/department_image/'.$get_data['image']))
				{
			      unlink('uploads/department_image/'.$get_data['image']);
			    }
				$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/department'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}	

	public function delete_logo_image($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('department_id'=>$id);
		$mediatData = $this->model->getRowArray('department','*',$cond); 
		$this->data = array('image'=>'');
		if((bool)$this->model->updateRecord('department',$this->data,$cond) === TRUE)
		{
		    if(file_exists('uploads/department_image/'.$mediatData['image'])){
                unlink('uploads/department_image/'.$mediatData['image']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/department/edit/'.$id));
		}
	} 
	
}
