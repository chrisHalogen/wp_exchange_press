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

// Create the Giftcards Tables
function hid_ex_m_create_giftcards_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_giftcards';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
        short_name tinytext NOT NULL,
		icon tinytext NOT NULL,
        buying_price decimal(10,2) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Giftcard Orders Tables
function hid_ex_m_create_giftcard_orders_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		customer_id tinytext NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        asset_id tinyint NOT NULL,
        quantity decimal(20,7) NOT NULL,
        price decimal(20,2) NOT NULL,
        order_status tinyint DEFAULT '1',
        card_picture int NOT NULL,
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

// Create the Support Tickets Tables
function hid_ex_m_create_supports_chat_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_chat';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
        sender tinytext NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        message text NOT NULL,
		attachment int NOT NULL DEFAULT 0,
        ticket int NOT NULL,
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
        quantity decimal(20,7) NOT NULL,
        fee decimal(20,2) NOT NULL,
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
        quantity_sold decimal(20,7) NOT NULL,
        amount_to_recieve decimal(20,2) NOT NULL,
        proof_of_payment int NOT NULL,
        order_status tinyint DEFAULT '1',
		PRIMARY KEY (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

// Create the Wallet Transactions Tables
function hid_ex_m_create_wallet_transactions_table() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id int NOT NULL AUTO_INCREMENT,
		customer_id int NOT NULL,
        transaction_type int NOT NULL,
        time_stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        amount decimal(10,2) NOT NULL,
        mode tinyint NOT NULL,
        details text NOT NULL,
        proof_of_payment int NOT NULL,
        sending_instructions text NOT NULL,
        transaction_status tinyint DEFAULT '1',
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
    hid_ex_m_create_supports_ticket_table();
    hid_ex_m_create_supports_chat_table();
    hid_ex_m_create_buy_orders_table();
    hid_ex_m_create_sell_orders_table();
    hid_ex_m_create_announcements_table();
    hid_ex_m_create_wallet_transactions_table();
    hid_ex_m_create_giftcards_table();
    hid_ex_m_create_giftcard_orders_table();

}

//--------------Deactivation Hook-----------------

function hid_ex_m_run_on_deactivation(){
    global $wpdb;

    $table_extensions = [
        'hid_ex_m_local_bank',
        'hid_ex_m_e_currency_assets',
        'hid_ex_m_crypto_currency_assets',
        'hid_ex_m_supports_ticket',
        'hid_ex_m_supports_chat',
        'hid_ex_m_buy_orders',
        'hid_ex_m_sell_orders',
        'hid_ex_m_announcements',
        'hid_ex_m_wallet_transactions',
        'hid_ex_m_giftcards',
        'hid_ex_m_giftcard_orders'
    ];

    foreach ($table_extensions as $extension) {

        # code...
        $table_name = $wpdb->prefix . $extension;
        $wpdb->query("DROP TABLE IF EXISTS " . $table_name);

    }

    if (get_option('wallet_local_bank')){

        delete_option('wallet_local_bank');

    }
    if (get_option('business_email')){

        delete_option('business_email');

    }
    if (get_option('smtp_host')){

        delete_option('smtp_host');

    }
    if (get_option('smtp_port')){

        delete_option('smtp_port');

    }
    if (get_option('smtp_username')){

        delete_option('smtp_username');

    }
    if (get_option('smtp_password')){

        delete_option('smtp_password');

    }
    if (get_option('smtp_encryption')){

        delete_option('smtp_encryption');

    }

    hid_ex_m_bulk_delete_users();

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

// Giftcards
function hid_ex_m_create_new_giftcard( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcards';

    $wpdb->insert(
        $table_name,
        $data
    );

}

function hid_ex_m_get_giftcard_data( $asset_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_giftcards';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$asset_id'");

    return $result[0];
}

function hid_ex_m_get_all_giftcards(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_giftcards';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_delete_giftcard( $asset_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcards';

    $wpdb->query("DELETE FROM $table_name WHERE id='$asset_id'");

}

function hid_ex_m_update_giftcard_data( $data, $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcards';

    $wpdb->update( $table_name, $data, $where );

}

// Giftcard Orders
function hid_ex_m_get_all_giftcard_orders(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;
}

function hid_ex_m_delete_giftcard_order( $order_id ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $wpdb->query("DELETE FROM $table_name WHERE id='$order_id'");

}

function hid_ex_m_get_giftcard_order_data( $order_id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$order_id'");

    return $result[0];
}

function hid_ex_m_create_new_giftcard_order( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $wpdb->insert(
        $table_name,
        $data
    );

    try {

        $customer = get_userdata($data["customer_id"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $asset_type = "Giftcard";
        $asset = hid_ex_m_get_giftcard_data( $data['asset_id'] );
        $asset_name = $asset->name;;
        $qty = $data["quantity"];
        $fee = $data["price"];
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because your Giftcard Order was placed successfully and is pending review.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity : $qty\nAmount you get : $fee\n\nKindly return to Luxtrade and sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Giftcard Order Created Successfully',
            $message_body
        );

        $name = hid_ex_m_get_customer_data_name($data["customer_id"]);

        $message_body = "Greetings,\n\nYou're recieving this eMail Notification because a customer by the name $name just made a Giftcard Order and is pending review.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity : $qty\nFee : # $fee\n\nKindly return to Luxtrade and sign into WP Admin to view and update the order.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            get_option('business_email'),
            'LuxTrade Alert !!! You have a new Buy Order',
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

}

function hid_ex_m_mark_giftcard_as_declined( $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $data = array(
        'order_status' => 0
    );

    $wpdb->update(
        $table_name,
        $data,
        $where
    );

}

function hid_ex_m_mark_giftcard_as_pending( $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $data = array(
        'order_status' => 1
    );

    $wpdb->update(
        $table_name,
        $data,
        $where
    );

}

function hid_ex_m_mark_giftcard_as_approve( $where ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_giftcard_orders';

    $data = array(
        'order_status' => 2
    );

    $wpdb->update(
        $table_name,
        $data,
        $where
    );

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

function comparator($object1, $object2) {

    return (int)($object1->account_balance < $object2->account_balance);

}

// Customers
function hid_ex_m_get_ranking_top_10_customers(){

    $args = array (
        'role' => 'customer',
        'orderby' => 'account_balance',
        'order' => 'DESC',
        'fields' => 'all'
    );

    // Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($args);

    // Get the results
    $customers = $wp_user_query->get_results();

    foreach ($customers as $customer) {

        $customer->account_balance = hid_ex_m_get_account_balance($customer->ID);

    }

    usort($customers, 'comparator');

    if (count($customers) > 10){
        return array_slice($customers, 0, 10);
    }

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
    add_user_meta( $user_id, 'account_balance', 0);
    add_user_meta( $user_id, 'can_withdraw', 1);

    try {

        $message_body = "Greetings $first_name,\n\nYou're recieving this eMail Notification because your registeration at Luxtrade was successful.\n\nBelow are some of your data provided upon registeration\nFirst Name : $first_name\nLast Name : $last_name\nEmail : $email\nPhone : $phone\nUsername : $username\nPassword : ----------------\n\nKindly return to Luxtrade to sign into your dashboard to start trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Customer Registeration Successful',
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

}

function hid_ex_m_delete_customer($customer_id){

    delete_user_meta( $customer_id, 'phone_number' );
    delete_user_meta( $customer_id, 'account_balance' );
    delete_user_meta( $customer_id, 'can_withdraw' );
    wp_delete_user($customer_id);
}

// Bulk Delete Customer
function hid_ex_m_bulk_delete_users(){

    //Include the user file with the user administration API
    require_once( ABSPATH . 'wp-admin/includes/user.php' );

    $role = 'customer';

    //Get a list of users that belongs to the specified role
    $users = get_users( array( 'role' => array( $role ) ) );

    //Delete all the user of the specified role
    foreach ( $users as $user ) {

        $customer_id = $user->ID;

        delete_user_meta( $customer_id, 'phone_number' );
        delete_user_meta( $customer_id, 'account_balance' );
        delete_user_meta( $customer_id, 'can_withdraw' );
        wp_delete_user( $customer_id );
    }
    
    
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

    try {
        
        $message_body = "Greetings $first_name,\n\nYou're recieving this eMail Notification because your profile at Luxtrade got updated successfully.\n\nBelow are some of your data provided\nFirst Name : $first_name\nLast Name : $last_name\nEmail : $email\nPhone : $phone\nUsername : $username\nPassword : ----------------\n\nKindly return to Luxtrade to sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Customer Registeration Successful',
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

}

// Buy Order
function hid_ex_m_create_new_buy_order( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_buy_orders';

    $wpdb->insert(
        $table_name,
        $data
    );

    try {

        $customer = get_userdata($data["customer_id"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $asset_type = hid_ex_m_get_asset_type($data["asset_type"]);
        $asset_name = hid_ex_m_get_asset_name($data["asset_type"],$data["asset_id"]);
        $qty = $data["quantity"];
        $fee = $data["fee"];
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because your buy order was placed successfully and is pending review.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity : $qty\nFee : $fee\n\nKindly return to Luxtrade and sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Buy order created Successfully',
            $message_body
        );

        $name = hid_ex_m_get_customer_data_name($data["customer_id"]);

        $message_body = "Greetings,\n\nYou're recieving this eMail Notification because a customer by the name $name just created a new buy order and is pending review.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity : $qty\nFee : # $fee\n\nKindly return to Luxtrade and sign into WP Admin to view and update the order.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            get_option('business_email'),
            'LuxTrade Alert !!! You have a new Buy Order',
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

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

    try {

        $customer = get_userdata($data["customer_id"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $asset_type = hid_ex_m_get_asset_type($data["asset_type"]);
        $asset_name = hid_ex_m_get_asset_name($data["asset_type"],$data["asset_id"]);
        $qty = $data["quantity"];
        $fee = $data["fee"];
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because a buy order of yours got updated by Luxtrade admin.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity : $qty\nFee : # $fee\n\nKindly return to Luxtrade and sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Buy order Updated by Admin',
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

}

// Sell Order
function hid_ex_m_create_new_sell_order( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_sell_orders';

    $wpdb->insert(
        $table_name,
        $data
    );

    try {

        $customer = get_userdata($data["customer_id"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $asset_type = hid_ex_m_get_asset_type($data["asset_type"]);
        $asset_name = hid_ex_m_get_asset_name($data["asset_type"],$data["asset_id"]);
        $qty = $data["quantity_sold"];
        $fee = $data["amount_to_recieve"];
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because your sell order was placed successfully and is pending review.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity Sold : $qty\nAmount to Recieve : # $fee\n\nKindly return to Luxtrade and sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Sell order created Successfully',
            $message_body
        );

        $name = hid_ex_m_get_customer_data_name($data["customer_id"]);

        $message_body = "Greetings,\n\nYou're recieving this eMail Notification because a customer by the name $name just created a sell order and is pending review.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity Sold : $qty\nAmount to Recieve : # $fee\n\nKindly return to Luxtrade and sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            get_option('business_email'),
            'LuxTrade Alert !!! You have a new sell order',
            $message_body
        );


    } catch (\Throwable $th) {

        write_log($th);

    }



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

    try {

        $customer = get_userdata($data["customer_id"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $asset_type = hid_ex_m_get_asset_type($data["asset_type"]);
        $asset_name = hid_ex_m_get_asset_name($data["asset_type"],$data["asset_id"]);
        $qty = $data["quantity_sold"];
        $fee = $data["amount_to_recieve"];
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because admin just updated your sell order.\n\nBelow are some of the order details\nAsset Type : $asset_type\nAsset : $asset_name\nQuantity Sold : $qty\nAmount to Recieve : $fee\n\nKindly return to Luxtrade and sign into your dashboard to continue trading Crypto and other digital assets.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            'LuxTrade Alert !!! Sell order updated by Admin',
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

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

    try {

        $customer = get_userdata($data["customer"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $title = $data["title"];
        
        if ($data["requester"] == "Admin"){

            $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because admin just opened a support ticket for you with the title - '$title'.\n\nKindly return to Luxtrade and sign into your dashboard; Checkout the Supports tab to know more about the ticket.\n\nCheers!!!\nLuxtrade - Admin";

            wp_mail(
                $email,
                'LuxTrade Alert !!! New Support Ticket from Admin',
                $message_body
            );

        } else {

            $name = hid_ex_m_get_customer_data_name($data["customer"]);

            $message_body = "Greetings,\n\nYou're recieving this eMail Notification because a customer with the name $name just opened a support ticket for you with the title - '$title'.\n\nKindly login to Luxtrade WP Admin to know more about the ticket.\n\nCheers!!!\nLuxtrade - Admin";

            wp_mail(
                get_option('business_email'),
                "LuxTrade Alert !!! New Support Ticket from $name",
                $message_body
            );
        }

    } catch (\Throwable $th) {

        write_log($th);

    }

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

    $table_name = $wpdb->prefix . 'hid_ex_m_supports_chat';

    $wpdb->query("DELETE FROM $table_name WHERE ticket='$id'");

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

// Wallet Page Data
function hid_ex_m_wallet_page_data($customer_id){

    $total_transactions = 0;
    $pending_payments = 0;

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $all_transactions = $wpdb->get_results("SELECT * FROM $table_name WHERE customer_id='$customer_id' ORDER BY time_stamp DESC");

    if (! empty($all_transactions)){
        $total_transactions = count($all_transactions);

        foreach($all_transactions as $transaction){

            if ($transaction->transaction_status == 1){
                
                $pending_payments += $transaction->amount;
            }
        }
    }

    $result = array(
        'account_balance'   => hid_ex_m_get_account_balance($customer_id),
        'can_withdraw'   => hid_ex_m_get_withdrawal_status($customer_id),
        'total_transactions'    => $total_transactions,
        'pending_payments'  => $pending_payments,
        'all_transactions'  => $all_transactions

    );

    return $result;
}

function hid_ex_m_get_all_transactions(){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $result = $wpdb->get_results("SELECT * FROM $table_name");

    return $result;

}

function hid_ex_m_get_all_transactions_30_days(){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    // CreatedDate >= DATEADD(day,-7, GETDATE())

    // DATEDIFF(Month,time_stamp,GetDate())<=1 AND transaction_status=2

    // Y-M-D h:m:s - gives actual day amd month

    // SELECT * FROM `wp_hid_ex_m_wallet_transactions` WHERE transaction_status=2 AND time_stamp >= 22-06-22

    $current_now = current_time("y-m-d");
    $current_month = date( 'y-m-d', strtotime( '-30 days', current_time('timestamp') ) );

    $result = $wpdb->get_results("SELECT * from $table_name WHERE time_stamp >= $current_month AND transaction_status=2");

    return $result;

}

// Get account balance
function hid_ex_m_get_account_balance($customer_id){

    if (! metadata_exists( 'user', $customer_id, 'account_balance' ) ) {

        add_user_meta( $customer_id, 'account_balance', 0);
    }

    if (! metadata_exists( 'user', $customer_id, 'can_withdraw' ) ) {

        add_user_meta( $customer_id, 'can_withdraw', 1);
    }

    $current_bal = get_user_meta($customer_id, 'account_balance')[0];

    return round($current_bal, 2);

}


// Get account balance
function hid_ex_m_get_withdrawal_status($customer_id){

    if (! metadata_exists( 'user', $customer_id, 'account_balance' ) ) {

        add_user_meta( $customer_id, 'account_balance', 0);
    }

    if (! metadata_exists( 'user', $customer_id, 'can_withdraw' ) ) {

        add_user_meta( $customer_id, 'can_withdraw', 1);
    }

    return get_user_meta($customer_id, 'can_withdraw')[0];

}

function hid_ex_m_get_wallet_transaction_type($type){

    $output = "";

    if ($type == 1){
        $output = "Deposit";

    } else if ($type == 2){

        $output = "Withdrawal";

    }

    return $output;
}

function hid_ex_m_get_wallet_transaction_mode($data, $type){

    $result = "";

    $output = hid_ex_m_get_wallet_transaction_type($type);

    if ($data == 0){

        $result = "Local Bank $output";

    } else if ($data == 1){

        $result = "eCurrency $output";

    } else if ($data == 2){

        $result = "Crypto Currency $output";

    }

    return $result;

}

function hid_ex_m_create_new_wallet_transaction( $data ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $wpdb->insert(
        $table_name,
        $data
    );


    try {

        $customer = get_userdata($data["customer_id"]);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $mode = hid_ex_m_get_wallet_transaction_mode($data["mode"], $data["transaction_type"]);
        $amount = $data["amount"];
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because your $mode of # $amount was successful and is pending review.\n\nKindly return to Luxtrade and sign into your dashboard; Visit the wallets tab to know more.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            "LuxTrade Alert !!! $mode created Successfully",
            $message_body
        );

        $name = hid_ex_m_get_customer_data_name($data["customer_id"]);

        $message_body = "Greetings,\n\nYou're recieving this eMail Notification because a customer by the name $name just made a $mode of # $amount and is pending review.\n\nKindly return to Luxtrade and sign into WP Admin to view and update the wallet transaction.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            get_option('business_email'),
            "LuxTrade Alert !!! You have a new $mode to review",
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }

}

function hid_ex_m_update_wallet_bank( $bank_id ){

    if (! update_option( 'wallet_local_bank', $bank_id) ){
        add_option( 'wallet_local_bank', $bank_id );
    }

}

function hid_ex_m_get_admin_wallet_page_data(){

    // global $wpdb;

    $total_customers = 0;
    $total_pending = 0;
    $total_declined = 0;
    $percentage_completed = 0;
    $total_completed = 0;
    $total_in_wallet = 0;
    $total_approved_credit = 0;
    $total_approved_debit = 0;
    $credit_30_days = 0;
    $debit_30_days = 0;

    $all_customers = hid_ex_m_get_all_customers();

    if (!empty($all_customers)){
        $total_customers = count($all_customers);

        foreach ($all_customers as $customer) {
            
            $total_in_wallet += hid_ex_m_get_account_balance($customer->ID);

        }
    }

    $all_transactions = hid_ex_m_get_all_transactions();

    if (!empty($all_transactions)){

        foreach($all_transactions as $transaction){

            if ($transaction->transaction_status == 0){

                $total_declined += 1;

            } else if ($transaction->transaction_status == 1){

                $total_pending += 1;

            } else if ($transaction->transaction_status == 2){

                $total_completed += 1;

                if ($transaction->transaction_type == 1){

                    $total_approved_credit += $transaction->amount;

                } else if ($transaction->transaction_type == 2){

                    $total_approved_debit += $transaction->amount;

                }

            }

        }

        $percentage_completed = ( $total_completed / count($all_transactions) ) * 100 ;
    }

    $approved_transactions_30_days = hid_ex_m_get_all_transactions_30_days();

    if (!empty($approved_transactions_30_days)){

        foreach ($approved_transactions_30_days as $transaction) {
            
            if ($transaction->transaction_type == 1){

                $credit_30_days += $transaction->amount;

            } else if ($transaction->transaction_type == 2){

                $debit_30_days += $transaction->amount;

            }

        }

    }

    $output = array(
        'total_customers'       => $total_customers,
        'total_pending'         => $total_pending,
        'total_declined'        => $total_declined,
        'percentage_completed'  => round($percentage_completed, 2),
        'total_in_wallet'       => round($total_in_wallet, 2),
        'total_approved_credit' => round($total_approved_credit,2),
        'total_approved_debit'  => round($total_approved_debit,2),
        'credit_30_days'        => round($credit_30_days, 2),
        'debit_30_days'         => round($debit_30_days, 2),
        'top_10_customers'      => hid_ex_m_get_ranking_top_10_customers(),
    );

    return $output;

}

function hid_ex_m_get_customer_approved_transactions($id,$type){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $output = 0;

    $result = $wpdb->get_results("SELECT * from $table_name WHERE customer_id = $id AND transaction_status=$type AND transaction_type = 1");

    if (!empty($result)){
        
        foreach ($result as $transaction) {
            $output += $transaction->amount;
        }
    }

    return $output;

}

function hid_ex_m_get_all_withdrawals(){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $result = $wpdb->get_results("SELECT * from $table_name WHERE transaction_type = 2 ORDER BY time_stamp DESC");

    return $result;

}

function hid_ex_m_get_one_wallet_transaction($id){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $result = $wpdb->get_results("SELECT * from $table_name WHERE id=$id");

    return $result[0];

}

function hid_ex_m_get_all_deposits(){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $result = $wpdb->get_results("SELECT * from $table_name WHERE transaction_type = 1 ORDER BY time_stamp DESC");

    return $result;

}

function hid_ex_m_update_transaction_status( $status, $id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $data = array(
        'transaction_status' => (int)$status
    );

    $where = array(
        'id'        => (int)$id
    );

    $wpdb->update(
        $table_name,
        $data,
        $where
    );

    try {

        $transaction = hid_ex_m_get_one_wallet_transaction($id);

        $customer = get_userdata($transaction->customer_id);
        $email = $customer->user_email;
        $name = $customer->display_name;
        $mode = hid_ex_m_get_wallet_transaction_mode($transaction->mode, $transaction->transaction_type);
        $amount = $transaction->amount;
        
        $message_body = "Greetings $name,\n\nYou're recieving this eMail Notification because your $mode of # $amount was just got updated by Luxtrade Admin.\n\nKindly return to Luxtrade and sign into your dashboard; Visit the wallets tab to know more.\n\nCheers!!!\nLuxtrade - Admin";

        wp_mail(
            $email,
            "LuxTrade Alert !!! $mode updated by Admin",
            $message_body
        );

    } catch (\Throwable $th) {

        write_log($th);

    }


}

function hid_ex_m_get_wallet_transaction_data( $id ){

    global $wpdb;

    $table_name = $wpdb->prefix . 'hid_ex_m_wallet_transactions';

    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$id'");

    return $result[0];
}

function hid_ex_m_update_wp_option( $option_key, $option_value ){

    if (! update_option( $option_key, $option_value) ){
        add_option( $option_key, $option_value );
    }

}

function hid_ex_m_password_reset_eMail( $user_id, $user_eMail ){

    $password_reset_token = hid_ex_m_generateRandomString();
    $password_reset_key = hid_ex_m_generateRandomString();
    $password_reset_iv = hid_ex_m_generateRandomString();
    $password_reset_string = $password_reset_token . "," . $password_reset_key . "," . $password_reset_iv;

    $encrypted_string = hid_ex_m_twoway_encrypt(
        $password_reset_token, 
        $password_reset_key, 
        $password_reset_iv, 
        'e'
    );

    $encrypted_string = substr( $encrypted_string, 0, strlen($encrypted_string) - 1 );

    // Send Mail
    $mail_subject = "LuxTrade Alert !!! You requested for Password Reset";
    $customer = get_userdata($user_id);
    $name = $customer->display_name;
    $username = $customer->user_login;
    $password_reset_url = site_url( "/authentication/reset-password/?customer=$username&token=$encrypted_string" );

    $email_body = "<p>Greetings $name</p><p>You are recieving this eMail because you requested for a password reset. <a href='$password_reset_url'>Follow this link</a> to reset your password</p><p>If you can't click on the link above, copy this link to your web browser - <code>$password_reset_url</code></p><p>If you haven't requested for any password reset, kindly ignore this eMail</p><p>Thank You</p>";

    add_filter( 'wp_mail_content_type', 'hid_ex_m_set_html_content_type' );

    wp_mail( $user_eMail, $mail_subject, $email_body );

    remove_filter( 'wp_mail_content_type', 'hid_ex_m_set_html_content_type' );

    add_user_meta($user_id, "password_reset_cridentials", $password_reset_string);

}

function hid_ex_m_twoway_encrypt($input_str, $secret_key, $secret_iv, $action = 'e'){

    $output = null;

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if($action == 'e'){

       $output = base64_encode(
                openssl_encrypt(
                    $input_str, "AES-256-CBC", $key, 0, $iv)
            );

    }else if($action == 'd'){

       $output = openssl_decrypt(
            base64_decode($input_str),
            "AES-256-CBC", $key, 0, $iv
        );

    }

    return $output;
}

function hid_ex_m_generateRandomString($length = 30) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function hid_ex_m_set_html_content_type() {
    return 'text/html';
}

function hid_ex_m_check_token($user_id, $token) {
    
    $token_string = get_user_meta($user_id, "password_reset_cridentials");

    $last = count($token_string) - 1;

    $token_string = $token_string[$last];

    // write_log($token_string);

    $cridentials = explode(",", $token_string);

    $decrypted_string = hid_ex_m_twoway_encrypt(
        $token . "=", 
        $cridentials[1], 
        $cridentials[2], 
        'd'
    );

    // write_log($decrypted_string);
    // write_log($cridentials[0]);

    if ($decrypted_string == $cridentials[0]){
        return 1;
    }

    return 0;
}

