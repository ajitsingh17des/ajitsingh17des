<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
	<div class="m-grid__item m-grid__item--fluid m-wrapper">
		<div class="m-content">
			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Events
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<!-- RIGHT SECTION CODE PUT HERE -->
								<a href="<?php echo base_url('backoffice/events/add') ?>" class="btn m-btn--pill btn-outline-success m-btn m-btn--custom m-btn--icon ">
									<span> <i class="la la-plus"></i> <span>Add</span> </span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!---- start Add flash data----------------------------->
				<div class="row" style="margin-left:0px; margin-top: 15px;">
					<div class="col-md-2"></div>
					<div class="col-md-6"></div>

				</div>

				<!---- End Add flash data----------------------------->
				<div class="m-portlet__body">

					<!--begin: Search Form -->
					<div class="row align-items-center">
						<div class="col-xl-12 order-2 order-xl-1">
							<div class="form-group m-form__group row align-items-center">

								<div class="col-md-8"></div>
								<div class="col-md-4">
									<div class="m-input-icon m-input-icon--left">
										<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
										<span class="m-input-icon__icon m-input-icon__icon--left">
											<span><i class="la la-search"></i></span>
										</span>
									</div>
								</div>
							</div>
						</div>

					</div>
					<!--end: Search Form -->

					<!--begin: Datatable -->

					<!-- datatable show here -->
                    <?php if($_SESSION['msg']){?>
						<div class="alert alert-<?php echo $_SESSION['msg_type'];?> alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $_SESSION['msg'];?> </div>
					<?php } ?>

					<table class="m-datatable" id="html_table" width="100%">
						<thead>
							<tr>
								<th>
									<center>S No</center>
								</th>
								<th>
									<center> Event Type</center>
								</th>
								<th>
									<center> Title</center>
								</th>
							
							
								<th>
									<center>Event Date</center>
								</th>
								<th>
									<center>Event Images</center>
								</th>
								
								<th>
									<center>Display Order</center>
								</th>
								
								<th>
									<center> Events Status</center>
								</th>
							   
								
								<th>
									<center> Map Gallery</center>
								</th>
								 <th>
									<center>Show On Home</center>
								</th>
								<th>
								
									<center>Action</center>
								</th>
								
								

							</tr>
						</thead>
						<tbody>
							<?php
							
								if(!empty($courseCatData)){
								
									$i=1; foreach($courseCatData as $data){
									if($data['image'])
									{
										$image_name = $data['image'];
										$image_url = base_url('uploads/events/'.$image_name);
									}
									else 
									{
										$image_url = base_url('custum/images/banner-default.jpg');
									}	
									
							?>

								<tr>
									<td>
										<center><?php echo $i; ?></center>
									</td>
									<td>
										<center><?php echo $data['event_title']; ?></center>
									</td>
									<td>
										<center><?php echo $data['title']; ?></center>
									</td>
										<td>
										<center><?php echo $data['event_date']; ?></center>
									</td>
									<td>
										<center><img style="width:30px;" src="<?php echo $image_url; ?>"></center>
									</td>
									
									<td>
										<center><?php echo $data['display_order']; ?></center>
									</td>
									
									<td>
										<center><?php if($data['status']=="1"){ echo "Active";} else{ echo "Deactive"; }?></center>
									</td>
									
									
									
									<td style="width: 200px;">
										<center>
											<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
												<a href="<?php echo base_url('backoffice/events/map_gallery/'.base64_encode($data['id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-danger"><i class="m-menu__link-icon flaticon-photo-camera"></i></span>
												</a>
											
												
											
											</div>
										</center>
									</td>
									
									<td style="width: 200px;">
										<center>
											<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
													<?php if($data['show_home']==1){ ?>
												<a onclick="return confirm('Do you sure want to Hide From Home Page.');" href="<?php echo base_url(); ?>backoffice/events/show_deactive/<?php echo base64_encode($data['id']); ?>" title="Deactive" > 
												<img  src="<?php echo base_url('custum/images/yes.png'); ?>">	
												<a>	
												<?php } else { ?>
												<a onclick="return confirm('Do you sure want to Show On Home Page.');" href="<?php echo base_url(); ?>backoffice/events/show_active/<?php echo base64_encode($data['id']); ?>" title="Active" >
														<img  src="<?php echo base_url('custum/images/cross.png'); ?>">	
												</a> 		
												<?php } ?>
												
											</div>
										</center>
									</td>
									
									<td style="width: 200px;">
										<center>
											<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
												<a href="<?php echo base_url('backoffice/events/edit/'.base64_encode($data['id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-info m-btn--gradient-to-accent"><i class="fa fa-pencil-alt"></i></span>
												</a>
												<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/events/delete/'.base64_encode($data['id'])) ?>">
													<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
												</a>
												
												<?php if($data['status']==1){ ?>
												<a onclick="return confirm('Do you sure want to deactive this record.');" href="<?php echo base_url(); ?>backoffice/events/deactive/<?php echo base64_encode($data['id']); ?>" title="Deactive" > 
													<span class="btn m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent"><i class="fa fa-eye" aria-hidden="true"></i></span>
												<a>	
												<?php } else { ?>
												<a onclick="return confirm('Do you sure want to active this record.');" href="<?php echo base_url(); ?>backoffice/events/active/<?php echo base64_encode($data['id']); ?>" title="Active" >
													<span class="btn m-btn--square m-btn m-btn--gradient-from-info m-btn--gradient-to-warning"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
												</a> 		
												<?php } ?>
												
											</div>
										</center>
									</td>
									
								</tr>

							<?php $i++;  } }  ?>


						</tbody>
					</table>

					<!--end: Datatable -->
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div><!-- end:: Body -->