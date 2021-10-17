<?php $editPageData = $trusteesData;?>

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
										<h3 class="m-portlet__head-text">Add Trustees</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/trustees') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Name </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="name" class="form-control" value="<?php if($editPageData){ echo $editPageData['name'];}else{ echo set_value('name'); } ?>">
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
										<label class="col-lg-2 col-form-label">Designation </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="designation" class="form-control" value="<?php if($editPageData){ echo $editPageData['designation'];}else{ echo set_value('designation'); } ?>">										 
										</div>
								</div>							
								
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Profile Pic<span class="error">*</span></label>
									
									
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="image" name="image" accept=".png, .jpg, .jpeg">
										<p class="help-block message">File should be in .jpg, .png format. (311*311)db</p>
										<p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('image')) ?  $validation->getError('image') : '';
											}?>
										</p>
										<?php if($editPageData['image']) { ?>
										<input type="hidden" name="OldImage" value="<?php echo ($editPageData['image']) ? $editPageData['image'] : '' ?>">
										<div  class="col-lg-4">	
											<img src="<?php echo base_url('uploads/trustees/').$editPageData['image']; ?>" style="width:140px; margin-bottom:10px;" class="img_hover">
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/trustees/delete_logo_image/'.base64_encode($editPageData['trustees_id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
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
						
																	
						<div class="clear"></div>
								
													
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<a href="<?php echo base_url('backoffice/trustees') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
