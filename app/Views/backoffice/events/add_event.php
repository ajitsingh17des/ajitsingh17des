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
										<h3 class="m-portlet__head-text">Add Event </h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/events') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
									<div class="media_section">
									 <div class="form-group m-form__group row">
									  <label class="col-lg-2 col-form-label">Select Campus</label>
										<div class="col-lg-8" id="select_media_div">		 							
											<select class="form-control m-bootstrap-select m_selectpicker" name="campus[]" id="campus" multiple>
												<?php   if($editPageData['campus_id']){ 
										
            										$explode_events    =   explode(",",$editPageData['campus_id']);
                    							}
            								?>
												<?php if($campus_type){ foreach($campus_type as $type){ ?>
													<option value="<?php echo $type['campus_id'] ?>" <?php if($editPageData['campus_id']){ if(in_array($type['campus_id'],$explode_events)){ echo 'selected';} } ?>><?php echo $type['campus_name'] ?></option>
												<?php } } ?>
											</select>								
																				
										</div>
									 </div>	
								  </div>
								
								<div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Type:<span class="error">*</span></label>
									<div class="col-lg-8" id="select_category_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker" name="event_type" id="event_type">
										<option value="">Please Select</option>
											<?php if($event_type){ foreach($event_type as $type){ ?>
												<option value="<?php echo $type['id'] ?>" <?php if($editPageData['event_type'] == $type['id']){ echo 'selected';} ?>><?php echo $type['title'] ?></option>
											<?php  } } ?>
										</select>								
											<p class="help-block error text-red" style="color:red;">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('event_type')) ?  $validation->getError('event_type') : '';
													}?>
											</p>								
										</div>
								 </div>	
								 
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Title </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="title" class="form-control" value="<?php if($editPageData){ echo $editPageData['title'];}else{ echo set_value('name'); } ?>">
										 <p class="help-block error text-red" style="color:red;">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('title')) ?  $validation->getError('title') : '';
											}?>
										</p>
										</div>
								</div>	
								
								
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Event Image<span class="error">*</span></label>
									
									
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="catagog_image" name="catagog_image" accept=".png, .jpg, .jpeg">
										<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
										<p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('image')) ?  $validation->getError('image') : '';
											}?>
										</p>
										<?php if($editPageData['image']) { ?>
										<input type="hidden" name="OldCatagogImage" value="<?php echo ($editPageData['image']) ? $editPageData['image'] : '' ?>">
										<div  class="col-lg-4">	
											<img src="<?php echo base_url('uploads/events/').$editPageData['image']; ?>" style="width:140px; margin-bottom:10px;" class="img_hover">
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/events/delete_image/'.base64_encode($editPageData['id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
									</div>
								</div>
								
								
								
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Home Event Banner Image</label>
									
									
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="catagog_image1" name="catagog_image1" accept=".png, .jpg, .jpeg">
										<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
										<p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('catagog_image1')) ?  $validation->getError('catagog_image1') : '';
											}?>
										</p>
										<?php if($editPageData['banner_images1']) { ?>
										<input type="hidden" name="OldCatagogImage1" value="<?php echo ($editPageData['banner_images1']) ? $editPageData['banner_images1'] : '' ?>">
										<div  class="col-lg-4">	
											<img src="<?php echo base_url('uploads/events/banner_images/').$editPageData['banner_images1']; ?>" style="width:140px; margin-bottom:10px;" class="img_hover">
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/events/delete_logo_image1/'.base64_encode($editPageData['id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
									</div>
								</div>
								
								
								
								
									<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Date</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" name="event_date" class="form-control m_datepicker_1_modal" id="m_datepicker_1_modal" readonly placeholder="Select Event date" value="<?php if($editPageData){ echo date('m/d/Y', strtotime($editPageData['event_date']));}else{ echo set_value('event_date'); } ?>" />
										 
											
										 </div>
								</div>
								
							
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Description</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="description" id="description" cols="80" rows="10" class="form-control editor"><?php if($editPageData){  echo $editPageData['description'];}else{ echo set_value('description'); } ?></textarea>
									</div>
									<p class="help-block"></p>
								</div>
						
								<div class="media_section">
									 <div class="form-group m-form__group row">
									  <label class="col-lg-2 col-form-label">Select Related Events:</label>
										<div class="col-lg-8" id="select_media_div">		 							
											<select class="form-control m-bootstrap-select m_selectpicker" name="related_events[]" id="related_events" multiple>
												<?php   if($editPageData['related_event_id']){ 
										
            										$explode_events    =   explode(",",$editPageData['related_event_id']);
                    							}
            								?>
												<?php if($related_events){ foreach($related_events as $type){ ?>
													<option value="<?php echo $type['id'] ?>" <?php if($editPageData['related_event_id']){ if(in_array($type['id'],$explode_events)){ echo 'selected';} } ?>><?php echo $type['title'] ?></option>
												<?php } } ?>
											</select>								
																				
										</div>
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
												<a href="<?php echo base_url('backoffice/events') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
