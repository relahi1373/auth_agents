<?php
function auth_add_manage_page()
{
    $hasTrue = false;
    $hasError = false;
    $message = [];
    $national_code = $_POST['national_code'];
    $store_name = $_POST['store_name'];
    $store_address = $_POST['store_address'];
    $postal_code = $_POST['postal_code'];
    $landline_phone = $_POST['landline_phone'];
    $phone = $_POST['phone'];
    $business_no = $_POST['business_no'];
    $economic_no = $_POST['economic_no'];
    $register_company_no = $_POST['register_company_no'];
    global $wpdb, $table_prefix;

    $table_name = $table_prefix . 'users';

    $action_edit_user = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : null;
    $action_bank_info = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : null;
    if ($action_edit_user == 'user_edit') {
        $action_callback = $_GET['action'] . '_handler';

        if (function_exists($action_callback)) {
            $action_callback();

            if (isset($_POST['editbtn'])) {
                $hasTrue = true;
                $message[] = 'اطلاعات با موفقیت بروز رسانی شد .';
                update_user_meta($_GET['id'], 'national_code', $national_code);
                update_user_meta($_GET['id'], 'store_name', $store_name);
                update_user_meta($_GET['id'], 'store_address', $store_address);
                update_user_meta($_GET['id'], 'postal_code', $postal_code);
                update_user_meta($_GET['id'], 'landline_phone', $landline_phone);
                update_user_meta($_GET['id'], 'phone', $phone);
                update_user_meta($_GET['id'], 'business_license', $business_no);
                update_user_meta($_GET['id'], 'economic_identifier', $economic_no);
                update_user_meta($_GET['id'], 'compony_register_num', $register_company_no);


                if ($_POST['agent_status'] == true) {
                    update_user_meta($_GET['id'], 'agent_status', $_POST['agent_status']);
                    echo 'مجوز نمایندگی برای کاربر جاری صادر شد .';
                } else {
                    update_user_meta($_GET['id'], 'agent_status', false);
                }

            }

            return;
        }
    }

    if ($action_bank_info == 'bank_info') {
        $action_callback = $_GET['action'] . '_handler';
        if (function_exists($action_callback)) {
            $action_callback();
            return;
        }
    }


    $users = $wpdb->get_results("SELECT * FROM {$table_name}");

    auth_load_templates('users.users', compact('users'));
}

function auth_admin_menu()
{
    add_menu_page(
        'نمایندگان',
        'نمایندگان',
        'manage_options',
        'auth_manage',
        'auth_add_manage_page',
        'dashicons-businessman'
    );
}

add_action('admin_menu', 'auth_admin_menu');

function user_edit_handler()
{
    $current_agent_id = $_GET['id'];
    global $wpdb;
    $user = $wpdb->get_row($wpdb->prepare("
    SELECT u.display_name , u.user_login , u.user_email FROM {$wpdb->prefix}users u
    WHERE u.ID = %d
    ", $current_agent_id));
    if (is_null($user)) {
        return false;
    }
    $status = get_user_meta($current_agent_id, 'agent_status', true);
    $info = [
        'national_code' => get_user_meta($current_agent_id, 'national_code', true),
        'store_name' => get_user_meta($current_agent_id, 'store_name', true),
        'address' => get_user_meta($current_agent_id, 'store_address', true),
        'postal_code' => get_user_meta($current_agent_id, 'postal_code', true),
        'landline_phone' => get_user_meta($current_agent_id, 'landline_phone', true),
        'phone' => get_user_meta($current_agent_id, 'phone', true),
        'business_license' => get_user_meta($current_agent_id, 'business_license', true),
        'economic_identifier' => get_user_meta($current_agent_id, 'economic_identifier', true),
        'compony_register_num' => get_user_meta($current_agent_id, 'compony_register_num', true),
        'upload_img_national_card' => get_user_meta($current_agent_id, 'upload_img_national_card', true),
        'upload_img_business_license' => get_user_meta($current_agent_id, 'upload_img_business_license', true),
        'upload_img_newspaper' => get_user_meta($current_agent_id, 'upload_img_newspaper', true)
    ];
    auth_load_templates('users.edit-user', compact('status', 'info', 'user'));
}

function bank_info_handler()
{
    $current_agent_id = $_GET['id'];
    $info = [
        'account_name' => get_user_meta($current_agent_id, 'account_name', true),
        'sheba_number' => get_user_meta($current_agent_id, 'sheba_number', true),
        'bank_name' => get_user_meta($current_agent_id, 'bank_name', true)
    ];
    auth_load_templates('users.bank-informations',compact('info'));
}


