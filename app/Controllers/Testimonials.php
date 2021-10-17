<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Testimonials extends BaseController
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
	  $get_testimonials_student = $this->model->getRows('testimonial','*',array('type'=>'Student','status'=>1),'display_order','ASC'); 
	  $get_testimonials_parents = $this->model->getRows('testimonial','*',array('type'=>'Parents','status'=>1),'display_order','ASC');
	  $get_testimonials_alumni = $this->model->getRows('testimonial','*',array('type'=>'Alumni','status'=>1),'display_order','ASC');
	  $get_testimonials_faculty = $this->model->getRows('testimonial','*',array('type'=>'Faculty','status'=>1),'display_order','ASC');
	  echo view('frontend/includes/inner_header');
	  echo view('frontend/testimonials',['get_testimonials_student'=>$get_testimonials_student,'get_testimonials_parents'=>$get_testimonials_parents,'get_testimonials_alumni'=>$get_testimonials_alumni,'get_testimonials_faculty'=>$get_testimonials_faculty]);	
      echo view('frontend/includes/inner_footer');	  
	}
    
    public function showTestimonial()
	{
	  $id = $this->request->getVar('id');
	  $response_data = $this->model->getRowArray('testimonial','*',array('id'=>$id));
	  $html = '<div class="row">
  			<div class="col-md-5">
  				<div class="pop-upImg">
  					<img src="'.base_url('uploads/testimonial/'.$response_data['image']).'" alt="'.$response_data['name'].'">
  					<h4>'.$response_data['name'].'</h4>
  					'.$response_data['designation'].'
  				</div>
  			</div>
  			<div class="col-md-7">
  				<div class="pop-uptext">
  					<p><strong>'.$response_data['description'].'</strong></p>
            <div class="poup_details">
  						<p>'.$response_data['long_description'].'</p>
  					</div>
  				</div>
  			</div>
  		</div>';
	  echo $html;
	}

	public function loadmore()
	{
      $limit   = $this->request->getVar('limit');
      $offset  = $this->request->getVar('offset');
      $type    = $this->request->getVar('type');
      $result  = $this->model->getRows('testimonial','*',array('type'=>$type,'status'=>1),'display_order','ASC',$offset,$limit);
      $data['view'] = $result;
      $data['offset'] =$offset +10;
      $data['limit'] =$limit;
      echo json_encode($data);
    }		
}
