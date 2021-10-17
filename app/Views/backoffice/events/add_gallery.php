
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
										<h3 class="m-portlet__head-text">Map Event  Gallery</h3>
													
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
							<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator" method="post" id="gallery_upload" action="<?php echo $act;?>" enctype="multipart/form-data">	
								
								
								<div class="form-group m-form__group row">
										<label class="col-lg-2 col-form-label">Upload your images<span class="error">*</span></label>
										<div class="col-lg-8 col-md-9 col-sm-12">
										 <div class="form-group">
            									<div class="field" align="left">
            										<h3>Upload your images</h3>
            										<input type="file" id="files" name="gallery_image[]" multiple="" required>
            									</div>
            									<p class="help-block error text-red"></p>
            								</div>
            								<div class="form-group">
            									<input type="submit" id="form_submit_media" class="btn btn-info" value="Upload Image" name="form_submit_media">
            								</div>
										</div>
								</div>
								
								
								<div class="form-group m-form__group row">
									<div class="gallery_views well well-sm">
                							<div class="row">	
                
                	                    <?php 
                	                    if(!empty($GalleryData)){
                					foreach($GalleryData as $gallery){					
                					?>							
                							<div class="col-md-2 text-center" style="margin-bottom:15px"> 
                								<img style="width:152px;height: 100px;" src="<?php echo base_url('uploads/event_gallery/'.$gallery['gallery_value']) ?>" alt="" class="img-fluid">
                								<form method="post" action="<?php echo base_url('backoffice/events/delete_view/'.base64_encode($gallery['id'])) ?>">
                									<input type="hidden" name="image_name" value="<?php echo $img; ?>">
                									<input type="submit" class="delete_iinfra_gallery" onclick="return confirm('Do you sure want to delete this record.');" value="Delete">
                								</form>
                							</div>
                							<?php } }?>
                							</div>
                						</div>
								</div>
								
								
									 
							
						
																	
					        	<div class="clear"></div>
													
												
							</form>						
							<!--end::Form-->					
					</div>				
				</div>			
			</div>		
		</div>	
	</div>
</div><!-- end:: Body -->
