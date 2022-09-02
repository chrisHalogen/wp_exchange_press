<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Customer Permission
function hid_ex_m_rest_permit_customers( $request ) {

    // write_log( $request );

    $current_user = wp_get_current_user();

    // write_log( '========================================' );

    // write_log( $current_user->roles );

    // write_log( '========================================' );

    if ( in_array( "customer", $current_user->roles ) ){
        return true;
    }

    return false;
}


// get giftcards
// https://wp.site.local/testing-server/wp-json/hid-rest/get-giftcards
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','get-giftcards', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_get_giftcards',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_get_giftcards( $request ){

    try {

        $all_giftcards = hid_ex_m_get_all_giftcards();

        if ( ! ( empty( $all_giftcards ) ) ){

            foreach ($all_giftcards as $giftcard){

                $giftcard->image_url = wp_get_attachment_url($giftcard->icon);

                unset( $giftcard->icon );
                
            }
        }

        $response = new WP_REST_Response( $all_giftcards );
        $response->set_status( 200 );

        return $response;

    } catch (\Throwable $th) {

        return new WP_Error( 
            'unknown error occured', // code
            'an unknown error occured while trying to fetch giftcards', // data
            array('status' => 400) // status
        );

    }

}

// sell giftcard
// https://wp.site.local/testing-server/wp-json/hid-rest/sell-giftcard
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','sell-giftcard', 
        array(
            'methods'  => 'POST',
            'callback' => 'hid_ex_m_rest_sell_giftcard',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_sell_giftcard( $request ){

    // write_log($request);

    if ( isset( $request['asset_id'] ) && isset( $request['quantity'] ) && isset( $_FILES['file'] ) ) {

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

                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                
                wp_update_attachment_metadata($data, wp_generate_attachment_metadata($data, $upload['file']));
            } else {

                return new WP_Error( 
                    'error processing order', // code
                    "error processing image", // data
                    array('status' => 400) // status
                );

            }

            $asset = hid_ex_m_get_giftcard_data( sanitize_text_field( $request['asset_id']) );

            $price = $request['quantity'] * $asset->buying_price;

            $input_data = array(

                'customer_id' => get_current_user_id(),
                'asset_id'      => sanitize_text_field($request['asset_id']) ,
                'quantity' => sanitize_text_field(floatval( $request['quantity'] )),
                'price' => $price,
                'card_picture' => $data, 
                'order_status'  => 1
                
            );

            hid_ex_m_create_new_giftcard_order( $input_data );

            $response = new WP_REST_Response('giftcard processed successfully');
            $response->set_status(200);

            return $response;

        } catch (\Throwable $th) {

            return new WP_Error( 
                'error processing order', // code
                "an error occured while trying to process the giftcard order - $th", // data
                array('status' => 400) // status
            );

        }
        
    } else {

        return new WP_Error( 
            'incomplete fields', // code
            'incomplete fields were submitted for process', // data
            array('status' => 400) // status
        );
    }

}

// get account balance
// https://wp.site.local/testing-server/wp-json/hid-rest/get-account-balance
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','get-account-balance', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_get_account_balance',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_get_account_balance( $request ){

    try {

        $data = hid_ex_m_get_account_balance( get_current_user_id() );

        $response = new WP_REST_Response( $data );
        $response->set_status( 200 );

        return $response;

    } catch (\Throwable $th) {

        return new WP_Error( 
            'unknown error occured', // code
            "an unknown error occured while trying to fetch customer's balance", // data
            array('status' => 400) // status
        );

    }

}

// Make Withdrawal Request
// https://wp.site.local/testing-server/wp-json/hid-rest/make-withdrawal-request
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','make-withdrawal-request', 
        array(
            'methods'  => 'POST',
            'callback' => 'hid_ex_m_rest_make_withdrawal_request',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_make_withdrawal_request( $request ){

    if ( isset( $request['amount-to-withdraw'] ) && isset( $request['sending-instructions'] ) ){

        if ( hid_ex_m_get_withdrawal_status( get_current_user_id() ) == 0 ){
            return new WP_Error( 
                'error occured', // code
                'withdrawal disabled for this user', // data
                array('status' => 400) // status
            );
        }

        if ( $request['amount-to-withdraw'] < 500 ){

            return new WP_Error( 
                'error occured', // code
                'the amount to withdraw is not up to the minimum which is 500 naira', // data
                array('status' => 400) // status
            );

        }

        try {

            $current_balance = hid_ex_m_get_account_balance(get_current_user_id());
            $withdrawable_amount = $current_balance - 100;

            if ( $request['amount-to-withdraw'] < $withdrawable_amount ){

                $input_data = array(
                    'customer_id' => get_current_user_id(),
                    'transaction_type' => 2,
                    'amount' => $request['amount-to-withdraw'],
                    'mode'  => 0,
                    'details'   => "Withdrawal Request from Mobile App",
                    'proof_of_payment' => 0,
                    'sending_instructions'  => $request['sending-instructions'],
                    'transaction_status'    => 1
                );

                // write_log($input_data);

                hid_ex_m_create_new_wallet_transaction( $input_data );

                $response = new WP_REST_Response( "Withdrawal Request Submitted Successfully" );
                $response->set_status( 200 );

                return $response;

            } else {

                return new WP_Error( 
                    'error occured', // code
                    'insufficient balance', // data
                    array('status' => 400) // status
                );

            }

        } catch (\Throwable $th) {

            return new WP_Error( 
                'unknown error occured', // code
                'an unknown error occured while trying to process withdrawals', // data
                array('status' => 400) // status
            );

        }

    } else {

        return new WP_Error( 
            'incomplete fields', // code
            'incomplete fields were submitted', // data
            array('status' => 400) // status
        );
    }

}

// get customer profile
// https://wp.site.local/testing-server/wp-json/hid-rest/get-customer-profile
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','get-customer-profile', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_get_customer_profile',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_get_customer_profile( $request ){

    try {

        $customer_data = hid_ex_m_get_customer_data( get_current_user_id() );

        $output_data = array(
            'id' => get_current_user_id(),
            'first-name' => $customer_data[0]->data->display_name,
            'last-name' => ucfirst( $customer_data[0]->data->user_nicename ),
            'username'  => $customer_data[0]->data->user_login,
            'email'   => $customer_data[0]->data->user_email,
            'phone' =>  $customer_data[1][0],
        );

        $response = new WP_REST_Response( $output_data );
        $response->set_status( 200 );

        return $response;

    } catch (\Throwable $th) {

        return new WP_Error( 
            'unknown error occured', // code
            'an unknown error occured while trying to fetch customer profile', // data
            array('status' => 400) // status
        );

    }

}

// get customer profile
// https://wp.site.local/testing-server/wp-json/hid-rest/update-customer-profile
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','update-customer-profile', 
        array(
            'methods'  => 'POST',
            'callback' => 'hid_ex_m_rest_update_customer_profile',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_update_customer_profile( $request ){

    if ( isset( $request['first-name'] ) && isset( $request['last-name'] ) && isset( $request['email'] ) && isset( $request['phone'] ) ) {

        try {
            $customer_data = hid_ex_m_get_customer_data( get_current_user_id() );

            $id = get_current_user_id();
            $username = $customer_data[0]->data->user_login;
            $email = sanitize_email( $request['email'] );
            $phone = sanitize_text_field( $request['phone'] );
            $first_name = sanitize_text_field( $request['first-name'] );
            $last_name = sanitize_text_field( $request['last-name'] );

            hid_ex_m_update_customer_data( 
                $first_name, 
                $last_name, 
                $email, 
                $phone,
                $username, 
                $id 
            );

            $response = new WP_REST_Response('user updated successfully');
            $response->set_status(200);
        
            return $response;

        } catch (\Throwable $th) {
            write_log($th);

            return new WP_Error( 
                'error-occured', // code
                'error occured while updating user', // data
                array('status' => 400) // status
            );
        }

    } else {

        return new WP_Error( 
            'incomplete fields', // code
            'incomplete fields were submitted for customer update', // data
            array('status' => 400) // status
        );
    }

}


// Test API
// https://wp.site.local/testing-server/wp-json/hid-rest/test-api
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','test-api', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_test_api',
            'permission_callback' => '__return_true' 
        ));
    }
);

function hid_ex_m_rest_test_api( $request ){

    try {

        $response = new WP_REST_Response( "API is Ready to go" );
        $response->set_status( 200 );

        return $response;

    } catch (\Throwable $th) {

        return new WP_Error( 
            'unknown error occured', // code
            'an unknown error occured while trying to test api', // data
            array('status' => 400) // status
        );

    }

}

// get assets
// https://wp.site.local/testing-server/wp-json/hid-rest/get-assets
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','get-assets', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_get_assets',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_get_assets( $request ){

    if ( isset( $request['asset-type'] ) ){

        try {

            $type = sanitize_text_field( $request['asset-type'] );
            $data = [];

            if ( $type == 1 ) {

                $data = hid_ex_m_get_all_e_currency_assets();

            } else if ( $type == 2 ) {

                $data = hid_ex_m_get_all_crypto_currency_assets();

            } else if ( $type == 3 ) {

                $data = hid_ex_m_get_all_giftcards();

            }

            if ( $type == 1 || $type == 2 ){
                if ( ! ( empty( $data ) ) ){

                    foreach ($data as $single_asset){
        
                        unset( $single_asset->associated_local_bank );
                        unset( $single_asset->selling_price );
                        
                    }
                }
            }

            if ( ! ( empty( $data ) ) ){
                foreach ($data as $single_asset){
        
                    $single_asset->image_url = wp_get_attachment_url($single_asset->icon);

                    unset( $single_asset->icon );
                    
                }
            }

            $response = new WP_REST_Response( $data );
            $response->set_status( 200 );

            return $response;

        } catch (\Throwable $th) {
            return new WP_Error( 
                'unknown error occured', // code
                'an unknown error occured while trying to fetch assets', // data
                array('status' => 400) // status
            );
        }        

    } else {
        return new WP_Error( 
            'error occured', // code
            'missing field : asset-type', // data
            array('status' => 400) // status
        );
    }

}

// get single asset
// https://wp.site.local/testing-server/wp-json/hid-rest/get-single-asset
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','get-single-asset', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_get_single_asset',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_get_single_asset( $request ){

    if ( isset( $request['asset-type'] ) && isset( $request['asset-id'] ) ){

        try {

            $type = sanitize_text_field( $request['asset-type'] );
            $id = sanitize_text_field( $request['asset-id'] );
            $data = [];

            if ( $type == 1 ) {

                try {

                    $data = hid_ex_m_get_e_currency_data( $id );

                } catch (\Throwable $th) {
                    return new WP_Error( 
                        'asset not found', // code
                        "there's no eCurrency asset with the specified id", // data
                        array('status' => 400) // status
                    );
                }

            } else if ( $type == 2 ) {

                try {

                    $data = hid_ex_m_get_crypto_currency_data( $id );

                } catch (\Throwable $th) {
                    return new WP_Error( 
                        'asset not found', // code
                        "there's no crypto currency asset with the specified id", // data
                        array('status' => 400) // status
                    );
                }

            } else if ( $type == 3 ) {

                try {

                    $data = hid_ex_m_get_giftcard_data( $id );

                } catch (\Throwable $th) {
                    return new WP_Error( 
                        'asset not found', // code
                        "there's no giftcard with the specified id", // data
                        array('status' => 400) // status
                    );
                }

            }

            if ( $type == 1 || $type == 2 ){
                unset( $data->associated_local_bank );
                unset( $data->selling_price );
                
            }

            $data->image_url = wp_get_attachment_url( $data->icon );

            unset( $data->icon );

            $response = new WP_REST_Response( $data );
            $response->set_status( 200 );

            return $response;

        } catch (\Throwable $th) {
            return new WP_Error( 
                'unknown error occured', // code
                'an unknown error occured while trying to fetch asset', // data
                array('status' => 400) // status
            );
        }        

    } else {
        return new WP_Error( 
            'error occured', // code
            'missing field : not all the required fields were provided', // data
            array('status' => 400) // status
        );
    }

}

// sell asset
// https://wp.site.local/testing-server/wp-json/hid-rest/sell-asset
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','sell-asset', 
        array(
            'methods'  => 'POST',
            'callback' => 'hid_ex_m_rest_sell_asset',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_sell_asset( $request ){

    // write_log($request);

    if ( isset( $request['asset-id'] ) && isset( $request['quantity'] ) && isset( $request['asset-type'] ) && isset( $_FILES['file'] ) ) {

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

                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                
                wp_update_attachment_metadata($data, wp_generate_attachment_metadata($data, $upload['file']));

            } else {

                return new WP_Error( 
                    'error processing order', // code
                    "error processing image", // data
                    array('status' => 400) // status
                );

            }

            $type = sanitize_text_field( $request['asset-type'] );
            $id = sanitize_text_field( $request['asset-id'] );

            $rate = hid_ex_m_get_asset_buying_price( $type, $id );

            $price = $request['quantity'] * $rate;

            $input_data = array(
                'customer_id'           => get_current_user_id(),
                'asset_type'            => $type,
                'asset_id'              => $id,
                'quantity_sold'         => floatval( $request['quantity'] ),
                'amount_to_recieve'     => $price,
                'proof_of_payment'      => $data,
                'order_status'          => 1
            );

            write_log($input_data);
    
            hid_ex_m_create_new_sell_order( $input_data );

            $output_data = array(
                'message'   =>  'Sell order created successfully'
            );

            $response = new WP_REST_Response($output_data);
            $response->set_status(200);

            return $response;

        } catch (\Throwable $th) {

            return new WP_Error( 
                'error processing order', // code
                "an error occured while trying to process the sell order - $th", // data
                array('status' => 400) // status
            );

        }
        
    } else {

        return new WP_Error( 
            'incomplete fields', // code
            'incomplete fields were submitted for process', // data
            array('status' => 400) // status
        );
    }

}

// fetch history
// https://wp.site.local/testing-server/wp-json/hid-rest/fetch-history
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','fetch-history', 
        array(
            'methods'  => 'GET',
            'callback' => 'hid_ex_m_rest_fetch_history',
            'permission_callback' => 'hid_ex_m_rest_permit_customers' 
        ));
    }
);

function hid_ex_m_rest_fetch_history( $request ){

    if ( isset( $request['type'] ) ){

        $history_type = sanitize_text_field( $request['type'] );
        $customer_id = get_current_user_id();
        $output_data = [];

        if ( $history_type == 1 ){

            $output_data = hid_ex_m_get_all_customer_withdrawals( $customer_id );

            if (! empty($output_data ) ){
                foreach ($output_data as $single) {
                    unset($single->id);
                    unset($single->customer_id);
                    unset($single->transaction_type);
                    unset($single->mode);
                    unset($single->proof_of_payment);

                    $single->transaction_mode = "Local Bank Withdrawal";
                    $single->status = hid_ex_m_get_order_status($single->transaction_status);

                    unset($single->transaction_status);
                }
            }


        } else if ( $history_type == 2 ) {

            $output_data = hid_ex_m_get_all_customer_giftcard_orders( $customer_id );

            if (! empty($output_data ) ){
                foreach ($output_data as $single) {
                    unset($single->id);
                    unset($single->customer_id);

                    $asset = hid_ex_m_get_giftcard_data( $single->asset_id );

                    $single->asset = $asset->name;
                    unset($single->asset_id);

                    $single->snapshot = wp_get_attachment_url($single->card_picture);
                    unset($single->card_picture);
                    // unset($single->proof_of_payment);

                    // $single->transaction_mode = "Local Bank Withdrawal";
                    $single->status = hid_ex_m_get_order_status($single->order_status);

                    unset($single->order_status);
                }
            }

        } else if ( $history_type == 3 ) {

            $output_data = hid_ex_m_get_all_customer_sell_orders( $customer_id );

            if (! empty($output_data ) ){
                foreach ($output_data as $single) {
                    

                    $single->quantity = floatval($single->quantity_sold);
                    $single->amount = floatval($single->amount_to_recieve);

                    $type = hid_ex_m_get_asset_type($single->asset_type);
                    $single->type = $type;

                    $asset = hid_ex_m_get_asset_full_name($single->asset_type,$single->asset_id);
                    $single->asset = $asset;

                    $single->snapshot = wp_get_attachment_url($single->proof_of_payment);
        
                    $single->status = hid_ex_m_get_order_status($single->order_status);

                    unset( $single->order_status );
                    unset( $single->id );
                    unset( $single->customer_id );
                    unset( $single->quantity_sold );
                    unset( $single->asset_id );
                    unset( $single->asset_type );
                    unset( $single->proof_of_payment );
                    unset( $single->amount_to_recieve );
                }
            }

        }

        if ( empty( $output_data ) ){
            $res = array(
                "message"   => "No history found"
            );

            $response = new WP_REST_Response( $res );
            $response->set_status( 200 );

            return $response;
        }

        $response = new WP_REST_Response( $output_data );
        $response->set_status( 200 );

        return $response;

    } else {
        return new WP_Error( 
            'incomplete fields', // code
            'incomplete fields were submitted for process', // data
            array('status' => 400) // status
        );
    }

    try {

        $all_giftcards = hid_ex_m_get_all_giftcards();

        if ( ! ( empty( $all_giftcards ) ) ){

            foreach ($all_giftcards as $giftcard){

                $giftcard->image_url = wp_get_attachment_url($giftcard->icon);

                unset( $giftcard->icon );
                
            }
        }

        $response = new WP_REST_Response( $all_giftcards );
        $response->set_status( 200 );

        return $response;

    } catch (\Throwable $th) {

        return new WP_Error( 
            'unknown error occured', // code
            'an unknown error occured while trying to fetch giftcards', // data
            array('status' => 400) // status
        );

    }

}