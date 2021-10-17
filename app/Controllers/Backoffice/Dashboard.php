<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Dashboard extends BaseController
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
		$this->model = new CommonModel();
	}
	
    public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['menu']	= 1;
		$activedata['submenu']	= 1;
	
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$activedata]);
		echo view('backoffice/template/dashboard');
		echo view('backoffice/template/includes/footer');
	} 

	public function setting()
	{
        if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['menu']	= 1;
		$activedata['submenu']	= 20;
		$this->data = $this->model->getRows('page_setting', '', '', 'display_order', 'ASC');
		$i=0;
		foreach($this->data as $val)
		{		   
		   $page_name = $this->model->getRowArray('cms_page', '*',array('page_id'=>$val['page_id']));
		   $this->data[$i]['page_name'] = $page_name['page_name'];
		   $i++;
		}
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$activedata]);
		echo view('backoffice/template/setting',['settingData'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	}

	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 		
		$cond     = array('setting_id'=>$id);
		if((bool)$this->model->deleteRecord('page_setting', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/dashboard/setting'));
		}
	}
	
	
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cond       = array('setting_id'=>$id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('page_setting',$this->data,$cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/dashboard/setting'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cond       = array('setting_id'=>$id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('page_setting',$this->data,$cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/dashboard/setting'));
		}
	}


	public function add_setting()
	{		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		$current_user_id = $this->session->get('admin_login_id');		
		
		$this->maxdata = $this->model->getRows('page_setting','','','display_order','ASC');	
		$all_cms_page = $this->model->getRows('cms_page', 'page_id,page_name', '', 'display_order','ASC');    
		if(!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/template/add_setting',['validation' => $this->validation,'maxData'=> $this->maxdata,'all_cms_page'=>$all_cms_page]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{			
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->data = array(
			 'page_id'    			=> trim($this->request->getVar('page_id')),
			 'how_many_of_image'    => trim($this->request->getVar('how_many_of_image')),
			 'how_many_of_editor'   => trim($this->request->getVar('how_many_of_editor')),
			 'how_many_of_pdf'    	=> trim($this->request->getVar('how_many_of_pdf')),
			 'text_type_of_field'   => trim($this->request->getVar('text_type_of_field')),
			 'status'     			=> trim($this->request->getVar('status')),
			 'display_order'    	=> trim($this->request->getVar('display_order')),
			 'created_ip'      		=> $ip,
			 'created_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->saveRecord('page_setting', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/dashboard/setting'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/dashboard/add_setting'));
			} 
		} 
	} 
    
    public function edit($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;	
		
		$cond = array('setting_id'=>$id);		
		$this->data = $this->model->getRowArray('page_setting','*',$cond);
		$all_cms_page = $this->model->getRows('cms_page', 'page_id,page_name', '', 'display_order','ASC'); 	
		$act = base_url('backoffice/dashboard/update_setting/'.$id);		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/template/add_setting', ['settingData'=>$this->data,'act'=> $act,'all_cms_page'=>$all_cms_page]);
		echo view('backoffice/template/includes/footer');
		
	}
    
    public function update_setting($id='')
	{		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		$current_user_id = $this->session->get('admin_login_id');
		$cond = array('setting_id'=>$id);
		$all_cms_page = $this->model->getRows('cms_page', 'page_id,page_name', '', 'display_order','ASC');
		if (!$this->validation($id))
		{			
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/template/add_setting', ['validation' => $this->validation,'all_cms_page'=>$all_cms_page]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{				
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->data = array(
			 'page_id'    			=> trim($this->request->getVar('page_id')),
			 'how_many_of_image'    => trim($this->request->getVar('how_many_of_image')),
			 'how_many_of_editor'   => trim($this->request->getVar('how_many_of_editor')),
			 'how_many_of_pdf'    	=> trim($this->request->getVar('how_many_of_pdf')),
			 'text_type_of_field'   => trim($this->request->getVar('text_type_of_field')),
			 'status'     			=> trim($this->request->getVar('status')),
			 'display_order'    	=> trim($this->request->getVar('display_order')),
			 'updated_ip'      		=> $ip,
			 'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('page_setting',$this->data,$cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/dashboard/setting'));
			}
		} 
	}
    
    private function validation($id=0)
	{
		if($id)
		{
		  $validation = $this->validate([            		  
			'page_id' => [
				'label'  => 'Page Name',
				'rules'  => 'trim|required|is_unique[page_setting.page_id,setting_id,'.$id.']',
				'errors' => [
					'required' => 'Please select a page name.',
					'is_unique' => 'This page name is already used.'
				]
			]
		  ]);	
		}
		else
		{
		  $validation = $this->validate([
			'page_id' => [
				'label'  => 'Page Name',
				'rules'  => 'trim|required|is_unique[page_setting.page_id]',
				'errors' => [
					'required' => 'Please select a page name.',
					'is_unique' => 'This page name is already used.'
				]
			]
		  ]);	
		}		
        return $validation;		
	}
}
