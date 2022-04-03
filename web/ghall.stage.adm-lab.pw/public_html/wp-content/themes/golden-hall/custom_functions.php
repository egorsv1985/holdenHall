<?php
function carouselgal( $atts ){
	$gal = get_field('carousel', 119);
    $galbody = '';
				    if ($gal) { 
                        $galbody .= '<div class="swiper-1 swiper-container">
					<div class="swiper-wrapper">';
					    foreach ($gal as $im) {
                            $galbody .= '
							<div class="swiper-slide">
					            <img class="image-fluid" src="'. $im['url'] .'">
					          </div>';
					     }
                         $galbody .= '
            	    </div>
				<div class="swiper-button-prev sw-prev"></div>
				<div class="swiper-button-next sw-next"></div>
				</div>';
				 }
	return $galbody;
}
 
add_shortcode( 'carousel_slider', 'carouselgal' );

//подключаем стили в head
add_action('wp_enqueue_scripts', 'add_header_styles');
function add_header_styles() {
	wp_enqueue_style( 'swipercss', get_template_directory_uri() .'/css/swiper.min.css');
}
//подключаем скрипты в хедер
add_action( 'wp_enqueue_scripts', 'add_header_scripts');
function add_header_scripts(){
	wp_enqueue_script('swiperjs', get_template_directory_uri() . '/js/swiper.min.js', false, false, false);

}