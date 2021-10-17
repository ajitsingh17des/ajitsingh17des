<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;
use App\Libraries\MyCustomLibrariesFunctions;

class CurrentOpening extends BaseController
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
		$this->lfunctions = new MyCustomLibrariesFunctions();
		$this->activedata['menu'] = 6;
		$this->activedata['submenu'] = 9;
	} 
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;		
		$this->data = $this->model->getRows('current_openings','','','display_order','ASC');
		if((bool)$this->data === TRUE)
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/current_opening/current_opening_view', ['openingData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/current_opening/current_opening_view');
			echo view('backoffice/template/includes/footer');
		} 
	} 
	
    public function add(){
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 4;
		$this->maxdata = $this->model->getRows('current_openings', 'max(display_order) as display_order', '', 'display_order','ASC');	
		$get_country = $this->lfunctions->getCountry('country');
		$act = base_url('backoffice/currentOpening/save');
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/current_opening/add_opening',['act'=> $act,'get_country'=>$get_country,'maxData'=>$this->maxdata]);
		echo view('backoffice/template/includes/footer');
	}


	public function save()
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}		
		$string = strtolower($this->request->getVar('title'));
		$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
		$pageArr = explode(" ",$page_name);
		$slug = implode('-',$pageArr);
		$ip = $_SERVER['REMOTE_ADDR'];
		$current_user_id = $this->session->get('admin_login_id');
		$this->data = array(
			'title'    				=> trim($this->request->getVar('title')),
			'year'    			    => trim($this->request->getVar('year')),
			'url_slug'       		=> trim($slug),
			'country_id'    		=> $this->request->getVar('country_id'),
			'state_id'    			=> $this->request->getVar('state_id'),
			'city_id'    			=> $this->request->getVar('city_id'),
			'description'    		=> trim($this->request->getVar('description')),
			'status'     			=> trim($this->request->getVar('status')),
			'display_order'    		=> trim($this->request->getVar('display_order')),
			'country_id' 			=> trim($this->request->getVar('country_id')),
			'state_id'    		    => trim($this->request->getVar('state_id')),
			'created_ip'      		=> $ip,
			'created_by'      		=> $current_user_id
		);
		if((bool)$this->model->saveRecord('current_openings', $this->data) === TRUE)
		{
			$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/currentOpening'));
		}
		else
		{
			$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/currentOpening/add'));
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
		$cond = array('opening_id'=>$cat_id);		
		$get_edit_data = $this->model->getRowObject('current_openings','',$cond);
		$get_country = $this->lfunctions->getCountry('country');
		$get_state = $this->model->getRows('state','*',array('country_id'=>$get_edit_data->country_id,'status'=>1),'state_name','ASC');	
		$get_city = $this->model->getRows('cities','*',array('country_id'=>$get_edit_data->country_id,'state_id'=>$get_edit_data->state_id,'status'=>1),'city_name','ASC');
		$act = base_url('backoffice/currentOpening/update/'.$id);		
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/current_opening/add_opening', ['editOpeningData'=>$get_edit_data,'get_country'=>$get_country,'get_state'=>$get_state,'get_city'=>$get_city,'act'=> $act]);
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
		$cond = array('opening_id'=>$cat_id);
		
		if(!$this->validation())
		{
		   $categorySlug = $this->model->getRowObject('current_openings', 'url_slug', $cond);
			$ip = $_SERVER['REMOTE_ADDR'];
		    $current_user_id = $this->session->get('admin_login_id');			
			$this->data = array(
				'title'    				=> trim($this->request->getVar('title')),
				'year'    			    => trim($this->request->getVar('year')),
				'url_slug'       		=> $categorySlug->url_slug,
				'country_id'    		=> $this->request->getVar('country_id'),
				'state_id'    			=> $this->request->getVar('state_id'),
				'city_id'    			=> $this->request->getVar('city_id'),
				'description'    		=> trim($this->request->getVar('description')),
				'status'     			=> trim($this->request->getVar('status')),
				'display_order'    		=> trim($this->request->getVar('display_order')),
				'country_id' 			=> trim($this->request->getVar('country_id')),
				'state_id'    		    => trim($this->request->getVar('state_id')),
				'updated_ip'      		=> $ip,
				'updated_by'      		=> $current_user_id
			);
			
			if((bool)$this->model->updateRecord('current_openings',$this->data,$cond) === TRUE)
			{				
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/currentOpening'));
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
		
		$cond     = array('opening_id'=>$cat_id);
		
		if((bool)$this->model->deleteRecord('current_openings', $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/currentOpening'));
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
		$cond       = array('opening_id'=>$cat_id);
		$this->data = array('status' => "1");
		
		if((bool)$this->model->updateRecord('current_openings', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/currentOpening'));
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
		$cond       = array('opening_id'=>$cat_id);
		$this->data = array('status' => "0");
		
		if((bool)$this->model->updateRecord('current_openings', $this->data, $cond) === TRUE)
		{
			$this->msg   = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/currentOpening'));
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

	public function getStateList()
	{
      $country_id = $this->request->getVar('country_id');
      $get_all_state = $this->model->getRows('state','*',array('status'=>1,'country_id'=>$country_id),'state_name','ASC');
      $html ='<select name="state_id" class="form-control" id="state_id" required="required" onchange="return showCity(this.value);"><option value="">Select State</option>';
      foreach($get_all_state as $stateVal)
      {
        $html .='<option value="'.$stateVal['state_id'].'">'.$stateVal['state_name'].'</option>';
      }									 
	  $html .= '</select>';
	  echo $html;
	}
    
    public function getCityList()
	{
      $country_id = $this->request->getVar('country_id');
      $state_id   = $this->request->getVar('state_id');
      $get_all_city = $this->model->getRows('cities','*',array('status'=>1,'country_id'=>$country_id,'state_id'=>$state_id),'city_name','ASC');
      $html ='<select name="city_id" class="form-control" id="city_id"><option value="">Select City</option>';
      foreach($get_all_city as $cityVal)
      {
        $html .='<option value="'.$cityVal['id'].'">'.$cityVal['city_name'].'</option>';
      }									 
	  $html .= '</select>';
	  echo $html;
	}
}
