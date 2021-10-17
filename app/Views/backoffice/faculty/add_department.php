<?php 
if(!empty($departmentData)){
	$departmentData = $departmentData;
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
										<h3 class="m-portlet__head-text"><?php if(isset($departmentData) && $departmentData!=''){echo 'Edit';}else{echo 'Add';} ?> Department</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/department') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_department" id="add_department">	
								
								<div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">School<span class="error">*</span></label>
									<div class="col-lg-8" id="select_category_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker	" name="college_id" id="college_id">
										<option value="">Please Select</option>
											<?php if($college){ foreach($college as $type){ ?>
												<option value="<?php echo $type['id'] ?>" <?php if(isset($departmentData['college_id']) && $departmentData['college_id'] == $type['id']){ echo 'selected';}else if(set_value('college_id') == $type['id']){ echo 'selected';} ?>><?php echo $type['name'] ?></option>
											<?php  } } ?>
										</select>								
											<p class="help-block error text-red" style="color:red;">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('college_id')) ?  $validation->getError('college_id') : '';
													}?>
											</p>								
										</div>
								 </div>	
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Department Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="department_name" class="form-control" value="<?php if($departmentData){ echo $departmentData['department_name'];}else{ echo set_value('department_name'); } ?>">
										 <p class="help-block error text-red" style="color:red;">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('department_name')) ?  $validation->getError('department_name') : '';
											}?>
										</p>
										</div>
								</div>	
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Banner Tag Line</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="banner_tag_line" class="form-control" value="<?php if(isset($departmentData['banner_tag_line']) && $departmentData['banner_tag_line']!=''){ echo $departmentData['banner_tag_line'];}else{ echo set_value('banner_tag_line'); } ?>">
										</div>
								</div>
							    <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Short Code</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="short_code" name="short_code" class="form-control" value="<?php if(isset($departmentData['short_code']) && $departmentData['short_code']!=''){ echo $departmentData['short_code'];}else{ echo set_value('short_code'); } ?>">
										</div>
								</div>
							    <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label"> Show on home page</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="checkbox" name="show_on_home_page" class="form-control" value="1" <?php if(isset($departmentData['show_on_home_page']) && $departmentData['show_on_home_page']=='1'){ echo 'Checked';}?>>
										</div>
								</div>
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Banner Image</label>
									
									
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="image" name="image" accept=".png, .jpg, .jpeg">
										<p class="help-block message">File should be in .jpg, .png format. (518*427)db</p>
										
										<?php if($departmentData['image']) { ?>
										<input type="hidden" name="OldImage" value="<?php echo ($departmentData['image']) ? $departmentData['image'] : '' ?>">
										<div  class="col-lg-4">	
											<img src="<?php echo base_url('uploads/department_image/').$departmentData['image']; ?>" style="width:140px; margin-bottom:10px;" class="img_hover">
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/department/delete_logo_image/'.$departmentData['department_id']) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
									</div>
								</div>
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" class="form-control" name="display_order" id="display_order" value="<?php if($departmentData){ echo $departmentData['display_order'];}else{ echo $maxdata['total_order']+1; } ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($departmentData['status'] == 1 || !isset($departmentData)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($departmentData['status'] == 0 && isset($departmentData)) ? 'checked="checked"': '' ?>> Inactive
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
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	Submit</span></span></button>		
												<a href="<?php echo base_url('backoffice/department') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
																					
																				
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
