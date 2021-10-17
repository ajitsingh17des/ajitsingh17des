<?php 
$page_data = $CmsData[0];
$session = \Config\Services::session($config);
$userData = $session->get('user_data');	

function printTree($tree,$submit,$dataId, $r = 0, $p = null) {
	foreach ($tree as $i => $t) {
		$dash = ($t['parent_id'] == 0) ? '' : str_repeat('&raquo; ', $r) .' ';
		$selected = '';
		if(set_value('parent_id'))
		{
			if(set_value('parent_id') == $t['page_id']){
				$selected = 'selected="selecetd"';
			}
		}
		elseif($submit == 'Update')
		{
			if($dataId == $t['page_id']){
				$selected = 'selected="selecetd"';
			}
		}
		echo '<option '.$selected.' value="'.$t['page_id'].'">'.$dash.$t['page_name'].'</option>';

		if (isset($t['children'])) {
			printTree($t['children'],$submit,$dataId, $r+1, $t['parent_id']);
		}
	}
}	
?>
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
		<div class="m-grid__item m-grid__item--fluid m-wrapper">		
			<div class="m-content">			
				<div class="row">				
					<div class="col-lg-12">					
						<!--begin::Portlet-->					
						<div class="m-portlet">						
							<div class="m-portlet__head">							
								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										<h3 class="m-portlet__head-text">Add CMS</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/cms') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" role="form"  method="post" action="<?php echo ($act) ? ($act) : '' ?>" enctype="multipart/form-data" name="add_cms" id="add_cms">	
								
								
								<div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Parent Page<span class="error">*</span></label>
									<div class="col-lg-8">		 							
										<select class="form-control" name="parent_id" id="parent_id">
											<option value="0">Default Page</option>
											<?php printTree($page_list,$submit,@$rec[0]['parent_id']); ?>
										  </select>
											<p class="help-block error text-red"> 
												<?php
												if(isset($_POST['form_submit']))
												{
													echo ($validation->hasError('parent_id')) ?  $validation->getError('parent_id') : '';
												}?>
											</p>								
										</div>
								 </div>	
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Page Name<span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="page_name" class="form-control" value="<?php echo ($page_data['page_name']) ? $page_data['page_name'] : ''; ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('page_name')) ?  $validation->getError('page_name') : '';
											}?>
										</p>
										</div>
								</div>				
					<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Page Heading</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="heading" class="form-control" value="<?php echo ($page_data['heading']) ? $page_data['heading'] : ''; ?>">										
										</div>
								</div>
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 1</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section1" id="section1" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section1']) ? $page_data['section1'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 1</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image1" name="image1" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image1']) { ?>
									<input type="hidden" name="OldCMSImage1" value="<?php echo ($page_data['image1']) ? $page_data['image1'] : ''; ?>">
									<div id="BannerImagehide1" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image1'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image1/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
							
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 2</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section2" id="section2" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section2']) ? $page_data['section2'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 2</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image2" name="image2" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image2']) { ?>
									<input type="hidden" name="OldCMSImage2" value="<?php echo ($page_data['image2']) ? $page_data['image2'] : ''; ?>">
									<div id="BannerImagehide2" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image2'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image2/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 3</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section3" id="section3" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section3']) ? $page_data['section3'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 3</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image3" name="image3" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image3']) { ?>
									<input type="hidden" name="OldCMSImage3" value="<?php echo ($page_data['image3']) ? $page_data['image3'] : ''; ?>">
									<div id="BannerImagehide3" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image3'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image3/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 4</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section4" id="section4" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section4']) ? $page_data['section4'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 4</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image4" name="image4" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image4']) { ?>
									<input type="hidden" name="OldCMSImage4" value="<?php echo ($page_data['image4']) ? $page_data['image4'] : ''; ?>">
									<div id="BannerImagehide4" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image4'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image4/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
                            <div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 5</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section5" id="section5" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section5']) ? $page_data['section5'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 5</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image5" name="image5" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image5']) { ?>
									<input type="hidden" name="OldCMSImage5" value="<?php echo ($page_data['image5']) ? $page_data['image5'] : ''; ?>">
									<div id="BannerImagehide5" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image5'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image5/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
                            <div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 6</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section6" id="section6" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section6']) ? $page_data['section6'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 6</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image6" name="image6" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image6']) { ?>
									<input type="hidden" name="OldCMSImage6" value="<?php echo ($page_data['image6']) ? $page_data['image6'] : ''; ?>">
									<div id="BannerImagehide6" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image6'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image6/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
                            <div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 7</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section7" id="section7" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section7']) ? $page_data['section7'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 7</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image7" name="image7" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image7']) { ?>
									<input type="hidden" name="OldCMSImage7" value="<?php echo ($page_data['image7']) ? $page_data['image7'] : ''; ?>">
									<div id="BannerImagehide7" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image7'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image7/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>
                            <div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Section 8</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="section8" id="section8" cols="80" rows="10" class="form-control editor" ><?php echo ($page_data['section8']) ? $page_data['section8'] : ''?></textarea>
								</div>
							</div>		
						
							<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Image 8</label>								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="image8" name="image8" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
									
									<?php if($page_data['image8']) { ?>
									<input type="hidden" name="OldCMSImage8" value="<?php echo ($page_data['image8']) ? $page_data['image8'] : ''; ?>">
									<div id="BannerImagehide8" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/cms_images/').''.$page_data['image8'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/cms/delet_page_image/image8/'.base64_encode($page_data['page_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
								    <?php } ?>								
								</div>							
							</div>







								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php echo ($next_display_order) ? $next_display_order : $page_data['display_order']; ?>">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="page_status" value="1" <?php echo ($page_data['page_status'] == 1) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="page_status" value="0" <?php echo ($page_data['page_status'] == 0) ? 'checked="checked"': '' ?>> Inactive
													<span></span>
												</label>
												
											</div>																				
											<span class="errorr"></span>								
										</div>								
									 </div>	
									 
									
									 
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											SEO Section
										</h3>
									</div>
								</div>
							</div>
						
						<div class="form-group m-form__group row">	
							<label class="col-lg-2 col-form-label">Page Title </label>
							<div class="col-lg-8 col-md-9 col-sm-12">	
								<input type="text" name="page_title" class="form-control" value="<?php echo ($page_data['page_title']) ? $page_data['page_title'] : ''?>">
							</div>
							<p class="help-block"></p>
						</div>
						<div class="form-group m-form__group row">	
							<label class="col-lg-2 col-form-label">Page Meta Keywords </label>
							<div class="col-lg-8 col-md-9 col-sm-12">	
								<input type="text" name="meta_keywords" class="form-control" value="<?php echo ($page_data['meta_keywords']) ? $page_data['meta_keywords'] : ''?>">
							</div>
							<p class="help-block"></p>
						</div>
						<div class="form-group m-form__group row">	
							<label class="col-lg-2 col-form-label">Page Meta Description </label>
							<div class="col-lg-8 col-md-9 col-sm-12">	
								<textarea name="meta_description" id="meta_description" cols="80" rows="10" class="form-control"><?php echo ($page_data['meta_description']) ? $page_data['meta_description'] : ''; ?></textarea>
							</div>
							<p class="help-block"></p>
						</div>
								
																	
						<div class="clear"></div>
								
								
								
														
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<a href="<?php echo base_url('backoffice/cms') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	Submit</span></span></button>											
																				
												</div>									
											</div>								
									</div>							
								</div>						
							</form>						
							<!--end::Form-->					
					</div>				
				</div>			
			</div>		
		</div>	
	</div>
</div><!-- end:: Body -->
