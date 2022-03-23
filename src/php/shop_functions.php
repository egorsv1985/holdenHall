<?php

defined('ABSPATH') || exit;

if (!class_exists('WooCommerce')) {
    return;
}

function ajaxs_add_to_cart($jx)
{
    $product_id = $jx->data['product_id'] ? $jx->data['product_id'] : null;
    $product_qty = $jx->data['qty'] ? $jx->data['qty'] : 1;
    $variation_id = $jx->data['variation_id'] ? $jx->data['variation_id'] : null;
    $variation_attributes = $jx->data['variation_attributes'] ? $jx->data['variation_attributes'] : null;
    $item_data = $jx->data['item_data'] ? $jx->data['item_data'] : null;
    $products = $jx->data['products'] ? $jx->data['products'] : null;

    if ($products !== null) {
        if (is_array($products)) {
            foreach ($products as $product) {
                $product_id = $product['product_id'];
                $product_qty = $product['product_qty'];
                $variation_id = $product['variation_id'];
                $variation_attributes = $product['variation_attributes'];
                $item_data = $product['item_data'];

                WC()->cart->add_to_cart($product_id, $product_qty, $variation_id, $variation_attributes, $item_data);
            }
        } else {
            $products = explode(',', $products);

            foreach ($products as $product) {
                $product_arr = array_map('trim', explode('-', $product));

                $product_id = $product_arr[0];

                if (count($product_arr) === 2) {
                    $variation_id = $product_arr[1];
                }

                WC()->cart->add_to_cart($product_id, $product_qty, $variation_id, $variation_attributes, $item_data);
            }
        }
    } else {
        $result = WC()->cart->add_to_cart($product_id, $product_qty, $variation_id, $variation_attributes, $item_data);
    }

    if (!$result) {
        $jx->error();
    }

    $jx->html('[data-wc=cart_count]', WC()->cart->cart_contents_count);
    $jx->html('[data-wc=cart_total]', WC()->cart->get_cart_total());

    ob_start();
    get_template_part('mini_cart', '');

    $jx->html('[data-wc=mini_cart]', ob_get_clean());

    if (get_option('woocommerce_cart_redirect_after_add') === 'yes') {
        $jx->redirect(wc_get_cart_url());
    }

    $jx->jseval("wtw_webflow_init()");
}

function ajaxs_change_cart_qty($jx)
{
    $item_key = $jx->data['key'];
    $item_qty = $jx->data['qty'];
    $action = $jx->data['cart_action'];

    $item = WC()->cart->get_cart_item($item_key);

    if ($action === 'cart_qty_plus') {
        WC()->cart->set_quantity($item_key, $item['quantity'] + 1);
    } elseif ($action === 'cart_qty_minus' && $item['quantity'] > 1) {
        WC()->cart->set_quantity($item_key, $item['quantity'] - 1);
    } elseif ($action === 'cart_product_qty') {
        WC()->cart->set_quantity($item_key, $item_qty);
    } elseif ($action === 'cart_product_remove') {
        WC()->cart->remove_cart_item($item_key);
    }

    $jx->html('[data-wc=cart_count]', WC()->cart->cart_contents_count);
    $jx->html('[data-wc=cart_total]', WC()->cart->get_cart_total());

    ob_start();
    echo do_shortcode("[woocommerce_cart]");
    $jx->html('[data-wc=cart]', ob_get_clean());

    ob_start();
    get_template_part('full_cart', '');
    $jx->html('[data-wc=full_cart]', ob_get_clean());

    ob_start();
    get_template_part('order_cart', '');
    $jx->html('[data-wc=order_cart]', ob_get_clean());

    ob_start();
    get_template_part('mobile_cart', '');
    $jx->html('[data-wc=mobile_cart]', ob_get_clean());

    ob_start();
    get_template_part('mini_cart', '');

    $jx->html('[data-wc=mini_cart]', ob_get_clean());
}

function ajaxs_refresh_cart($jx)
{
    $jx->html('[data-wc=cart_count]', WC()->cart->cart_contents_count);
    $jx->html('[data-wc=cart_total]', WC()->cart->get_cart_total());

    ob_start();
    get_template_part('mini_cart', '');
    $jx->html('[data-wc=mini_cart]', ob_get_clean());

    $jx->jseval("wtw_webflow_init()");
}

function wtw_get_billing_state_options($args)
{
    if (isset($args['billing_state'])) {
        $cur_state = $args['billing_state'];
    } else {
        $cur_state = get_user_meta(get_current_user_id(), 'billing_state', true);
    }

    if (isset($args['billing_country'])) {
        $cur_country = $args['billing_country'];
    } elseif (get_current_user_id() !== 0) {
        $cur_country = get_user_meta(get_current_user_id(), 'billing_country', true);
    } else {
        $def_country = explode(':', get_option('woocommerce_default_country'));
        $cur_country = $def_country[0];
    }

    $WC_Countries = new WC_Countries();
    $states = $WC_Countries->get_shipping_country_states();

    $options = '';
    foreach ($states[$cur_country] as $state_code => $state_title) {
        $options .= get_option_html($state_code, $state_title, $cur_state)."\n";
    }

    return $options;
}

function get_var_options_list($variations, $template)
{
    foreach ($variations as $variation) {
        $taxonomy = key($variation['attributes']);
        $attr = array_shift($variation['attributes']);
        $taxonomy = str_replace('attribute_', '', $taxonomy);
        $term = get_term_by('slug', $attr, $taxonomy);

        $variation_id = $variation['variation_id'];
        $price = get_formatted_price($variation['display_price']);
        $regular_price = get_formatted_price($variation['display_regular_price']);

        $title = $term->name;

        if ($template !== '') {
            $title = str_replace('%attr%', $title, $template);
            $title = str_replace('%price%', $price, $title);
        }

        if (strpos($variation['availability_html'], 'available-on-backorder') !== false) {
            $stock_status = 'backorder';
        } elseif ($variation['is_in_stock']) {
            $stock_status = 'in_stock';
        } else {
            $stock_status = 'out_stock';
        }

        $options = sprintf(
            '<option value="%s" data-price="%s" data-price-regular="%s" data-stock-status="%s">%s</option>',
            $variation_id,
            $price,
            $regular_price,
            $stock_status,
            $title
        );

        echo $options;
    }
}

function is_sale()
{
    global $product;

    if (!isset($product)) {
        $product = get_product(get_the_ID());
    }

    $sale = $product->is_on_sale();

    return $sale;
}

function get_price($price_type, $format = 'default')
{
    global $product;

    if (!isset($product)) {
        $product = get_product(get_the_ID());
    }

    $sale = $product->is_on_sale();

    $price = '';
    $range_price = '';
    $extreme_price = '';

    if ($product->product_type === 'variable') {
        if ($price_type === 'price' && !$sale) {
            $extreme_price = $product->get_variation_price();
            $range_price = $product->get_variation_regular_price('min', true).'-'.$product->get_variation_regular_price('max', true);
        } elseif ($price_type === 'price' && $sale) {
            $range_price = $product->get_variation_sale_price('min', true).'-'.$product->get_variation_regular_price('max', true);
        } elseif ($price_type === 'price_sale' && $sale) {
            $extreme_price = $product->get_variation_sale_price('min', true);
        } elseif ($price_type === 'price_regular' && $sale) {
            $extreme_price = $product->get_variation_regular_price('min', true);
            if ($product->get_variation_sale_price('min', true) >= $price) {
                $extreme_price = $product->get_variation_sale_price('max', true);
            }
        }

        if ($format === 'default') {
            $variation_id = find_matching_product_variation($product, $product->default_attributes);
            if ($variation_id !== 0 && !is_null($variation_id)) {
                $product_variation = new WC_Product_Variation($variation_id);
                $sale = $product_variation->is_on_sale();
                if ($price_type === 'price' && !$sale) {
                    $price = $product_variation->get_price();
                } elseif ($price_type === 'price_sale' && $sale) {
                    $price = $product_variation->get_sale_price();
                } elseif ($price_type === 'price_regular' && $sale) {
                    $price = $product_variation->get_regular_price();
                }
            } else {
                $price = $extreme_price;
            }
        } elseif ($format === 'extreme') {
            $price = $extreme_price;
        } elseif ($format === 'range') {
            $price = $range_price;
        }
    } else {
        if ($price_type === 'price' && !$sale) {
            $price = $product->get_price();
        } elseif ($price_type === 'price_sale' && $sale) {
            $price = $product->get_sale_price();
        } elseif ($price_type === 'price_regular' && $sale) {
            $price = $product->get_regular_price();
        }
    }

    if ($price !== '') {
        $price = get_formatted_price($price);
    }

    return $price;
}

function get_formatted_price($price)
{
    $price_arr = explode('-', $price);
    $i = 0;
    foreach ($price_arr as $price) {
        $price = number_format(
            $price,
            wc_get_price_decimals(),
            wc_get_price_decimal_separator(),
            wc_get_price_thousand_separator()
        );
        $price = sprintf(get_woocommerce_price_format(), get_woocommerce_currency_symbol(), $price);
        $price_arr[$i] = $price;
        $i++;
    }

    $price = implode(' - ', $price_arr);

    return $price;
}

function ajaxs_load_product($jx)
{
    $id = $jx->data['id'];
    $part = $jx->data['part'];
    global $post;
    $post = get_post($id);
    setup_postdata($post);
    ob_start();
    require locate_template($part . '.php');
    $jx->html('[data-part=' . $part . ']', ob_get_clean());
    $jx->jseval('change_variations(); set_var_price();');
    $jx->jseval("wtw_webflow_init()");
}

function ajaxs_wc_login($jx)
{
    $result = wp_signon([
        'user_login' => $jx->data['login'],
        'user_password' => $jx->data['password'],
        'remember' => isset($jx->data['rememberme']) ? $jx->data['rememberme'] : 'forever',
    ]);
    if (is_wp_error($result)) {
        $jx->error($result);
    } else {
        $jx->success();
    }
}

function ajaxs_wc_register($jx)
{
    $args = [];

    jx()->log($jx->data);

    foreach ($jx->data as $field => $value) {
        if ($field === 'email') {
            $email = $value;
        } elseif ($field === 'password') {
            $password = $value;
        } elseif ($field === 'username') {
            $username = $value;
        } elseif ($field !== 'ajaxs_nonce') {
            $args[$field] = $value;
        }
    }

    if (isset($display_name)) {
        $username = slugify($display_name);
    } elseif (isset($display_name)) {
        $username = slugify($display_name);
    } elseif (isset($first_name) && isset($last_name)) {
        $username = slugify($first_name.'_'.$last_name);
    } else {
        $username = str_replace(['@','.'], '_', $email);
    }

    $result = wc_create_new_customer($email, $username, $password, $args);

    if (is_wp_error($result)) {
        $jx->error($result);
    } else {
        $jx->success();
    }
}

function ajaxs_wc_recover($jx)
{
    $email = $jx->data['email'];
    $user = get_user_by('email', $email);
    if ($user === false) {
        $jx->error('Ошибка: Такого пользователя не существует!');
    } else {
        $pass = wp_generate_password();
        wp_set_password($pass, $user->ID);

        if (!isset($jx->data['subject'])) {
            $subject = 'Ваш новый пароль';
        } else {
            $subject = $jx->data['subject'];
        }

        if (!isset($jx->data['message'])) {
            $message = 'Ваш новый пароль:';
        } else {
            $message = $jx->data['message'];
        }

        wp_mail($email, $subject, $message . ' ' . $pass);
        $jx->success();
    }
}

function ajaxs_load_variation($jx)
{
    $product_id = $jx->data['id'];
    $product = get_product($product_id);

    $attributes = $jx->data['variation_attributes'];
    if ($attributes === '') {
        $attributes = $product->default_attributes;
    }

    $variation_id = find_matching_product_variation($product, $attributes);

    if ($variation_id !== 0 && !is_null($variation_id)) {
        $product_variation = new WC_Product_Variation($variation_id);
        $price = $product_variation->get_price();
        $sale_price = $product_variation->get_sale_price();
        $regular_price = $product_variation->get_regular_price();
        $price === $sale_price ? $sale = true : $sale = false;

        $product_image = wp_get_attachment_image_src($product->get_image_id(), 'large');
        $variation_image = wp_get_attachment_image_src($product_variation->get_image_id(), 'large');

        $response = [
            'id' => $variation_id,
            'product_id' => $product_id,
            'attributes' => $attributes,
            'attributes_complete' => count($attributes) === count($product->get_attributes()),
            'title' => $product_variation->get_title(),
            'sku' => $product_variation->get_sku(),
            'stocked' => $product_variation->is_in_stock(),
            'stock_status' => $product_variation->get_stock_status(),
            'stock_quantity' => $product_variation->get_stock_quantity(),
            'weight' => $product_variation->get_weight(),
            'length' => $product_variation->get_length(),
            'width' => $product_variation->get_width(),
            'height' => $product_variation->get_height(),
            'description' => $product_variation->get_description(),
            'price' => $sale ? '' : wc_price($product_variation->get_price()),
            'sale_price' => !$sale ? '' : wc_price($product_variation->get_sale_price()),
            'regular_price' => !$sale ? '' : wc_price($product_variation->get_regular_price()),
            'parent_image_url' => $product_image[0],
            'image_url' => $variation_image[0],
        ];

        $response = apply_filters('wtw_variation_data_extend', $response, $product, $product_variation);
    } else {
        $product_image = wp_get_attachment_image_src($product->get_image_id(), 'large');

        $response = [
            'id' => 0,
            'attributes_complete' => count($attributes) === count($product->get_attributes()),
            'parent_image_url' => $product_image[0],
        ];
    }

    //$jx->log($response);
    return $response;
}

function find_matching_product_variation($product, $attributes)
{
    //jx()->log('product', $product);
    foreach ($attributes as $key => $value) {
        if (strpos($key, 'attribute_') === 0) {
            continue;
        }
        unset($attributes[$key]);
        $attributes[sprintf('attribute_%s', $key)] = $value;
    }
    if (class_exists('WC_Data_Store')) {
        $data_store = WC_Data_Store::load('product');
        return $data_store->find_matching_product_variation($product, $attributes);
    } else {
        return $product->get_matching_variation($attributes);
    }
}

function get_current_shipping_cost()
{
    $method_data = explode(':', WC()->session->get('chosen_shipping_methods')[0]);
    $method = WC_Shipping_Zones::get_shipping_method($method_data[1]);
    return wc_price($method->cost);
}

function ajaxs_recalc_checkout($jx)
{
    if (isset($jx->data['shipping_method'])) {
        WC()->session->set('chosen_shipping_methods', $jx->data['shipping_method']);
    }

    if (isset($jx->data['payment_method'])) {
        WC()->session->set('chosen_payment_method', $jx->data['payment_method']);
    }

    WC()->customer->set_props(
        [
            'billing_postcode' => isset($jx->data['billing_postcode']) ? wp_unslash($jx->data['billing_postcode']) : null,
            'billing_country' => isset($jx->data['billing_country']) ? wp_unslash($jx->data['billing_country']) : null,
            'billing_state' => isset($jx->data['billing_state']) ? wp_unslash($jx->data['billing_state']) : null,
            'billing_city' => isset($jx->data['billing_city']) ? wp_unslash($jx->data['billing_city']) : null,
            'billing_address_1' => isset($jx->data['billing_address_1']) ? wp_unslash($jx->data['billing_address_1']) : null,
            'billing_address_2' => isset($jx->data['billing_address_2']) ? wp_unslash($jx->data['billing_address_2']) : null,
            'shipping_postcode' => isset($jx->data['billing_postcode']) ? wp_unslash($jx->data['billing_postcode']) : null,
            'shipping_country' => isset($jx->data['billing_country']) ? wp_unslash($jx->data['billing_country']) : null,
            'shipping_state' => isset($jx->data['billing_state']) ? wp_unslash($jx->data['billing_state']) : null,
            'shipping_city' => isset($jx->data['billing_city']) ? wp_unslash($jx->data['billing_city']) : null,
            'shipping_address_1' => isset($jx->data['billing_address_1']) ? wp_unslash($jx->data['billing_address_1']) : null,
            'shipping_address_2' => isset($jx->data['billing_address_2']) ? wp_unslash($jx->data['billing_address_2']) : null,
        ]
    );

    WC()->customer->set_calculated_shipping(true);
    WC()->customer->save();

    WC()->cart->calculate_totals();

    if (!isset(WC()->session->reload_checkout)) {
        $messages = wc_print_notices(true);
    } else {
        $messages = '';
    }

    unset(WC()->session->refresh_totals, WC()->session->reload_checkout);

    ob_start();
    get_template_part('woocommerce/checkout/form-checkout', '', $jx->data);
    $jx->html('[data-name=checkout_form]', ob_get_clean());

    $jx->jseval("if (typeof(wtw_after_recalc_checkout) === 'function') { wtw_after_recalc_checkout(); } else { wtw_webflow_init() }");
}

add_action('pre_get_posts', 'custom_posts_per_page');
function custom_posts_per_page($query)
{
    if (!isset($_GET['perpage'])) {
        return false;
    }
    if ($_GET['perpage'] == '') {
        if (get_query_var('posts_per_page') === get_option('posts_per_page')) {
            $query->set('posts_per_page', get_option('posts_per_page'));
        }
    } else {
        if (get_query_var('posts_per_page') === get_option('posts_per_page')) {
            $query->set('posts_per_page', $_GET['perpage']);
        }
    }
}

function upsell_products()
{
    return get_post_meta(get_the_ID(), '_upsell_ids')[0];
}

function get_upsell_products($limit = 4)
{
    $args = [];
    $args['orderby'] = 'rand';
    $args['post_type'] = 'product';
    $args['posts_per_page'] = $limit;
    $args['post__in'] = upsell_products();
    return $args;
}

function crosssell_products()
{
    return get_post_meta(get_the_ID(), '_crosssell_ids')[0];
}

function get_crosssell_products($limit = 4)
{
    $args = [];
    $args['orderby'] = 'rand';
    $args['post_type'] = 'product';
    $args['posts_per_page'] = $limit;
    $args['post__in'] = crosssell_products();
    return $args;
}

function viewed_products()
{
    $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode(
        '|',
        $_COOKIE['woocommerce_recently_viewed']
    ) : [];
    $viewed_products = array_filter(array_map('absint', $viewed_products));
    return $viewed_products;
}

function get_viewed_products($limit = 4)
{
    $args = [];
    $args['orderby'] = 'rand';
    $args['post_type'] = 'product';
    $args['posts_per_page'] = $limit;
    $args['post__in'] = viewed_products();
    return $args;
}

function related_products($limit = 4)
{
    global $woocommerce;
    $id = get_the_ID();

    $tags_array = [0];
    $cats_array = [0];

    $terms = wp_get_post_terms($id, 'product_cat');
    foreach ($terms as $term) {
        $cats_array[] = $term->term_id;
    }

    if (sizeof($cats_array) == 1 && sizeof($tags_array) == 1) {
        return [];
    }

    $meta_query = [];
    $meta_query[] = $woocommerce->query->visibility_meta_query();
    $meta_query[] = $woocommerce->query->stock_status_meta_query();

    $related_posts = get_posts(apply_filters('woocommerce_product_related_posts', [
        'orderby' => 'rand',
        'posts_per_page' => $limit,
        'post_type' => 'product',
        'fields' => 'ids',
        'meta_query' => $meta_query,
        'tax_query' => [
            'relation' => 'OR',
            [
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $cats_array
            ],
            [
                'taxonomy' => 'product_tag',
                'field' => 'id',
                'terms' => $tags_array
            ]
        ]
    ]));
    $related_posts = array_diff($related_posts, [$id]);
    return $related_posts;
}

function get_related_products($limit = 4)
{
    $args = [];
    $args['orderby'] = 'rand';
    $args['post_type'] = 'product';
    $args['posts_per_page'] = $limit;
    $args['post__in'] = related_products($limit);
    return $args;
}

add_action('wp', 'login_redirect');
function login_redirect()
{
    global $post;
    if (!is_user_logged_in() && ($post->post_name === 'my-orders' || $post->post_name === 'my-data')) {
        wp_redirect(site_url() . '/my-account');
        exit;
    }
}

add_action('template_redirect', 'head_hook');
function head_hook_()
{
    if (WC()->cart->cart_contents_count != 0 && is_page('cart')) {
        wp_redirect(home_url('/checkout'));
        exit();
    }
}

function get_product_variation_price($variation_id)
{
    global $woocommerce;
    $product = new WC_Product_Variation($variation_id);
    return $product->get_price_html();
}

function ajaxs_update_user($jx)
{
    $user_id = wp_update_user([
        'ID' => get_current_user_id(),
        'first_name' => $jx->data['first_name'],
        'last_name' => $jx->data['last_name'],
        'user_email' => $jx->data['user_email'],
    ]);
    if (!is_wp_error($user_id)) {
        $jx->jseval("$('[name=update_user]').siblings('.w-form-done').fadeIn().delay(3000).fadeOut();");
    } else {
        $jx->jseval("$('[name=update_user]').siblings('.w-form-fail').fadeIn().delay(3000).fadeOut();");
    }
}

function ajaxs_update_password($jx)
{
    $user = get_userdata(get_current_user_id());
    if ($jx->data['password_1'] != $jx->data['password_2']) {
        $jx->jseval("$('[name=update_password]').siblings('.w-form-fail').text('Ошибка! Пароли не
одинаковы.').fadeIn().delay(3000).fadeOut();");
    } elseif ($jx->data['password_1'] === '') {
        $jx->jseval("$('[name=update_password]').siblings('.w-form-fail').text('Ошибка! Пароли не
задан.').fadeIn().delay(3000).fadeOut();");
    } elseif (!wp_check_password($jx->data['password_current'], $user->data->user_pass)) {
        $jx->jseval("$('[name=update_password]').siblings('.w-form-fail').text('Ошибка! Текущий пароль указан не
верно.').fadeIn().delay(3000).fadeOut();");
    } else {
        wp_set_password($jx->data['password_1'], get_current_user_id());
        $jx->jseval("$('[name=update_password]').siblings('.w-form-done').fadeIn().delay(3000).fadeOut();");
    }
}

function ajaxs_update_billing($jx)
{
    foreach ($jx->data as $field => $value) {
        if ($field !== 'ajaxs_nonce') {
            update_user_meta(get_current_user_id(), $field, $value);
        }
    }
    $jx->jseval("$('[name=update_billing]').siblings('.w-form-done').fadeIn().delay(3000).fadeOut();");
}

function ajaxs_update_shipping($jx)
{
    foreach ($jx->data as $field => $value) {
        if ($field !== 'ajaxs_nonce') {
            update_user_meta(get_current_user_id(), $field, $value);
        }
    }
    $jx->jseval("$('[name=update_shipping]').siblings('.w-form-done').fadeIn().delay(3000).fadeOut();");
}

function ajaxs_add_to_wl($jx)
{
    YITH_WCWL()->details['add_to_wishlist'] = $jx->data['id'];
    YITH_WCWL()->add();
    $jx->html('[data-wc=wl_count]', YITH_WCWL()->count_products());
}

function ajaxs_wl_remove($jx)
{
    $query_args['is_default'] = 1;
    $wishlist_items = YITH_WCWL()->get_products($query_args);
    foreach ($wishlist_items as $item) {
        if (in_array($item['prod_id'], $jx->data['id']) || $jx->data['id'][0] === 'all') {
            YITH_WCWL()->details['remove_from_wishlist'] = $item['prod_id'];
            YITH_WCWL()->remove();
        }
    }

    ob_start();
    get_template_part('full_wishlist', '');

    $jx->html('[data-wc=full_wishlist]', ob_get_clean());
    $jx->jseval('set_var_price()');
    $jx->html('[data-wc=wl_count]', YITH_WCWL()->count_products());
}

function ajaxs_wl_move($jx)
{
    $query_args['is_default'] = 1;
    $wishlist_items = YITH_WCWL()->get_products($query_args);
    foreach ($wishlist_items as $item) {
        if (in_array($item['prod_id'], $jx->data['id'])) {
            WC()->cart->add_to_cart($item['prod_id']);
            YITH_WCWL()->details['remove_from_wishlist'] = $item['prod_id'];
            YITH_WCWL()->remove();
        }
    }

    ob_start();
    get_template_part('full_wishlist', '');
    $jx->html('[data-wc=full_wishlist]', ob_get_clean());

    $jx->html('[data-wc=cart_count]', WC()->cart->cart_contents_count);
    $jx->html('[data-wc=cart_total]', WC()->cart->get_cart_total());
    $jx->html('[data-wc=wl_count]', YITH_WCWL()->count_products());

    ob_start();
    get_template_part('mini_cart', '');
    $jx->html('[data-wc=mini_cart]', ob_get_clean());
}

function ajaxs_wl_copy($jx)
{
    $query_args['is_default'] = 1;
    $wishlist_items = YITH_WCWL()->get_products($query_args);
    foreach ($wishlist_items as $item) {
        if (in_array($item['prod_id'], $jx->data['id'])) {
            WC()->cart->add_to_cart($item['prod_id']);
        }
    }

    ob_start();
    get_template_part('full_wishlist', '');
    $jx->html('[data-wc=full_wishlist]', ob_get_clean());

    ob_start();
    get_template_part('mini_cart', '');

    $jx->html('[data-wc=cart_count]', WC()->cart->cart_contents_count);
    $jx->html('[data-wc=cart_total]', WC()->cart->get_cart_total());

    $jx->html('[data-wc=mini_cart]', ob_get_clean());
}

add_filter('woocommerce_currencies', 'add_my_currency');
function add_my_currency($currencies)
{
    $currencies['RUB1'] = __('Российский рубль 1', 'woocommerce');
    $currencies['RUB2'] = __('Российский рубль 2', 'woocommerce');
    return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
function add_my_currency_symbol($currency_symbol, $currency)
{
    switch ($currency) {
case 'RUB1': $currency_symbol = 'Р.'; break;
case 'RUB2': $currency_symbol = 'руб'; break;
}
    return $currency_symbol;
}

function wtw_cart_attr($attr_name, $cart_item)
{
    $attribute = 'attribute_'.$attr_name;
    if (isset($cart_item['variation'][$attribute])) {
        $attr_value = $cart_item['variation'][$attribute];

        $term = get_term_by('slug', $attr_value, $attr_name);

        if ($term !== false) {
            return $term->name;
        } else {
            return '';
        }
    }
}

function wtw_cart_term($taxonomy, $cart_item)
{
    $post_id = $cart_item['product_id'];
    $terms = wp_get_post_terms($post_id, $taxonomy);

    if (is_array($terms) && count($terms)) {
        return $terms[0]->name;
    } else {
        return '';
    }
}
