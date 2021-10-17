<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
class Testimonials extends BaseController
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
		$this->activedata['menu'] = 7;
		$this->activedata['submenu'] = 11;
	} 
	
    /************************code Written By  11091994 start here********************/
    
    
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$this->data['testimonial'] = $this->model->getRows('testimonial','','','display_order','asc');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/testimonial/testimonial_view', ['testimonial'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	} 
	
	public function add()
	{		
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		
		$this->data['act'] = base_url().'backoffice/testimonials/save';
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/testimonial/add_testimonial', ['testimonialAdd'=>$this->data]);
		echo view('backoffice/template/includes/footer');
	} 

	public function save(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		if ($this->validation())
		{
			$imageName = '';
			if($this->request->getFile('image')!='')
			{ 
				$image = $this->request->getFile('image');
				$imageErr = $image->getError();
				if(!$imageErr)
				{
					$imageName = $image->getRandomName();
					$image->move(ROOTPATH . 'uploads/testimonial/',$imageName);
				}
			}
			$data = array(
			    'type' => trim($this->request->getVar('type')),
				'name' => trim($this->request->getVar('name')),
				'organization' => trim($this->request->getVar('organization')),
				'description' => $this->request->getVar('description'),
				'long_description' => $this->request->getVar('long_description'),
				'designation'=> $this->request->getVar('designation'),
				'image'  => $imageName,
				'status'   => $this->request->getVar('status'),
				'display_order' => $this->request->getVar('display_order'),
				'created_date' => date('Y-m-d H:i:s')
			);
			if((bool)$this->model->saveRecord('testimonial', $data) === TRUE)
			{
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/testimonials'));
			}else{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/testimonials/add'));
			}
		}else{
			$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/testimonials/add'));
		}
	}
	
	
	
	public function edit($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$testimonial_id = $id;
		$cond = array('id'=>$testimonial_id);
	    $this->data['testimonialData'] = $this->model->getRows('testimonial', '*', $cond);	
		$this->data['act'] = base_url('backoffice/testimonials/update/'.$id);
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/testimonial/add_testimonial', ['testimonialAdd'=>$this->data]);
		echo view('backoffice/template/includes/footer');
		
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$testimonial_id = $id;
		$cond = array('id'=>$testimonial_id);
		
		if ($this->validation())
		{  
			
			if($this->request->getFile('image')!='')
			{ 
				$image = $this->request->getFile('image');
				$imageErr = $image->getError();
				if(!$imageErr)
				{
					$imageName = $image->getRandomName();
					$image->move(ROOTPATH . 'uploads/testimonial/',$imageName);
				}
			}else{
				$imageName = $this->request->getVar('Oldimage');
			}
			
			$data = array(
			    'type' => trim($this->request->getVar('type')),
				'name' => trim($this->request->getVar('name')),
				'organization' => trim($this->request->getVar('organization')),
				'description' => $this->request->getVar('description'),
				'long_description' => $this->request->getVar('long_description'),
				'designation'=> $this->request->getVar('designation'),
				'image'  => $imageName,
				'status'   => $this->request->getVar('status'),
				'display_order' => $this->request->getVar('display_order')
			);
			if((bool)$this->model->updateRecord('testimonial', $data, $cond) === TRUE)
			{
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/testimonials'));
			}
		}else{
			$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/testimonials/edit/'.$id));
		} 
	}
	
	
	public function delete($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$testimonial_id = $id;
		$cond     = array('id'=>$testimonial_id);
		
		if((bool)$this->model->deleteRecord('testimonial', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/testimonials'));
		}
	}
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$testimonial_id   = $id;
		$cond       = array('id'=>$testimonial_id);
		$this->data = array('status' => "1");
		if((bool)$this->model->updateRecord('testimonial', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/testimonials'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		$testimonial_id   = $id;
		$cond       = array('id'=>$testimonial_id);
		$this->data = array('status' => "0");
		if((bool)$this->model->updateRecord('testimonial', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/testimonials'));
		}
	}
	
	public function delete_image($id='')
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$testimonial_id = $id;
		$cond = array('id'=>$testimonial_id);
		$testimonialData = $this->model->getRows('testimonial', '*', $cond); 
		$this->data = array(
		    'image' => '', 
		);
		if((bool)$this->model->updateRecord('testimonial', $this->data, $cond) === TRUE)
		{
		    if(file_exists('uploads/testimonial/'.$testimonialData[0]['image'])){
                unlink('uploads/testimonial/'.$testimonialData[0]['image']);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/testimonials/edit/'.$id));
		}
	} 
	public function validation()
	{
		return $this->validate([
			'name' => [
				'label'  => 'Testimonial Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Testimonial Name can not be empty.'
				]
			],'type' => [
				'label'  => 'Testimonial Type',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Testimonial Type can not be empty.'
				]
			]
		]); 
	}

/************************code Written By  11091994 end here********************/
	

}
