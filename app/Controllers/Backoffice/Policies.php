<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Policies extends BaseController
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
		$this->activedata['submenu'] = 21;
	} 	
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		
		$this->data = $this->model->getRows('iqac_policies', '', '', 'display_order', 'ASC');
		
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/iqac_policies_and_nirf_view', ['iqac_policies_and_nirf_data'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/iqac_policies_and_nirf_view');
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
		$current_user_id = $this->session->get('admin_login_id');		
		
		$this->maxdata = $this->model->getRows('iqac_policies','','','display_order','ASC');	    
		if(!$this->validation())
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/add_iqac_policies_and_nirf', ['validation' => $this->validation,'maxData'=> $this->maxdata]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{		
		    $string = strtolower($this->request->getVar('title'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);	

			if($this->request->getFile('upload_pdf')!='')
			{
				$avatar = $this->request->getFile('upload_pdf');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/pdf/',$file_name);
				}	
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->data = array(
				'page_type'    			=> trim($this->request->getVar('page_type')),
				'other_page_url'    	=> trim($this->request->getVar('other_page_url')),
				'title'    		        => trim($this->request->getVar('title')),
				'upload_pdf'       	    => trim($file_name),
				'url_slug'       		=> trim($slug),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'created_ip'      		=> $ip,
				'created_by'      		=> $current_user_id
			);
			if((bool)$this->model->saveRecord('iqac_policies',$this->data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/policies'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/policies/add'));
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
		$cond = array('id'=>$id);
		$this->data = $this->model->getRowArray('iqac_policies', '*', $cond);	
		$act = base_url('backoffice/policies/update/'.$id);
		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/other/add_iqac_policies_and_nirf', ['trusteesData'=>$this->data,'act'=> $act]);
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
		$current_user_id = $this->session->get('admin_login_id');		
		$cond = array('id'=>$id);		
		if(!$this->validation($id))
		{			
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/other/add_iqac_policies_and_nirf', ['validation' => $this->validation]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{	
			$string = strtolower($this->request->getVar('title'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);	

			if($this->request->getFile('upload_pdf')!='')
			{
				$avatar = $this->request->getFile('upload_pdf');
				$error = $avatar->getError();
				if(!$error)
				{
					$file_name = $avatar->getRandomName();
					$avatar->move(ROOTPATH . 'uploads/pdf/',$file_name);
				}	
			}
			else
			{
				$file_name = $this->request->getVar('Oldupload_pdf');
			}			
			$ip = $_SERVER['REMOTE_ADDR'];
			$this->data = array(
				'page_type'    			=> trim($this->request->getVar('page_type')),
				'other_page_url'    	=> trim($this->request->getVar('other_page_url')),
				'title'    		        => trim($this->request->getVar('title')),
				'upload_pdf'       	    => trim($file_name),
				'url_slug'       		=> trim($slug),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'updated_ip'      		=> $ip,
				'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('iqac_policies', $this->data, $cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/policies'));
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
		$cond     = array('id'=>$id);
		$mediatData = $this->model->getRowArray('iqac_policies','*',$cond); 
		if((bool)$this->model->deleteRecord('iqac_policies',$cond) === TRUE)
		{
			if(file_exists('uploads/pdf/'.$mediatData['upload_pdf'])){
                unlink('uploads/pdf/'.$mediatData['upload_pdf']);
            }
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/policies'));
		}
	}
	
	
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond       = array('id'=>$id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('iqac_policies', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/policies'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$cond       = array('id'=>$id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('iqac_policies', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/policies'));
		}
	}
	
	public function delete_logo_upload_pdf($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$cond = array('id'=>$id);
		$mediatData = $this->model->getRowArray('iqac_policies','*',$cond); 
		$this->data = array('upload_pdf'=>'');
		if((bool)$this->model->updateRecord('iqac_policies',$this->data,$cond) === TRUE)
		{
		    if(file_exists('uploads/pdf/'.$mediatData['upload_pdf'])){
                unlink('uploads/pdf/'.$mediatData['upload_pdf']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/policies/edit/'.$id));
		}
	} 
	
	private function validation($id=0)
	{
		if($id)
		{
		  $validation = $this->validate([	
            'page_type' => [
				'label'  => 'Page Type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Please select a type.'
				]
			],		  
			'title' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[iqac_policies.title,id,'.$id.']',
				'errors' => [
					'required' => 'Title can not be empty.'
				]
			]
		  ]);	
		}
		else
		{
		  $validation = $this->validate([
		    'page_type' => [
				'label'  => 'Page Type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Please select a type.'
				]
			],
			'title' => [
				'label'  => 'title',
				'rules'  => 'trim|required|is_unique[iqac_policies.title]',
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
