<?php
/*
Template name: Search
*/
?>
<!DOCTYPE html>
<!-- Last Published: Tue Mar 15 2022 12:38:41 GMT+0000 (Coordinated Universal Time) --><html data-wf-page="62230a7f87949d2d7e81a6ba" data-wf-site="62230a7f87949d68de81a6a0">
	<?php get_template_part("header_block", ""); ?>
	<body class="body">
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
		<div class="breadcrumbs wf-section">
			<div class="bc-text"><a href="/" class="bc-link">Главная</a> <span class="bc-sep">/</span> ПОИСК</div>
		</div>
		<div class="posts wf-section">
			<div class="container">
				<div class="post-content">
					<div class="posts-list">
						<?php $rotation = 0; if(have_posts()) : while(have_posts()) : the_post(); $rotation === 0 ? $rotation = 1 : $rotation++; ?>
						<div class="blog-post _2"><a href="<?php the_permalink(); ?>" class="blog-photo mini w-inline-block" style='background-image: url(<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(), "full"); echo $img[0]; ?>);'></a>
							<div class="blog-post-content _2"><a href="<?php the_permalink(); ?>" class="post-link-2 w-inline-block"><h3 class="h3 _2"><?php the_title(); ?></h3></a>
								<div class="blog-post-info aside-info">
									<div class="post-date">
										<?php echo get_the_date(get_option('date_format')); ?>
									</div>
									<div class="blog-info-separator">|</div>
									<div class="post-author"><a href="<?php echo get_author_posts_url(get_the_author_meta( "ID" )) ?>" class="author-link"><?php the_author(); ?></a></div>
								</div>
								<div class="post-text _2">
									<?php the_excerpt(); ?>
								</div><a href="<?php the_permalink(); ?>" class="post-link-2 w-inline-block"><div class="blog-btn-2">Подробнее</div></a></div>
						</div>
						<?php endwhile; ?>
						<?php else : ?>
						<?php endif; wp_reset_postdata(); ?>
					</div>
				</div>
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