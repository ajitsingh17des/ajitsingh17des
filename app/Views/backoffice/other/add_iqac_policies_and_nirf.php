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
										<h3 class="m-portlet__head-text">Add IQAC Policies & NIRF</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/policies') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Page Type *</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<select name="page_type" class="form-control" id="page_type" required="required" onchange="return showDiv(this.value);">
											<option value="">Select Type</option>
											<option value="1"<?php if(isset($editPageData['page_type']) && $editPageData['page_type']=='1'){ echo 'Selected="Selected"';}else if(set_value('page_type')=='1'){ echo 'Selected="Selected"';}?>>NIRF</option>
											<option value="2"<?php if(isset($editPageData['page_type']) && $editPageData['page_type']=='2'){ echo 'Selected="Selected"';}else if(set_value('page_type')=='2'){ echo 'Selected="Selected"';}?>>IQAC Policies</option>
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
										<label class="col-lg-2 col-form-label">Title *</label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="title" class="form-control" value="<?php if($editPageData){ echo $editPageData['title'];}else{ echo set_value('title'); } ?>">
										 <p class="help-block error text-red" style="color:red;">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('title')) ?  $validation->getError('title') : '';
											}?>
										</p>
										</div>
								</div>	
								
								<div class="form-group m-form__group row" id="showNIRF" <?php if(isset($editPageData['other_page_url']) && $editPageData['other_page_url']!=''){ }else{echo 'style="display:none;"';} ?>>
										<label class="col-lg-2 col-form-label">Other URl </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="other_page_url" class="form-control" value="<?php if($editPageData){ echo $editPageData['other_page_url'];}else{ echo set_value('other_page_url'); } ?>">							 
										</div>
								</div>							
								
								<div class="form-group m-form__group row" id="showIQACPolicies" <?php if(isset($editPageData['page_type']) && $editPageData['page_type']=='2'){}else{echo 'style="display:none;"';} ?>>
									<label class="col-lg-2 col-form-label">Upload PDF<span class="error">*</span></label>									
									<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="file" class="form-control" id="upload_pdf" name="upload_pdf" accept=".pdf,.docx,.doc">
										<p class="help-block message">File should be in <b>.pdf, .docx and doc format.</b></p>
										<p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('upload_pdf')) ?  $validation->getError('upload_pdf') : '';
											}?>
										</p>
										<?php if(isset($editPageData['upload_pdf']) && $editPageData['upload_pdf']!='') { ?>
										<input type="hidden" name="Oldupload_pdf" value="<?php echo ($editPageData['upload_pdf']) ? $editPageData['upload_pdf'] : '' ?>">
										<div  class="col-lg-4">
										<a target="_blank" href="<?php echo base_url('uploads/pdf/').$editPageData['upload_pdf']; ?>" class="img_hover">Download</a>	
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/policies/delete_logo_upload_pdf/'.$editPageData['id']) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
											
										</div>
									<?php } ?>
									
									</div>
								</div>
																
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if($editPageData){ echo  $editPageData['display_order'];}else{ echo  $maxData[0]['display_order']+1; } ?>" onkeypress="return isNumber(event)">
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
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	Submit</span></span></button>
												<a href="<?php echo base_url('backoffice/policies') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span> Cancel</span></span></button></a>									
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
<script type="text/javascript">
	function showDiv(str)
	{
	  if(str=='1')
	  {
        $('#showNIRF').show();
        $('#showIQACPolicies').hide();
	  }
	  else if(str=='2')
	  {
        $('#showIQACPolicies').show();
        $('#showNIRF').hide();
	  }
	}
</script>