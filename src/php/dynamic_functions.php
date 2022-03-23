<?php
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
'key' => 'sekcii-stranicy',
'title' => 'Секции страницы',
'menu_order' => 0,
'location' => array(
  array(
    array(
      'param' => 'post_template',
      'operator' => '==',
      'value' => 'index.php',
    ),
  ),
),
'hide_on_screen' => array(
  
),
'fields' => array (
  0 => 
  array (
    'label' => 'Заголовок',
    'name' => 'zagolovok',
    'key' => 'field_index_zagolovok',
    'type' => 'text',
  ),
),
));
endif;
?><?php
register_sidebar( array(
'name'          => 'Слайдер на главной',
'id'            => 'slajder_na_glavnoj',
'description'   => '',
'class'         => '',
'before_widget' => '<div class="">',
'after_widget'  => '</div>',
'before_title'  => '<h3 class="">',
'after_title'   => '</h3>'
)); ?>
<?php
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
'key' => 'parametry-golden-hall',
'title' => 'Параметры Golden Hall',
'menu_order' => 0,
'location' => array(
  array(
    array(
      'param' => 'post_template',
      'operator' => '==',
      'value' => 'golden-hall.php',
    ),
  ),
),
'hide_on_screen' => array(
  0 => 'the_content',
),
'fields' => array (
  0 => 
  array (
    'label' => 'Заголовок',
    'name' => 'zagolovok',
    'key' => 'field_golden-hall_zagolovok',
    'type' => 'text',
  ),
  1 => 
  array (
    'label' => '1 абзац',
    'name' => '1_abzac',
    'key' => 'field_golden-hall_1_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  2 => 
  array (
    'label' => '2 абзац',
    'name' => '2_abzac',
    'key' => 'field_golden-hall_2_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  3 => 
  array (
    'label' => '3 абзац',
    'name' => '3_abzac',
    'key' => 'field_golden-hall_3_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  4 => 
  array (
    'label' => '4 абзац',
    'name' => '4_abzac',
    'key' => 'field_golden-hall_4_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
),
));
endif;
?><?php
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
'key' => 'parametry-rotonda',
'title' => 'Параметры Ротонда',
'menu_order' => 0,
'location' => array(
  array(
    array(
      'param' => 'post_template',
      'operator' => '==',
      'value' => 'rotonda.php',
    ),
  ),
),
'hide_on_screen' => array(
  0 => 'the_content',
),
'fields' => array (
  0 => 
  array (
    'label' => '1 абзац',
    'name' => '1_abzac',
    'key' => 'field_rotonda_1_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  1 => 
  array (
    'label' => '2 абзац',
    'name' => '2_abzac',
    'key' => 'field_rotonda_2_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  2 => 
  array (
    'label' => '2abzac',
    'name' => '2abzac',
    'key' => 'field_rotonda_2abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  3 => 
  array (
    'label' => '3 абзац',
    'name' => '3_abzac',
    'key' => 'field_rotonda_3_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  4 => 
  array (
    'label' => '4 абзац',
    'name' => '4_abzac',
    'key' => 'field_rotonda_4_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
),
));
endif;
?><?php
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
'key' => 'parametry-silver-hall',
'title' => 'Параметры Silver Hall',
'menu_order' => 0,
'location' => array(
  array(
    array(
      'param' => 'post_template',
      'operator' => '==',
      'value' => 'silverhall.php',
    ),
  ),
),
'hide_on_screen' => array(
  0 => 'the_content',
),
'fields' => array (
  0 => 
  array (
    'label' => '1_abzac',
    'name' => '1_abzac',
    'key' => 'field_silverhall_1_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  1 => 
  array (
    'label' => '2_abzac',
    'name' => '2_abzac',
    'key' => 'field_silverhall_2_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  2 => 
  array (
    'label' => '4_abzac',
    'name' => '4_abzac',
    'key' => 'field_silverhall_4_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
  3 => 
  array (
    'label' => '3_abzac',
    'name' => '3_abzac',
    'key' => 'field_silverhall_3_abzac',
    'type' => 'wysiwyg',
    'toolbar' => 'full',
  ),
),
));
endif;
?>