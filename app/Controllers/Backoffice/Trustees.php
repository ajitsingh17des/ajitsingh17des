<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Trustees extends BaseController
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
		$this->activedata['menu'] = 10;
		$this->activedata['submenu'] = 19;
	} 	
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		
		$this->data = $this->model->getRows('trustees', '', '', 'display_order', 'ASC');
		
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/trustees/trustees_view', ['trusteesData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/trustees/trustees_view');
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
		$activedata['active']	=4;
		$current_user_id = $this->session->get('admin_login_id');		
		
		$this->maxdata = $this->model->getRows('trustees','','','display_order','ASC');	    
		if(!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/trustees/add_trustees', ['validation' => $this->validation,'maxData'=> $this->maxdata]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{			
			if($this->request->getFile('image')!='')
			{
				$avatar = $this->request->getFile('image');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/trustees/',$file_name);
				}	
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->data = array(
				'name'    				=> trim($this->request->getVar('name')),
				'designation'    		=> trim($this->request->getVar('designation')),
				'image'       	        => trim($file_name),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'created_ip'      		=> $ip,
				'created_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->saveRecord('trustees', $this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/trustees'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/trustees/add'));
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
		
		$cat_id = base64_decode($id);
		$cond = array('trustees_id'=>$cat_id);
		$this->data = $this->model->getRowArray('trustees', '*', $cond);	
		$act = base_url('backoffice/trustees/update/'.$id);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/trustees/add_trustees', ['trusteesData'=>$this->data,'act'=> $act]);
		echo view('backoffice/template/includes/footer');
		
	}
	
	public function update($id='')
	{		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active']	=4;
		$current_user_id = $this->session->get('admin_login_id');
		
		
		$cat_id = base64_decode($id);
		$cond = array('trustees_id'=>$cat_id);
		
		if (!$this->validation())
		{			
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/home/add_trustees', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{	
			if($this->request->getFile('image')!='')
			{ 
				$avatar = $this->request->getFile('image');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/trustees/',$file_name);
				}
			}
			else
			{
				$file_name = $this->request->getVar('OldImage');
			}			
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->data = array(
				'name'    				=> trim($this->request->getVar('name')),
				'designation'    		=> trim($this->request->getVar('designation')),
				'image'       	        => trim($file_name),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'updated_ip'      		=> $ip,
				'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('trustees', $this->data, $cond) === TRUE)
			{
				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/trustees'));
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
		$cat_id = base64_decode($id);
		
		$cond     = array('trustees_id'=>$cat_id);
		$mediatData = $this->model->getRowArray('trustees', '*', $cond); 
		if((bool)$this->model->deleteRecord('trustees', $cond) === TRUE)
		{
			if(file_exists('uploads/trustees/'.$mediatData['image'])){
                unlink('uploads/trustees/'.$mediatData['image']);
            }
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/trustees'));
		}
	}
	
	
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = base64_decode($id);
		$cond       = array('trustees_id'=>$cat_id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('trustees', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/trustees'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cat_id   = base64_decode($id);
		$cond       = array('trustees_id'=>$cat_id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('trustees', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/trustees'));
		}
	}
	
	public function delete_logo_image($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cat_id = base64_decode($id);
		$cond = array('trustees_id'=>$cat_id);
		$mediatData = $this->model->getRowArray('trustees', '*', $cond); 
		$this->data = array('image'=>'');
		if((bool)$this->model->updateRecord('trustees', $this->data,$cond) === TRUE)
		{
		    if(file_exists('uploads/trustees/'.$mediatData['image'])){
                unlink('uploads/trustees/'.$mediatData['image']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/trustees/edit/'.$id));
		}
	} 
	
	public function validation()
	{
		return $this->validate([
					
			
			'name' => [
				'label'  => 'title',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Title can not be empty.'
				]
			]
		]); 
	}


	

}
