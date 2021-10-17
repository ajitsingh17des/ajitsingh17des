<?php 
if(isset($data['role_data'])){
	$roles = $data['role_data'][0];
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
										<h3 class="m-portlet__head-text">Add User Role</h3>
													
									</div>							
								</div>	

								<div class="m-portlet__head-caption">								
									<div class="m-portlet__head-title">									
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/user_role') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>	Back</span></span></button></a>											
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
										<label class="col-lg-2 col-form-label">Role Name <span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="role_name" class="form-control" value="<?php if($roles){ echo $roles['role_name'];}else{ echo set_value('role_name'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('role_name')) ?  $validation->getError('role_name') : '';
											}?>
										</p>
										</div>
								</div>	
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="role_status" value="1" <?php echo ($roles['role_status'] == 1 || !isset($roles)) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="role_status" value="0" <?php echo ($roles['role_status'] == 0 && isset($roles)) ? 'checked="checked"': '' ?>> Inactive
													<span></span>
												</label>
												
											</div>																				
											<span class="errorr"></span>								
										</div>								
									 </div>
									 
									 
									 <div class="form-group m-form__group row">
									
									<label class="col-lg-2 col-form-label"></label>	
									<div class="col-lg-8">	
									 <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">

											<!--begin::Item-->
											
											<?php if(isset($roles) && !empty($roles)){?>
												<?php if(!empty($data['returnData'])){ $n=1; 
										foreach($data['returnData'] as $key => $menu_val){?>
											
											<div class="m-accordion__item">
												<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body<?php echo $n;?>" aria-expanded="    false">
													<span class="m-accordion__item-icon"></span>
													<span class="m-accordion__item-title"><?php echo $key;?></span>
													<span class="m-accordion__item-mode"></span>
												</div>
												<div class="m-accordion__item-body collapse" id="m_accordion_1_item_1_body<?php echo $n;?>" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
													<div class="m-accordion__item-content">
														<table width="100%" cellpadding="0" cellspacing="0" border="0" class="contentTable">
																<thead>
																	<tr>
																		<th width="55%">Form Name</th>
																		<th width="15%" class="forthCenter">View</th>
																		<th width="3%" class="forthCenter">Add</th>
																		<th width="3%" class="forthCenter">Edit</th>
																		<th width="3%" class="forthCenter">Delete</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($menu_val as $mVal){?>
																	<tr>
																		<td><?php echo $mVal['form_name'];?></td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_view[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_view'] == '1') echo 'checked';?> >
																		</td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_add[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_add'] == '1') echo 'checked';?> >
																		</td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_edit[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_edit'] == '1') echo 'checked';?> >
																		</td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_delete[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_delete'] == '1') echo 'checked';?> ></td>
																	</tr>
																	<?php } ?>	
																</tbody>
															</table>
													</div>
												</div>
											</div>
											<?php $n++; } }?>
											<?php } ?>	
											<!--end::Item-->

											

											
										</div>
									 </div>
									 </div>
									 
									 
									 <?php if(isset($roles) && !empty($roles)){?>	
									<!--<div class="form-group m-form__group row">
									
									<label class="col-lg-2 col-form-label"></label>	
									<div class="col-lg-8">						
										<div class="form-group">
											<div class="panel-group" id="myGroup">
										<?php if(!empty($data['returnData'])){ $n=1; 
										foreach($data['returnData'] as $key => $menu_val){?>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" data-target="#collapse<?php echo $n;?>" data-parent="#myGroup" href="javascript:void(0);" class="form-control collapsed" aria-expanded="false"><?php echo $key;?><span class="fa pull-right"></span>
															</a>
														</h4>
													</div>
													<div id="collapse<?php echo $n;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
														<div class="panel-body">
															<table width="100%" cellpadding="0" cellspacing="0" border="0" class="contentTable">
																<thead>
																	<tr>
																		<th width="55%">Form Name</th>
																		<th width="15%" class="forthCenter">View</th>
																		<th width="3%" class="forthCenter">Add</th>
																		<th width="3%" class="forthCenter">Edit</th>
																		<th width="3%" class="forthCenter">Delete</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($menu_val as $mVal){?>
																	<tr>
																		<td><?php echo $mVal['form_name'];?></td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_view[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_view'] == '1') echo 'checked';?> >
																		</td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_add[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_add'] == '1') echo 'checked';?> >
																		</td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_edit[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_edit'] == '1') echo 'checked';?> >
																		</td>
																		<td class="forthCenter">
																		<input type="checkbox" name="form_delete[<?php echo $mVal['form_id']?>]" value="1" <?php if(!empty($data['permission']) && $data['permission'][$mVal['form_id']]['form_delete'] == '1') echo 'checked';?> ></td>
																	</tr>
																	<?php } ?>	
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<?php $n++; } }?>
											</div>
										</div>
									</div>
								
									</div>	-->	
									<?php } ?>			
									<div class="clear"></div>					
								<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">								
									<div class="m-form__actions m-form__actions--solid">									
											<div class="row">										
												<div class="col-lg-2"></div>										
												<div class="col-lg-8">	
												<a href="<?php echo base_url('backoffice/user_role') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
