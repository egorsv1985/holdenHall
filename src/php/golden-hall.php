<?php
/*
Template name: Golden Hall
Template Post Type: golden-hall
*/
?>
<!DOCTYPE html>
<!-- Last Published: Tue Mar 15 2022 12:38:41 GMT+0000 (Coordinated Universal Time) --><html data-wf-page="62230a7f87949d1d0681a6af" data-wf-site="62230a7f87949d68de81a6a0">
	<?php get_template_part("header_block", ""); ?>
	<body wp_template_cpt="golden-hall" class="body">
		<div data-collapse="medium" data-animation="default" data-duration="400" data-easing="ease" data-easing2="ease" role="banner" class="navbar w-nav">
			<div class="navbar-container w-container">
				<div class="nav-content"><a href="http://ghall.stage.adm-lab.pw/" class="brand w-nav-brand"><img loading="lazy" src="<?php echo get_template_directory_uri() ?>/images/62243fc837bb31bc7c4d6733_logo.svg" alt></a>
					<nav role="navigation" class="nav-menu w-nav-menu">
						<?php if( $menu_items = wp_get_nav_menu_items('Главное меню') ) { $menu_list = ''; $current_class = '';
        foreach ( (array)$menu_items as $key =>$menu_item ) { if($menu_item->url === get_home_url(null, $wp->request).'/'){$current_class = ' w--current';} else {$current_class = '';} if($menu_items[$key+1]->menu_item_parent != 0 && $menu_items[$key]->menu_item_parent == 0){ $target = $menu_item->target ? $menu_item->target : '_self'; $menu_list .= '
						<div data-ix class="nav-link w-dropdown" true>
							<div class="dropdown-toggle-3 w-dropdown-toggle">
								<div>'.$menu_item->title.'</div>
								<div class="w-icon-dropdown-toggle"></div>
							</div>
							<nav class="dropdown-list-7 w-dropdown-list">'; }else{ if($menu_items[$key]->menu_item_parent == 0){ $target = $menu_item->target ? $menu_item->target : '_self'; $link_class = 'nav-link w-nav-link';}else{$link_class = 'drop-link w-dropdown-link';} $menu_list .= '<a class="'.$link_class.$current_class.'" title="'.$menu_item->attr_title.'" target="'.$target.'" href="'.$menu_item->url.'">'.$menu_item->title.'</a> '; if($menu_items[$key+1]->menu_item_parent == 0 && $menu_items[$key]->menu_item_parent != 0){ $menu_list .= '</nav>
						</div>'; } } } echo $menu_list; } ?></nav>
					<div class="nav-system">
						<h4 class="phone"><a href="tel:+79529562530" class="link-2">+7 (952) 956-25-30</a></h4>
						<div data-w-id="d0655d62-4bb9-a5c5-96b5-834af7a43317" class="system-item icon-search"></div>
					</div>
				</div>
				<div class="menu-button w-nav-button">
					<div class="w-icon-nav-menu"></div>
				</div>
			</div>
			<div class="search-cont">
				<form action="<?php echo get_home_url() ?>/index.php#results" class="search full w-form" method="get" id="search" name="search" data-name="search" data-action="search">
<input type="search" class="search-input w-input" maxlength="256" name="s" placeholder="Поиск" id="search" required data-name="s" value="<?php echo get_search_query() ?>">
<input type="submit" value class="search-button w-button"></form>
			</div>
		</div>
		<div>
			<div class="posts wf-section">
				<?php if(have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<h1 class="head-zaly gh">Golden Hall</h1>
				<div class="container">
					<div data-delay="4000" data-animation="slide" class="slider-1 gh w-slider" data-autoplay="false" data-easing="ease" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0" data-nav-spacing="3" data-duration="500" data-infinite="true">
						<div class="w-slider-mask">
							<div class="w-slide">
								<div class="slider-content gh">
									<div class="slider-div"><img src="<?php echo get_template_directory_uri() ?>/images/6225b8561d5b31a8ef6ef692_Group205581.svg" loading="lazy" alt class="image-6">
										<h2 class="slider-title">Gold Hall</h2><img src="<?php echo get_template_directory_uri() ?>/images/6225b87b470892893f696d98_Group205580.svg" loading="lazy" alt class="image-7"></div>
								</div>
							</div>
							<div class="w-slide">
								<div class="slider-content sl2">
									<div class="slider-div"><img src="<?php echo get_template_directory_uri() ?>/images/6225b8561d5b31a8ef6ef692_Group205581.svg" loading="lazy" alt class="image-6">
										<h2 class="slider-title">
											<?php echo get_field('zagolovok') ?>
										</h2><img src="<?php echo get_template_directory_uri() ?>/images/6225b87b470892893f696d98_Group205580.svg" loading="lazy" alt class="image-7"></div>
								</div>
							</div>
							<div class="w-slide">
								<div class="slider-content sl3">
									<div class="slider-div"><img src="<?php echo get_template_directory_uri() ?>/images/6225b8561d5b31a8ef6ef692_Group205581.svg" loading="lazy" alt class="image-6">
										<h2 class="slider-title">Silver Hall</h2><img src="<?php echo get_template_directory_uri() ?>/images/6225b87b470892893f696d98_Group205580.svg" loading="lazy" alt class="image-7"></div>
								</div>
							</div>
							<div class="w-slide">
								<div class="slider-content sl4">
									<div class="slider-div"><img src="<?php echo get_template_directory_uri() ?>/images/6225b8561d5b31a8ef6ef692_Group205581.svg" loading="lazy" alt class="image-6">
										<h2 class="slider-title">Silver Hall</h2><img src="<?php echo get_template_directory_uri() ?>/images/6225b87b470892893f696d98_Group205580.svg" loading="lazy" alt class="image-7"></div>
								</div>
							</div>
						</div>
						<div class="w-slider-arrow-left">
							<div class="slider-arrow w-icon-slider-left"></div>
						</div>
						<div class="w-slider-arrow-right">
							<div class="slider-arrow right w-icon-slider-right"></div>
						</div>
						<div class="w-slider-nav w-round"></div>
					</div>
					<div class="post-content post-page">
						<div class="rich-text-block w-richtext">
							<?php echo get_field('1_abzac') ?>
						</div>
					</div>
					<div class="golden-halls w-row">
						<div class="w-col w-col-3 w-col-medium-6">
							<div class="decorative">
								<div class="div-block-collumn show"><img src="<?php echo get_template_directory_uri() ?>/images/6229ddbf6d295fe0452d2b8d_Group.svg" loading="lazy" alt class="image-collumn">
									<h4 class="head-collumn">до 50 праковочных <br><span class="text-span-4">мест</span></h4>
								</div>
							</div>
						</div>
						<div class="w-col w-col-3 w-col-medium-6">
							<div class="decorative">
								<div class="div-block-collumn show"><img src="<?php echo get_template_directory_uri() ?>/images/6229df534e6e95d4dd3e659e_Group205607.svg" loading="lazy" alt class="image-collumn">
									<h4 class="head-collumn">Средний чек от 2000 ₽</h4>
									<div class="text-collumn">Golden Hall</div>
								</div>
							</div>
						</div>
						<div class="w-col w-col-3 w-col-medium-6">
							<div class="decorative">
								<div class="div-block-collumn show"><img src="<?php echo get_template_directory_uri() ?>/images/6229df530a238e82c677361f_Group205608.svg" loading="lazy" alt class="image-collumn">
									<h4 class="head-collumn">Средний чек от 2000 ₽</h4>
									<div class="text-collumn">Silver Hall</div>
								</div>
							</div>
						</div>
						<div class="w-col w-col-3 w-col-medium-6">
							<div class="decorative">
								<div class="div-block-collumn show"><img src="<?php echo get_template_directory_uri() ?>/images/6229df542b1f0d0baf7f183c_Group20(1).svg" loading="lazy" alt class="image-collumn">
									<h4 class="head-collumn"><span class="text-span"><strong>Собственный</strong></span></h4>
									<div class="text-collumn">кондитер</div>
								</div>
							</div>
						</div>
					</div>
					<div class="w-row">
						<div class="w-col w-col-4"><img src="<?php echo get_template_directory_uri() ?>/images/6229ed051b007108a3177a40_Rectangle203403.png" loading="lazy" alt></div>
						<div class="w-col w-col-4"><img src="<?php echo get_template_directory_uri() ?>/images/6229ed0506879bc7a37c6144_Rectangle203402.png" loading="lazy" alt></div>
						<div class="w-col w-col-4"><img src="<?php echo get_template_directory_uri() ?>/images/6229ed051fff925ddf4f45e0_Rectangle203401.png" loading="lazy" alt></div>
					</div>
					<div class="rich-text-block w-richtext">
						<?php echo get_field('2_abzac') ?>
					</div>
					<div class="w-row">
						<div class="w-col w-col-6"><img src="<?php echo get_template_directory_uri() ?>/images/6229ed66c05eb738afd633da_Rectangle203401.png" loading="lazy" alt></div>
						<div class="w-col w-col-6"><img src="<?php echo get_template_directory_uri() ?>/images/6229ed7344525d21b6074bcf_Rectangle203402.png" loading="lazy" alt></div>
					</div>
					<div class="rich-text-block w-richtext">
						<?php echo get_field('3_abzac') ?>
					</div>
					<div class="w-row">
						<div class="w-col w-col-4"><img src="<?php echo get_template_directory_uri() ?>/images/6229edab2bf34b3768611367_Rectangle203401.png" loading="lazy" alt></div>
						<div class="w-col w-col-8"><img src="<?php echo get_template_directory_uri() ?>/images/6229edb4cfabceada75632c5_Rectangle203402.png" loading="lazy" alt></div>
					</div>
					<div class="rich-text-block w-richtext">
						<?php echo get_field('4_abzac') ?>
					</div>
				</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
		<div data-collapse="medium" data-animation="default" data-duration="400" data-easing="ease" data-easing2="ease" role="banner" class="navbar w-nav">
			<div class="navbar-container w-container">
				<div class="nav-content"><a href="http://ghall.stage.adm-lab.pw/" class="brand w-nav-brand"><img loading="lazy" src="<?php echo get_template_directory_uri() ?>/images/62243fc837bb31bc7c4d6733_logo.svg" alt></a>
					<nav role="navigation" class="nav-menu w-nav-menu">
						<?php if( $menu_items = wp_get_nav_menu_items('Главное меню') ) { $menu_list = ''; $current_class = '';
        foreach ( (array)$menu_items as $key =>$menu_item ) { if($menu_item->url === get_home_url(null, $wp->request).'/'){$current_class = ' w--current';} else {$current_class = '';} if($menu_items[$key+1]->menu_item_parent != 0 && $menu_items[$key]->menu_item_parent == 0){ $target = $menu_item->target ? $menu_item->target : '_self'; $menu_list .= '
						<div data-ix class="nav-link w-dropdown" true>
							<div class="dropdown-toggle-3 w-dropdown-toggle">
								<div>'.$menu_item->title.'</div>
								<div class="w-icon-dropdown-toggle"></div>
							</div>
							<nav class="dropdown-list-7 w-dropdown-list">'; }else{ if($menu_items[$key]->menu_item_parent == 0){ $target = $menu_item->target ? $menu_item->target : '_self'; $link_class = 'nav-link w-nav-link';}else{$link_class = 'drop-link w-dropdown-link';} $menu_list .= '<a class="'.$link_class.$current_class.'" title="'.$menu_item->attr_title.'" target="'.$target.'" href="'.$menu_item->url.'">'.$menu_item->title.'</a> '; if($menu_items[$key+1]->menu_item_parent == 0 && $menu_items[$key]->menu_item_parent != 0){ $menu_list .= '</nav>
						</div>'; } } } echo $menu_list; } ?></nav>
					<div class="nav-system">
						<h4 class="phone"><a href="tel:+79529562530" class="link-2">+7 (952) 956-25-30</a></h4>
						<div data-w-id="d0655d62-4bb9-a5c5-96b5-834af7a43317" class="system-item icon-search"></div>
					</div>
				</div>
				<div class="menu-button w-nav-button">
					<div class="w-icon-nav-menu"></div>
				</div>
			</div>
			<div class="search-cont">
				<form action="<?php echo get_home_url() ?>/index.php#results" class="search full w-form" method="get" id="search" name="search" data-name="search" data-action="search">
<input type="search" class="search-input w-input" maxlength="256" name="s" placeholder="Поиск" id="search" required data-name="s" value="<?php echo get_search_query() ?>">
<input type="submit" value class="search-button w-button"></form>
			</div>
		</div>
		<div class="footer wf-section">
			<div class="container">
				<div class="columns w-row">
					<div class="w-col w-col-2">
						<div class="footer-left-box w-clearfix">
							<h5 class="head-footer">2022 © Все права защищены</h5>
						</div>
					</div>
					<div class="w-clearfix w-col w-col-4"><img src="<?php echo get_template_directory_uri() ?>/images/62249d09ceb046b3d714cd92_Vector.png" loading="lazy" alt class="image-2">
						<h5 class="head-footer">  Проведение банкетов: Пн-Вс с 10:00-24:00<br></h5>
					</div>
					<div class="w-clearfix w-col w-col-4"><img src="<?php echo get_template_directory_uri() ?>/images/62249f1c786212682b2910ca_Group.png" loading="lazy" alt class="image-3">
						<h5 class="head-footer">   Просмотр залов: Пн-Вс с 11:00-18:00<br></h5>
					</div>
					<div class="w-col w-col-2"><a href="#" class="link-footer w-inline-block"><img src="<?php echo get_template_directory_uri() ?>/images/62249deedd39afa95db4ccc9_Telegram.png" loading="lazy" width="20" alt></a><img src="<?php echo get_template_directory_uri() ?>/images/62249e68dd39aff705b4ce9a_Vector2034.png" loading="lazy" alt><a href="#" class="link-footer w-inline-block"><img src="<?php echo get_template_directory_uri() ?>/images/62249deefca782e1e2c55eac_VK.png" loading="lazy" width="20" alt></a><img src="<?php echo get_template_directory_uri() ?>/images/62249e68dd39aff705b4ce9a_Vector2034.png" loading="lazy" alt><a href="#" class="link-footer w-inline-block"><img src="<?php echo get_template_directory_uri() ?>/images/62249dee62cce9cc578d7a8e_Instagram.png" loading="lazy" width="20" alt></a></div>
				</div>
			</div>
		</div>
		<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
		<?php get_template_part("footer_block", ""); ?>