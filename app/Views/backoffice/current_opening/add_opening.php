<?php 
 $editPageData = $editOpeningData;
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
										<h3 class="m-portlet__head-text"><?php if(isset($editPageData) && $editPageData!=''){ echo 'Edit';}else{ echo 'Add'; } ?> Openings</h3>	
									</div>							
								</div>	
								<div class="m-portlet__head-caption">							
									<div class="m-portlet__head-title">							
										<span class="m-portlet__head-icon m--hide"> <i class="la la-gear"></i> </span>									
										
										<a href="<?php echo base_url('backoffice/currentOpening') ?>"><button type="button" class="btn m-btn--pill    btn-outline-primary"><span><i class="fa 	fa-angle-double-left "></i><span>Back</span></span></button></a>											
									</div>							
								</div>									
							</div>				
							
											
							<!--begin::Form-->						
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" action="<?php echo ($act) ? $act : '' ?>" enctype="multipart/form-data" name="add_media" id="add_media">	
								
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Title </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="title" class="form-control" value="<?php if(isset($editPageData->title) && $editPageData->title!=''){ echo $editPageData->title;}else{ echo set_value('title'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo ($validation->hasError('title')) ?  $validation->getError('title') : '';
											}?>
										</p>
										</div>
								</div>	
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Country </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										 <select name="country_id" class="form-control" id="country_id" required="required" onchange="return showState(this.value);">
										 	<option value="">Select Country</option>
										 	<?php foreach($get_country as $ctryval){?>
                                             <option value="<?=$ctryval['country_id']?>"<?php if(isset($editPageData->country_id) && $editPageData->country_id==$ctryval['country_id']){echo 'Selected="Selected"';} ?>><?=$ctryval['country_name']?></option> 
										 	<?php } ?>
										 </select>
										</div>
								</div>
                                <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">State </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										 <span class="showStateDataWithClass">
										 <select name="state_id" class="form-control" id="state_id" required="required" onchange="return showCity(this.value);">
										 	<option value="">Select State</option>
										 	<?php if(!empty($get_state)){ foreach($get_state as $stateVal){?>
                                             <option value="<?=$stateVal['state_id']?>"<?php if(isset($editPageData->state_id) && $editPageData->state_id==$stateVal['state_id']){echo 'Selected="Selected"';} ?>><?=$stateVal['state_name']?></option> 
										 	<?php }} ?>
										 </select>
										 </span>
										</div>
								</div>
                                <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">City </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										 <span class="showCityDataWithClass">
										 <select name="city_id" class="form-control" id="city_id">
										 	<option value="">Select City</option>
										 	<?php if(!empty($get_city)){ foreach($get_city as $cityVal){?>
                                             <option value="<?=$cityVal['id']?>"<?php if(isset($editPageData->city_id) && $editPageData->city_id==$cityVal['id']){echo 'Selected="Selected"';} ?>><?=$cityVal['city_name']?></option> 
										 	<?php }} ?>
										 </select>
										 </span>
										</div>
								</div>
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Year </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										<input type="text" name="year" class="form-control" value="<?php if(isset($editPageData->year) && $editPageData->year!=''){ echo $editPageData->year;}else{ echo set_value('year'); } ?>">
										 <p class="help-block error text-red">
											<?php
											if(isset($_POST['form_submit']))  
											{
												echo($validation->hasError('year')) ?  $validation->getError('year') : '';
											}?>
										</p>
										</div>
								</div>								
								
								<div class="form-group m-form__group row">	
									<label class="col-lg-2 col-form-label">Description</label>
									<div class="col-lg-8 col-md-9 col-sm-12">	
										<textarea name="description" id="description" cols="80" rows="10" class="form-control editor"><?php if(isset($editPageData->description) && $editPageData->description!=''){  echo $editPageData->description;}else{ echo set_value('description'); } ?></textarea>
									</div>
									<p class="help-block"></p>
								</div>
						
								
								
								 <div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Display Order </label>
										<div class="col-lg-8 col-md-9 col-sm-12">
											<input type="text" placeholder="Enter ..." class="form-control" name="display_order" id="display_order" value="<?php if(isset($editPageData->display_order) && $editPageData->display_order!=''){ echo  $editPageData->display_order;}else{ echo  $maxData[0]['display_order']+1; } ?>">
										</div>
								</div>	
								
								<div class="form-group m-form__group row">									
										<label class="col-lg-2 col-form-label">Status:</label>									
										<div class="col-lg-8">								    	
											<div class="m-radio-inline">
												
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php echo ($editPageData->status == 1) ? 'checked="checked"': '' ?>> Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?php echo ($editPageData->status == 0) ? 'checked="checked"': '' ?>> Inactive
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
												<a href="<?php echo base_url('backoffice/currentOpening') ?>"><button type="button" class="btn btn-outline-danger m-btn--pill"><span><i class="fa fa-times "></i><span>	Cancel</span></span></button></a>										
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
</div><!-- end:: Body -->
<script type="text/javascript">
	var site_url = '<?php echo base_url('backoffice') ?>';
	function showState(country_id){
	  $.post(site_url+"/CurrentOpening/getStateList",
	  {
	    country_id: country_id
	  },
	  function(data, status){
	    //alert("Data: " + data + "\nStatus: " + status);
	    $('.showStateDataWithClass').html(data);
	  });
	}
	function showCity(state_id){
	  var country_id = $('#country_id').val();
	  $.post(site_url+"/CurrentOpening/getCityList",
	  {
	    country_id: country_id,
	    state_id: state_id
	  },
	  function(data){
	    $('.showCityDataWithClass').html(data);
	  });
	}
</script>

