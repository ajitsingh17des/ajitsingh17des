<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\MenuModel;

class Sub_menu extends BaseController
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
		$this->model = new MenuModel();
		$this->activedata['menu'] = 2;
		$this->activedata['submenu'] = 3;
	}

	public function index(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}

		$this->data = $this->model->getRowsWithJoin('form_information','form_information.*,menu.menu_name','menu','menu.id = form_information.module_id','inner','');	
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/sub_menu/submenu_view', ['submenu'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function add(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['menu_name_list'] = $this->model->getRows('menu','id,menu_name',array('status'=>"1"));
		$this->data['maxdata'] = $this->model->getRows('form_information', 'max(display_order_form) as display_order', '', 'display_order_form', 'ASC');
		$this->data['act'] = base_url('backoffice/sub_menu/save');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/sub_menu/add_submenu', ['returnData'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function save(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->submenu_validate()){
			$data = array(
				'module_id' => $this->request->getVar('menu_name'),
				'form_name' => $this->request->getVar('submenu_name'),
				'display_order_form' => $this->request->getVar('display_order'),
				'form_url' => $this->request->getVar('url'),
				'form_status' => $this->request->getVar('status'),
				'child' => $this->request->getVar('child')
			);
			
			if((bool)$this->model->saveData('form_information', $data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/sub_menu'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/sub_menu/add'));
			}
		}else{
			$this->msg = array('msg'=>'All fields are required', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/sub_menu/add'));
		}
	}

	public function edit($id=''){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['menu_name_list'] = $this->model->getRows('menu','id,menu_name',array('status'=>"1"));
		$cond = array('form_id'=>base64_decode($id));
		$this->data['subMenuData'] = $this->model->getRows('form_information', '*', $cond);
		$this->data['act'] = base_url().'backoffice/sub_menu/update/'.$id;
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/sub_menu/add_submenu', ['returnData'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function update($id=''){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if($this->submenu_validate())
		{
			$data = array(
				'module_id' => $this->request->getVar('menu_name'),
				'form_name' => $this->request->getVar('submenu_name'),
				'display_order_form' => $this->request->getVar('display_order'),
				'form_url' => $this->request->getVar('url'),
				'form_status' => $this->request->getVar('status'),
				'child' => $this->request->getVar('child')
			);
			$cond = array('form_id'=>base64_decode($id));
			if((bool)$this->model->updateRecord('form_information', $data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/sub_menu'));
			}else{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/sub_menu/edit/'.$id));
			}
		}else{
			$this->msg = array('msg'=>'All fields are required', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/sub_menu/edit/'.$id));
		}
	}

	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$menu_id = base64_decode($id);
		$cond = array('form_id'=>$menu_id);
		$this->data = array(
		'form_status' => "1"	
		);
		
		if((bool)$this->model->updateRecord('form_information', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/sub_menu'));
		}
	}
	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$menu_id = base64_decode($id);
		$cond = array('form_id'=>$menu_id);
		$this->data = array(
		'form_status' => "0"
		);
		
		if((bool)$this->model->updateRecord('form_information', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/sub_menu'));
		}
	}

	
	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$menu_id = base64_decode($id);
		$cond = array('form_id'=>$menu_id);
		
		if((bool)$this->model->deleteRecord('form_information', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/sub_menu'));
		}
	}

	public function submenu_validate()
	{ 
		return $this->validate([
			'menu_name' => [
				'label'  => 'Menu Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Menu name can not be empty.'
				]
			],
			'submenu_name' => [
				'label'  => 'Sub Menu Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Sub Menu name can not be empty.'
				]
			],
			'url' => [
				'label'  => 'Url',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Url can not be empty.'
				]
			],
			'child' => [
				'label'  => 'Menu Type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Menu Type can not be empty.'
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
	
	

}
