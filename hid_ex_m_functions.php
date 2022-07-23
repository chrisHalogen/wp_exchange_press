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
        'Wallets',//page title
        'Wallets',//menu title
        'manage_options',//manage optios
        'wallet-management',//slug
        'hid_ex_m_wallet_master_view'//function
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

add_action('after_setup_theme', 'hid_ex_m_remove_admin_bar');

function hid_ex_m_remove_admin_bar() {

    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }

}

function hid_ex_m_filter_footer(){

    ?>
        <div class="hid_ex_m_currency-calculator" id="hid_ex_m_currency-calculator">

            <div class="inner-div">
                <i class="fa-solid fa-xmark" id="close-rate-calculator"></i>
                <form action="" method="post">
                    <h1>Rate Calculator</h1>
                    <div class="modal-content">
                        <div class="input-div">
                            <h2>Asset Type</h2>
                            <div class="asset-radio-buttons">
                            <label id="checker-1">
                                <input id="asset-btn-1" class="asset-btn-1" name="asset-type" type="radio" value="1"> eCurrency
                            </label>
                            <option selling='' buying='' value=1></option>
                            
                            <label>
                                <input id="asset-btn-2" class="asset-btn-2" name="asset-type" type="radio" value="2"> Crypto Currency
                            </label>

                        </div>

                        <select name="asset-select" id="asset-selection">
                            <option value="0">Select An Asset</option>
                        </select>

                        <h2>Asset Quantity</h2>
                        <input type="text" name="" id="item-quantity" value=0>
                            
                        </div>
                        <div class="output-div">
                        <p>Buying Price</p>
                        <h2>#<span id="output-buying">-</span></h2>
                        <p>Selling Price</p>
                        <h2>#<span id="output-selling">-</span></h2>
                        <p>Buying Per Quantity</p>
                        <h2>#<span id="output-buying-q">-</span></h2>
                        <p>Selling Per Quantity</p>
                        <h2>#<span id="output-selling-q">-</span></h2>

                        </div>
                    </div>
                    
                </form>
            </div>

        </div>
    <?php

}

add_filter('wp_footer', 'hid_ex_m_filter_footer');


function hid_ex_m_guests_rate_output(){

    ?>
        <div class="hid_ex_m_guests_rate_output">

            <div class="currency-rates-wrapper">

                <?php
                        
                    $e_assets = hid_ex_m_get_all_e_currency_assets();

                    if (empty($e_assets)){
                        echo "<center><p>No eCurrency Assets Available</p></center>";
                    } else {
                        
                        ?>
                        
                        <div class="rates-top">
                            <h2 class="section-title main-head-title">eCurrency Rates</h2>
                            <button class="open-calculator">eCurrency Rates Calculator</button>
                        </div> 
                        
                        <div class="table-container">
                            
                            <table>
                                <thead>
                                    <tr>
                                        <td style="width: 10%; min-width: 70px">Icon</td>
                                        <td style="width: 50%; min-width: 250px">Name | Allias</td>
                                        <td style="width: 20%; min-width: 100px">Buying Price</td>
                                        <td style="width: 20%; min-width: 100px">Selling Price</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    
                                        foreach ($e_assets as $asset){

                                            ?>
                                            
                                            <tr>
                                                <td><img src="<?php echo wp_get_attachment_url( $asset->icon ) ?>" alt="..."></td>
                                                <td><?php echo $asset->name . ' | ' . $asset->short_name ?></td>
                                                <td><?php echo $asset->buying_price ?></td>
                                                <td><?php echo $asset->selling_price ?></td>
                                            </tr>
                                            
                                            <?php

                                        }
                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                        
                        <?php

                    }

                ?>

            </div>

            <div class="currency-rates-wrapper">

                <?php
                        
                    $crypto_assets = hid_ex_m_get_all_crypto_currency_assets();

                    if (empty($crypto_assets)){
                        echo "<center><p>No Crypto Currency Assets Available</p></center>";
                    } else {
                        
                        ?>
                        
                        <div class="rates-top">
                            <h2 class="section-title main-head-title">Crypto Rates</h2>
                            <button class="open-calculator">Crypto Rates Calculator</button>
                        </div> 
                        
                        <div class="table-container">
                            
                            <table>
                                <thead>
                                    <tr>
                                        <td style="width: 10%; min-width: 70px">Icon</td>
                                        <td style="width: 50%; min-width: 250px">Name | Allias</td>
                                        <td style="width: 20%; min-width: 100px">Buying Price</td>
                                        <td style="width: 20%; min-width: 100px">Selling Price</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    
                                        foreach ($crypto_assets as $asset){

                                            ?>
                                            
                                            <tr>
                                                <td><img src="<?php echo wp_get_attachment_url( $asset->icon ) ?>" alt="..."></td>
                                                <td><?php echo $asset->name . ' | ' . $asset->short_name ?></td>
                                                <td><?php echo $asset->buying_price ?></td>
                                                <td><?php echo $asset->selling_price ?></td>
                                            </tr>
                                            
                                            <?php

                                        }
                                    
                                    ?>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                        
                        <?php

                    }

                ?>

            </div>

        </div>
    <?php

}

add_shortcode('hid_ex_m_show_rates','hid_ex_m_guests_rate_output');


function hid_ex_m_hook_css() {
    ?>
    
    <style>
        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Thin.ttf' ?>') format('truetype');
            font-weight: 100;
            font-style: normal;
        }

        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Ultralight.ttf' ?>') format('truetype');
            font-weight: 200;
            font-style: normal;
        }
        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Light.ttf' ?>') format('truetype');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Regular.ttf' ?>') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Medium.ttf' ?>') format('truetype');
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Semibold.ttf' ?>') format('truetype');
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Bold.ttf' ?>') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>') format('truetype');
            font-weight: 800;
            font-style: normal;
        }

        @font-face {
            font-family: "SF Pro";
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>');
            src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>') format('truetype');
            font-weight: 900;
            font-style: normal;
        }

    </style>
    
    <?php
}
// add_action('wp_head', 'hid_ex_m_hook_css');

// // Mailer
add_action( 'phpmailer_init', 'hid_ex_m_send_smtp_email' );

function hid_ex_m_send_smtp_email( $phpmailer ) {

    $phpmailer->isSMTP();

    $phpmailer->Host       = get_option('smtp_host');
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = strval(get_option('smtp_port'));
    $phpmailer->SMTPSecure = get_option('smtp_encryption');
    $phpmailer->Username   = get_option('smtp_username');
    $phpmailer->Password   = get_option('smtp_password');
    $phpmailer->From       = get_option('business_email');
    $phpmailer->FromName   = 'LuxTrade Admin';

}

add_action( 'wp_mail_failed', function ( $error ) {
    write_log( $error->get_error_message() );
} );

// add_filter( 'wp_mail_smtp_core_wp_mail_function_incorrect_location_notice', '__return_false' );
