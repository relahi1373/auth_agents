<?php

function auth_load_templates( $templates, $params = array(), $type = 'admin' ) {
	$templates = str_replace( '.', '/', $templates );
	! empty( $params ) ? extract( $params ) : null;
	$base_path = $type == 'admin' ? AUTH_TMP_BEND : AUTH_TMP_FEND;
	include $base_path . $templates . '.php';

}


function auth_is_admin() {
    return is_user_logged_in() && current_user_can( 'manage_options' );
}

function auth_is_agent() {
    return is_user_logged_in() && current_user_can( 'agent_editor' );
}

function auth_redirect_page( $url ) {
	wp_redirect( home_url($url) );
	exit();
}

function auth_replace_persian_number( $number ) {
    $persian_num = array(
        '۰',
        '۱',
        '۲',
        '۳',
        '۴',
        '۵',
        '۶',
        '۷',
        '۸',
        '۹'
    );
    $en_num      = array(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9'
    );
    $number      = str_replace( $en_num, $persian_num, $number );

    return $number;
}