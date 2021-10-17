<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Events extends BaseController
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
	  $get_single_events = $this->model->getRows('events','*',array('event_type'=>1,'status'=>1),'display_order','ASC','0','1');
	  $get_two_events = $this->model->getRows('events','*',array('event_type'=>1,'status'=>1),'display_order','ASC','1','2');
	  $get_remaining_events = $this->model->getRows('events','*',array('event_type'=>1,'status'=>1),'display_order','ASC','3','9');	 
	  echo view('frontend/includes/inner_header');
	  echo view('frontend/events',['get_single_events'=>$get_single_events,'get_two_events'=>$get_two_events,'get_remaining_events'=>$get_remaining_events]);	
      echo view('frontend/includes/inner_footer');	  
	}
	
	public function showEvents()
	{
	  $type = $this->request->getVar('type');
	  $month = $this->request->getVar('month');
	  $year = $this->request->getVar('year');
	  if(!empty($month) && empty($year))
	  {
        $get_data = $this->model->getRows('events','*',array('event_type'=>$type,'status'=>1,'event_and_news_month'=>$month),'display_order','ASC','0','10');
	  }
	  elseif(empty($month) && !empty($year))
	  {
	  	$get_data = $this->model->getRows('events','*',array('event_type'=>$type,'status'=>1,'event_and_news_year'=>$year),'display_order','ASC','0','10');
	  }
	  elseif(!empty($month) && !empty($year))
	  {
	  	$get_data = $this->model->getRows('events','*',array('event_type'=>$type,'status'=>1,'event_and_news_month'=>$month,'event_and_news_year'=>$year),'display_order','ASC','0','10');
	  }
	  elseif(empty($month) && empty($year))
	  {
	  	$get_data = $this->model->getRows('events','*',array('event_type'=>$type,'status'=>1),'display_order','ASC','0','10');
	  }
      if(count($get_data) >0)
      {
		  $html = '<div class="row">';
		  foreach($get_data as $value)
		  {
	        $html .='<div class="col-md-4"><a href="'.base_url('events/').$value['slug'].'" class="dateDetails">
	                        <p><span><strong>'.date('d', strtotime($value['event_date'])).'</strong> /</span>'.date('M Y', strtotime($value['event_date'])).'</p>
	                        <div class="insideImage">
	                            <img src="'.base_url('uploads/events/'.$value['image']).'" alt="'.$value['title'].'">
	                            <div class="insideText7">
	                                <p>'.$value['title'].'</p>
	                            </div>
	                        </div>
	                    </a></div>';
		  }
		  $html .='</div>              
              <div class="center_btn showBox">
              <a href="javascript:void(0);" class="btn">Load More<i class="fa fa-angle-down" aria-hidden="true"></i></a>
              </div>';
		  echo $html;
	  }
	  else
	  {
	  	echo '<div class="col-md-12" style="color:red;">Data not available!</div>';
	  }
	}

	public function showEventsDetail($slug)
	{
      $get_single_events = $this->model->getRowArray('events','*',array('event_type'=>1,'status'=>1,'slug'=>$slug));	 
	  echo view('frontend/includes/inner_header');
	  echo view('frontend/detail',['get_single_events'=>$get_single_events,'ptitle'=>'events']);	
      echo view('frontend/includes/inner_footer');	
	}
}
