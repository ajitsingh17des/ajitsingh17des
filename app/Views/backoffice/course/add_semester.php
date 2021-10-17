<?php 
if(!empty($editData)){
	$total_sem	=	$editData[0]['semester'];
}
if(!empty($editsemData)){
	$editPageData = $editsemData[0];
}
?>
editsemData
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
										<h3 class="m-portlet__head-text">Map Semesters Data</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/course/map_semester/'.$id) ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="map_sem" id="map_sem">	
								
							
								
								<div class="form-group m-form__group row">
							      <label class="col-lg-2 col-form-label">Semester<span class="error">*</span></label>
									<div class="col-lg-8" id="Semester_div">		 							
										<select class="form-control m-bootstrap-select m_selectpicker	" name="select_sem" id="select_sem">
										<option value="">Please Select</option>
											<?php if($total_sem){ for($i=1; $i<=$total_sem; $i++){ ?>
												<option value="<?php echo $i ?>" <?php if($editPageData['semester'] ==$i){ echo 'selected';} ?> ><?php echo $i; ?></option>
											<?php  } } ?>
										</select>								
											<p class="help-block error text-red">
													<?php
													if(isset($_POST['form_submit']))
													{
														echo ($validation->hasError('select_sem')) ?  $validation->getError('select_sem') : '';
													}?>
											</p>								
										</div>
								 </div>	
								 
								 
								 
								 
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Semester Course Curriculum</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="sem_details" id="sem_details" cols="" rows="20" class="form-control"><?php if($editPageData){  echo $editPageData['sem_details'];}else{ echo set_value('sem_details'); } ?></textarea>
									</div>
									
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
									 
						
																	
						<div class="clear"></div>
									 
							
						
																	
						<div class="clear"></div>
								
								
								
														
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<button type="submit" name="form_submit" id="form_submit"  class="btn m-btn--pill  btn-outline-success"><span><i class="fa fa-save"></i><span>	Submit</span></span></button>	
												<a href="<?php echo base_url('backoffice/course/map_semester/'.$id) ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
													
																								
																				
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
