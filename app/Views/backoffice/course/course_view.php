<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
	<div class="m-grid__item m-grid__item--fluid m-wrapper">
		<div class="m-content">
			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<h3 class="m-portlet__head-text">
								Manage Course
							</h3>
						</div>
					</div>

					<div class="m-portlet__head-tools">
						<ul class="m-portlet__nav">
							<li class="m-portlet__nav-item">
								<!-- RIGHT SECTION CODE PUT HERE -->
								<?php if($permission_data['add'] == 1){?>
								<a href="<?php echo base_url('backoffice/course/add') ?>" class="btn m-btn--pill btn-outline-success m-btn m-btn--custom m-btn--icon ">
									<span> <i class="la la-plus"></i> <span>Add</span> </span>
								</a>
								<?php }?>
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
									<center>college</center>
								</th>
								<th>
									<center>Department</center>
								</th>
								<th>
									<center>Program</center>
								</th>
								<th>
									<center>Course</center>
								</th>
								<th>
									<center>Semesters</center>
								</th>
								<th>
									<center>Map Semesters</center>
								</th>
								<th>
									<center>Course Status</center>
								</th>
								<th>
									<center>Display Order</center>
								</th>
								<th>
									<center>Action</center>
								</th>
								
								

							</tr>
						</thead>
						<tbody>
							<?php
								if(!empty($listing_data)){
									foreach($listing_data as  $key => $value){
										if($value['semester']!=0){
											$sem	=	$value['semester'];
										}else{
											$sem	=	'';
										}
										
							?>
							<tr>
								<td><center><?php echo ++$key;?></center></td>
								<td><center><?php echo $value['college_name'];?></center></td>
								<td><center><?php echo $value['department_name'];?></center></td>
								<td><center><?php echo $value['program_name'];?></center></td>
								<td><center><?php echo $value['course_name'];?></center></td>
								<td><center><?php echo $sem;?></center></td>
								<td><center>
								<?php if($value['semester']!=0){?>
								<a href="<?php echo base_url('backoffice/course/map_semester/'.($value['id']))?>">
									<span class=""><i class="m-menu__link-icon fa fa-indent"></i></span>
								</a><?php } ?>
								</center></td>
								<td><center><?php echo ($value['status'] == 1)?'Active':'Inactive';?></center></td>
								<td><center><?php echo $value['display_order'];?></center></td>
								
								<td>
									<center>
											<div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
												<?php if($permission_data['edit'] == 1){?>
													<a href="<?php echo base_url('backoffice/course/edit/'.($value['id']))?>">
														<span class="btn m-btn--square  m-btn m-btn--gradient-from-info m-btn--gradient-to-accent"><i class="fa fa-pencil-alt"></i></span>
													</a>
												<?php }?>
												<?php if($permission_data['delete'] == 1){?>
													<a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url('backoffice/course/delete/'.($value['id'])) ?>">
														<span class="btn m-btn--square  m-btn m-btn--gradient-from-danger m-btn--gradient-to-warning"><i class="fa fa-trash-alt"></i></span>
													</a>
												<?php }?>
												<?php if($permission_data['edit'] == 1){?>
												
													<?php if($value['status']==1){ ?>
													<a onclick="return confirm('Do you sure want to deactive this record.');" href="<?php echo base_url(); ?>backoffice/course/deactive/<?php echo ($value['id']); ?>" title="Deactive" > 
														<span class="btn m-btn--square m-btn m-btn--gradient-from-success m-btn--gradient-to-accent"><i class="fa fa-eye" aria-hidden="true"></i></span>
													<a>	
													<?php } else { ?>
													<a onclick="return confirm('Do you sure want to active this record.');" href="<?php echo base_url(); ?>backoffice/course/active/<?php echo ($value['id']); ?>" title="Active" >
														<span class="btn m-btn--square m-btn m-btn--gradient-from-info m-btn--gradient-to-warning"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
													</a> 		
													<?php } ?>
												<?php }?>
												 
											</div>
										</center>
								</td>
							</tr>
						<?php $sno++;} }?>
						</tbody>
					</table>

					<!--end: Datatable -->
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div><!-- end:: Body -->