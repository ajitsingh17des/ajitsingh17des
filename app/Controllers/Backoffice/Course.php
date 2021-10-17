<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
/*
Class Name : Course
Description : Used for  Vijayawada courses in Backoffice
Written By: DEV-11091994
Created At: 11 oct 2021 

START HERE
*/
class Course extends BaseController
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
		$this->activedata['submenu'] = 24;
		$this->permission = $this->session->get('admin_permission')[24];		
	}

	public function index()
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['listing_data'] = $this->model->getRows('course','*','','display_order','ASC');
		$i=0; foreach($this->data['listing_data'] as $data)
		{
			$program_id = $data['program_id'];
			$department_id = $data['department_id'];
			$college_id = $data['college_id'];
		
			$program = $this->model->getRows('program','name',array('id'=>$program_id));
			$this->data['listing_data'][$i]['program_name'] = $program[0]['name'];
			
			$department = $this->model->getRows('department','department_name',array('department_id'=>$department_id));
			$this->data['listing_data'][$i]['department_name'] = $department[0]['department_name'];
			
			$college = $this->model->getRows('college','name',array('id'=>$college_id));
			$this->data['listing_data'][$i]['college_name'] = $college[0]['name'];
		$i++; }
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/course/course_view', ['listing_data'=>$this->data['listing_data'],'permission_data'=> $this->permission]);
		echo view('backoffice/template/includes/footer');
	 }
	 
	 
	public function department_dropdown()
	{	
		 $id				=	$_POST['current_id'];
		$str			=	'';
		$department 	= $this->model->getRows('department', 'department_id,department_name', array('department_delete_status'=>'Active','department_status'=>1,'college_id'=>$id),'department_display_order','ASC');
		//print_r($department);
		$str	.=		'<select class="form-control m_selectpicker" name="department_id" id="department_id"><option value="">Please Select</option>';
			if($department){ foreach($department as $type){
		$str	.=		'<option value="'.$type['department_id'].'">'.$type['department_name'].'</option>';
			}}
		$str	.=		'</select>';	
		echo json_encode(array('dropdown'=>$str));
	}
	 
	 
	
	public function add()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$maxdata 				= $this->model->getRows('course', 'max(display_order) as display_order', '', 'display_order', 'ASC');
		$data['college'] 		= $this->model->getRows('college', 'id,name', array('delete_status'=>'Active','status'=>1), 
			'display_order','ASC');
		$data['program'] 		= $this->model->getRows('program', 'id,name', array('delete_status'=>'Active','status'=>1), 
		'display_order','ASC');
		$data['department'] 	= $this->model->getRows('department', 'department_id,department_name', array('department_delete_status'=>'Active','department_status'=>1),'department_display_order','ASC');
		$act 			= base_url('backoffice/course/save');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/course/add_course',['type_data'=>$data,'act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation]);
		echo view('backoffice/template/includes/footer');	
	}

	public function save(){
		if($this->campus_validate()){
			$adminData = $this->session->get('admin_data');
			if($this->request->getFile('course_image')!=''){
				$avatar1 = $this->request->getFile('course_image');
				$error1 = $avatar1->getError();
				if(!$error1)
				{
					$file_name1 = $avatar1->getRandomName();
					$avatar1->move(ROOTPATH . 'uploads/course/',$file_name1);
				}	
			}
			$this->data = array(
				'department_id'  	 	=> $this->request->getVar('department_id'),
				'program_id'      		=> $this->request->getVar('program_id'),
				'college_id'      		=> $this->request->getVar('college_id'),
				'course_name'      		=> $this->request->getVar('course_name'),
				'course_slug'      		=> $this->request->getVar('course_slug'),
				'course_image'       	=> trim($file_name1),
				'duration'      		=> $this->request->getVar('duration'),
				'semester'      		=> $this->request->getVar('semester'),
				'overview'      		=> $this->request->getVar('overview'),
				'eligibility'      		=> $this->request->getVar('eligibility'),
				'objective'      		=> $this->request->getVar('objective'),
				'outcome'     			=> $this->request->getVar('outcome'),
				'opportunities'      	=> $this->request->getVar('opportunities'),
				'display_order'  		=> $this->request->getVar('display_order'),
				'status'         		=> $this->request->getVar('status'),
				'page_title' 			=> trim($this->request->getVar('page_title')),
				'meta_keywords'   		=> trim($this->request->getVar('meta_keywords')),
				'meta_description' 		=> trim($this->request->getVar('meta_description')),
				'created_date'   		=> date('Y-m-d H:i:s'),
				'created_by'     		=> $adminData->id
			);
			
			if((bool)$this->model->saveData('course', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/course'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/course/add'));
			}
		}else{
			return $this->add();
		}
	}


	public function campus_validate()
	{ 
		return $this->validate([
			'department_id' => [
				'label'  => ' department_id',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Department can not be empty.'
				]
			],'program_id' => [
				'label'  => 'program_id',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Program can not be empty.'
				]
			],'college_id' => [
				'label'  => 'college_id',
				'rules'  => 'required',
				'errors' => [
					'required' => 'college can not be empty.'
				]
			],'course_name' => [
				'label'  => 'course_name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'course can not be empty.'
				]
			],'course_slug' => [
				'label'  => 'course_slug',
				'rules'  => 'required',
				'errors' => [
					'required' => 'course URL can not be empty.'
				]
			]
		]); 
	}	
	
	
	
	public function semester_validate()
	{ 
		return $this->validate([
			'select_sem' => [
				'label'  => 'select_sem',
				'rules'  => 'required',
				'errors' => [
					'required' => 'semester can not be empty.'
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
		
		$cond = array('id'=>($id),'delete_status'=> 'Active','status'=>1);
		$this->data = $this->model->getRows('course', '*', $cond);
		$college_id	=	$this->data[0]['college_id'];
		$data['college'] 		= $this->model->getRows('college', 'id,name', array('delete_status'=>'Active','status'=>1), 
			'display_order','ASC');
		$data['program'] 		= $this->model->getRows('program', 'id,name', array('delete_status'=>'Active','status'=>1), 
		'display_order','ASC');
		$department 	= $this->model->getRows('department', 'department_id,department_name', array('department_delete_status'=>'Active','department_status'=>1,'college_id'=>$college_id),'department_display_order','ASC');
		
				
		$act = base_url('backoffice/course/update/'.$id);
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/course/add_course',['department'=>$department,'type_data'=>$data,'act'=>$act,'validation'=>$this->validation,'editData'=>$this->data]);
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
		if($this->campus_validate())
		{
			if($this->request->getFile('course_image')!='')
					{ 
						$avatar1 = $this->request->getFile('course_image');
						$error1 = $avatar1->getError();
						if(!$error1)
						{
							$file_name1 = $avatar1->getRandomName();
							$avatar1->move(ROOTPATH . 'uploads/course/',$file_name1);
						}
			}else{
				$file_name1 = $this->request->getVar('OldcourseImage');
			}
			$this->data = array(
				'department_id'  		=> $this->request->getVar('department_id'),
				'program_id'      		=> $this->request->getVar('program_id'),
				'college_id'      		=> $this->request->getVar('college_id'),
				'course_name'      		=> $this->request->getVar('course_name'),
				'course_slug'      		=> $this->request->getVar('course_slug'),
				'course_image'       	=> trim($file_name1),
				'duration'      		=> $this->request->getVar('duration'),
				'semester'      		=> $this->request->getVar('semester'),
				'overview'      		=> $this->request->getVar('overview'),
				'eligibility'      		=> $this->request->getVar('eligibility'),
				'objective'      		=> $this->request->getVar('objective'),
				'outcome'     			=> $this->request->getVar('outcome'),
				'opportunities'      	=> $this->request->getVar('opportunities'),
				'display_order'  		=> $this->request->getVar('display_order'),
				'status'         		=> $this->request->getVar('status'),
				'page_title' 			=> trim($this->request->getVar('page_title')),
				'meta_keywords'   		=> trim($this->request->getVar('meta_keywords')),
				'meta_description' 		=> trim($this->request->getVar('meta_description')),
				'updated_date'  		=> date('Y-m-d H:i:s'),
				'updated_by'     		=> $adminData->id
				);
				
			if((bool)$this->model->updateRecord('course', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/course'));
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
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('course', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/course'));
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
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('course', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/course'));
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
		
		if((bool)$this->model->updateRecord('course',array('delete_status'=>"Deleted"), $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/course'));
		}
	}
	
	public function delete_image($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cat_id = $id;
		$cond = array('id'=>$cat_id);
		$mediatData = $this->model->getRows('course', '*', $cond); 
		$this->data = array(
		    'course_image' => '', 
		);
		if((bool)$this->model->updateRecord('course', $this->data, $cond) === TRUE)
		{
		    if(file_exists('uploads/course/'.$mediatData[0]['course_image'])){
                unlink('uploads/course/'.$mediatData[0]['course_image']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/course/edit/'.$id));
		}
	} 
	
	
	
	
	
	public function map_semester($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		
		$cond = array('id'=>($id),'delete_status'=> 'Active','status'=>1);
		$this->data = $this->model->getRows('course', '*', $cond);
		 $semester=	$this->data[0]['semester'];
		$semAllData = $this->model->getRows('course_semester', '*', array('course_id'=>$id));
		
		 $c_semCount	=	count($semAllData);
		 
		if($semester<=$c_semCount){
			$show	=	'display:none';
		}else{
			$show	=	'display:block';
		}
				
		$act = base_url('backoffice/course/update_semester/'.$id);
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/course/map_semester',['show'=>$show,'semAllData'=>$semAllData,'editData'=>$this->data,'act'=>$act,'validation'=>$this->validation]);
		echo view('backoffice/template/includes/footer');	
	}
	
	
	
	
	
	public function update_semester($id='')
	{
		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		
		$adminData = $this->session->get('admin_data');
		
		$cond = array('id'=>($id),'delete_status'=> 'Active','status'=>1);
		$this->data = $this->model->getRows('course', '*', $cond);	
		//print_r($this->data);
		$act = base_url('backoffice/course/update_semester/'.$id);
		$maxdata 			= $this->model->getRows('course_semester', 'max(display_order) as display_order', '', 'display_order', 'ASC');
		if(!$this->semester_validate())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/course/add_semester',['id'=>$id,'maxdata'=>$maxdata,'editData'=>$this->data,'act'=>$act,'validation'=>$this->validation]);
			echo view('backoffice/template/includes/footer');	
		}
		else
		{
			$cond = array('course_id'=>($id),'status'=>1,'semester'=>$this->request->getVar('select_sem'));
			$check_data	 = $this->model->getRows('course_semester', '*', $cond);
			
			$this->data = array(
				'course_id'  			=> $id,
				'semester'      		=> $this->request->getVar('select_sem'),
				'sem_details'      		=> $this->request->getVar('sem_details'),
				'display_order'  		=> $this->request->getVar('display_order'),
				'status'         		=> $this->request->getVar('status'),
				'updated_date'  		=> date('Y-m-d H:i:s'),
				'updated_by'     		=> $adminData->id
				);
			if((bool)$this->model->saveData('course_semester', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/course/map_semester/'.$id));
			}
		
		} 
	} 
	
	
	
	public function sem_edit($c_id='',$id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		
		$cond1 = array('id'=>($c_id),'delete_status'=> 'Active','status'=>1);
		$this->data = $this->model->getRows('course', '*', $cond1);
		
		$activedata['active']	=1;
			
		$cond 			 = array('id'=>$id,'course_id'=>$c_id,'status'=>1);
		$editsemData	 = $this->model->getRows('course_semester', '*', $cond);
		$act = base_url('backoffice/course/save_semester/'.$c_id.'/'.$id);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/course/add_semester',['editData'=>$this->data,'editsemData'=>$editsemData,'maxdata'=>$maxdata,'editData'=>$this->data,'act'=>$act,'validation'=>$this->validation]);
		echo view('backoffice/template/includes/footer');	
		
	}
	
	
	public function save_semester($c_id='',$id='')
	{
		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		
		$adminData = $this->session->get('admin_data');
		
		$cond = array('id'=>($id),'delete_status'=> 'Active','status'=>1);
		$this->data = $this->model->getRows('course', '*', $cond);	
		//print_r($this->data);
		$act = base_url('backoffice/course/update_semester/'.$id);
		$maxdata 			= $this->model->getRows('course_semester', 'max(display_order) as display_order', '', 'display_order', 'ASC');
		if(!$this->semester_validate())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/course/add_semester',['maxdata'=>$maxdata,'editData'=>$this->data,'act'=>$act,'validation'=>$this->validation]);
			echo view('backoffice/template/includes/footer');	
		}
		else
		{
			$cond_sem = array('id'=>$id,'course_id'=>$c_id);
			
			$this->data = array(
				'course_id'  			=> $c_id,
				'semester'      		=> $this->request->getVar('select_sem'),
				'sem_details'      		=> $this->request->getVar('sem_details'),
				'display_order'  		=> $this->request->getVar('display_order'),
				'status'         		=> $this->request->getVar('status'),
				'updated_date'  		=> date('Y-m-d H:i:s'),
				'updated_by'     		=> $adminData->id
				);
			//echo "<pre>";	print_r($this->data); die();
				if((bool)$this->model->updateRecord('course_semester', $this->data, $cond_sem) === TRUE)
				{				
					$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
					$this->session->setFlashdata($this->msg);
					return redirect()->to(base_url('backoffice/course/map_semester/'.$c_id));
				}
		
		} 
	} 
	
	
	public function sem_active($c_id='',$id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$id = ($id);
		$cond = array('id'=>$id,'course_id'=>$c_id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('course_semester', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/course/map_semester/'.$c_id));
		}
	}
	
	
    public function sem_deactive($c_id='',$id=''){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$id = ($id);
		$cond = array('id'=>$id,'course_id'=>$c_id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('course_semester', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/course/map_semester/'.$c_id));
		}
	}
	
	/*
	
Class Name : Course
Description : Used for  Vijayawada courses in Backoffice
Written By: DEV-11091994
Created At: 11 oct 2021 
Updated At: 12 oct 2021 
Created By: DEV-11091994

END HERE
*/
}
