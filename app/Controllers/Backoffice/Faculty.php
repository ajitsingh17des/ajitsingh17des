<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\FacultyModel;
/*
Class Name : Faculty
Description : Used for faculty section in Backoffice
Written By: DEV-17121986
Created At: 09 Oct 2021  

*/
class Faculty extends BaseController
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
		$this->activedata['submenu'] = 18;
		$this->permission = $this->session->get('admin_permission')[18];
	}
	
	public function index()
	{			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}		
		$this->data['faculty_data'] = $this->model->getRows(
			'faculty', 
			'*', 
			array('faculty_delete_status'=>'Active'), 
			'faculty_display_order', 
			'ASC'
		);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/faculty/faculty_view', ['faculty_data'=>$this->data['faculty_data'],'permission_data'=> $this->permission]);
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
			$maxdata = $this->model->getRows('faculty', 'max(faculty_display_order) as faculty_display_order', '', 'faculty_display_order', 'ASC');
			//$this->data['campus'] = $this->model->getRows('campus','campus_id,campus_name',array('campus_delete_status'=>'Active','campus_status'=>1));
			$campus_type  = $this->model->getRows('campus', 'campus_id,campus_name', array('campus_status'=>"1",'campus_delete_status'=>'Active'), 'campus_display_order', 'ASC');
			$this->data['department'] = $this->model->getRows('department','department_id,department_name',array('department_delete_status'=>'Active','department_status'=>1));
			$this->data['faculty_type'] = $this->model->getRows('faculty_type','faculty_type_id,faculty_type_name',array('faculty_type_delete_status'=>'Active','faculty_type_status'=>1));
			$this->data['designation'] = $this->model->getRows('designation','designation_id,designation_name',array('designation_delete_status'=>'Active','designation_status'=>1));
			$act = base_url('backoffice/faculty/save_faculty');
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_faculty',['act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation,'data'=>$this->data,'campus_type'=>$campus_type]);
			echo view('backoffice/template/includes/footer');
		}else{
			return redirect()->to(base_url());
		}	
	}

	public function save_faculty(){
		if($this->faculty_validate()){
			$adminData = $this->session->get('admin_data');
			$string = strtolower($this->request->getVar('faculty_name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			$faculty_img = $this->request->getFile('faculty_image');
			$faculty_img_error = $faculty_img->getError();
			if(empty($faculty_img_error)){
				$image = $faculty_img->getRandomName();
				$faculty_img->move(ROOTPATH . 'uploads/faculty_images/',$image);
			}else{
				$image = '';
			}
			$this->data = array(
				'faculty_name'      => $this->request->getVar('faculty_name'),
				'faculty_slug' => $slug,
				'department_id' => $this->request->getVar('department_id'),
				//'faculty_type_id' => implode(',',$this->request->getVar('faculty_type_id')),
				'campus_id' => implode(',',$this->request->getVar('campus')),
				'designation_id' => implode(',',$this->request->getVar('designation_id')),
				'faculty_image' => $image,
				'short_description' => $this->request->getVar('short_description'),
				//'description' => $this->request->getVar('description'),
				'emp_code' => $this->request->getVar('emp_code'),
				'name_of_journal' => $this->request->getVar('name_of_journal'),
				'faculty_status'         => $this->request->getVar('status'),
				
				'education'         => $this->request->getVar('education'),
				'experience'         => $this->request->getVar('experience'),
				'research'         => $this->request->getVar('research'),
				'conference'         => $this->request->getVar('conference'),
				'achievement'         => $this->request->getVar('achievement'),
				'publication'         => $this->request->getVar('publication'),
				'linkedin'         => $this->request->getVar('linkedin'),
				'email'         => $this->request->getVar('email'),
				
				
				'faculty_display_order'  => $this->request->getVar('display_order'),
				'created_date'   => date('Y-m-d H:i:s'),
				'created_by'     => $adminData->id
			);
			
			if((bool)$this->model->saveData('faculty', $this->data) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty'));
			}
			else
			{
							
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty/add'));
			}
		}else{
			return $this->add();
		}
	}


	public function faculty_validate()
	{ 
		return $this->validate([
			'faculty_name' => [
				'label'  => 'Faculty Type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Faculty Name can not be empty.'
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
			$cond = array('faculty_id'=>base64_decode($id),'faculty_delete_status'=> 'Active');
			$this->data['faculty'] = $this->model->getRows('faculty', '*', $cond);

		//	$this->data['campus'] = $this->model->getRows('campus','campus_id,campus_name',array('campus_delete_status'=>'Active','campus_status'=>1));
			$campus_type  = $this->model->getRows('campus', 'campus_id,campus_name', array('campus_status'=>"1",'campus_delete_status'=>'Active'), 'campus_display_order', 'ASC');
			

			$this->data['department'] = $this->model->getRows('department','department_id,department_name',array('department_delete_status'=>'Active','department_status'=>1));

			$this->data['faculty_type'] = $this->model->getRows('faculty_type','faculty_type_id,faculty_type_name',array('faculty_type_delete_status'=>'Active','faculty_type_status'=>1));

			$this->data['designation'] = $this->model->getRows('designation','designation_id,designation_name',array('designation_delete_status'=>'Active','designation_status'=>1));	

			$act = base_url('backoffice/faculty/update/'.$id);
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/faculty/add_faculty',['act'=>$act,'validation'=>$this->validation,'data'=> $this->data,'campus_type'=>$campus_type]);
			echo view('backoffice/template/includes/footer');
		}else{
			return redirect()->to(base_url('backoffice/login'));
		}	
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('faculty_id'=>base64_decode($id));
		if($this->faculty_validate())
		{
		
			$faculty_img = $this->request->getFile('faculty_image');
			$faculty_img_error = $faculty_img->getError();
			if(empty($faculty_img_error)){
				$image = $faculty_img->getRandomName();
				$faculty_img->move(ROOTPATH . 'uploads/faculty_images/',$image);
			}else{
				$image = $this->request->getVar('old_faculty_image');
			}
			$slug = $this->model->getRows('faculty', 'faculty_slug', $cond);
			$this->data = array(
				'faculty_name'      => $this->request->getVar('faculty_name'),
				'faculty_slug' => $slug[0]['faculty_slug'],
				'department_id' => $this->request->getVar('department_id'),
				//'faculty_type_id' => implode(',',$this->request->getVar('faculty_type_id')),
				'campus_id' => implode(',',$this->request->getVar('campus')),
				'designation_id' => implode(',',$this->request->getVar('designation_id')),
				'faculty_image' => $image,
				'emp_code' => $this->request->getVar('emp_code'),
				'name_of_journal' => $this->request->getVar('name_of_journal'),
				'short_description' => $this->request->getVar('short_description'),
				//'description' => $this->request->getVar('description'),
				'faculty_status'         => $this->request->getVar('status'),
				
				'education'         => $this->request->getVar('education'),
				'experience'         => $this->request->getVar('experience'),
				'research'         => $this->request->getVar('research'),
				'conference'         => $this->request->getVar('conference'),
				'achievement'         => $this->request->getVar('achievement'),
				'publication'         => $this->request->getVar('publication'),
				'linkedin'         => $this->request->getVar('linkedin'),
				'email'         => $this->request->getVar('email'),
				
				
				'faculty_display_order'  => $this->request->getVar('display_order'),
				'updated_date'           => date('Y-m-d H:i:s'),
				'updated_by'             => $adminData->id
			);
				
			if((bool)$this->model->updateRecord('faculty', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty'));
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
			$cond = array('faculty_id'=>$id);
			$this->data = array(
			'faculty_status' => "1"	
			);
			
			if((bool)$this->model->updateRecord('faculty', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty'));
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
			$cond = array('faculty_id'=>$id);
			$this->data = array(
			'faculty_status' => "0"
			);
			
			if((bool)$this->model->updateRecord('faculty', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty'));
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
			$cond = array('faculty_id'=>$id);
			
			if((bool)$this->model->updateRecord('faculty',array('faculty_delete_status'=>"Deleted"), $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}

	public function delete_faculty_image($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		if($this->permission['edit'] == 1){
			$id = base64_decode($id);
			$cond = array('faculty_id'=>$id);
			$fData = $this->model->getRows('faculty', 'faculty_image', $cond);
			if((bool)$this->model->updateRecord('faculty',array('faculty_image'=>""), $cond) === TRUE)
			{
				if(file_exists('uploads/faculty_images/'.$fData[0]['faculty_image'])){
	                unlink('uploads/faculty_images/'.$fData[0]['faculty_image']);
	            }
				$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/faculty'));
			}
		}else{
			return redirect()->to(base_url());
		}
	}
	
	
}
