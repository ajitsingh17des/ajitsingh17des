<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Users extends BaseController
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
		$this->activedata['submenu'] = 4;
		
	} 
	
	
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['userData'] = $this->model->getRowsWithJoin('user','user.*,user_role.role_name','user_role','user.login_type = user_role.role_id','inner join',array('user_role.role_status'=>1));
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/users/user_view', ['userData'=>$this->data['userData']]);
		echo view('backoffice/template/includes/footer');
	}

	public function add(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['act'] = base_url().'backoffice/users/save_user';
		$this->data['roles'] = $this->model->getRows('user_role','role_id,role_name',array('role_status'=>1));

		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/users/add_user',['data'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function save_user(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}

		if($this->validate_user()){
			$this->data = array(
				'first_name'=> trim($this->request->getVar('first_name')),
				'last_name'=> trim($this->request->getVar('last_name')),
				'address' => trim($this->request->getVar('address')),
				'emailid' => trim($this->request->getVar('emailid')),
				'login_type' => trim($this->request->getVar('user_role')),
				'password' => md5(trim($this->request->getVar('password'))),
				'contact_no' => trim($this->request->getVar('contact_no')),
				'status' =>  trim($this->request->getVar('status')),
				'created_date' => date('Y-m-d'),
				'created_by' => 1
			);
			
			if((bool)$this->model->saveRecord('user', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/users'));
			}else{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/users/add'));
			}
		}else{
			$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/users/add'));
		}
	}

	public function edit($id=''){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$user_id = base64_decode($id);
		$cond = array('id'=>$user_id);
		$this->data['roles'] = $this->model->getRows('user_role','role_id,role_name',array('role_status'=>1));	
		$this->data['act'] = base_url()."backoffice/users/update/$id";
		$this->data['user_data'] = $this->model->getRows('user', '*',$cond);	

		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/users/add_user',['data'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$user_id = base64_decode($id);
		$cond = array('id'=>$user_id);
	   
		if (!$this->validate_user())
		{
			$this->msg = array('msg'=>'All Fields are required', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/users/edit/'.$id));
		}
		else
		{		
			if(empty($this->request->getVar('password'))){
				$pass = $this->request->getVar('old_password');
			}else{
				$pass = md5(trim($this->request->getVar('password')));
			}
			$this->data = array(
				'first_name'=> trim($this->request->getVar('first_name')),
				'last_name'=> trim($this->request->getVar('last_name')),
				'address' => trim($this->request->getVar('address')),
				'emailid' => trim($this->request->getVar('emailid')),
				'login_type' => trim($this->request->getVar('user_role')),
				'password' => $pass,
				'contact_no' => trim($this->request->getVar('contact_no')),
				'status' =>  trim($this->request->getVar('status'))
			);
			if((bool)$this->model->updateRecord('user', $this->data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/users'));
			}else{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/users/edit/'.$id));
			}
		} 
	} 
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$user_id = base64_decode($id);
		$cond = array('id'=>$user_id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('user', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/users'));
		}
	}
	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$user_id = base64_decode($id);
		$cond = array('id'=>$user_id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('user', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/users'));
		}
	}

	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$user_id = base64_decode($id);
		$cond = array('id'=>$user_id);
		
		if((bool)$this->model->deleteRecord('user', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/users'));
		}
	}
	public function validate_user(){
		return $this->validate([
			'first_name' => [
				'label'  => 'First Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'First Name can not be empty.'
				]
			],
			'last_name' => [
				'label'  => 'Last Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Last Name can not be empty.'
				]
			],
			'user_role' => [
				'label'  => 'User Role',
				'rules'  => 'required',
				'errors' => [
					'required' => 'User Role can not be empty.'
				]
			],
			'address' => [
				'label'  => 'Address',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Address can not be empty.'
				]
			],
			'emailid' => [
				'label'  => 'Email Id',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Email Id can not be empty.'
				]
			],
			'contact_no' => [
				'label'  => 'Contact No',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Contact No can not be empty.'
				]
			],
			'status' => [
				'label'  => 'Status',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Status can not be empty.'
				]
			],
		]); 
	}
}
