<?php
//Edit Website And Apply Filters And Add Actions By Reza Elahi WebDeveloper
// Add "Wholesale Price" custom field to Products option pricing
add_action('woocommerce_product_options_pricing', 'w4dev_add_product_options_pricing');
function w4dev_add_product_options_pricing()
{
    woocommerce_wp_text_input(array(
        'id' => '_wholesale_price',
        'class' => 'wc_input_wholesale_price short',
        'label' => 'قیمت عمده فروشی' . ' (' . get_woocommerce_currency_symbol() . ')',
        'type' => 'text'
    ));

    woocommerce_wp_text_input(array(
        'id' => '_auth_wallet',
        'class' => 'wc_input_auth_wallet short',
        'label' => 'تعیین درصد کیف پول(%)',
        'type' => 'text'
    ));
}

// Add custom field to VARIATIONS option pricing
add_action('woocommerce_variation_options_pricing', 'w4dev_add_variation_options_pricing', 20, 3);
function w4dev_add_variation_options_pricing($loop, $variation_data, $post_variation)
{
    $value = get_post_meta($post_variation->ID, '_wholesale_price', true);
    $symbol = ' (' . get_woocommerce_currency_symbol() . ')';
    $key = '_wholesale_price[' . $loop . ']';

    echo '<p class="form-field variable_regular_price_0_field form-row form-row-first">
        <label style="font-weight: bold">' . 'قیمت عمده فروشی' . $symbol . '</label>
        <input type="text" size="5" name="' . $key . '" value="' . esc_attr($value) . '" />
    </p>';

    $wallet_value = get_post_meta($post_variation->ID, '_auth_wallet', true);
    $wallet_key = '_auth_wallet[' . $loop . ']';

    echo '<p class="form-field variable_sale_price0_field form-row form-row-last">
        <label style="font-weight: bold">' . 'تعیین درصد کیف پول(%)' . '</label>
        <input type="text" size="5" name="' . $wallet_key . '" value="' . esc_attr($wallet_value) . '" />
    </p>';

}

// Save "Wholesale Price" custom field to Products
add_action('woocommerce_process_product_meta_simple', 'w4dev_save_product_wholesale_price', 20, 1);
function w4dev_save_product_wholesale_price($product_id)
{
    if (isset($_POST['_wholesale_price']) && isset($_POST['_auth_wallet'])) {
        update_post_meta($product_id, '_wholesale_price', $_POST['_wholesale_price']);
        $wallet_value = $_POST['_auth_wallet'] / 100;
        update_post_meta($product_id, '_auth_wallet', $wallet_value);
    }
}

// Save "Wholesale Price" custom field to VARIATIONS
add_action('woocommerce_save_product_variation', 'w4dev_save_product_variation_wholesale_price', 20, 2);
function w4dev_save_product_variation_wholesale_price($variation_id, $i)
{
    if (isset($_POST['_wholesale_price'][$i]) && isset($_POST['_auth_wallet'][$i])) {
        update_post_meta($variation_id, '_wholesale_price', floatval($_POST['_wholesale_price'][$i]));
        $wallet_value = ($_POST['_auth_wallet'][$i]) / 100;
        update_post_meta($variation_id, '_auth_wallet', $wallet_value);
    }
}

// Simple, grouped and external products
add_filter('woocommerce_product_get_price', 'w4dev_custom_price', 90, 2);
add_filter('woocommerce_product_get_regular_price', 'w4dev_custom_price', 90, 2);

// Product variations (of a variable product)
add_filter('woocommerce_product_variation_get_regular_price', 'w4dev_custom_price', 99, 2);
add_filter('woocommerce_product_variation_get_price', 'w4dev_custom_price', 90, 2);

function w4dev_custom_price($price, $product)
{

    $stat = get_user_meta(get_current_user_id(), 'agent_status', true);
    $caps = [
        'admin' => 'manage_options',
        'agent' => 'agent_editor',
        'customer' => 'subscriber'
    ];

    switch ('agent_editor') {
        case current_user_can($caps['admin']):
            return get_post_meta($product->get_id(), '_wholesale_price', true);
            break;
        case current_user_can($caps['agent']):
            if ($stat)
                return get_post_meta($product->get_id(), '_wholesale_price', true);
            else
                return $price;
            break;

        case current_user_can($caps['customer']):
            return get_post_meta($product->get_id(), '_regular_price', true);
            break;
    }


    return $price;
}

// Variable product price ramge
add_filter('woocommerce_variation_prices_price', 'w4dev_custom_variation_price', 90, 3);
add_filter('woocommerce_variation_prices_regular_price', 'w4dev_custom_variation_price', 90, 3);

function w4dev_custom_variation_price($price, $variation, $product)
{
    $stat = get_user_meta(get_current_user_id(), 'agent_status', true);
    $caps = [
        'admin' => 'manage_options',
        'agent' => 'agent_editor',
        'customer' => 'subscriber'
    ];


    switch ('agent_editor') {
        case current_user_can($caps['admin']):
            return get_post_meta($variation->get_id(), '_wholesale_price', true);
            break;
        case current_user_can($caps['agent']):
            if ($stat)
                return get_post_meta($variation->get_id(), '_wholesale_price', true);
            else
                return $price;
            break;
        case current_user_can($caps['customer']):
            return get_post_meta($variation->get_id(), '_regular_price', true);
            break;
    }


    return $price;
}


function avada_change_price_display($price)
{
    global $post;
    $product = wc_get_product($post->ID);
    if (current_user_can('agent_editor')) {
        return '<span class="woocommerce-Price-amount amount">' . $price . '</span>';
    } else {
//        $price = '';
        return $price;
    }
}

//add_action('woocommerce_get_price_html', 'avada_change_price_display');

add_action('woocommerce_after_single_product_summary', 'auth_after_single_product_summary_func');
function auth_after_single_product_summary_func()
{
    global $product;
    if (!current_user_can('agent_editor')) {
        echo '<a style="background: #ff5a00;color: #fff;padding: 10px;" href="' . home_url('/register') . '"><span class="woocommerce-Price-amount amount">' . 'برای بهره مندی از قیمت عمده فروشی باید درخواست نمایندگی برای مدیریت ارسال نمایید .' . '</span></a>';
    }
}



