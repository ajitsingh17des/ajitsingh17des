<?php 
if(!empty($returnData['subMenuData'])){
	$submenu = $returnData['subMenuData'][0];
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
										<h3 class="m-portlet__head-text">Add Sub Menu</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/sub_menu') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($returnData['act']) ? $returnData['act'] : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">


								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Menu Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<select class="form-control" name="menu_name" id="menu_name">
											<option value="">Select Menu</option>
										<?php if(!empty($returnData['menu_name_list'])){
											foreach($returnData['menu_name_list'] as $mValue){?>
												<option value="<?php echo $mValue['id'];?>" <?php if(isset($submenu) && $submenu['module_id'] == $mValue['id']) echo 'selected';?>><?php echo $mValue['menu_name'];?></option>
										<?php } }?>
										</select>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('menu_name')) ?  $validation->getError('menu_name') : '';
											}?>
										</p>
										</div>
								</div>	
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Sub Menu Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="submenu_name" class="form-control" value="<?php if(isset($submenu)){ echo $submenu['form_name'];}else{ echo set_value('submenu_name'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('submenu_name')) ?  $validation->getError('submenu_name') : '';
											}?>
										</p>
										</div>
								</div>	

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Url<span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="url" class="form-control" value="<?php if($submenu){ echo $submenu['form_url'];}else{ echo set_value('url'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('url')) ?  $validation->getError('url') : '';
											}?>
										</p>
										</div>
								</div>	

								
								
						
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if($submenu){ echo  $submenu['display_order_form'];}else{ echo  $returnData['maxdata'][0]['display_order']+1; } ?>">
										</div>
								</div>	

								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Menu Type:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="child" value="1" <?php echo ($submenu['child'] == 1 || !isset($submenu)) ? 'checked="checked"': '' ?>> Sub Menu
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="child" value="0" <?php echo ($submenu['child'] == 0 && isset($submenu)) ? 'checked="checked"': '' ?>> Main Menu
													<span></span>
												</label>
												
											</div>																				
											<span class="errorr"></span>								
										</div>								
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($submenu['form_status'] == 1 || !isset($submenu)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($submenu['form_status'] == 0 && isset($submenu)) ? 'checked="checked"': '' ?>> Inactive
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
												<a href="<?php echo base_url('backoffice/sub_menu') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
