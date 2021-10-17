<?php $editPageData = $CourseCategoryData[0];?>

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
										<h3 class="m-portlet__head-text">About Home Page</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/home_page') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Program Offered </label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="program_offered" id="program_offered" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['program_offered'];}else{ echo set_value('program_offered'); } ?></textarea>
									</div>
									<p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('program_offered')) ?  $validation->getError('program_offered') : '';
											}?>
										</p>
								</div> 
								
								
								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Student Development</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="student_development" id="student_development" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['student_development'];}else{ echo set_value('student_development'); } ?></textarea>
									</div>
									
								</div> 
								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Campus Life</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="campus_life" id="campus_life" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['campus_life'];}else{ echo set_value('campus_life'); } ?></textarea>
									</div>
									
								</div> 
								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Research</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="research" id="research" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['research'];}else{ echo set_value('research'); } ?></textarea>
									</div>
									
								</div> 
								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Happenings</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="happenings" id="happenings" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['happenings'];}else{ echo set_value('happenings'); } ?></textarea>
									</div>
									
								</div> 
								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">About Reva</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="about_klu" id="about_klu" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['about_klu'];}else{ echo set_value('about_klu'); } ?></textarea>
									</div>
									
								</div> 
								
								
								
								
						
								
								
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if($editPageData){ echo  $editPageData['display_order'];}else{ echo  $maxData[0]['display_order']+1; } ?>">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($editPageData['status'] == 1) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($editPageData['status'] == 0) ? 'checked="checked"': '' ?>> Inactive
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
												<a href="<?php echo base_url('backoffice/home_page') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
