<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Notices_and_announcements extends BaseController
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
	  $get_notices_and_announcements = $this->model->getRows('notices_and_announcements','*',array('status'=>1),'display_order','ASC',0,4);
	  $fromlimit = 2;
	  $limit = 4;
	  $controller_name = 'notices_and_announcements'; 
	  echo view('frontend/includes/inner_header',['fromlimit'=>$fromlimit,'limit'=>$limit,'controller_name'=>$controller_name]);
	  echo view('frontend/notice-announcement',['get_notices_and_announcements'=>$get_notices_and_announcements,'limit'=>$limit]);	
      echo view('frontend/includes/inner_footer');
	}

	public function listing()
	{
	  $tolimit   = $_POST['limit'];
	  $fromlimit = $_POST['fromlimit'];
	  $newfrom = $tolimit*$fromlimit;
	  $get_notices_and_announcements = $this->model->getRows('notices_and_announcements','*',array('status'=>1),'display_order','ASC',$newfrom,$tolimit);  

      $i=1; 
      $html = '';
      foreach($get_notices_and_announcements as $fVal){ if($i%2==0){$display = 'grey9';}else{$display = '';}
          $html .= '<div class="panel panel-default '.$display.'">
              <div class="panel-heading" role="tab" id="heading'.$i.'">
                  <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" aria-expanded="false" aria-controls="collapse'.$i.'">
                        <div class="dateDetails">
                              <p><span><strong>'.date('d', strtotime($fVal['created_date'])).'</strong> /</span>'.date('M Y', strtotime($fVal['created_date'])).'</p>
                          </div>'.$fVal['title'].'
                      </a>
                  </h4>
              </div>
              <div id="collapse'.$i.'" class="panel-collapse collapse" role="tabpanel" data-parent="#accordion" aria-labelledby="heading'.$i.'">
                  <div class="panel-body">
                      <div class="isiMateri">
                          '.$fVal['description'].'
                      </div>
                  </div>
              </div>
          </div>';
        $i++;
        }
      echo $html;
	}	
}
