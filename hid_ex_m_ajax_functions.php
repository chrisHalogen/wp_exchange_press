<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// The function that handles ajax request from the frontend
function hid_ex_m_get_e_assets() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax

    if ( isset($_REQUEST) ) {

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


// The function that handles ajax request from the frontend
function hid_ex_m_get_e_assets_with_local_bank() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax

    if ( isset($_REQUEST) ) {

        try {

            $result = hid_ex_m_get_all_e_currency_assets();

            if ($result != 0){

                foreach ($result as $asset){

                    $asset->bank = hid_ex_m_get_bank_data( $asset->associated_local_bank );
                    
                }
            }

            wp_send_json_success($result);
            
            
        } catch (\Throwable $th) {
            write_log($th);
        }

        // wp_send_json_success( $data = $output );
    }

    // Killing the Ajax function
    die();
}

// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_get_e_assets_with_local_bank', 'hid_ex_m_get_e_assets_with_local_bank' );
add_action( 'wp_ajax_nopriv_hid_ex_m_get_e_assets_with_local_bank', 'hid_ex_m_get_e_assets_with_local_bank' );

function hid_ex_m_get_crypto_assets_with_local_bank() {

    // _REQUEST is the PHP superglobal bringing in all the data sent via ajax
    
    if ( isset($_REQUEST) ) {

        //write_log("Got Here Now");

        try {

            $result = hid_ex_m_get_all_crypto_currency_assets();
            
            if ($result != 0){

                foreach ($result as $asset){

                    $asset->bank = hid_ex_m_get_bank_data( $asset->associated_local_bank );
                    
                }
            }

            wp_send_json_success($result);
            
        } catch (\Throwable $th) {
            write_log($th);
        }

        //return hid_ex_m_get_all_crypto_currency_assets_with_local_bank();
    }

    // Killing the Ajax function
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_get_crypto_assets_with_local_bank', 'hid_ex_m_get_crypto_assets_with_local_bank' );
add_action( 'wp_ajax_nopriv_hid_ex_m_get_crypto_assets_with_local_bank', 'hid_ex_m_get_crypto_assets_with_local_bank' );




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


function hid_ex_m_get_recent_chats_view(){

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
  
add_action( 'wp_ajax_hid_ex_m_get_recent_chats_view', 'hid_ex_m_get_recent_chats_view' );
add_action( 'wp_ajax_nopriv_hid_ex_m_get_recent_chats_view', 'hid_ex_m_get_recent_chats_view' );


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

        check_ajax_referer('file_upload', 'security');

        $output = 0;

        $data = 0;

        try {

            $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

            if (in_array($_FILES['file']['type'], $arr_img_ext)) {

                $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));

                $type = '';
                if (!empty($upload['type'])) {

                    $type = $upload['type'];

                } else {
                    $mime = wp_check_filetype($upload['file']);
                if ($mime) {
                    $type = $mime['type'];
                    }
                }

                $attachment = array('post_title' => basename($upload['file']), 'post_content' => '', 'post_type' => 'attachment', 'post_mime_type' => $type, 'guid' => $upload['url']);

                $data = wp_insert_attachment($attachment, $upload['file']);
                
                wp_update_attachment_metadata($data, wp_generate_attachment_metadata($data, $upload['file']));
            }            
            
            
            $input_data = array(

                'customer_id' => get_current_user_id(),
                'asset_type'    => $_REQUEST['chosen_asset_type'],
                'asset_id'      => $_REQUEST['chosen_asset_id'],
                'quantity_sold' => (float)($_REQUEST['entered_quantity']),
                'amount_to_recieve' => $_REQUEST['amount_to_recieve'],
                'proof_of_payment'  => $data,
                'sending_instructions' => $_REQUEST['sending'],
                'order_status'  => 1
                
            );

            hid_ex_m_create_new_sell_order( $input_data );

            write_log($input_data);

            $output = 1;
            
        } catch (\Throwable $th) {
            $output = 0;
            write_log($th);
        }

        wp_send_json_success($output);
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_submit_sell_order', 'hid_ex_m_submit_sell_order' );
add_action( 'wp_ajax_nopriv_hid_ex_m_submit_sell_order', 'hid_ex_m_submit_sell_order' );

function hid_ex_m_submit_buy_order() {

    if ( isset($_REQUEST) ) {

        check_ajax_referer('file_upload', 'security');

        $output = 0;

        $data = 0;

        try {

            $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

            if (in_array($_FILES['file']['type'], $arr_img_ext)) {

                $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));

                $type = '';
                if (!empty($upload['type'])) {

                    $type = $upload['type'];

                } else {
                    $mime = wp_check_filetype($upload['file']);
                if ($mime) {
                    $type = $mime['type'];
                    }
                }

                $attachment = array('post_title' => basename($upload['file']), 'post_content' => '', 'post_type' => 'attachment', 'post_mime_type' => $type, 'guid' => $upload['url']);

                $data = wp_insert_attachment($attachment, $upload['file']);
                
                wp_update_attachment_metadata($data, wp_generate_attachment_metadata($data, $upload['file']));
            }            
            
            
            $input_data = array(

                'customer_id' => get_current_user_id(),
                'asset_type'    => $_REQUEST['chosen_asset_type'],
                'asset_id'      => $_REQUEST['chosen_asset_id'],
                'quantity' => (float)($_REQUEST['entered_quantity']),
                'fee' => $_REQUEST['amount_to_recieve'],
                'proof_of_payment'  => $data,
                'sending_instructions' => $_REQUEST['sending'],
                'order_status'  => 1
                
            );

            hid_ex_m_create_new_buy_order( $input_data );

            write_log($input_data);

            $output = 1;
            
        } catch (\Throwable $th) {
            $output = 0;
            write_log($th);
        }

        wp_send_json_success($output);
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_submit_buy_order', 'hid_ex_m_submit_buy_order' );
add_action( 'wp_ajax_nopriv_hid_ex_m_submit_buy_order', 'hid_ex_m_submit_buy_order' );


function hid_ex_m_customer_open_new_support_ticket() {

    if ( isset($_REQUEST) ) {

        $input = array(
            'title' => $_REQUEST['ticket-title'],
            'details'    => $_REQUEST['ticket-details'],
            'customer'      => $_REQUEST['customer'],
            'ticket_status' => 1,
            'requester' => $_REQUEST['customer-name']
        );

        $data = 0;

        try {

            hid_ex_m_create_new_support_ticket( $input );

            $data = 1;

        } catch (\Throwable $th) {
            $data = 0;
        }

        wp_send_json_success($data);
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_customer_open_new_support_ticket', 'hid_ex_m_customer_open_new_support_ticket' );
add_action( 'wp_ajax_nopriv_hid_ex_m_customer_open_new_support_ticket', 'hid_ex_m_customer_open_new_support_ticket' );

function hid_ex_m_retrieve_ticket_chats() {

    if ( isset($_REQUEST) ) {

        $data = 0;

        $all_chats = array();

        try {

            $all_chats = hid_ex_m_get_all_support_chat( $_REQUEST['ticket-id'] );

            if ($all_chats != 0){

                foreach ($all_chats as $message){

                    if ($message->attachment){

                        $message->attachment_url = wp_get_attachment_url($message->attachment);

                    }
                    
                }
            }
            
            $data = 1;

        } catch (\Throwable $th) {
            $data = 0;
        }

        wp_send_json_success( $all_chats);
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_retrieve_ticket_chats', 'hid_ex_m_retrieve_ticket_chats' );
add_action( 'wp_ajax_nopriv_hid_ex_m_retrieve_ticket_chats', 'hid_ex_m_retrieve_ticket_chats' );


function hid_ex_m_create_a_new_chat() {

    if ( isset($_REQUEST) ) {

        check_ajax_referer('file_upload', 'security');

        $data = 0;

        try {

            check_ajax_referer('file_upload', 'security');

            $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

            if (in_array($_FILES['file']['type'], $arr_img_ext)) {

                $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));

                write_log($upload);

                $type = '';
                if (!empty($upload['type'])) {

                    $type = $upload['type'];

                } else {
                    $mime = wp_check_filetype($upload['file']);
                if ($mime) {
                    $type = $mime['type'];
                    }
                }

                $attachment = array('post_title' => basename($upload['file']), 'post_content' => '', 'post_type' => 'attachment', 'post_mime_type' => $type, 'guid' => $upload['url']);

                $data = wp_insert_attachment($attachment, $upload['file']);
                
                wp_update_attachment_metadata($data, wp_generate_attachment_metadata($data, $upload['file']));
            }            
            
            hid_ex_m_create_new_support_chat( array(
                'sender' => $_REQUEST['sender'],
                'message' => $_REQUEST['new-chat-text'],
                'attachment' => $data,
                'ticket' => $_REQUEST['ticket']
            ) );
            
        } catch (\Throwable $th) {
            $data = -1;
        }

        wp_send_json_success( $data );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_create_a_new_chat', 'hid_ex_m_create_a_new_chat' );
add_action( 'wp_ajax_nopriv_hid_ex_m_create_a_new_chat', 'hid_ex_m_create_a_new_chat' );

function hid_ex_m_get_wallet_funding_local_bank() {

    if ( isset($_REQUEST) ) {

        $data = 0;

        $bank_id = get_option('wallet_local_bank');

        $bank = hid_ex_m_get_bank_data( $bank_id );

        $output = array(
            'data'  => $data,
            'bank'  => $bank
        );

        wp_send_json_success( $output );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_get_wallet_funding_local_bank', 'hid_ex_m_get_wallet_funding_local_bank' );
add_action( 'wp_ajax_nopriv_hid_ex_m_get_wallet_funding_local_bank', 'hid_ex_m_get_wallet_funding_local_bank' );

function hid_ex_m_credit_wallet() {

    if ( isset($_REQUEST) ) {

        check_ajax_referer('file_upload', 'security');

        $data = 0;

        try {

            // check_ajax_referer('file_upload', 'security');

            $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

            if (in_array($_FILES['file']['type'], $arr_img_ext)) {

                $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));

                // write_log($upload);

                $type = '';
                if (!empty($upload['type'])) {

                    $type = $upload['type'];

                } else {
                    $mime = wp_check_filetype($upload['file']);
                if ($mime) {
                    $type = $mime['type'];
                    }
                }

                $attachment = array('post_title' => basename($upload['file']), 'post_content' => '', 'post_type' => 'attachment', 'post_mime_type' => $type, 'guid' => $upload['url']);

                $image_id = wp_insert_attachment($attachment, $upload['file']);
                
                wp_update_attachment_metadata($data, wp_generate_attachment_metadata($data, $upload['file']));
            }            
            
            $input_data = array(
                'customer_id' => get_current_user_id(),
                'transaction_type' => 1,
                'amount' => $_REQUEST['amount'],
                'mode'  => $_REQUEST['mode'],
                'details'   => $_REQUEST['details'],
                'proof_of_payment' => $image_id,
                'sending_instructions'  => 'Not required',
                'transaction_status'    => 1
            );

            write_log($input_data);

            hid_ex_m_create_new_wallet_transaction( $input_data );

            $data = 1;
            
        } catch (\Throwable $th) {
            $data = -1;
        }

        wp_send_json_success( $data );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_credit_wallet', 'hid_ex_m_credit_wallet' );
add_action( 'wp_ajax_nopriv_hid_ex_m_credit_wallet', 'hid_ex_m_credit_wallet' );


function hid_ex_m_debit_wallet() {

    if ( isset($_REQUEST) ) {

        $data = 0;

        // Check if user's account balance is sufficient

        if (!(hid_ex_m_get_account_balance(get_current_user_id()) < $_REQUEST['amount_'] )){

            try {           
                
                $input_data = array(
                    'customer_id' => get_current_user_id(),
                    'transaction_type' => 2,
                    'amount' => $_REQUEST['amount_'],
                    'mode'  => $_REQUEST['mode_w'],
                    'details'   => $_REQUEST['details'],
                    'proof_of_payment' => 0,
                    'sending_instructions'  => $_REQUEST['info'],
                    'transaction_status'    => 1
                );

                write_log($input_data);

                hid_ex_m_create_new_wallet_transaction( $input_data );

                $data = 1;
                
            } catch (\Throwable $th) {
                $data = -1;
            }

        }

        wp_send_json_success( $data );
    }
  
    die();
}
  
// Hooking the ajax function into wordpress
add_action( 'wp_ajax_hid_ex_m_debit_wallet', 'hid_ex_m_debit_wallet' );
add_action( 'wp_ajax_nopriv_hid_ex_m_debit_wallet', 'hid_ex_m_debit_wallet' );