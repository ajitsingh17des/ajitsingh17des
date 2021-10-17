<?php echo "pihhu".$landingPage_id; if($landingPage_id){
	$page_ID	=	'/'.$landingPage_id;
}
?>


<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
		<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
						
			
							<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']=='aa'){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-book"></i><span class="m-menu__link-text">Landing Pages</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									    
									   <li class="m-menu__item <?php if($Data['active']=='aa'){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/landing_pages';?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Landing Pages Cms </span></a></li>
									   
									 </ul>
								</div>
							</li>
							<li class="m-menu__item  m-menu__item--submenu <?php if($Data['active']==101){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-clipboard-list"></i><span class="m-menu__link-text">Popular Courses</span><i
									 class="m-menu__ver-arrow la la-angle-right"></i></a>
								<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									    
									   <li class="m-menu__item <?php if($Data['active']==101){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true"><a href="<?php echo base_url().'backoffice/landing_pages/popular_courses'.$page_ID;?>" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Popular Courses</span></a></li>
									   
									 </ul>
								</div>
							</li>
						</ul>
					</div>
					
					
					<!-- END: Aside Menu -->
				</div>

				<!-- END: Left Aside -->