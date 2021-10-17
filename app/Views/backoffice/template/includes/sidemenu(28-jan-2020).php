<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
		<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__item  <?php if($Data['active']==99999){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true">
				<a href="<?php echo base_url().'backoffice/dashboard';?>" class="m-menu__link ">
					<i class="m-menu__link-icon flaticon-line-graph"></i>
					<span class="m-menu__link-title"> 
						<span class="m-menu__link-wrap"> 
							<span class="m-menu__link-text">Dashboard</span>
							<span class="m-menu__link-badge"></span> 
						</span>
					</span>
				</a>
			</li>			
			<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']==1 || $Data['active']==2){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-placeholder-3"></i><span class="m-menu__link-text">Location</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									   <li class="m-menu__item <?php if($Data['active']==1){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/country';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Country </span></a></li>
									   <li class="m-menu__item <?php if($Data['active']==2){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/city';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">City </span></a></li>
									</ul>
								</div>
							</li>
							
							<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']==3){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-indent"></i><span class="m-menu__link-text">Training Type</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									    <li class="m-menu__item <?php if($Data['active']==3){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/training_type';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Training Type View </span></a></li>
									</ul>
								</div>
							</li>
							
							<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']==4 || $Data['active']==5 || $Data['active']==6){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon la la-book"></i><span class="m-menu__link-text">Courses</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									    
									   <li class="m-menu__item <?php if($Data['active']==4){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/course_category';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Course Category</span></a></li>
									   
									   <li class="m-menu__item <?php if($Data['active']==5){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/parent_course';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Certifications</span></a></li>
									   <li class="m-menu__item <?php if($Data['active']==6){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/course';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Courses</span></a></li>
									   
									 </ul>
								</div>
							</li>
							
							<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']==7){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-calendar"></i><span class="m-menu__link-text">Schedule</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									    
									   <li class="m-menu__item <?php if($Data['active']==7){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/schedule';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Schedule</span></a></li>
									   
									 </ul>
								</div>
							</li>
							<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']==8){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-clipboard-list"></i><span class="m-menu__link-text">Cms</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									    
									   <li class="m-menu__item <?php if($Data['active']==8){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/cms';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Cms</span></a></li>
									   
									 </ul>
								</div>
							</li>
						</ul>
					</div>
					
					
					<!-- END: Aside Menu -->
				</div>

				<!-- END: Left Aside -->