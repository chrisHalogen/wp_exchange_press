<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Login endpoint
// https://wp.site.local/testing-server/wp-json/jwt-auth/v1/token

// Create new customer
// https://wp.site.local/testing-server/wp-json/hid-rest/new-customer
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','new-customer', 
        array(
            'methods'  => 'POST',
            'callback' => 'hid_ex_m_rest_create_new_customer',
            'permission_callback' => '__return_true' // non protected
        ));
    }
);

function hid_ex_m_rest_create_new_customer( $request ){

    if ( isset( $request['first-name'] ) && isset( $request['last-name'] ) && isset( $request['email'] ) && isset( $request['phone'] )  && isset( $request['password'] ) && isset( $request['username'] ) ) {

        $email = sanitize_email( $request['email'] );
        $username = sanitize_text_field( $request['username'] );
        $phone = sanitize_text_field( $request['phone'] );
        $password = sanitize_text_field( $request['password'] );
        $first_name = sanitize_text_field( $request['first-name'] );
        $last_name = sanitize_text_field( $request['last-name'] );

        if ( email_exists( $email ) ){

            return new WP_Error( 
                'email already exists', // code
                'this email address have been used by another user. kindly provide another', // data
                array('status' => 401) // status
            );

        }

        if ( username_exists( $username ) ){

            return new WP_Error( 
                'username already exists', // code
                'this username address have been used by another user. kindly provide another', // data
                array('status' => 401) // status
            );

            // $response = new WP_REST_Response('user created successfully');
            // $response->set_status(401);

            // return $response;

        }

        hid_ex_m_create_new_customer(
            $first_name,
            $last_name,
            $email,
            $phone,
            $password,
            $username
        );

        $response = new WP_REST_Response('user created successfully');
        $response->set_status(200);
    
        return $response;

    } else {

        return new WP_Error( 
            'incomplete fields', // code
            'incomplete fields were submitted for customer registration', // data
            array('status' => 400) // status
        );
    }

}

// Initiate password reset
// https://wp.site.local/testing-server/wp-json/hid-rest/password-reset
add_action('rest_api_init', function () {
    register_rest_route( 'hid-rest','password-reset', 
        array(
            'methods'  => 'POST',
            'callback' => 'hid_ex_m_rest_password_reset',
            'permission_callback' => '__return_true' // non protected
        ));
    }
);

function hid_ex_m_rest_password_reset( $request ){

    if ( isset( $request['email'] ) ) {

        $email = sanitize_email( $request['email'] );
        

        if ( !( email_exists( $email ) ) ){

            return new WP_Error( 
                'this email does not exist', // code
                'this email address is not registered to any user', // data
                array('status' => 401) // status
            );

            $response = new WP_REST_Response( 'email already exists' );
            $response->set_status(401);

        }

        hid_ex_m_password_reset_eMail( email_exists($email), $email );

        $response = new WP_REST_Response('recovery email sent successfully');
        $response->set_status(200);
    
        return $response;

    } else {

        return new WP_Error( 
            'no email', // code
            'no email was submitted', // data
            array('status' => 400) // status
        );
    }

}