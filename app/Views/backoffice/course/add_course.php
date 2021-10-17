<?php 
if(!empty($editData)){
	$editPageData = $editData[0];
}
?>
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
		<div class="m-grid__item m-grid__item--fluid m-wrapper">		
			<div class="m-content">
			<?php if($_SESSION['msg']){?>
				<div class="alert alert-<?php echo $_SESSION['msg_type'];?> alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $_SESSION['msg'];?> </div>
			<?php } ?>			
				<div class="row">				
					<div class="col-lg-12">					
						<!--begin::Portlet-->					
						<div class="m-portlet">						
							<div class="m-portlet__head">							
								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										<h3 class="m-portlet__head-text">Add Course</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/course') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_campus" id="add_campus">	
								
								<div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">College<span class="error">*</span></label>
									<div class="col-lg-8" id="college_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker	" name="college_id" id="college_id">
										<option value="">Please Select</option>
											<?php if($type_data['college']){ foreach($type_data['college'] as $type){ ?>
												<option value="<?php echo $type['id'] ?>" <?php if($editPageData['college_id'] == $type['id']){ echo 'selected';} ?>><?php echo $type['name'] ?></option>
											<?php  } } ?>
										</select>								
											<p class="help-block error text-red">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('college_id')) ?  $validation->getError('college_id') : '';
													}?>
											</p>								
										</div>
								 </div>	
								 
								 <div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Department<span class="error">*</span></label>
									<div class="col-lg-8" id="dep_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker	" name="department_id" id="department_id">
										<option value="">Please Select</option>
										
											<?php if($department){ foreach($department as $type){ ?>
												<option value="<?php echo $type['department_id'] ?>" <?php if($editPageData['department_id'] == $type['department_id']){ echo 'selected';} ?>><?php echo $type['department_name'] ?></option>
											<?php  } } ?>
											
										</select>								
											<p class="help-block error text-red">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('department_id')) ?  $validation->getError('department_id') : '';
													}?>
											</p>								
										</div>
								 </div>	
								 
								 <div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Program<span class="error">*</span></label>
									<div class="col-lg-8" id="program_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker	" name="program_id" id="program_id">
										<option value="">Please Select</option>
											<?php if($type_data['program']){ foreach($type_data['program'] as $type){ ?>
												<option value="<?php echo $type['id'] ?>" <?php if($editPageData['program_id'] == $type['id']){ echo 'selected';} ?>><?php echo $type['name'] ?></option>
											<?php  } } ?>
										</select>								
											<p class="help-block error text-red">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('program_id')) ?  $validation->getError('program_id') : '';
													}?>
											</p>								
										</div>
								 </div>	
								 
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Course Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="course_name" class="form-control" value="<?php if($editPageData){ echo $editPageData['course_name'];}else{ echo set_value('course_name'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('course_name')) ?  $validation->getError('course_name') : '';
											}?>
										</p>
										</div>
								</div>	
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Course Slug <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="course_slug" class="form-control" value="<?php if($editPageData){ echo $editPageData['course_slug'];}else{ echo set_value('course_slug'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('course_slug')) ?  $validation->getError('course_slug') : '';
											}?>
										</p>
										</div>
								</div>	
								
								
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Course Image</label>
									
									
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="course_image" name="course_image" accept=".png, .jpg, .jpeg">
										<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
										<p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('course_image')) ?  $validation->getError('course_image') : '';
											}?>
										</p>
										<?php if($editPageData['course_image']) { ?>
										<input type="hidden" name="OldcourseImage" value="<?php echo ($editPageData['course_image']) ? $editPageData['course_image'] : '' ?>">
										<div  class="col-lg-4">	
											<img src="<?php echo base_url('uploads/course/').$editPageData['course_image']; ?>" style="width:140px; margin-bottom:10px;" class="img_hover">
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/course/delete_image/'.$editPageData['id']) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
									</div>
								</div>
								
								
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Duration</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="duration" class="form-control" value="<?php if($editPageData){ echo $editPageData['duration'];}else{ echo set_value('duration'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('duration')) ?  $validation->getError('duration') : '';
											}?>
										</p>
										</div>
								</div>



								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Semesters</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="number" name="semester" class="form-control" value="<?php if($editPageData){ echo $editPageData['semester'];}else{ echo set_value('semester'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('semester')) ?  $validation->getError('semester') : '';
											}?>
										</p>
										</div>
								</div>								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Overview</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="overview" id="overview" cols="" rows="20" class="form-control"><?php if($editPageData){  echo $editPageData['overview'];}else{ echo set_value('overview'); } ?></textarea>
									</div>
									
								</div>
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Eligibility</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="eligibility" id="eligibility" cols="" rows="20" class="form-control"><?php if($editPageData){  echo $editPageData['eligibility'];}else{ echo set_value('eligibility'); } ?></textarea>
									</div>
									<p class="help-block"></p>
								</div>
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Objective</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="objective" id="objective" cols="" rows="20" class="form-control"><?php if($editPageData){  echo $editPageData['objective'];}else{ echo set_value('objective'); } ?></textarea>
									</div>
									<p class="help-block"></p>
								</div>
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Outcome</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="outcome" id="outcome" cols="" rows="20" class="form-control"><?php if($editPageData){  echo $editPageData['outcome'];}else{ echo set_value('outcome'); } ?></textarea>
									</div>
									<p class="help-block"></p>
								</div>
								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Opportunities</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="opportunities" id="opportunities" cols="" rows="20" class="form-control"><?php if($editPageData){  echo $editPageData['opportunities'];}else{ echo set_value('opportunities'); } ?></textarea>
									</div>
									<p class="help-block"></p>
								</div>
								
								
								
								
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if($editPageData){ echo  $editPageData['display_order'];}else{ echo  $maxdata[0]['display_order']+1; } ?>">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($editPageData['status'] == 1 || !isset($editPageData)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($editPageData['status'] == 0 && isset($editPageData)) ? 'checked="checked"': '' ?>> Inactive
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
									<input type="text" name="page_title" class="form-control" value="<?php echo ($editPageData['page_title']) ? $editPageData['page_title'] : ''?>">
								</div>
								<p class="help-block"></p>
							</div>
						
						<div class="form-group m-form__group row">	
							<label class="col-lg-2 col-form-label">Page Meta Description </label>
							<div class="col-lg-8 col-md-9 col-sm-12">	
								<textarea name="meta_description" id="meta_description" cols="80" rows="10" class="form-control"><?php echo ($editPageData['meta_description']) ? $editPageData['meta_description'] : ''; ?></textarea>
							</div>
							<p class="help-block"></p>
						</div>
						<div class="form-group m-form__group row">	
							<label class="col-lg-2 col-form-label">Page Meta Keywords </label>
							<div class="col-lg-8 col-md-9 col-sm-12">	
								<textarea name="meta_keywords" id="meta_keywords" cols="80" rows="10" class="form-control"><?php echo ($editPageData['meta_keywords']) ? $editPageData['meta_keywords'] : ''; ?></textarea>
							</div>
							<p class="help-block"></p>
						</div>
									 
							
						
																	
						<div class="clear"></div>
								
								
								
														
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	Submit</span></span></button>	
												<a href="<?php echo base_url('backoffice/course') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
													
																								
																				
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

<script>
$(document).on('change', '#college_id', function(e) {
	var current_id	=	$(this).val();
	$.ajax({
		url: "<?php echo base_url();?>backoffice/course/department_dropdown",
		method : "POST",
		data : {current_id:current_id},
		async : true,
		dataType : 'json',
		success: function(data){
			 $('#dep_div').html(data.dropdown);
		}
	});
});
</script>
