<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Home_page extends BaseController
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
		$this->activedata['submenu'] = 7;
	} 
	
	
	
	
	
	public function index($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		
	
		
		//$cat_id = base64_decode($id);
		$cat_id = 1;
		$cond = array('id'=>$cat_id);
		$this->data = $this->model->getRows('home_page', '*', $cond, 'display_order', 'ASC');	
		$act = base_url('backoffice/home_page/save');
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/home/about_home', ['CourseCategoryData'=>$this->data,'act'=> $act]);
		echo view('backoffice/template/includes/footer');
		
	}
	
	public function save($id='')
	{
		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		$current_user_id = $this->session->get('admin_login_id');
		
		
		//$cat_id = base64_decode($id);
		
		$cat_id = 1;
		$cond = array('id'=>$cat_id);
		
		if (!$this->validation())
		{
			
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/home/about_home', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{  
		    $homeData_check = $this->model->getRows('home_page', '', '', '', '');
			$this->data = array(
				'program_offered'    				=> trim($this->request->getVar('program_offered')),
				'student_development'       		=> trim($this->request->getVar('student_development')),
				'campus_life'       	            => trim($this->request->getVar('campus_life')),
				'research'    	                    => trim($this->request->getVar('research')),
				'happenings'     		            => trim($this->request->getVar('happenings')),
				'about_klu'    			            => trim($this->request->getVar('about_klu')),
				'status'    					    => trim($this->request->getVar('status')),
				'display_order'    				    => trim($this->request->getVar('display_order')),
				'page_title' 					    => trim($this->request->getVar('page_title')),
				'meta_keywords'    				    => trim($this->request->getVar('meta_keywords')),
				'meta_description' 				    => trim($this->request->getVar('meta_description')),
				'updated_date'     				    => date('Y-m-d'),
				'updated_by'      				    => $current_user_id
			);
		
			if($homeData_check){
			    
			    if((bool)$this->model->updateRecord('home_page', $this->data, $cond) === TRUE)
    			{
    			    $this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
    				$this->session->setFlashdata($this->msg);
    				return redirect()->to(base_url('backoffice/home_page'));
    			}
			}else{
			    if((bool)$this->model->saveRecord('home_page', $this->data) === TRUE)
    			{
    				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
    				return redirect()->to(base_url('backoffice/home_page'));
    			}
			}
			
			
			
		} 
		}
	
	
	
	
	public function validation()
	{
		return $this->validate([
					
			
			'program_offered' => [
				'label'  => 'Program Offered',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Program Offered can not be empty.'
				]
			]
		]); 
	}


	

}
