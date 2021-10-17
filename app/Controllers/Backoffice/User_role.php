<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class User_role extends BaseController
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
		$this->activedata['menu'] = 3;
		$this->activedata['submenu'] = 5;

		
	} 
	
	
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['role_data'] = $this->model->getRows('user_role', '*');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/user_role/role_view', ['roleData'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function add(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['act'] = base_url().'backoffice/user_role/save_role';
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/user_role/add_role',['data'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function save_role(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->validate_role()){
			$this->data = array(
				'role_name'=> trim($this->request->getVar('role_name')),
				'role_status'=> trim($this->request->getVar('role_status')),
				'created_date' => date('Y-m-d'),
				'created_by' => 1
			);
			if((bool)$this->model->saveRecord('user_role', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/user_role'));
			}else{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/user_role/add'));
			}
		}else{
			$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/user_role/add'));
		}
	}

	public function edit($id=''){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$user_role_id = base64_decode($id);
		$cond = array('role_id'=>$user_role_id);
		$this->data['role_data'] = $this->model->getRows('user_role', '*', $cond);	
		$act = base_url('backoffice/user/update_role/'.$id);
		$joinSql = 'Select menu.menu_name,menu.id,form_information.* from form_information  inner join menu on menu.id = form_information.module_id where menu.status = 1';
		$joinData = $this->model->solveCustomQuery($joinSql);
		$returnData = array();
		if(!empty($joinData)){
			foreach($joinData as $submenu){
				$returnData[$submenu['menu_name']][] = $submenu;
			}
		}
		$form_permission = $this->model->getRows('form_permission', "*", array('role_id'=>$user_role_id));
		$permissionArr = array();
		if(!empty($form_permission)){
			foreach($form_permission as $perArr){
				$permissionArr[$perArr['form_information_id']] = $perArr;
			}
		}
		$this->data['returnData']= $returnData;
		$this->data['permission'] = $permissionArr;
		$this->data['act'] = base_url()."backoffice/user_role/role_update/$id";
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/user_role/add_role',['data'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}
	public function role_update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$user_role_id = base64_decode($id);
		$cond = array('role_id'=>$user_role_id);
	    $form_add=$this->request->getVar('form_add');
		$form_view=$this->request->getVar('form_view');
		$form_edit=$this->request->getVar('form_edit');
		$form_delete=$this->request->getVar('form_delete');
		if (!$this->validate_role())
		{
			$this->msg = array('msg'=>'All Fields are required', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/user_role/edit/'.$id));
		}
		else
		{		
			$this->data = array(
				'role_name'=> trim($this->request->getVar('role_name')),
				'role_status'=> trim($this->request->getVar('role_status')),
			);	
			if((bool)$this->model->updateRecord('user_role', $this->data, $cond) === TRUE)
			{				
				if(!empty($form_view))
				{							    
					foreach($form_view as $key=>$form_view_val)
					{
	                   	$val[] =   $form_view_val; 
					    $access_edit='0';
						$access_delete='0';
						$access_add='0';
						if($form_add[$key]!="")
						{
							$access_add='1';
						}
						if($form_edit[$key]!="")
						{
							$access_edit='1';
						}
						if($form_delete[$key]!="")
						{
							$access_delete='1';
						}
						$get_view_result = $this->model->getRows('form_permission','*',array('role_id'=>$user_role_id,'form_information_id'=>$key));			
						if(!empty($get_view_result))
						{	
							$this->model->updateRecord('form_permission',array('form_view'=>'1','form_edit'=>$access_edit,'form_delete'=>$access_delete,'form_add'=>$access_add),array('role_id'=>$user_role_id,'form_information_id'=>$key));	
						} else {
							$this->model->saveRecord('form_permission',array('form_view'=>'1','role_id'=>$user_role_id,'form_information_id'=>$key,'form_edit'=>$access_edit,'form_delete'=>$access_delete,'form_add'=>$access_add));
						}	
					}
				}							
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/user_role'));
			}
		} 
	} 
	public function role_active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$user_role_id = base64_decode($id);
		$cond = array('role_id'=>$user_role_id);
		$this->data = array('role_status' => "1");
		
		if((bool)$this->model->updateRecord('user_role', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/user_role'));
		}
	}
	
	
    public function role_deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$user_role_id = base64_decode($id);
		$cond = array('role_id'=>$user_role_id);
		$this->data = array('role_status' => "0");
		
		if((bool)$this->model->updateRecord('user_role', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/user_role'));
		}
	}

	public function validate_role(){
		return $this->validate([
			'role_name' => [
				'label'  => 'Role Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Role Name can not be empty.'
				]
			]
		]); 
	}
}
