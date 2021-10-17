<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class AboutUS extends BaseController
{
	public $session = null;
	public $data = null;
	public $validation = null;
	public $model = null;

	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->validation =  \Config\Services::validation();
		helper(['form','url','validation','custom_helper']);
		$this->model = new CommonModel();
		$this->db = \Config\Database::connect(); 	
	}

	public function index()
	{
	  $get_page = $this->model->getRowArray('cms_page','*',array('page_id'=>4,'page_status'=>1));
	  echo view('frontend/includes/inner_header');
	  echo view('frontend/about-us',['pageData'=>$get_page]);	
      echo view('frontend/includes/inner_footer');	  
	}
	
}
