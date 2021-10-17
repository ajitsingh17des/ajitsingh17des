<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Home extends BaseController
{
	public $session = null;
	public $data = null;
	public $validation = null;
	public $model = null;

	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->validation =  \Config\Services::validation();
		helper(['form', 'url', 'validation']);
		$this->model = new CommonModel();
		$this->db = \Config\Database::connect(); 	
	}

	public function index()
	{
	  echo view('frontend/includes/header');
	  echo view('frontend/index');	
      echo view('frontend/includes/footer');	  
	}
	
	public function backoffice()
	{
	  return redirect()->to(base_url('backoffice/login'));	
	}	
    
}
