<?php 
if(!empty($data['faculty'])){
	$facultyData = $data['faculty'][0];
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
										<h3 class="m-portlet__head-text">Add Faculty</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/faculty') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_faculty" id="add_faculty">	
							
								 
								 <div class="media_section">
									 <div class="form-group m-form__group row">
									  <label class="col-lg-2 col-form-label">Select Campus</label>
										<div class="col-lg-8" id="select_media_div">		 							
											<select class="form-control m-bootstrap-select m_selectpicker" name="campus[]" id="campus" multiple>
												<?php   if($facultyData['campus_id']){ 
										
            										$explode_events    =   explode(",",$facultyData['campus_id']);
                    							}
            								?>
												<?php if($campus_type){ foreach($campus_type as $type){ ?>
													<option value="<?php echo $type['campus_id'] ?>" <?php if($facultyData['campus_id']){ if(in_array($type['campus_id'],$explode_events)){ echo 'selected';} } ?>><?php echo $type['campus_name'] ?></option>
												<?php } } ?>
											</select>								
																				
										</div>
									 </div>	
								  </div>

                                <div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Department<span class="error">*</span></label>
									<div class="col-lg-8" id="select_category_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker	" name="department_id" id="department_id">
										<option value="">Please Select</option>
											<?php if($data['department']){ foreach($data['department'] as $type){ ?>
												<option value="<?php echo $type['department_id'] ?>" <?php if($facultyData['department_id'] == $type['department_id']){ echo 'selected';} ?>><?php echo $type['department_name'] ?></option>
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
							      <label class="col-lg-2 col-form-label">Designation<span class="error">*</span></label>
									<div class="col-lg-8">		 							
										<select class="form-control m-bootstrap-select m_selectpicker" name="designation_id[]" id="designation_id" multiple>
										<option value="">Select Designation</option>
										<?php if(!empty($data['designation'])){
											foreach($data['designation'] as $des_value){?>
											<option <?php 
												if(in_array($des_value['designation_id'], explode(',', $facultyData['designation_id']))) echo 'selected';
											?> value="<?php echo $des_value['designation_id'];?>"><?php echo $des_value['designation_name'];?></option>
										<?php }}?>
										</select>
											<p class="help-block error text-red"> 
												<?php
												if(isset($_POST['form_submit']))
												{
													echo ($validation->hasError('designation_id')) ?  $validation->getError('designation_id') : '';
												}?>
											</p>								
										</div>
								 </div>
								 
								 
								 

								 

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Faculty Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="faculty_name" class="form-control" value="<?php if($facultyData){ echo $facultyData['faculty_name'];}else{ echo set_value('faculty_name'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('faculty_name')) ?  $validation->getError('faculty_name') : '';
											}?>
										</p>
										</div>
								</div>	

								

								
								<div class="form-group m-form__group row ">
								<label class="col-lg-2 col-form-label">Faculty Image</label>
								
								
								<div class="col-lg-8 col-md-9 col-sm-12">
									<input type="file" class="form-control" id="faculty_image" name="faculty_image" accept=".png, .jpg, .jpeg">
									<p class="help-block message">File should be in .jpg, .png format.</p>
									
									<?php if($facultyData['faculty_image']) { ?>
									<input type="hidden" name="old_faculty_image" value="<?php echo ($facultyData['faculty_image']) ? $facultyData['faculty_image'] : ''; ?>">
									<div id="BannerImagehide" class="col-lg-4">	
										<img src="<?php echo base_url('uploads/faculty_images/').''.$facultyData['faculty_image'] ?>" style="width:200px; margin-bottom:10px;" class="img_hover">
											<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/faculty/delete_faculty_image/'.base64_encode($facultyData['faculty_id'])) ?>">
												<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
											</a>
										
									</div>
									<?php } ?>
								
								</div>
							</div>
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Profile</label>
									<div class="col-lg-8 col-md-9 col-sm-12">
										<textarea  name="short_description" id="short_description"  class="form-control editor1"  rows="10"><?php echo ($facultyData['short_description']) ? $facultyData['short_description'] : ''; ?></textarea>
										<p class="help-block error"></p>
									</div>
								</div>
							    <div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Linkedin</label>
									<div class="col-lg-8 col-md-9 col-sm-12">
									    <input type="url" name="linkedin" class="form-control" value="<?php if($facultyData){ echo $facultyData['linkedin'];}else{ echo set_value('linkedin'); } ?>">
									 
									</div>
								</div>	
								
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Email</label>
									<div class="col-lg-8 col-md-9 col-sm-12">
									    <input type="email" name="email" class="form-control" value="<?php if($facultyData){ echo $facultyData['email'];}else{ echo set_value('email'); } ?>">
									 
									</div>
								</div>	
									
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Education</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="education" id="education" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['education']) ? $facultyData['education'] : ''?></textarea>
								</div>
							</div>
							
							
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Experience</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="experience" id="experience" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['experience']) ? $facultyData['experience'] : ''?></textarea>
								</div>
							</div>
							
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Research</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="research" id="research" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['research']) ? $facultyData['research'] : ''?></textarea>
								</div>
							</div>
							
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Conferences</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="conference" id="conference" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['conference']) ? $facultyData['conference'] : ''?></textarea>
								</div>
							</div>
							
							
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Projects/Achievements</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="achievement" id="achievement" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['achievement']) ? $facultyData['achievement'] : ''?></textarea>
								</div>
							</div>
							
							
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Publications</label>
								<div class="col-lg-8 col-md-9 col-sm-12">	
									<textarea name="publication" id="publication" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['publication']) ? $facultyData['publication'] : ''?></textarea>
								</div>
							</div>
							
							
					
							<!--<div class="form-group m-form__group row">-->
							<!--	<label class="col-lg-2 col-form-label">Description</label>-->
							<!--	<div class="col-lg-8 col-md-9 col-sm-12">	-->
							<!--		<textarea name="description" id="description" cols="80" rows="10" class="form-control editor1" ><?php echo ($facultyData['description']) ? $facultyData['description'] : ''?></textarea>-->
							<!--	</div>-->
							<!--</div>-->
							
							 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if($facultyData){ echo  $facultyData['faculty_display_order'];}else{ echo  $maxdata[0]['faculty_display_order']+1; } ?>">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($facultyData['faculty_status'] == 1 || !isset($facultyData)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($facultyData['faculty_status'] == 0 && isset($facultyData)) ? 'checked="checked"': '' ?>> Inactive
													<span></span>
												</label>
												
											</div>																				
											<span class="errorr"></span>								
										</div>								
									 </div>	
								
							</div>
																			
						<div class="clear"></div>
													
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	Submit</span></span></button>	
												<a href="<?php echo base_url('backoffice/faculty') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
																						
																				
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
