<?php 
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;
use App\Models\Backoffice\CommonModel;

class Pdf_cmc extends BaseController
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
		helper(['form', 'url']); 
		$this->model = new CommonModel();
		$this->activedata['menu'] = 4;
		$this->activedata['submenu'] = 6;
	} 
	
	public function index()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 8;
		
		$limit_from = 0;
		$limit = 1000;
		$conds=array();
		if($this->request->getVar('form_submit_page')=='Search'){			
			$page_name = $this->request->getVar('page_name');			
			if($page_name!=''){
				$conds[]= "p.page_name like '%".trim($page_name)."%'";
			}
			
			$url_cond.='?page_name='.$page_name.'&form_submit_page=Search';
		}
		if(!empty($conds)){
			$cond1= implode(' and',$conds);
			$cond="where ". $cond1;
		}
		
		$page_sql="SELECT distinct p.* FROM cms_page p ".$cond." order by p.display_order asc LIMIT ".$limit_from.",".$limit;
				
		$this->data = $this->buildTree($this->model->solveCustomQuery($page_sql)); 

		if((bool)$this->data === TRUE)
		{
			//return render('backoffice/cms/cms_pages_view', ['CmsData'=>$this->data]);
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/cms/cms_pages_view', ['CmsData'=>$this->data]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/cms/cms_pages_view');
			echo view('backoffice/template/includes/footer');
			//return render('backoffice/cms/cms_pages_view');
		} 
	} 
	
	public function add()
	{	
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 8;
		
		$current_user_id = $this->session->get('admin_login_id');
		
		$sql = "SELECT COUNT(*) as total FROM cms_page;";
		$tableRows = $this->model->solveCustomQuery($sql)[0];
		$totalRows = $tableRows['total'];
		$next_display_order = (int)$totalRows + 1;
		
		$data = $this->model->getRows('cms_page','',array('page_status'=>1));
		$page_list = $this->buildTree($data, $parent=0);
		$submit = 'Save';
		
		if(!$this->validation())
		{
			$string = strtolower($this->request->getVar('page_name'));
			$page_name = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			
			$form_add_data = array(
				'parent_id' => trim($this->request->getVar('parent_id')),
				'page_name' => trim($this->request->getVar('page_name')),
				'heading' => trim($this->request->getVar('heading')),
				'page_slug' => trim($slug),
				//'menu_type' => trim($this->request->getVar('menu_type')),
				'tag_line' => trim($this->request->getVar('tag_line')),
				'section1' => $this->request->getVar('section1'),
				'section2' => $this->request->getVar('section2'),
				'section3' => $this->request->getVar('section3'),
				'section4' => $this->request->getVar('section4'),
				'section5' => $this->request->getVar('section5'),
				'section6' => $this->request->getVar('section6'),
				'section7' => $this->request->getVar('section7'),
				'section8' => $this->request->getVar('section8'),
				'display_order' => trim($this->request->getVar('display_order')),
				'mega_menu' => trim($this->request->getVar('mega_menu')),
				'page_title' => trim($this->request->getVar('page_title')),
				'meta_keywords' => trim($this->request->getVar('meta_keywords')),
				'meta_description' => trim($this->request->getVar('meta_description')),
				'page_status' => trim($this->request->getVar('page_status')),
				'enquiry_page' => trim($this->request->getVar('enquiry_page')),
				'created_date' => date('Y-m-d'),
				'created_by' => $current_user_id
			);
			$formdata[] = $form_add_data;
			//return render('backoffice/cms/add_cms_page', ['CmsData'=>$formdata, 'validation'=>$this->validation, 'page_list'=> $page_list, 'next_display_order'=>$next_display_order ]);
		
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/cms/add_cms_page', ['CmsData'=>$formdata, 'validation'=>$this->validation,'page_list'=> $page_list, 'next_display_order'=>$next_display_order]);
			echo view('backoffice/template/includes/footer');
		}
		else
		{
			$string = strtolower($this->request->getVar('page_name'));
			$page_name  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
			$pageArr = explode(" ",$page_name);
			$slug = implode('-',$pageArr);
			
			$pageslugArr = $this->model->getRows('cms_page', 'page_slug', array('page_slug'=> $slug));
			
			if(!empty($pageslugArr))
			{
				$slug = $pageslugArr[0]['page_slug'].'-1';
			}
			else
			{
				$slug = $slug;
			}
			
			$avatar1 = $this->request->getFile('image1');
			$avatar2 = $this->request->getFile('image2');
			$avatar3 = $this->request->getFile('image3');
			$avatar4 = $this->request->getFile('image4');
			$avatar5 = $this->request->getFile('image5');
			$avatar6 = $this->request->getFile('image6');
			$avatar7 = $this->request->getFile('image7');
			$avatar8 = $this->request->getFile('image8');
			$error1 = $avatar1->getError();
			if(!$error1)
			{
				$file_name1 = $avatar1->getRandomName();
			}
			$error2 = $avatar2->getError();
			if(!$error2)
			{
				$file_name2 = $avatar2->getRandomName();
			}
			$error3 = $avatar3->getError();
			if(!$error3)
			{
				$file_name3 = $avatar3->getRandomName();
			}
			$error4 = $avatar4->getError();
			if(!$error4)
			{
				$file_name4 = $avatar4->getRandomName();
			}
			$error5 = $avatar5->getError();
			if(!$error5)
			{
				$file_name5 = $avatar5->getRandomName();
			}
			$error6 = $avatar6->getError();
			if(!$error6)
			{
				$file_name6 = $avatar6->getRandomName();
			}
			$error7 = $avatar7->getError();
			if(!$error7)
			{
				$file_name7 = $avatar7->getRandomName();
			}
			$error8 = $avatar8->getError();
			if(!$error8)
			{
				$file_name8 = $avatar8->getRandomName();
			}
			$this->data = array(
				'parent_id' => trim($this->request->getVar('parent_id')),
				'page_name' => trim($this->request->getVar('page_name')),
				'heading' => trim($this->request->getVar('heading')),
				'page_slug' => trim($slug),
				//'menu_type' => trim($this->request->getVar('menu_type')),
				'tag_line' => trim($this->request->getVar('tag_line')),
				'section1' => $this->request->getVar('section1'),
				'section2' => $this->request->getVar('section2'),
				'section3' => $this->request->getVar('section3'),
				'section4' => $this->request->getVar('section4'),
				'section5' => $this->request->getVar('section5'),
				'section6' => $this->request->getVar('section6'),
				'section7' => $this->request->getVar('section7'),
				'section8' => $this->request->getVar('section8'),
				'display_order' => trim($this->request->getVar('display_order')),
				'mega_menu' => trim($this->request->getVar('mega_menu')),
				'image1' => trim($file_name1),
				'image2' => trim($file_name2),
				'image3' => trim($file_name3),
				'image4' => trim($file_name4),
				'image5' => trim($file_name5),
				'image6' => trim($file_name6),
				'image7' => trim($file_name7),
				'image8' => trim($file_name8),
				'page_title' => trim($this->request->getVar('page_title')),
				'meta_keywords' => trim($this->request->getVar('meta_keywords')),
				'meta_description' => trim($this->request->getVar('meta_description')),
				'page_status' => trim($this->request->getVar('page_status')),
				'enquiry_page' => trim($this->request->getVar('enquiry_page')),
				'created_date' => date('Y-m-d'),
				'created_by' => $current_user_id
			);
			
			if((bool)$this->model->saveRecord('cms_page', $this->data) === TRUE)
			{
				if(!$error1)
				{
				 $avatar1->move(ROOTPATH . 'uploads/cms_images/',$file_name1);
				}
				if(!$error2)
				{
				 $avatar2->move(ROOTPATH . 'uploads/cms_images/',$file_name2);
				}
				if(!$error3)
				{
				 $avatar3->move(ROOTPATH . 'uploads/cms_images/',$file_name3);
				}
				if(!$error4)
				{
				 $avatar4->move(ROOTPATH . 'uploads/cms_images/',$file_name4);
				}
				if(!$error5)
				{
				 $avatar5->move(ROOTPATH . 'uploads/cms_images/',$file_name5);
				}
				if(!$error6)
				{
				 $avatar6->move(ROOTPATH . 'uploads/cms_images/',$file_name6);
				}
				if(!$error7)
				{
				 $avatar7->move(ROOTPATH . 'uploads/cms_images/',$file_name7);
				}
				if(!$error8)
				{
				 $avatar8->move(ROOTPATH . 'uploads/cms_images/',$file_name8);
				}
				$this->msg = array('msg'=>'Record saved successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/cms'));
			}
			else
			{
				$this->msg = array('msg'=>'Somthing went wrong. Please try again!', 'msg_type'=>'error');
				$this->session->setFlashdata($this->msg);
				return $this->add();
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
		$activedata['active']	=8;
		
		$page_id = base64_decode($id);
		$cond = array('page_id'=>$page_id);
		
		$page_list = $this->buildTree($this->model->getRows('cms_page','',array('page_status'=>1)));
		$rec = $this->model->getRows('cms_page','',array('page_id'=>$page_id));
		$submit = 'Update'; 
		
		
		$this->data = $this->model->getRows('cms_page', '*', $cond, 'display_order', 'ASC');		
		$act = base_url('backoffice/cms/update/'.$id);
		//return render('backoffice/cms/add_cms_page', ['CmsData'=>$this->data, 'validation'=>$this->validation, 'act'=>$act, 'page_list'=> $page_list, 'rec'=>$rec, 'submit'=>$submit]); 
	
		echo view('backoffice/template/includes/header');
		echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
		echo view('backoffice/cms/add_cms_page', ['CmsData'=>$this->data, 'validation'=>$this->validation, 'act'=>$act, 'page_list'=> $page_list, 'rec'=>$rec, 'submit'=>$submit]);
		echo view('backoffice/template/includes/footer');
	}
	
	public function update($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$activedata['active'] = 8;
		
		$current_user_id = $this->session->get('admin_login_id');
		
		$page_id = base64_decode($id);
		$cond = array('page_id'=>$page_id);
		
		$page_list = $this->buildTree($this->model->getRows('cms_page','',array('page_status'=>1)));
		$rec = $this->model->getRows('cms_page','',array('page_id'=>$page_id));
		$submit = lang('UPDATE_BTN');
		
		$this->data = $this->model->getRows( 'cms_page', '*', $cond);
				
		if (!$this->validation())
		{
			$pageslug = $this->model->getRows('cms_page', 'page_slug', $cond);
			$slug = $pageslug[0]['page_slug'];
			
			$form_add_data = array(
				'parent_id' => trim($this->request->getVar('parent_id')),
				'page_name' => trim($this->request->getVar('page_name')),
				'heading' => trim($this->request->getVar('heading')),
				'page_slug' => trim($slug),
				//'menu_type' => trim($this->request->getVar('menu_type')),
				'tag_line' => trim($this->request->getVar('tag_line')),
				'section1' => $this->request->getVar('section1'),
				'section2' => $this->request->getVar('section2'),
				'section3' => $this->request->getVar('section3'),
				'section4' => $this->request->getVar('section4'),
				'section5' => $this->request->getVar('section5'),
				'section6' => $this->request->getVar('section6'),
				'section7' => $this->request->getVar('section7'),
				'section8' => $this->request->getVar('section8'),
				'display_order' => trim($this->request->getVar('display_order')),
				'mega_menu' => trim($this->request->getVar('mega_menu')),
				'page_title' => trim($this->request->getVar('page_title')),
				'meta_keywords' => trim($this->request->getVar('meta_keywords')),
				'meta_description' => trim($this->request->getVar('meta_description')),
				'page_status' => trim($this->request->getVar('page_status')),
				'enquiry_page' => trim($this->request->getVar('enquiry_page')),
				'updated_date' => date('Y-m-d'),
				'updated_by' => $current_user_id
			);
			$formdata[] = $form_add_data;
			//return render('backoffice/cms/add_cms_page', ['CmsData'=>$formdata, 'validation'=>$this->validation, 'parent_page_list'=> $parent_page_list, 'page_list'=> $page_list, 'rec'=>$rec, 'submit'=>$submit]);		
		
			echo view('backoffice/template/includes/header');
			echo view('backoffice/template/includes/sidemenu',['Data'=>$this->activedata]);
			echo view('backoffice/cms/add_cms_page', ['CmsData'=>$formdata, 'validation'=>$this->validation, 'parent_page_list'=> $parent_page_list, 'page_list'=> $page_list, 'rec'=>$rec, 'submit'=>$submit]);
			echo view('backoffice/template/includes/footer');

		}
		else
		{		

			$pageslug = $this->model->getRows('cms_page', 'page_slug', $cond);
			$slug = $pageslug[0]['page_slug'];
			$avatar1 = $this->request->getFile('image1');
			$avatar2 = $this->request->getFile('image2');
			$avatar3 = $this->request->getFile('image3');
			$avatar4 = $this->request->getFile('image4');
			$avatar5 = $this->request->getFile('image5');
			$avatar6 = $this->request->getFile('image6');
			$avatar7 = $this->request->getFile('image7');
			$avatar8 = $this->request->getFile('image8');
			$error1 = $avatar1->getError();
			if(!$error1)
			{
			   $file_name1 = $avatar1->getRandomName();
			   $avatar1->move(ROOTPATH . 'uploads/cms_images/',$file_name1);
			}
			else
			{
				$file_name1 = $this->request->getVar('OldCMSImage1');	
			}
			$error2 = $avatar2->getError();
			if(!$error2)
			{
			   $file_name2 = $avatar2->getRandomName();
			   $avatar2->move(ROOTPATH . 'uploads/cms_images/',$file_name2);
			}
			else
			{
				$file_name2 = $this->request->getVar('OldCMSImage2');	
			}
			$error3 = $avatar3->getError();
			if(!$error3)
			{
			  $file_name3 = $avatar3->getRandomName();
			  $avatar3->move(ROOTPATH . 'uploads/cms_images/',$file_name3);
			}
			else
			{
				$file_name3 = $this->request->getVar('OldCMSImage3');	
			}
			$error4 = $avatar4->getError();
			if(!$error4)
			{
			  $file_name4 = $avatar4->getRandomName();
			  $avatar4->move(ROOTPATH . 'uploads/cms_images/',$file_name4);
			}
			else
			{
				$file_name4 = $this->request->getVar('OldCMSImage4');	
			}
			$error5 = $avatar5->getError();
			if(!$error5)
			{
			   $file_name5 = $avatar5->getRandomName();
			   $avatar5->move(ROOTPATH . 'uploads/cms_images/',$file_name5);
			}
			else
			{
				$file_name5 = $this->request->getVar('OldCMSImage5');	
			}
			$error6 = $avatar6->getError();
			if(!$error6)
			{
			  $file_name6 = $avatar6->getRandomName();
			  $avatar6->move(ROOTPATH . 'uploads/cms_images/',$file_name6);
			}
			else
			{
				$file_name6 = $this->request->getVar('OldCMSImage6');	
			}
			$error7 = $avatar7->getError();
			if(!$error7)
			{
			  $file_name7 = $avatar7->getRandomName();
			  $avatar7->move(ROOTPATH . 'uploads/cms_images/',$file_name7);
			}
			else
			{
				$file_name7 = $this->request->getVar('OldCMSImage7');	
			}
            $error8 = $avatar8->getError();
			if(!$error8)
			{
			  $file_name8 = $avatar8->getRandomName();
			  $avatar8->move(ROOTPATH . 'uploads/cms_images/',$file_name8);
			}
			else
			{
				$file_name8 = $this->request->getVar('OldCMSImage8');	
			}
			$this->data = array(
				'parent_id' => trim($this->request->getVar('parent_id')),
				'page_name' => trim($this->request->getVar('page_name')),
				'heading' => trim($this->request->getVar('heading')),
				'page_slug' => trim($slug),
				//'menu_type' => trim($this->request->getVar('menu_type')),
				'tag_line' => trim($this->request->getVar('tag_line')),
				'section1' => $this->request->getVar('section1'),
				'section2' => $this->request->getVar('section2'),
				'section3' => $this->request->getVar('section3'),
				'section4' => $this->request->getVar('section4'),
				'section5' => $this->request->getVar('section5'),
				'section6' => $this->request->getVar('section6'),
				'section7' => $this->request->getVar('section7'),
				'section8' => $this->request->getVar('section8'),
				'display_order' => trim($this->request->getVar('display_order')),
				'mega_menu' => trim($this->request->getVar('mega_menu')),
				'image1' => trim($file_name1),
				'image2' => trim($file_name2),
				'image3' => trim($file_name3),
				'image4' => trim($file_name4),
				'image5' => trim($file_name5),
				'image6' => trim($file_name6),
				'image7' => trim($file_name7),
				'image8' => trim($file_name8),
				'page_title' => trim($this->request->getVar('page_title')),
				'meta_keywords' => trim($this->request->getVar('meta_keywords')),
				'meta_description' => trim($this->request->getVar('meta_description')),
				'page_status' => trim($this->request->getVar('page_status')),
				'enquiry_page' => trim($this->request->getVar('enquiry_page')),
				'updated_date' => date('Y-m-d'),
				'updated_by' => $current_user_id
			);
			
			if((bool)$this->model->updateRecord('cms_page', $this->data, $cond) === TRUE)
			{
				if(!$error)
				{
					
				}
				$this->msg = array('msg'=>'Record updated successfully!', 'msg_type'=>'success');
				$this->session->setFlashdata($this->msg);
				return redirect()->to(base_url('backoffice/cms'));
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
		$page_id = base64_decode($id);
		$cond = array('page_id'=>$page_id);
		$pageData = $this->model->getRowArray('cms_page', '*', $cond);
		if((bool)$this->model->deleteRecord('cms_page', $cond) === TRUE)
		{
			if(file_exists('uploads/cms_images/'.$pageData['image1'])){
                unlink('uploads/cms_images/'.$pageData['image1']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image2'])){
                unlink('uploads/cms_images/'.$pageData['image2']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image3'])){
                unlink('uploads/cms_images/'.$pageData['image3']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image4'])){
                unlink('uploads/cms_images/'.$pageData['image4']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image5'])){
                unlink('uploads/cms_images/'.$pageData['image5']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image6'])){
                unlink('uploads/cms_images/'.$pageData['image6']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image7'])){
                unlink('uploads/cms_images/'.$pageData['image7']);
            }
            if(file_exists('uploads/cms_images/'.$pageData['image8'])){
                unlink('uploads/cms_images/'.$pageData['image8']);
            }
			$this->msg = array('msg'=>'Record delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/cms'));
		}
	}
	
	
	public function active($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
				
		$page_id = base64_decode($id);
		$cond = array('page_id'=>$page_id);
		$this->data = array('page_status' => "1");
		
		if((bool)$this->model->updateRecord('cms_page', $this->data, $cond) === TRUE)
		{	
			$this->msg = array('msg'=>'Record active successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/cms'));
		}
	}	
	
    public function deactive($id='')
	{
		if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		} 
		
		$page_id = base64_decode($id);
		$cond = array('page_id'=>$page_id);
		$this->data = array('page_status' => "0");
		
		if((bool)$this->model->updateRecord('cms_page', $this->data, $cond) === TRUE)
		{
			$this->msg = array('msg'=>'Record deacivate successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/cms'));
		}
	}
	
	public function buildTree($data, $parent = 0) 
	{
		$tree = array();
		foreach ($data as $d) {
			if ($d['parent_id'] == $parent) 
			{
				$children = $this->buildTree($data, $d['page_id']);
				if (!empty($children)) {
					$d['children'] = $children;
				}
				$tree[] = $d;
			}
		}
		return $tree;
	} 
	
	public function validation()
	{
		return $this->validate([
			'parent_id' => [
				'label'  => 'Parent Page',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Parent Page is required.'
				]
			],
			'page_name' => [
				'label'  => 'Page Name',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Page Name is required.'
				]
			]
			

		]); 
	}
	
	public function delet_page_image($column_name,$id)
	{
	    if((bool)$this->session->get('IsAdminLoggedIn') == FALSE)
		{
			return redirect()->to(base_url('backoffice/login'));
			exit();
		}
		$postid = base64_decode($id);
		$cond = array('page_id'=>$postid);
		$pageData = $this->model->getRowArray('cms_page', '*', $cond);
		$this->data = array($column_name =>'');
		
		if((bool)$this->model->updateRecord('cms_page', $this->data, $cond) === TRUE)
		{
		    if(file_exists('uploads/cms_images/'.$pageData[$column_name])){
                unlink('uploads/cms_images/'.$pageData[$column_name]);
            }
        
			$this->msg = array('msg'=>'Image delete successfully!', 'msg_type'=>'success');
			$this->session->setFlashdata($this->msg);
			return redirect()->to(base_url('backoffice/cms'));
		}
	}
	
}