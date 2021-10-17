<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Trustees extends BaseController
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
	  $get_single = $this->model->getRows('trustees','*',array('status'=>1),'display_order','ASC','0','1'); 
	  $get_trustees = $this->model->getRows('trustees','*',array('status'=>1),'display_order','ASC','1','10'); 
	  echo view('frontend/includes/inner_header');
	  echo view('frontend/trustees',['get_single'=>$get_single,'get_trustees'=>$get_trustees]);	
      echo view('frontend/includes/inner_footer');
	}	
}
