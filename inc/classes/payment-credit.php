<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Custom Payment Gateway.
 *
 * Provides a Custom Payment Gateway, mainly for testing purposes.
 */
add_action('plugins_loaded', 'init_custom_gateway_class');
function init_custom_gateway_class(){

    class WC_Gateway_Payment_On_Time extends WC_Payment_Gateway {

        public $domain;

        /**
         * Constructor for the gateway.
         */
        public function __construct() {

            $this->domain = 'authUsers';

            $this->id                 = 'payment_on_time';
            $this->icon               = apply_filters('woocommerce_payment_on_time_gateway_icon', '');
            $this->has_fields         = false;
            $this->method_title       = __( 'پرداخت اعتباری با زمان مشخص شده', $this->domain );
            $this->method_description = __( 'اجازه پرداخت از طریق روش اعتباری', $this->domain );

            // Load the settings.
            $this->init_form_fields();
            $this->init_settings();

            // Define user set variables
            $this->title        = $this->get_option( 'title' );
            $this->description  = $this->get_option( 'description' );
            $this->instructions = $this->get_option( 'instructions', $this->description );
            $this->order_status = $this->get_option( 'order_status', 'completed' );

            // Actions
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            add_action( 'woocommerce_thankyou_payment_on_time', array( $this, 'thankyou_page' ) );

            // Customer Emails
            add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
        }

        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {

            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'فعال / غیر فعال کردن', $this->domain ),
                    'type'    => 'checkbox',
                    'label'   => __( 'فعال کردن پرداخت اعتباری با زمان مشخص', $this->domain ),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => __( 'عنوان روش پرداخت', $this->domain ),
                    'type'        => 'text',
                    'description' => __( 'این عنوان را نمایندگان در صفحه پرداخت خواهند دید .', $this->domain ),
                    'default'     => __( 'پرداخت اعتباری با زمان مشخص', $this->domain ),
                    'desc_tip'    => true,
                ),
                'order_status' => array(
                    'title'       => __( 'وضعیت سفارش', $this->domain ),
                    'type'        => 'select',
                    'class'       => 'wc-enhanced-select',
                    'description' => __( 'وضعیت پس از پرداخت را انتخاب کنید .', $this->domain ),
                    'default'     => 'wc-completed',
                    'desc_tip'    => true,
                    'options'     => wc_get_order_statuses()
                ),
                'description' => array(
                    'title'       => __( 'توضیحات', $this->domain ),
                    'type'        => 'textarea',
                    'description' => __( 'این توضیحات را نمایندگان در صفحه پرداخت خواهند دید .', $this->domain ),
                    'default'     => __('تکمیل اطلاعات پرداخت', $this->domain),
                    'desc_tip'    => true,
                ),
                'instructions' => array(
                    'title'       => __( 'دستورالعمل ها', $this->domain ),
                    'type'        => 'textarea',
                    'description' => __( 'در این بخش ایمیل و شماره تماستان را برای استفاده نمایندگان قرار دهید .', $this->domain ),
                    'default'     => '',
                    'desc_tip'    => true,
                ),
            );
        }

        /**
         * Output for the order received page.
         */
        public function thankyou_page() {
            if ( $this->instructions )
                echo wpautop( wptexturize( $this->instructions ) );
        }

        /**
         * Add content to the WC emails.
         *
         * @access public
         * @param WC_Order $order
         * @param bool $sent_to_admin
         * @param bool $plain_text
         */
        public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
            if ( $this->instructions && ! $sent_to_admin && 'custom' === $order->payment_method && $order->has_status( 'on-hold' ) ) {
                echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
            }
        }

        public function payment_fields(){

            if ( $description = $this->get_description() ) {
                echo wpautop( wptexturize( $description ) );
            }

            ?>
            <div id="custom_input">
                <p class="form-row form-row-wide">
                    <label for="mobile" class=""><?php _e('شماره همراه :', $this->domain); ?></label>
                    <input type="text" class="" name="mobile" id="mobile" placeholder="" value="">
                </p>
                <p class="form-row form-row-wide">
                    <label for="national_num" class=""><?php _e('کد ملی :', $this->domain); ?></label>
                    <input type="text" class="" name="national_num" id="national_num" placeholder="" value="">
                </p>
                <p class="form-row form-row-wide">
                    <label for="the_term"><?php _e('مدت زمان پرداخت نهایی', $this->domain); ?></label>
                    <select class="select-term" name="the_term" id="the_term">
                        <option value="30">یک ماهه</option>
                        <option value="45">چهل و پنج روزه</option>
                        <option value="60">دو ماهه</option>
                    </select>
                </p>
            </div>
            <?php
        }

        /**
         * Process the payment and return the result.
         *
         * @param int $order_id
         * @return array
         */
        public function process_payment( $order_id ) {

            $order = wc_get_order( $order_id );

            $status = 'wc-' === substr( $this->order_status, 0, 3 ) ? substr( $this->order_status, 3 ) : $this->order_status;

            // Set order status
            $order->update_status( $status, __( 'پرداخت با روش اعتباری ', $this->domain ) );

            // Reduce stock levels
            $order->reduce_order_stock();

            // Remove cart
            WC()->cart->empty_cart();

            // Return thankyou redirect
            return array(
                'result'    => 'success',
                'redirect'  => $this->get_return_url( $order )
            );
        }
    }
}

add_filter( 'woocommerce_payment_gateways', 'add_custom_gateway_class' );
function add_custom_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Payment_On_Time';
    return $methods;
}

add_action('woocommerce_checkout_process', 'process_payment_on_time');
function process_payment_on_time(){

    if($_POST['payment_method'] != 'payment_on_time')
        return;

    if( !isset($_POST['mobile']) || empty($_POST['mobile']) )
        wc_add_notice( __( 'لطفاً شماره تلفن همراه خود را وارد کنید .', $this->domain ), 'error' );


    if( !isset($_POST['national_num']) || empty($_POST['national_num']) )
        wc_add_notice( __( 'لطفاً کد ملی خود را وارد کنید .', $this->domain ), 'error' );

}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'auth_payment_on_time_update_order_meta' );
function auth_payment_on_time_update_order_meta( $order_id ) {

    if($_POST['payment_method'] != 'payment_on_time')
        return;

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit();
    update_post_meta($order_id,'created_at',the_date());
    update_post_meta( $order_id, 'mobile', $_POST['mobile'] );
    update_post_meta( $order_id, 'transaction', $_POST['national_num'] );
    update_post_meta( $order_id, 'the_term', $_POST['the_term'] );
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'auth_payment_on_time_checkout_field_display_admin_order_meta', 10, 1 );
function auth_payment_on_time_checkout_field_display_admin_order_meta($order){
    $method = get_post_meta( $order->id, '_payment_method', true );
    if($method != 'payment_on_time')
        return;

    $mobile = get_post_meta( $order->id, 'mobile', true );
    $transaction = get_post_meta( $order->id, 'transaction', true );
    $the_term = get_post_meta( $order->id, 'the_term', true );

    echo '<p><strong>'.__( 'شماره همراه' ).':</strong> ' . $mobile . '</p>';
    echo '<p><strong>'.__( 'کد ملی').':</strong> ' . $transaction . '</p>';
    echo '<p><strong>'.__( 'مدت زمان پرداخت').':</strong> ' . $the_term . '</p>';
}
