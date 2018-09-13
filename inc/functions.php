<?php
/**
 * @snippet       Hide Price & Add to Cart for Logged Out Users
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=299
 * @author        Reza Elahi
 * @testedwith    WooCommerce 3.3.4
 */
//add_action('init', 'auth_hide_price_add_cart_not_logged_in');

//function auth_hide_price_add_cart_not_logged_in()
//{
//    $id = get_current_user_id();
//    $agent_status = get_user_meta($id, 'agent_status', true);
//    if (!is_user_logged_in() || $agent_status == false) {
//        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
//        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
//        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
//        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
////        add_action('woocommerce_single_product_summary', 'auth_print_login_to_see', 31);
////        add_action('woocommerce_after_shop_loop_item', 'auth_print_login_to_see', 11);
//    }
//}
//
//function auth_print_login_to_see()
//{
//    echo '<a href="' . home_url('/register') . '"><span class="woocommerce-Price-amount amount">' . 'برای مشاهده قیمت عمده فروشی باید درخواست نمایندگی برای مدیریت ارسال نمایید .' . '</span></a>' . get_post_meta(get_the_ID(), '_wholesale_price', true);
//}

include AUTH_INC . 'wholesale-price.php';
include AUTH_INC . 'classes/soap.php';
include AUTH_INC . 'classes/payment-credit.php';
add_filter('woocommerce_payment_on_time_gateway_icon', function () {
    return '';
});
function auth_wlog($msg, $level = 'DEBUG') {

    if (!WP_DEBUG) {
        return;
    }

    $p = '/tmp/wp_debug.log';
    $trace = debug_backtrace();
    $m = "{$level} " . date('Ymdhi') . ' ' . "{$msg}\n";
    error_log($m, 3, $p);
}

function auth_load_tmpl($filePath, $variables = array(), $print = false) {
    $output = NULL;
    if (!file_exists($filePath)) {
        auth_wlog("file *{$filePath}* not found");
        return null;
    }

    extract($variables);

    ob_start();

    include $filePath;

    $output = ob_get_clean();

    if ($print) {
        print $output;
    }

    return $output;
}
add_action('auth_success_payment_credit','auth_send_email_order_success');
function auth_send_email_order_success($order_id)
{
    $order = new WC_Order($order_id);
    $to = $order["billing_address"];
    $data = [
        'transaction_id' => get_post_meta($order_id, 'transaction', true),
        'the_term' => get_post_meta($order_id, 'the_term', true)
    ];

    // html utf-8 mail (yo can get data from forms)
    $html = auth_load_tmpl(plugin_dir_path(__FILE__) . 'email-tpl-users.php', $data);
    $subject = 'شرکت فولاد رایانه تصویر - جزئیات خرید';
    $headers = "From: info@localhost\r\n";
    $headers .= "Reply-To: info@localhost\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail($to, $subject, $html, $headers);

}
add_action('woocommerce_payment_complete', 'auth_send_email_order_success');

//Agent functions

function auth_register_account_info($account_name, $sheba_number, $bank_name, $register_account_info_field_nonce)
{
    if ((empty($account_name) || empty($sheba_number)) || (empty($bank_name) || empty($register_account_info_field_nonce))) {
        return false;
    }
    if (!preg_match('/IR\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d\d$/', $sheba_number)) {
        return false;
    }
    return true;
}

function auth_disable_wplogin()
{
    function give_permissions($allcaps, $cap, $args)
    {
        $allcaps['upload_files'] = true;
        return $allcaps;
    }

    add_filter('user_has_cap', 'give_permissions', 0, 3);
    add_role(
        'agent_editor',
        'نماینده',
        array(
            'read' => true,  // true allows this capability
            'edit_posts' => true,
            'upload_files' => true
        )
    );
    $currentUrl = $_SERVER['REQUEST_URI'];

    if (strpos("$currentUrl", 'wp-login.php') !== false) {
        auth_redirect_page('agent-login');
    }

}

add_action('init', 'auth_disable_wplogin'); // Disable wp-login.php file unaccess !

add_filter('ajax_query_attachments_args', 'auth_dramatist_filter_media');

add_shortcode('auth_dramatist_front_upload', 'auth_dramatist_front_upload_callback');

function upload_agent_file_send_notify($message, $current_user_id)
{


//Send SMS

    /**
     * @author parsgreen
     * @copyright 2014
     */

//

    $portalCode = '6932';
    $userName = 'fouladrayaneh';
    $password = 'frt500';
    $webServiceURL = "http://messagingws.negins.com/sendSMS.asmx?wsdl";
//    $webServiceSignature = "348E3537-42B1-4155-A2B6-440353854D59";
    $webServiceNumber = '300081070';
    $mobile = '09015419719'; // all mobile add in this array => support one or more
    $isFlash = false; // falsh sms => open quick in phone and after close message , cleare from phone ;
    $serverType = 1;


    mb_internal_encoding("utf-8");
    $message = $message['success']; // sms text// the text or body for sending
    $message = mb_convert_encoding($message, "UTF-8"); // encoding to utf-8
    // OR
    //$textMessage=iconv($encoding, 'UTF-8//TRANSLIT', $textMessage); // encoding to utf-8
    // OR
    //$textMessage =  utf8_encode( $str); // encoding to utf-8

//    $parameters['signature'] = $webServiceSignature;
    $parameters['userName'] = $userName;
    $parameters['passWord'] = $password;
    $parameters['mobile'] = $mobile;
    $parameters['portalCode'] = $portalCode;
    $parameters['message'] = $message;
    $parameters['ServerType'] = $serverType;
    $con = new soapclient($webServiceURL);

    $responseSTD = (array)$con->singleSMSengine(
        $portalCode,
        $userName,
        $password,
        $mobile,
        $message,
        $serverType
    );
    if ($responseSTD) {
        echo $responseSTD['singleSMSengine'];
    } else {
        echo 'Error';
    }


//Send Mail To Admin
    global $wpdb;
    $user = $wpdb->get_row($wpdb->prepare("
                        SELECT u.display_name , u.user_email FROM {$wpdb->prefix}users u
                        WHERE u.ID= %d
                        ", $current_user_id));
    if (is_null($user)) {
        return false;
    }
    // html utf-8 mail (yo can get data from forms)
    $to = $user->user_email;
    $html = auth_load_tmpl(plugin_dir_path(__FILE__) . 'email-tpl-admin.php', $user);
    $subject = 'فولاد رایانه - نمایندگان فروش';
    $headers = "From: info@localhost\r\n";
    $headers .= "Reply-To: info@localhost\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail($to, $subject, $html, $headers);
}

add_action('upload_Agent_file', 'upload_agent_file_send_notify', 1, 2);

function auth_registration_save($user_id)
{
    $user = new WP_User($user_id);

    $user->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
    $user->add_role('agent_editor');
}


/**
 * Call wp_enqueue_media() to load up all the scripts we need for media uploader
 */


function auth_add_media_script()
{
    if (is_admin()) {
        return;
    }
    wp_enqueue_media();
}

add_action('wp_enqueue_scripts', 'auth_add_media_script');

$load_media = new auth_agents();
$load_media->enqueueAssets();

/**
 * This filter insures users only see their own media
 */
function auth_dramatist_filter_media($query)
{
    // admins get to see everything
    if (!current_user_can('manage_options'))
        $query['author'] = get_current_user_id();
    return $query;
}

function auth_dramatist_front_upload_callback($args)
{
//     check if user can upload files
    if (current_user_can('agent_editor')) {
        $str = 'انتخاب تصویر';
        return '<input id="custom_media_upload" type="button" value="' . $str . '" class="custom_media_upload form-control button" style="position: relative; z-index: 1;"><img id="frontend-image" />';
    }
    return 'لطفا برای آپلود تصاویر در سایت لاگین کنید.';
}

function check_auth_username_password($username, $password)
{
    $existUserName = get_user_by('login', $username);

    if (!$existUserName) {
        return false;
    }
    $user = wp_authenticate_username_password(null, $username, $password);
    if (is_wp_error($user)) {
        return false;
    }

    return $user;

}

function check_auth_register_fields($name, $email, $username, $password, $confirm)
{

    $is_email = is_email($email);

    if (!$is_email && email_exists($email)) {
        return false;
    }

    if (empty($name) || empty($password) || empty($confirm) || empty($username)) {
        return false;
    }

    if (username_exists($username) && !validate_username($username)) {
        return false;
    }

    $user = wp_authenticate_username_password(null, $username, $password);


    if ((!$user || ($password !== $confirm)) || (strlen($password) <= 8 || !preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password))) {
        return false;
    }

    return $user;
}

function auth_check_info_fields_meta_data($national_code, $store_name, $address, $postal_code, $landline_phone, $phone, $business_license, $compony_register_num)
{
    if (empty($national_code) || empty($store_name) || empty($address) || empty($postal_code) || empty($landline_phone) || empty($phone)) {
        return 'empty_all';
    }

    if (empty($business_license) && empty($compony_register_num)) {
        return 'empty_bus_com';
    }

    $count_len = [
        'national' => strlen($national_code),
        'postal' => strlen($postal_code),
        'landline' => strlen($landline_phone),
        'phone' => strlen($phone)
    ];

    if ((!($count_len['national'] == 10) || !($count_len['postal'] == 10)) || (!($count_len['landline'] == 11) || !($count_len['phone'] == 11))) {
        return 'no_match_pass';
    }

}


//Define Functions For Activation And Deactivation Opration

function auth_activation_callback()
{

}


function auth_deactivation_callback()
{

}


//Add Filters

function auth_logout_page($logout_url, $redirect)
{
    return home_url('/logout');
}

add_filter('logout_url', 'auth_logout_page', 10, 2);

function auth_lost_password_page($lostpassword_url, $redirect)
{
    return home_url('lostpassword');
}

add_filter('lostpassword_url', 'auth_lost_password_page', 10, 2);


//Define Add Actions

function authILogin($url = '')
{
    if (is_user_logged_in()) {
        auth_redirect_page($url);
    }

}

function auth_current_url()
{
    $currentUrl = $_SERVER['REQUEST_URI'];
    global $wpdb;
    $hasError = false;
    $hasSuccess = false;
    $message = [];
    if (strpos("$currentUrl", 'register') !== false) {
        add_filter('avada_before_main_container', 'auth_agent_register_form_rendered');
        function auth_agent_register_form_rendered()
        {
            authILogin();
            $message = [];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $pass = $_POST['password'];
            $confirm = $_POST['confirm'];
            if (isset($_POST['register'])) {
                if (
                    !isset($_POST['register_agent_nonce'])
                    || !wp_verify_nonce($_POST['register_agent_nonce'], 'register_agent')
                ) {
                    wp_die('درخواست شما نامعتبر می باشد .');
                }
                $user = check_auth_register_fields($name, $email, $username, $pass, $confirm);
                if (!$user) {
                    $hasError = true;
                    $message[] = 'از تکمیل فیلد های زیر اطمینان حاصل کنید، ممکن است ایمیل در دسترس نباشد یا در انتخاب نام کاربری اشتباهی رخ داده باشد ، فیلد های کلمه عبور و تایید کلمه عبور باید یکسان باشد .';
                }

                if (!$hasError) {
//                list($preAt, $postAt) = explode('@', $email);
                    $user_login = $username;
                    $userData = [
                        'display_name' => apply_filters('pre_user_display_name', $name),
                        'user_email' => apply_filters('pre_user_email', $email),
                        'user_pass' => apply_filters('pre_user_pass', $pass),
                        'user_login' => apply_filters('pre_user_login', $user_login),
                        'user_nicename' => apply_filters('pre_user_nicename', $username)
                    ];

                    $registerResult = wp_insert_user($userData);

                    if (is_wp_error($registerResult)) {
                        $message[] = 'در هنگام ثبت نام شما در سیستم خطایی رخ داده است لطفاً مجدداً امتحان کنید(ممکن است از نام کاربری و یا ایمیل تکراری برای ثبت نام استفاده کرده اید)';
                        $hasError = true;
                    } else {
                        $hasTrue = true;
                        $message[] = 'ثبت نام شما با موفقیت انجام شد. ';
                        add_action('user_register', 'auth_registration_save', 10, 1);
                        do_action('user_register', $registerResult);
                        auth_redirect_page('agent-login');
                    }
                }


            }

            include AUTH_TMP_FEND . "register.php";
            exit();
        }
    }
    if (strpos("$currentUrl", 'agent-login') !== false) {
        add_filter('avada_before_main_container', 'auth_agent_login_form_rendered');
        function auth_agent_login_form_rendered()
        {
            authILogin();
            if (isset($_POST['login'])) {

                if (
                    !isset($_POST['login_user_nonce'])
                    || !wp_verify_nonce($_POST['login_user_nonce'], 'login_user_login')
                ) {
                    wp_die('درخواست شما نامعتبر می باشد .');
                }
                $username = $_POST['username'];
                $pass = $_POST['password'];
                $remember = $_POST['remember'];
                $user = check_auth_username_password($username, $pass);

                if (!$user) {
                    $hasError = true;
                    $message[] = 'نام کاربری و کلمه عبور اشتباه است .';
                }

                if (!$hasError) {
                    $creds = array(
                        'user_login' => $user->user_login,
                        'user_password' => $pass,
                        'remember' => isset($_POST['remember'])
                    );

                    $signonUser = wp_signon($creds, false);

                    if (is_wp_error($signonUser)) {
                        $hasError = true;
                        $message[] = $signonUser->get_error_message();
                    }

                    if (auth_is_admin()) {
                        auth_redirect_page('/wp-admin');
                    } else {
                        auth_redirect_page('profile');
                    }

                }


            }
            include AUTH_TMP_FEND . 'agent-login.php';
            exit();
        }

    }
    if (strpos("$currentUrl", '/logout') !== false) {
        wp_logout();
        auth_redirect_page('agent-login');
    }
    if (strpos("$currentUrl", 'profile') !== false) {

        add_filter('avada_before_main_container', 'auth_agent_profile_rendered');
        function auth_agent_profile_rendered()
        {
            $current_user_id = get_current_user_id();
            global $wpdb;
            $user = $wpdb->get_row($wpdb->prepare("
        SELECT u.display_name FROM {$wpdb->prefix}users u
        WHERE u.ID = %d
        ", $current_user_id));
            if (is_null($user)) {
                return false;
            }
            auth_load_templates('profile', compact('user', 'current_user_id'), 'fronend');
            exit();
        }
//        }
    }

    if (strpos("$currentUrl", 'information') !== false) {
        add_filter('avada_before_main_container', 'auth_agent_complete_info_rendered');
        function auth_agent_complete_info_rendered()
        {
            $current_user_id = get_current_user_id();
            $register_meta_data = $_POST['register_meta_data'];

            if (isset($register_meta_data)) {
                if (
                    !isset($_POST['register_info_nonce'])
                    || !wp_verify_nonce($_POST['register_info_nonce'], 'register_info')
                ) {
                    wp_die('درخواست شما نامعتبر می باشد . ');
                }
                $stat = auth_check_info_fields_meta_data(
                    $_POST['national_code'],
                    $_POST['store_name'],
                    $_POST['store_address'],
                    $_POST['postal_code'],
                    $_POST['landline_phone'],
                    $_POST['phone'],
                    $_POST['business_license'],
                    $_POST['compony_register_num']
                );
                switch ($stat) {
                    case 'empty_all':
                        $hasError = true;
                        $message[] = 'لطفا از پر بودن تمامی فیلد هایی که با عبارت (الزامی) همراه هستند اطمینان حاصل کنید .';
                        break;
                    case 'empty_bus_com':
                        $hasError = true;
                        $message[] = 'لطفاً یکی از دو فیلد شماره جواز کسب و یا شماره ثبت شرکت را پر کنید .';
                        break;
                    case 'no_match_pass':
                        $hasError = true;
                        $message[] = 'لطفاً فیلدهایی که با ارقام پر میشوند را بررسی کنید ممکن است تعداد ارقام صحیح نباشد .';
                        break;
//                    case false:
//                        $message[] = 'هیچ تصویری برای جواز کسب و یا آخرین روزنامه رسمی شرکت انتخاب نشده است . لطفاً یکی از این دو را ارسال نمایید .';
//                        break;
//                    case 'large_file':
//                        $message[] = 'اندازه فایل های تصویر از حد مجاز بیشتر می باشد لطفاً تصویری با سایز کمتر انتخاب کنید .';
//                        break;
                    default:
                        global $wpdb;
                        $user = $wpdb->get_row($wpdb->prepare("
                    SELECT u.display_name FROM {$wpdb->prefix}users u WHERE u.ID =%d 
                    ", $current_user_id));
                        if (is_null($user)) {
                            return false;
                        }
                        echo '<div class="alert alert-success">';
                        echo '<strong>تبریک !</strong>. ثبت نام شما با موفقیت انجام شد ';
                        echo '</div></div>';
                        $type = 'image';
                        update_user_meta($current_user_id, 'national_code', $_POST['national_code']);
                        update_user_meta($current_user_id, 'store_name', $_POST['store_name']);
                        update_user_meta($current_user_id, 'store_address', $_POST['store_address']);
                        update_user_meta($current_user_id, 'postal_code', $_POST['postal_code']);
                        update_user_meta($current_user_id, 'landline_phone', $_POST['landline_phone']);
                        update_user_meta($current_user_id, 'phone', $_POST['phone']);
                        update_user_meta($current_user_id, 'business_license', $_POST['business_license']);
                        update_user_meta($current_user_id, 'economic_identifier', $_POST['economic_identifier']);
                        update_user_meta($current_user_id, 'compony_register_num', $_POST['compony_register_num']);
                        $roots = wp_upload_dir();
                        update_user_meta($current_user_id, 'upload_img_national_card', $_FILES["upload_img_national_card"]["name"]);
                        update_user_meta($current_user_id, 'upload_img_business_license', $_FILES["upload_img_business_license"]["name"]);
                        update_user_meta($current_user_id, 'upload_img_newspaper', $_FILES["upload_img_newspaper"]["name"]);
                        move_uploaded_file($_FILES["upload_img_national_card"]["tmp_name"], $roots['basedir'] . '/' . $_FILES["upload_img_national_card"]["name"]);
                        move_uploaded_file($_FILES["upload_img_business_license"]["tmp_name"], $roots['basedir'] . '/' . $_FILES["upload_img_business_license"]["name"]);
                        move_uploaded_file($_FILES["upload_img_newspaper"]["tmp_name"], $roots['basedir'] . '/' . $_FILES["upload_img_newspaper"]["name"]);
                        $message['success'] = 'سلام، نماینده با شماره id =' . $current_user_id . ' اقدام به آپلود مدارک نموده است لطفاً هرچه سریعتر نسبت به اقدام و پاسخگویی به نماینده مذکور نمایید . با تشکر';
                        do_action('upload_Agent_file', $message, $current_user_id);
                        update_user_meta($current_user_id, 'agent_status', false);
                        break;
                }


            }

            auth_load_templates('information', compact('message', 'hasError', 'stat', 'current_user_id'), 'fronend');
            exit();
        }
    }

    if (strpos("$currentUrl", 'lostpassword') !== false) {
        include AUTH_TMP_FEND . 'lostpassword.php';
        exit();
    }

    if (strpos("$currentUrl", 'auth-wallet') !== false) {
        add_filter('avada_before_main_container', 'auth_agent_wallet_rendered');
        function auth_agent_wallet_rendered()
        {
            $id = get_current_user_id();
            auth_load_templates('wallet', compact('id'), 'fronend');
            exit();
        }
    }
    if (strpos("$currentUrl", 'pony-request') !== false) {
        add_filter('avada_before_main_container', 'auth_agent_pony_request_rendered');
        function auth_agent_pony_request_rendered()
        {
            $user_id = get_current_user_id();
            $account_name = $_POST['account_name'];
            $sheba_number = $_POST['sheba_number'];
            $bank_name = $_POST['bank_name'];
            $register_account_info_field_nonce = $_POST['register_account_info_field_nonce'];
            $result = auth_register_account_info($account_name, $sheba_number, $bank_name, $register_account_info_field_nonce);
            if (isset($_POST['register_account_info'])) {
                if (
                    !isset($register_account_info_field_nonce) ||
                    !wp_verify_nonce($register_account_info_field_nonce, 'register_account_info_field')
                ) {
                    wp_die('درخواست شما نامعتبر می باشد .');
                }
                if ($result) {
                    $hasSuccess = true;
                    update_user_meta($user_id, 'account_name', $account_name);
                    update_user_meta($user_id, 'sheba_number', $sheba_number);
                    update_user_meta($user_id, 'bank_name', $bank_name);
                    $message[] = 'اطلاعات حساب کاربری شما با موفقیت در سیستم ثبت شد . ';
                }else{
                    $hasError = true;
                    $message[] = 'متاسفانه در خواست شما انجام پذیر نمی باشد مجدداً امتحان کنید .';
                }
            }
            auth_load_templates('pony-request', compact('message', 'hasSuccess','hasError'), 'frontend');
            exit();
        }
    }

}


add_action('parse_request', 'auth_current_url');   // check request for register page!


