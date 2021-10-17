<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Notices_and_announcements extends BaseController
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
		$this->activedata['menu'] = 11;
		$this->activedata['submenu'] = 22;
	} 
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;		
		$this->data = $this->model->getRows('notices_and_announcements','','','display_order','ASC');
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/notices_and_announcements_view',['naaData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/notices_and_announcements_view');
			echo view('backoffice/template/includes/footer');
		} 
	} 
	
  public function add()
  {
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		$this->maxdata = $this->model->getRows('notices_and_announcements', 'max(display_order) as display_order', '', 'display_order','ASC');
		$act = base_url('backoffice/notices_and_announcements/save');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/other/add_notices_and_announcements',['act'=> $act,'maxData'=>$this->maxdata]);
		echo view('backoffice/template/includes/footer');
	}


	public function save()
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}	
		$activedata['active'] = 4;
		$this->maxdata = $this->model->getRows('notices_and_announcements', 'max(display_order) as display_order', '', 'display_order','ASC');
		if(!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/add_notices_and_announcements', ['validation' => $this->validation,'maxData'=> $this->maxdata]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			$current_user_id = $this->session->get('admin_login_id');
			$this->data = array(
				'title'    				=> trim($this->request->getVar('title')),
				'description'    	=> trim($this->request->getVar('description')),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'   => trim($this->request->getVar('display_order')),
				'created_ip'      => $ip,
				'created_by'      => $current_user_id
			);
			if((bool)$this->model->saveRecord('notices_and_announcements', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/notices_and_announcements'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/notices_and_announcements/add'));
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
		$cat_id = $id;
		$cond = array('id'=>$cat_id);		
		$get_edit_data = $this->model->getRowArray('notices_and_announcements','',$cond);		
		$act = base_url('backoffice/notices_and_announcements/update/'.$id);		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/other/add_notices_and_announcements', ['get_edit_data'=>$get_edit_data,'act'=> $act]);
		echo view('backoffice/template/includes/footer');
		
	}
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		
		$cat_id = $id;
		$cond = array('id'=>$cat_id);
		
		if(!$this->validation($cat_id))
		{	        	
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/add_notices_and_announcements', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
      $current_user_id = $this->session->get('admin_login_id');			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('title')),
			  'description'    	=> trim($this->request->getVar('description')),
			  'status'     			=> trim($this->request->getVar('status')),
			  'display_order'   => trim($this->request->getVar('display_order')),
				'updated_ip'      => $ip,
				'updated_by'      => $current_user_id
			);
			
			if((bool)$this->model->updateRecord('notices_and_announcements',$this->data,$cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/notices_and_announcements'));
			}
		}		 
	}

	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}		
		$cat_id = $id;		
		$cond     = array('id'=>$cat_id);		
		if((bool)$this->model->deleteRecord('notices_and_announcements',$cond)===TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!','msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/notices_and_announcements'));
		}
	}	
	
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = $id;
		$cond       = array('id'=>$cat_id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('notices_and_announcements',$this->data,$cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!','msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/notices_and_announcements'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = $id;
		$cond       = array('id'=>$cat_id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('notices_and_announcements',$this->data,$cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!','msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/notices_and_announcements'));
		}
	}	
	
	private function validation($id=0)
	{
		if($id)
		{
		  $validation = $this->validate([            
			'title' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[notices_and_announcements.title,id,'.$id.']',
				'errors' => [
					'required' => 'Title can not be empty.'
				]
			]
		  ]);	
		}
		else
		{
		  $validation = $this->validate([
			'title' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[notices_and_announcements.title]',
				'errors' => [
					'required' => 'Title can not be empty.',
					'is_unique' => 'This title is already used.'
				]
			]
		  ]);	
		}		
    return $validation;		
	}

	
}
