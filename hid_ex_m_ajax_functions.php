<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// The function that handles ajax request from the frontend
function hid_ex_m_get_e_assets() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax

    if ( isset($_REQUEST) ) {

        // write_log("Got Here");

        // $output = hid_ex_m_get_all_e_currency_assets();

        // return $output;

        try {
            wp_send_json_success(hid_ex_m_get_all_e_currency_assets());
        } catch (\Throwable $th) {
            write_log($th);
        }

        


        // wp_send_json_success( $data = $output );
    }

    // Killing the Ajax function
    die();
}

// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_get_e_assets', 'hid_ex_m_get_e_assets' );
add_action( 'wp_ajax_nopriv_hid_ex_m_get_e_assets', 'hid_ex_m_get_e_assets' );

function hid_ex_m_get_crypto_assets() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
    
    if ( isset($_REQUEST) ) {

        //write_log("Got Here Now");

        try {
            wp_send_json_success(hid_ex_m_get_all_crypto_currency_assets());
        } catch (\Throwable $th) {
            write_log($th);
        }

        //return hid_ex_m_get_all_crypto_currency_assets();
    }

    // Killing the Ajax function
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_get_crypto_assets', 'hid_ex_m_get_crypto_assets' );
add_action( 'wp_ajax_nopriv_hid_ex_m_get_crypto_assets', 'hid_ex_m_get_crypto_assets' );


function hid_ex_m_add_new_chat() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
    
    if ( isset($_REQUEST) ) {

        try {

            hid_ex_m_create_new_support_chat( $_REQUEST['data'] );

            wp_send_json_success();

        } catch (\Throwable $th) {

            write_log($th);
        }

        //return hid_ex_m_get_all_crypto_currency_assets();
    }

    // Killing the Ajax function
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_add_new_chat', 'hid_ex_m_add_new_chat' );


function hid_ex_m_get_recent_chats_view() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
    
    if ( isset($_REQUEST) ) {

        try {

            $result = hid_ex_m_get_recent_support_chat_data( $_REQUEST['time'], $_REQUEST['ticket_id'] );

            if ($result != 0){

                foreach ($result as $message){

                    if ($message->attachment){

                        $message->attachment_url = wp_get_attachment_url($message->attachment);

                    }
                    
                }
            }

            wp_send_json_success($result);

        } catch (\Throwable $th) {
            
            write_log($th);
        }

        //return hid_ex_m_get_all_crypto_currency_assets();
    }

    // Killing the Ajax function
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_get_recent_chats_view', 'hid_ex_m_get_recent_chats_view' );


function hid_ex_m_check_if_user_exists() {

    if ( isset($_REQUEST) ) {
  
        // Setting the query arguments to get the list of users
        $field = $_REQUEST['field'];
        $value = $_REQUEST['value'];

        $data = 0;
  
        if ( get_user_by( $field , $value ) ){
            $data = 1;
        }

        write_log($data);

        wp_send_json_success( $data );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_check_if_user_exists', 'hid_ex_m_check_if_user_exists' );
add_action( 'wp_ajax_nopriv_hid_ex_m_check_if_user_exists', 'hid_ex_m_check_if_user_exists' );


function hid_ex_m_check_if_user_password_matches() {

    if ( isset($_REQUEST) ) {
  
        // Setting the query arguments to get the list of users
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        $data = 0;
  
        $user = get_user_by( 'login', $username );

        if ( $user && wp_check_password( $password, $user->data->user_pass , $user->ID ) ) {
            $data = 1;
        } 

        write_log($data);

        wp_send_json_success( $data );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_check_if_user_password_matches', 'hid_ex_m_check_if_user_password_matches' );
add_action( 'wp_ajax_nopriv_hid_ex_m_check_if_user_password_matches', 'hid_ex_m_check_if_user_password_matches' );

function hid_ex_m_log_the_user_in() {

    if ( isset($_REQUEST) ) {
  
        // Setting the query arguments to get the list of users
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $rememberMe = $_REQUEST['rememberMe'];

        $rememberMeValue = false;

        if ($rememberMe == 1){
            $rememberMeValue = true;
        }

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $rememberMeValue
        );

        $user = wp_signon( $creds, is_ssl() );

        $data = 0;
     
        if ( is_wp_error( $user ) ) {
            echo $user->get_error_message();
            $data = 0;
        } else {
            $data = 1;
        }

        wp_send_json_success( $data );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_log_the_user_in', 'hid_ex_m_log_the_user_in' );
add_action( 'wp_ajax_nopriv_hid_ex_m_log_the_user_in', 'hid_ex_m_log_the_user_in' );


function hid_ex_m_complete_user_registration() {

    if ( isset($_REQUEST) ) {
  
        hid_ex_m_create_new_customer(
            $_REQUEST['data']['first_name'],
            $_REQUEST['data']['last_name'],
            $_REQUEST['data']['email'],
            $_REQUEST['data']['phone_number'],
            $_REQUEST['data']['password'],
            $_REQUEST['data']['username']
        );

        write_log("User Created");

        wp_send_json_success();
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_complete_user_registration', 'hid_ex_m_complete_user_registration' );
add_action( 'wp_ajax_nopriv_hid_ex_m_complete_user_registration', 'hid_ex_m_complete_user_registration' );

function hid_ex_m_update_customer() {

    if ( isset($_REQUEST) ) {

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $first_name = $_REQUEST['first-name'];
        $last_name = $_REQUEST['last-name'];
        $email = $_REQUEST['email'];
        $phone = $_REQUEST['phone-number'];
        $id = $_REQUEST['user-id'];

        $data = 0;

        $user = wp_authenticate($username, $password);

        if(!is_wp_error($user)) {

            hid_ex_m_update_customer_data( $first_name, $last_name, $email, $phone,$username, $id );

            $data = 1;

        } else {

            $data = 0;
        }

        wp_send_json_success($data);
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_update_customer', 'hid_ex_m_update_customer' );
add_action( 'wp_ajax_nopriv_hid_ex_m_update_customer', 'hid_ex_m_update_customer' );


function hid_ex_m_submit_sell_order() {

    if ( isset($_REQUEST) ) {

        write_log($_REQUEST);

        // check_ajax_referer('file_upload', 'security');

        $attachment_id = 0;

        $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

        if (in_array($_FILES['file']['type'], $arr_img_ext)) {
            $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
            //$upload['url'] will gives you uploaded file path

            $attachment_id = wp_insert_attachment_from_url($upload['url']);
        }

        $data = array(
            'customer_id' => get_current_user_id(),
            'asset_type'    => $_REQUEST['asset_type'],
            'asset_id'      => $_REQUEST['asset_id'],
            'quantity_sold' => $_REQUEST['quantity_sold'],
            'amount_to_recieve' => $_REQUEST['amount_to_recieve'],
            'proof_of_payment' => $attachment_id,
            'order_status'      => 1
        );

        write_log($data);

        try {

            // hid_ex_m_create_new_sell_order( $data );
            $data = 1;

        } catch (\Throwable $th) {
            $data = 0;
        }

        wp_send_json_success($data);
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_submit_sell_order', 'hid_ex_m_submit_sell_order' );
add_action( 'wp_ajax_nopriv_hid_ex_m_submit_sell_order', 'hid_ex_m_submit_sell_order' );