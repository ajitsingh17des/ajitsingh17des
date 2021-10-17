<?php 
if(!empty($testimonialAdd['testimonialData'])){
	$testimonialData = $testimonialAdd['testimonialData'][0];
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
										<h3 class="m-portlet__head-text">Add Testimonial Customer</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/testimonials') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($testimonialAdd['act']) ? $testimonialAdd['act'] : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
									<div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Testimonials Type<span class="error">*</span></label>
									<div class="col-lg-8" id="select_category_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker" name="type" id="type">
										<option value="">Please Select</option>					
											<option value="Teacher" <?php if($testimonialData['type']=='Teacher'){ echo 'selected';} ?>>Teacher</option>
											<option value="Student"<?php if($testimonialData['type'] == 'Student'){ echo 'selected';} ?>>Student</option>
											<option value="International"<?php if($testimonialData['type'] == 'International'){ echo 'selected';} ?>>International</option>
											<option value="Domestic"<?php if($testimonialData['type'] == 'Domestic'){ echo 'selected';} ?>>Domestic</option>
											<option value="Parents"<?php if($testimonialData['type'] == 'Parents'){ echo 'selected';} ?>>Parents</option>
											<option value="Alumni"<?php if($testimonialData['type'] == 'Alumni'){ echo 'selected';} ?>>Alumni</option>
											<option value="Faculty"<?php if($testimonialData['type'] == 'Faculty'){ echo 'selected';} ?>>Faculty</option>
										</select>								
											<p class="help-block error text-red">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('type')) ?  $validation->getError('type') : '';
													}?>
											</p>								
										</div>
								 </div>	
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="name" class="form-control" value="<?php if($testimonialData){ echo $testimonialData['name'];}else{ echo set_value('name'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('name')) ?  $validation->getError('name') : '';
											}?>
										</p>
										</div>
								</div>
							
								
								
								

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Organization</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="organization" class="form-control" value="<?php if($testimonialData){ echo $testimonialData['organization'];}else{ echo set_value('organization'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('organization')) ?  $validation->getError('organization') : '';
											}?>
										</p>
										</div>
								</div>	

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Designation <span class="error"></span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="designation" class="form-control" value="<?php if($testimonialData){ echo $testimonialData['designation'];}else{ echo set_value('designation'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('designation')) ?  $validation->getError('designation') : '';
											}?>
										</p>
										</div>
								</div>

							

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Short Description </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<textarea name="description" maxlength="200" class="form-control"><?php if($testimonialData){ echo $testimonialData['description'];}else{ echo set_value('description'); } ?></textarea>
										</div>
								</div>	
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Long Description </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<textarea name="long_description" maxlength="200" class="form-control editor"><?php if($testimonialData){ echo $testimonialData['long_description'];}else{ echo set_value('long_description'); } ?></textarea>
										</div>
								</div>	
								
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Image</label>
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="image" name="image" accept=".png, .jpg, .jpeg">
										
										
										<?php if($testimonialData['image']) { ?>
										<input type="hidden" name="Oldimage" value="<?php echo ($testimonialData['image']) ? $testimonialData['image'] : '' ?>">
										<div  class="col-lg-4">	
											<img src="<?php echo base_url('uploads/testimonial/').$testimonialData['image']; ?>" style="width:140px; margin-bottom:10px;" class="img_hover">
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/testimonials/delete_image/'.base64_encode($testimonialData['id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
									</div>
								</div>
								
								
						
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if($testimonialData){ echo  $testimonialData['display_order'];}else{ echo  $maxdata[0]['display_order']+1; } ?>">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($testimonialData['status'] == 1 || !isset($testimonialData)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($testimonialData['status'] == 0 && isset($testimonialData)) ? 'checked="checked"': '' ?>> Inactive
													<span></span>
												</label>
												
											</div>																				
											<span class="errorr"></span>								
										</div>								
									 </div>	
									 
									
									 
							
						
																	
						<div class="clear"></div>
								
								
								
														
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<a href="<?php echo base_url('backoffice/testimonials') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
