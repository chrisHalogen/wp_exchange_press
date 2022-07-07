<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Admin notice
function hid_ex_m_success_message( ){
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Success!!!', 'hidn' ); ?></p>
    </div>
    <?php
}

if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
        if ( is_array( $log ) || is_object( $log ) ) {
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
    }
}


// Enqueue Admin CSS
function  hid_ex_m_admin_css() {
    
    wp_register_style( 'hid-ex-madmin-css', plugin_dir_url( __FILE__ ) . 'assets/css/admin_style.css', array(), time() );
    wp_enqueue_style('hid-ex-madmin-css');

}

add_action( 'admin_enqueue_scripts', 'hid_ex_m_admin_css' );

// Admin JS
function hid_ex_m_load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'hid_ex_m_load_media_files' );

function hid_ex_m_register_admin_script(){
    wp_enqueue_script( 'hid-ex-m-main-js', plugin_dir_url(__FILE__) . '/assets/js/admin_scripts.js', array('jquery','media-upload'), time() );

    wp_localize_script( 'hid-ex-m-main-js', 'script_data',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        )
    );
}

add_action( 'admin_enqueue_scripts', 'hid_ex_m_register_admin_script' );

// User Area Scripts
function hid_ex_m_client_side_css() {
    
    wp_register_style( 'hid-ex-main-frontend-css', plugin_dir_url( __FILE__ ) . 'assets/css/client_side/main.css', array(), time() );
    wp_enqueue_style('hid-ex-main-frontend-css');

    wp_register_style( 'hid-ex-main-font-awesome', plugin_dir_url( __FILE__ ) . 'assets/font-awesome/css/all.css', array(), time() );
    wp_enqueue_style('hid-ex-main-font-awesome');

}

add_action( 'wp_enqueue_scripts', 'hid_ex_m_client_side_css' );

function hid_ex_m_register_client_script(){
    wp_enqueue_script( 'hid-ex-m-main-client-js', plugin_dir_url(__FILE__) . '/assets/js/client_side/client_side.js', array('jquery'), time() );

    wp_localize_script( 'hid-ex-m-main-client-js', 'script_data',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'sign_up_url' => site_url( '/authentication/register/' ),
            'sign_in_url' => site_url( '/authentication/sign-in/' ),
            'dashboard_url' => site_url('/customer-area/dashboard/'),
            'security'      => wp_create_nonce( 'file_upload' ),
            
        )
    );
}

add_action( 'wp_enqueue_scripts', 'hid_ex_m_register_client_script' );


/* Create Customer User Role */
add_role(
    'customer', //  System name of the role.
    __( 'Customer'  ), // Display name of the role.
    array(
        'read'  => false,
        'delete_posts'  => false,
        'delete_published_posts' => false,
        'edit_posts'   => false,
        'publish_posts' => false,
        'upload_files'  => false,
        'edit_pages'  => false,
        'edit_published_pages'  =>  false,
        'publish_pages'  => false,
        'delete_published_pages' => false, 
    )
);

// Building Navigation

add_action('admin_menu', 'addAdminPageContent');

function addAdminPageContent() {

    //adding plugin in menu
    add_menu_page('Exchange Manager', //page title
        'HID Exchange', //menu title
        'manage_options', //capabilities
        'exchange-manager', //menu slug
        'hid_ex_m_exchange_manager_settings', //function
        'dashicons-admin-site-alt', // Icon
        10 , // Position
    );

    //adding submenu to a menu
    add_submenu_page('exchange-manager',//parent page slug
        'Customers',//page title
        'Customers',//menu titel
        'manage_options',//manage optios
        'customers-management',//slug
        'hid_ex_m_customers_management'//function
    );

    //adding submenu to a menu
    add_submenu_page('exchange-manager',//parent page slug
        'eCurrency',//page title
        'eCurrency',//menu titel
        'manage_options',//manage optios
        'e-currency-management',//slug
        'hid_ex_m_e_currency_management'//function
    );

    add_submenu_page('exchange-manager',//parent page slug
        'Crypto-Currency',//page title
        'Crypto-Currency',//menu title
        'manage_options',//manage optios
        'crypto-currency-management',//slug
        'hid_ex_m_crypto_currency'//function
    );

    add_submenu_page('exchange-manager',//parent page slug
        'Buy Orders',//page title
        'Buy Orders',//menu title
        'manage_options',//manage optios
        'buy-orders-management',//slug
        'hid_ex_m_buy_order_master_view'//function
    );

    add_submenu_page('exchange-manager',//parent page slug
        'Sell Orders',//page title
        'Sell Orders',//menu title
        'manage_options',//manage optios
        'sell-orders-management',//slug
        'hid_ex_m_sell_order_master_view'//function
    );

    add_submenu_page('exchange-manager',//parent page slug
        'Announcements',//page title
        'Announcements',//menu title
        'manage_options',//manage optios
        'announcements',//slug
        'hid_ex_m_announcement_master_view'//function
    );

    add_submenu_page('exchange-manager',//parent page slug
        'Support',//page title
        'Support',//menu title
        'manage_options',//manage optios
        'support',//slug
        'hid_ex_m_support_master_view'//function
    );
}

// Rewrite Rules for pages
function hid_ex_m_rewrite_rules(){

    // Note that indexing starts from one

    add_rewrite_rule(
        'authentication/([a-zA-Z0-9-]+)[/]?$', // Regular Expression
        'index.php?authentication_page_name=$matches[1]', // Query Parameters
        'top' // Position on the URL Stack
    );

    // /^[0-9A-Za-z\s\-]+$/
    // ^[A-Za-z0-9_-]*$
    // ([a-z]+)[/]?$

    add_rewrite_rule(
        'customer-area/([a-zA-Z0-9-]+)[/]?$', // Regular Expression
        'index.php?customer_page_name=$matches[1]', // Query Parameters
        'top' // Position on the URL Stack
    );
}

add_action( 'init', 'hid_ex_m_rewrite_rules' );

add_filter( 'query_vars' , function( $query_vars ){
    // You have to register the query variables to make sure WordPress Recognizes them

    $query_vars[] = 'authentication_page_name';
    $query_vars[] = 'customer_page_name';

    // Now Return the Query Variables
    return $query_vars;
});

// Register the templates to serve as the endpoint to our custom route
add_action( 'template_include', function( $template ) {

    if ( get_query_var( 'authentication_page_name' ) != false && get_query_var( 'authentication_page_name' ) != '' ) {

        if ( is_user_logged_in() ){
            
            wp_redirect(site_url('/customer-area/dashboard/'));
        } else {

            return HID_EX_M_ROOTDIR . 'client/hid_ex_m_auth_area.php';
        }
        
    }

    if ( get_query_var( 'customer_page_name' ) != false && get_query_var( 'customer_page_name' ) != '' ) {

        if ( !is_user_logged_in() ){
            wp_redirect(site_url( '/authentication/sign-in/' ));
        } else {
            return HID_EX_M_ROOTDIR . 'client/hid_ex_m_client_area.php';
        }
        
    }
 
    return $template;
} );

function wp_insert_attachment_from_url( $url, $parent_post_id = null ) {

	if ( ! class_exists( 'WP_Http' ) ) {
		require_once ABSPATH . WPINC . '/class-http.php';
	}

	$http     = new WP_Http();
	$response = $http->request( $url );
	if ( 200 !== $response['response']['code'] ) {
		return false;
	}

	$upload = wp_upload_bits( basename( $url ), null, $response['body'] );
	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$file_path        = $upload['file'];
	$file_name        = basename( $file_path );
	$file_type        = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir    = wp_upload_dir();

	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	// Create the attachment.
	$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

	// Include image.php.
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Generate the attachment metadata.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

	// Assign metadata to attachment.
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;

}