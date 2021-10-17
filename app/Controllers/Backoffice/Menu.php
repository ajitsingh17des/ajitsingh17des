<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\MenuModel;

class Menu extends BaseController
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
		$this->activedata['submenu'] = 2;
	}
	
	public function check()
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
	}

	public function index()
	{
			
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['menu'] = $this->model->getRows('menu', '', array('display_order >'=>0), 'display_order', 'ASC');
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/menu/menu_view', ['menu'=>$this->data['menu']]);
		echo view('backoffice/template/includes/footer');
	   
		
	}
	
	public function add()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$maxdata = $this->model->getRows('menu', 'max(display_order) as display_order', '', 'display_order', 'ASC');
		$act = base_url('backoffice/menu/save_menu');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/menu/add_menu',['act'=>$act,'maxdata'=>$maxdata,'validation'=>$this->validation]);
		echo view('backoffice/template/includes/footer');	
	}

	public function save_menu(){
		if($this->menu_validate()){
			$this->data = array(
				'menu_name'      => $this->request->getVar('menu_name'),
				'icon'      	 => $this->request->getVar('icon'),
				'display_order'  => $this->request->getVar('display_order'),
				'status'         => $this->request->getVar('status'),
				'created_date'   => date('Y-m-d'),
				'created_by'     => 1
			);
			
			if((bool)$this->model->saveData('menu', $this->data) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/menu'));
			}
			else
			{
							
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return $this->add();
			}
		}else{
			return $this->add();
		}
	}


	public function menu_validate()
	{ 
		return $this->validate([
			'menu_name' => [
				'label'  => 'Menu Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Menu name can not be empty.'
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
		
		$cond = array('id'=>base64_decode($id));
		$this->data = $this->model->getRows('menu', '*', $cond, 'display_order', 'ASC');		
		$act = base_url('backoffice/menu/update/').''.$id;
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/menu/add_menu',['act'=>$act,'validation'=>$this->validation,'menuData'=>$this->data]);
		echo view('backoffice/template/includes/footer');	
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('id'=>base64_decode($id));
		if($this->menu_validate())
		{
			
			$this->data = array(
					'menu_name'      => $this->request->getVar('menu_name'),
					'icon'      	 => $this->request->getVar('icon'),
					'display_order'  => $this->request->getVar('display_order'),
					'status'         => $this->request->getVar('status'),
					'updated_date'  => date('Y-m-d'),
					'updated_by'    => 1
				);
				
			if((bool)$this->model->updateRecord('menu', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/menu'));
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
		
		$menu_id = base64_decode($id);
		$cond = array('id'=>$menu_id);
		$this->data = array(
		'status' => "1"	
		);
		
		if((bool)$this->model->updateRecord('menu', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/menu'));
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
		$cond = array('id'=>$menu_id);
		$this->data = array(
		'status' => "0"
		);
		
		if((bool)$this->model->updateRecord('menu', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/menu'));
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
		$cond = array('id'=>$menu_id);
		
		if((bool)$this->model->deleteRecord('menu', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/menu'));
		}
	}
	
	
}
