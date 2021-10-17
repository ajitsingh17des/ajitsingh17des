<?php 
if(isset($data['user_data'])){
	$user_data = $data['user_data'][0];
}

?>
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
										<h3 class="m-portlet__head-text">Add User</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/users') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
									</div>							
								</div>									
							</div>	
							
							
							<?php if($_SESSION['msg']){?>
								<div class="alert alert-<?php echo $_SESSION['msg_type'];?> alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $_SESSION['msg'];?> </div>
							<?php } ?>			
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($data['act']) ? $data['act'] : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
								
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">First Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="first_name" class="form-control" value="<?php if($user_data){ echo $user_data['first_name'];}else{ echo set_value('first_name'); } ?>" required>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('first_name')) ?  $validation->getError('first_name') : '';
											}?>
										</p>
										</div>
								</div>	

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Last Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="last_name" class="form-control" value="<?php if($user_data){ echo $user_data['last_name'];}else{ echo set_value('last_name'); } ?>" required>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('last_name')) ?  $validation->getError('last_name') : '';
											}?>
										</p>
										</div>
								</div>	

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">User Role <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<select name="user_role" class="form-control" required>
											<option value="">Select Role</option>
											<?php if(!empty($data['roles'])){
												foreach($data['roles'] as $roles){?> 
													<option value="<?php echo $roles['role_id']?> " <?php if($roles['role_id'] == $user_data['login_type']) echo 'selected';?>>
														<?php echo $roles['role_name']?>
													</option>
											<?php } }?>
										</select>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('user_role')) ?  $validation->getError('user_role') : '';
											}?>
										</p>
										</div>
								</div>	

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Address <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="address" class="form-control" value="<?php if($user_data){ echo $user_data['address'];}else{ echo set_value('address'); } ?>" required>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('address')) ?  $validation->getError('address') : '';
											}?>
										</p>
										</div>
								</div>	

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Email Id <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="emailid" class="form-control" value="<?php if($user_data){ echo $user_data['emailid'];}else{ echo set_value('emailid'); } ?>" required>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('emailid')) ?  $validation->getError('emailid') : '';
											}?>
										</p>
										</div>
								</div>
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Password <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="password" name="password" class="form-control" value="">
										<?php if($user_data){?>
											<input type="hidden" value="<?php echo $user_data['password'];?>" name="old_password">
										<?php } ?>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('password')) ?  $validation->getError('password') : '';
											}?>
										</p>
										</div>
								</div>

								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Contact No<span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="contact_no" class="form-control" value="<?php if($user_data){ echo $user_data['contact_no'];}else{ echo set_value('contact_no'); } ?>" required>
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('contact_no')) ?  $validation->getError('contact_no') : '';
											}?>
										</p>
										</div>
								</div>		

								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($user_data['status'] == 1 || !isset($user_data)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($user_data['status'] == 0 && isset($user_data)) ? 'checked="checked"': '' ?>> Inactive
													<span></span>
												</label>
												
											</div>																				
											<span class="errorr"></span>								
										</div>								
									 </div>				
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<a href="<?php echo base_url('backoffice/users') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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

<style>

.m-accordion .m-accordion__item .m-accordion__item-head {  padding: 0.5rem 1rem; }
</style>
