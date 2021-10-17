<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class IqacMeetingProceedings extends BaseController
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
	  $get_iqac_meeting_proceedings = $this->model->getRows('iqac_policies','*',array('page_type'=>'2','status'=>1),'display_order','ASC'); 
	  echo view('frontend/includes/inner_header');
	  echo view('frontend/iqac_meeting_proceedings',['get_iqac_meeting_proceedings'=>$get_iqac_meeting_proceedings]);	
      echo view('frontend/includes/inner_footer');
	}	
}
