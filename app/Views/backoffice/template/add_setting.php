<?php 
 $editPageData = $settingData;
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
										<h3 class="m-portlet__head-text"><?php if(isset($editPageData) && $editPageData!=''){ echo 'Edit';}else{ echo 'Add'; } ?> Setting</h3>	
									</div>							
								</div>	
								<div class="m-portlet__head-caption">							
									<div class="m-portlet__head-title">							
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/dashboard/setting') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>Back</span></span></button></a>											
									</div>							
								</div>									
							</div>				
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Page Name </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										 <select name="page_id" class="form-control" id="page_id" required="required">
										 	<option value="">Select CMS</option>
										 	<?php foreach($all_cms_page as $cmsval){?>
                                             <option value="<?=$cmsval['page_id']?>"<?php if(isset($editPageData['page_id']) && $editPageData['page_id']==$cmsval['page_id']){echo 'Selected="Selected"';} ?>><?=$cmsval['page_name']?></option> 
										 	<?php } ?>
										 </select>
										 <p class="help-block error text-red" style="color:red;">
											<?php
											if(isset($_REQUEST['form_submit']))
											{
												echo ($validation->hasError('page_id')) ?  $validation->getError('page_id') : '';
											}?>
											</p>
										</div>
								</div>
                               
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">How Many of Image </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="how_many_of_image" class="form-control" value="<?php if(isset($editPageData['how_many_of_image']) && $editPageData['how_many_of_image']!=''){echo $editPageData['how_many_of_image'];}else{echo set_value('how_many_of_image');} ?>" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;">		 
										</div>
								</div>
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">How Many of Editor </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="how_many_of_editor" class="form-control" value="<?php if(isset($editPageData['how_many_of_editor']) && $editPageData['how_many_of_editor']!=''){echo $editPageData['how_many_of_editor'];}else{echo set_value('how_many_of_editor');} ?>" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;">		 
										</div>
								</div>
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">How Many of PDF </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="how_many_of_pdf" class="form-control" value="<?php if(isset($editPageData['how_many_of_pdf']) && $editPageData['how_many_of_pdf']!=''){echo $editPageData['how_many_of_pdf'];}else{echo set_value('how_many_of_pdf');} ?>" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;">		 
										</div>
								</div>
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Text Type of field</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<select name="text_type_of_field" id="text_type_of_field" class="form-control">
											<option value="">Please Type</option>
											<option value="editor"<?php if(isset($editPageData['text_type_of_field']) && $editPageData['text_type_of_field']=='editor'){echo 'Selected="Selected"';} ?>>Editor</option>
											<option value="textarea"<?php if(isset($editPageData['text_type_of_field']) && $editPageData['text_type_of_field']=='textarea'){echo 'Selected="Selected"';} ?>>Text Area</option>
										</select>		 
										</div>
								</div>
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if(isset($editPageData['display_order']) && $editPageData['display_order']!=''){ echo $editPageData['display_order'];}else{ echo  $maxData[0]['display_order']+1; } ?>" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;">
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
												<a href="<?php echo base_url('backoffice/dashboard/setting') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	<?php if(isset($editPageData) && $editPageData!=''){ echo 'Update';}else{ echo 'Add'; } ?></span></span></button>											
																				
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
</div>