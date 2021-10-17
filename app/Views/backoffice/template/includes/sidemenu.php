<?php 
/*echo '<pre>'; 
print_r($_SESSION);exit;*/
$session = \Config\Services::session($config);
$userData = $session->get('user_data');
$sideMenu = sideMenu($userData->login_type);
//echo '<pre>';print_r($sideMenu);die;
?>
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
	<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
		<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<?php if(!empty($sideMenu)){
			foreach($sideMenu as $key=>$value){ 
			if($value[0]['icon']){
				$icon_class	=	$value[0]['icon'];
			}else{
				$icon_class	=	'la la-align-justify';
			}
			
			?>			
			<li class="m-menu__item  m-menu__item--submenu <?php if($Data['menu'] == $value[0]['module_id']){ echo ' m-menu__item--open'; } ?> " aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="javascript:void(0);" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon <?php echo $icon_class;?>"></i>
					<span class="m-menu__link-text"><?php echo $key;?></span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<?php foreach($value as $childValue){?>
						<li class="m-menu__item <?php if($Data['submenu']== $childValue['form_id']){ echo 'm-menu__item--active'; } ?>" aria-haspopup="true">
							<a href="<?php echo base_url('backoffice/').$childValue['form_url']; ?>" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text"><?php echo $childValue['form_name']; ?> </span>
							</a>
						</li>
					<?php }?>
						
					</ul>
				</div>
			</li>
		<?php } } ?>
		</ul>
	</div>
</div>