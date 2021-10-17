<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\LoginModel;

class Login extends BaseController
{
	public $session = null;
	public $data = null;
	public $model = null;
	public $validation = null;
	
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->validation =  \Config\Services::validation();
		helper(['form', 'url']); 
		$this->model = new LoginModel();
	}

	public function index()
	{   
		if((bool)($this->session->get('IsAdminLoggedIn')) === TRUE)
		{
			return redirect()->to(base_url('backoffice/dashboard'));
			exit();
		}
		
		$emailid = trim($this->request->getVar('emailid'));
		$password = trim($this->request->getVar('password'));
		$this->data = array(
			'emailid'=>$emailid,
			'password'=>$password
		);
		if(!$this->validate([
			'emailid' => [
				'label'  => 'Email',
				'rules'  => 'required|valid_email',
				'errors' => [
					'required' => 'Email is required'
				]
			],
			'password' => [
				'label'  => 'Password',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Password is required'
				]
			]
		]))
		{
		   
			echo view('backoffice/login', ['validation'=>$this->validator, 'formData'=>$this->data]);
		}
		else
		{
			
			$md5password = md5($password);
			$loginData = array('emailid'=>$emailid, 'password'=>$md5password);

			if((bool)$this->model->getVerifiedLogin('user', $loginData) === TRUE)
			{
			    $userdata = $this->model->getVerifiedLogin('user', $loginData);				
				$str = 'abcdefghijklmnopqrstuvwxyz01234567891011121314151617181920212223242526';
                $shuffled = str_shuffle($str);
                $shuffled = substr($shuffled,1,30);				
				$condlogin =  array('login_id'=>$userdata[0]->id, 'ip_address'=> $_SERVER['SERVER_ADDR'], 'login_time'=> date('Y-m-d H:i:s'), 'status'=>"1",'session_code'=> $shuffled);								
				$loginSave = $this->model->saveRecord('login_time' , $condlogin);
				$permissionData = $this->model->getRows('form_permission','*',array('role_id'=>$userdata[0]->login_type));
				
				$pData = array();
				if(!empty($permissionData)){
					foreach($permissionData as $val){
						$pData[$val['form_information_id']] = array(
							'view' => $val['form_view'],
							'add' => $val['form_add'],
							'edit' => $val['form_edit'],
							'delete' => $val['form_delete']
						);
					}
				}
				$this->session->set('admin_login_id', $userdata[0]->id);
				$this->session->set('admin_login_email', $userdata[0]->emailid);
				$this->session->set('temp_login_id', $shuffled);
				$this->session->set('user_data', $userdata[0]);
				$this->session->set('admin_permission', $pData);
				$this->session->set('IsAdminLoggedIn', $userdata[0]->id);				
				if($userdata[0]->login_type == 1){				   
				    return redirect()->to(base_url('backoffice/dashboard'));
				}				
			}
			else
			{			   
				$error = 'Username or Password is wrong. Please try again!';
				echo view('backoffice/login', ['validation'=>$this->validator, 'login_error'=>$error, 'formData'=>$this->data]);
			}
		} 
		
	}
	
	public function logout()
	{
		if((bool)($this->session->get('IsAdminLoggedIn')) === TRUE)
		{
			$condlogin =  array('login_id'=>$_SESSION['admin_login_id'], 'ip_address'=> $_SERVER['SERVER_ADDR'],'session_code'=>$_SESSION['temp_login_id'],'status'=>"1" );
						
			$logoutlogin =  array('logout_time'=> date('Y-m-d H:i:s'), 'status'=>"0");
			
			$loginUpdate = $this->model->updateRecord('login_time' , $logoutlogin, $condlogin);
			
			$this->session->remove('admin');
			$this->session->remove('user_data');
			$this->session->remove('admin_login_email');
			$this->session->set('IsAdminLoggedIn', 0);
		}
		return redirect()->to(base_url('backoffice/login'));
	} 
	
}
