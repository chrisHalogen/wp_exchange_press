<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

//--------------Activation Hook-----------------
global $jal_db_version;

$jal_db_version = '1.0';

// Create the Local Banks Tables
function hid_ex_m_create_local_banks_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
        display_name text NOT NULL,
		bank_name tinytext NOT NULL,
        bank_account_name tinytext NOT NULL,
		bank_account_number bigint(12),
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the eCurrency Tables
function hid_ex_m_create_e_currency_assets_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
        short_name tinytext NOT NULL,
		icon tinytext NOT NULL,
        buying_price decimal(10,2) NOT NULL,
        selling_price decimal(10,2) NOT NULL,
        associated_local_bank int NOT NULL,
        sending_instruction text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Cryptocurrency Assets Tables
function hid_ex_m_create_crypto_currency_assets_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
        short_name tinytext NOT NULL,
		icon tinytext NOT NULL,
        buying_price decimal(10,2) NOT NULL,
        selling_price decimal(10,2) NOT NULL,
        wallet_address text NOT NULL,
        associated_local_bank int NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Activity Logs Tables
function hid_ex_m_create_activity_logs_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_activity_logs';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		user_id int NOT NULL,
        user_role tinytext NOT NULL,
		action_type tinytext NOT NULL,
        action_description tinytext NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Support Tickets Tables
function hid_ex_m_create_supports_ticket_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
        title text NOT NULL,
        details text NOT NULL,
        customer int NOT NULL,
		ticket_status boolean NOT NULL,
        created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		last_activity DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        requester tinytext NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Support Chat Tables
function hid_ex_m_create_supports_chat_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_chat';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		sender tinytext NOT NULL DEFAULT 'Admin',
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        message text NOT NULL DEFAULT '',
        attachment int NOT NULL DEFAULT 0,
        ticket int,
		PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Buy Orders Tables
function hid_ex_m_create_buy_orders_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		customer_id tinytext NOT NULL,
        asset_type tinyint NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        asset_id tinyint NOT NULL,
        quantity decimal(10,7) NOT NULL,
        fee decimal(10,2) NOT NULL,
        sending_instructions text DEFAULT '',
        order_status tinyint DEFAULT '1',
        proof_of_payment int NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Sell Orders Tables
function hid_ex_m_create_sell_orders_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		customer_id tinytext NOT NULL,
        asset_type tinyint NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        asset_id tinyint NOT NULL,
        quantity_sold decimal(10,7) NOT NULL,
        amount_to_recieve decimal(10,2) NOT NULL,
        proof_of_payment int NOT NULL,
        sending_instructions text NOT NULL,
        order_status tinyint DEFAULT '1',
		PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Announcements Tables
function hid_ex_m_create_announcements_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_announcements';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		headline text NOT NULL,
        body text NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

function hid_ex_m_run_on_activation(){

    // Create all Database Tables
    hid_ex_m_create_local_banks_table();
    hid_ex_m_create_e_currency_assets_table();
    hid_ex_m_create_crypto_currency_assets_table();
    hid_ex_m_create_activity_logs_table();
    hid_ex_m_create_supports_ticket_table();
    hid_ex_m_create_supports_chat_table();
    hid_ex_m_create_buy_orders_table();
    hid_ex_m_create_sell_orders_table();
    hid_ex_m_create_announcements_table();

}

//--------------Deactivation Hook-----------------

function hid_ex_m_run_on_deactivation(){
    global $wpdb;

    $table_extensions = [
        'hid_ex_m_local_bank',
        'hid_ex_m_e_currency_assets',
        'hid_ex_m_crypto_currency_assets',
        'hid_ex_m_activity_logs',
        'hid_ex_m_supports_ticket',
        'hid_ex_m_supports_chat',
        'hid_ex_m_buy_orders',
        'hid_ex_m_sell_orders',
        'hid_ex_m_announcements'
    ];

    foreach ($table_extensions as $extension) {

        # code...
        $table_name = $wpdb->prefix . $extension;
        $wpdb->query("DROP TABLE IF EXISTS " . $table_name);

    }

}

//----------CDUD ECurrency Local Banks-------------

function hid_ex_m_get_all_banks(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_get_bank_data( $bank_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$bank_id'");

    $data = array(
        'display_name'          => $result[0]->display_name,
        'bank_name'             => $result[0]->bank_name,
        'bank_account_name'     => $result[0]->bank_account_name,
        'bank_account_number'   => $result[0]->bank_account_number,
    );

    return $data;
}

function hid_ex_m_create_new_local_bank( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_update_local_bank( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $wpdb->update( $table_name, $data, $where );

}

function hid_ex_m_delete_local_bank( $bank_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $wpdb->query("DELETE FROM $table_name WHERE id='$bank_id'");

    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $wpdb->query("DELETE FROM $table_name WHERE associated_local_bank='$bank_id'");

}


//----------CDUD ECurrency -------------

function hid_ex_m_create_new_e_currency_asset( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_get_all_e_currency_assets(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_get_asset_display_name( $asset_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_local_bank';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

    return $result[0]->display_name;
}

function hid_ex_m_delete_e_currency_asset( $asset_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $wpdb->query("DELETE FROM $table_name WHERE id='$asset_id'");

}

function hid_ex_m_get_e_currency_data( $asset_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

    return $result[0];
}

function hid_ex_m_update_e_currency_data( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

    $wpdb->update( $table_name, $data, $where );

}

// Cryptocurrency
function hid_ex_m_get_all_crypto_currency_assets(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_delete_crypto_currency_asset( $asset_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

    $wpdb->query("DELETE FROM $table_name WHERE id='$asset_id'");

}

function hid_ex_m_create_new_crypto_currency_asset( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_update_crypto_currency_data( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

    $wpdb->update( $table_name, $data, $where );

}

function hid_ex_m_get_crypto_currency_data( $asset_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

    return $result[0];
}

// Customers
function hid_ex_m_get_all_customers(){

    $args = array (
        'role' => 'customer'
    );

    // Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($args);

    // Get the results
    $customers = $wp_user_query->get_results();

    return $customers;
}

/* Create Customer User Instance */

function hid_ex_m_create_new_customer( $first_name, $last_name, $email, $phone, $password, $username ){

    $userdata = array(
        'user_pass'             => $password,
        'user_login'            => $username,
        'user_nicename'         => $last_name,
        'user_email'            => $email,
        'display_name'          => $first_name,
        'last_name'             => $last_name,
        'role'                  => 'customer'
    );

    $user_id = wp_insert_user( $userdata );
    add_user_meta( $user_id, 'phone_number', $phone);

}

function hid_ex_m_delete_customer($customer_id){

    wp_delete_user($customer_id);
}

function hid_ex_m_get_customer_data($customer_id){

    $main = get_userdata($customer_id);
    $phone = get_user_meta($customer_id, 'phone_number');

    return [$main, $phone];
}

function hid_ex_m_update_customer_data( $first_name, $last_name, $email, $phone,$username, $id ){

    $userdata = array(
        'ID'                    => $id,
        'user_login'            => $username,
        'user_nicename'         => $last_name,
        'user_email'            => $email,
        'display_name'          => $first_name,
        'last_name'             => $last_name,
        'role'                  => 'customer'
    );

    wp_update_user($userdata);

    update_user_meta( $id, 'phone_number', $phone );

}

// Buy Order
function hid_ex_m_create_new_buy_order( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_get_all_buy_orders(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_get_customer_data_name($customer_id){

    $user = get_userdata($customer_id);

    return $user->display_name . " " . ucfirst($user->user_nicename);
}

function hid_ex_m_get_asset_type($id){

    if ($id == 1){
        return "eCurrency";
    } else{
        return "Crypto Currency";
    }

}

function hid_ex_m_get_order_status($status){

    if ($status == 0){
        return "Declined";
    } elseif ($status == 1){
        return "Pending";
    } else{
        return "Completed";
    }

}

function hid_ex_m_delete_buy_order( $order_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $wpdb->query("DELETE FROM $table_name WHERE id='$order_id'");

}

function hid_ex_m_get_buy_order_data( $order_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$order_id'");

    return $result[0];
}

function hid_ex_m_update_buy_order_data( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $wpdb->update( $table_name, $data, $where );

}

// Sell Order
function hid_ex_m_create_new_sell_order( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_get_all_sell_orders(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_delete_sell_order( $order_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $wpdb->query("DELETE FROM $table_name WHERE id='$order_id'");

}

function hid_ex_m_get_sell_order_data( $order_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$order_id'");

    return $result[0];
}

function hid_ex_m_update_sell_order_data( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $wpdb->update( $table_name, $data, $where );

}

function hid_ex_m_get_asset_name($asset_type,$asset_id){

    global $wpdb;

    if ($asset_type == 1){

        $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

        $output_data = $result[0]->name . " | " . $result[0]->short_name;

        return $output_data;

    } else{

        $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

        $output_data = $result[0]->name . " | " . $result[0]->short_name;

        return $output_data;

    }


}

// Announcements
function hid_ex_m_delete_announcement( $id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_announcements';

    $wpdb->query("DELETE FROM $table_name WHERE id='$id'");

}

function hid_ex_m_get_all_announcements(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_announcements';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_create_new_announcement( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_announcements';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_update_announcement_data( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_announcements';

    $wpdb->update( $table_name, $data, $where );

}

function hid_ex_m_get_announcement_data( $order_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_announcements';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$order_id'");

    return $result[0];
}

// Support Ticket

function hid_ex_m_create_new_support_ticket( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_get_all_support_tickets(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $result = $wpdb->get_results("SELECT * FROM $table_name ORDER BY last_activity DESC");

    return $result;
}

function hid_ex_m_mark_support_ticket_as_close(  $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $data = array(
        'ticket_status' => 0
    );

    $wpdb->update(
        $table_name,
        $data,
        $where
    );

    hid_ex_m_update_last_activity( $where['id'] );

}

function hid_ex_m_reopen_support_ticket( $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $data = array(
        'ticket_status' => 1
    );

    $wpdb->update(
        $table_name,
        $data,
        $where
    );

    hid_ex_m_update_last_activity( $where['id'] );

}

function hid_ex_m_update_last_activity( $id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $wpdb->query("UPDATE $table_name SET last_activity=CURRENT_TIMESTAMP WHERE id='$id'");

}

function hid_ex_m_delete_support_ticket( $id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $wpdb->query("DELETE FROM $table_name WHERE id='$id'");

}

function hid_ex_m_get_single_ticket_data( $ticket_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$ticket_id'");

    return $result[0];
}

// Support Chat
function hid_ex_m_create_new_support_chat( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_chat';

    $wpdb->insert(
        $table_name,
        $data
    );

    // $where = array(
    //     'id' => $data['ticket']
    // );

    hid_ex_m_update_last_activity( $data['ticket'] );

}

function hid_ex_m_get_all_support_chat( $ticket_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_chat';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE ticket='$ticket_id'");

    return $result;

}

function hid_ex_m_get_recent_support_chat_data( $time, $ticket_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_supports_chat';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE ticket='$ticket_id' AND time_stamp>'$time'");

    // $result = $wpdb->get_results("SELECT * FROM $table_name WHERE ticket='$ticket_id' AND time_stamp>Convert(datetime, $time)");

    // $_REQUEST['ticket_id']

    // SELECT * FROM $table_name WHERE ticket='$ticket_id' AND time_stamp>Convert(datetime, '2021-12-17 18:25:29')

    if (empty($result)){
        return 0;
    }

    return $result;

}

// Page Specific Data

// Comparison function
function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1->time_stamp);
    $datetime2 = strtotime($element2->time_stamp);
    return $datetime1 - $datetime2;
}

function hid_ex_m_get_dashboard_data($user_id){

    // Initializing results

    $total_sold = 0;
    $total_bought = 0;
    $total_transactions = 0;
    $pending_payments = 0;

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $result_buy = $wpdb->get_results("SELECT * FROM $table_name WHERE customer_id='$user_id'");

    if (empty($result_buy)){
        $total_bought = 0;
    } else {

        foreach($result_buy as $order){
            $total_bought += $order->fee;

            if ($order->order_status == 1){
                $pending_payments += $order->fee;
            }
        }
    }

    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $result_sell = $wpdb->get_results("SELECT * FROM $table_name WHERE customer_id='$user_id'");

    if (empty($result_sell)){
        $total_sold = 0;
    } else {

        foreach($result_sell as $order){
            $total_sold += $order->amount_to_recieve;
            
            if ($order->order_status == 1){
                $pending_payments += $order->amount_to_recieve;
            }
        }
    }

    $total_transactions = count($result_sell) + count($result_buy);

    $all_orders = array_merge($result_buy,$result_sell);

    if (count($all_orders) > 1){

        // // Comparison function
        // function date_compare($element1, $element2) {
        //     $datetime1 = strtotime($element1->time_stamp);
        //     $datetime2 = strtotime($element2->time_stamp);
        //     return $datetime1 - $datetime2;
        // } 
        
        // Sort the array 
        usort($all_orders, 'date_compare');

    }

    
    // array_slice(array, start, length, preserve)

    if (count($all_orders) > 5){
        $all_orders = array_slice($all_orders,0,5);
    }

    $announcements = hid_ex_m_get_all_announcements();

    if (count($announcements) > 3){
        $announcements = array_slice($announcements,0,3);
    }

    $data = array(
        'total_bought'          => $total_bought,
        'total_sold'            => $total_sold,
        'total_transactions'    => $total_transactions,
        'pending_payments'      => $pending_payments,
        'announcements'         => $announcements,
        'orders'                => $all_orders
    );

    return $data;

}

function hid_ex_m_get_asset_short_name($asset_type,$asset_id){

    global $wpdb;

    if ($asset_type == 1){

        $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

        return $result[0]->short_name;

    } else{

        $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

        return $result[0]->short_name;;

    }


}

function hid_ex_m_get_asset_full_name($asset_type,$asset_id){

    global $wpdb;

    if ($asset_type == 1){

        $table_name = $wpdb->prefix . 'hid_ex_m_e_currency_assets';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

        return $result[0]->name;

    } else{

        $table_name = $wpdb->prefix . 'hid_ex_m_crypto_currency_assets';

        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

        return $result[0]->name;;

    }


}


function hid_ex_m_get_user_history_data($user_id){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $result_buy = $wpdb->get_results("SELECT * FROM $table_name WHERE customer_id='$user_id'");

    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $result_sell = $wpdb->get_results("SELECT * FROM $table_name WHERE customer_id='$user_id'");


    $all_orders = array_merge($result_buy,$result_sell);

    if (count($all_orders) > 1){

        // Comparison function
        // function date_compare($element1, $element2) {
        //     $datetime1 = strtotime($element1->time_stamp);
        //     $datetime2 = strtotime($element2->time_stamp);
        //     return $datetime1 - $datetime2;
        // } 
        
        // Sort the array 
        usort($all_orders, 'date_compare');

    }

    return $all_orders;
}

function hid_ex_m_get_customer_support_tickets($customer_id){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_ticket';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE customer='$customer_id' AND ticket_status='1' ORDER BY last_activity DESC");

    return $result;
}