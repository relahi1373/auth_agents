<?php
/**
 * Plugin Name: Auth Users
 * Plugin URI: http://rdesigns.ir/
 * Description: سیتسم ورود و عضویت کاربران برای وب سایت های وردپرسی
 * Version: 1.0.0
 * Author: Reza Elahi
 * Author URI: http://rdesigns.ir/rezadeveloper
 * Text Domain: authUsers
 */

defined('ABSPATH') || die('access denied !');
define('AUTH_DIR', plugin_dir_path(__FILE__));
define('AUTH_TMP_FEND', plugin_dir_path(__FILE__) . 'template/frontend/');
define('AUTH_TMP_BEND', plugin_dir_path(__FILE__) . 'template/backend/');
define('AUTH_INC', plugin_dir_path(__FILE__) . 'inc/');
define('AUTH_ADMIN', plugin_dir_path(__FILE__) . 'admin/');
define('AUTH_ASS_CSS', plugin_dir_url(__FILE__) . 'assets/css/');
define('AUTH_ASS_JS', plugin_dir_url(__FILE__) . 'assets/js/');
define('AUTH_ASS_IMG', plugin_dir_url(__FILE__) . 'assets/img/');
define('AUTH_UPLOADS', plugin_dir_url(__FILE__) . 'assets/img/');

// Include Files

include AUTH_INC . 'utility.php';
include AUTH_INC . 'functions.php';
include AUTH_ADMIN . 'admin.php';

register_deactivation_hook(__FILE__, 'auth_deactivation_callback');
register_activation_hook(__FILE__, 'auth_activation_callback');

class auth_agents
{
    public function __construct()
    {
        add_action('wp_footer', array($this, 'enqueueAssets'));
        add_action('wp_head', array($this, 'auth_enqueue_style'));
    }

    public function enqueueAssets()
    {
        wp_register_script('wordpress-uploader', AUTH_ASS_JS . 'wordpress-uploader.js', array('jquery'), '', true);
        wp_enqueue_script('wordpress-uploader');
    }

    public function auth_enqueue_style()
    {
        wp_register_style('bootstrap-cdn', AUTH_ASS_CSS . 'bootstrap-css-min.css');
        wp_enqueue_style('bootstrap-cdn');
        wp_register_style('fontawesome', AUTH_ASS_CSS . 'fontawesome-css-min.css');
        wp_enqueue_style('fontawesome');
        wp_register_style('fontiran', AUTH_ASS_CSS . 'fontiran.css');
        wp_enqueue_style('fontiran');
        wp_register_style('main-css', AUTH_ASS_CSS . 'main.css');
        wp_enqueue_style('main-css');
        wp_register_style('all-css', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css');
        wp_enqueue_style('all-css');
    }



    // More methods
}
