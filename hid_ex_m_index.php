<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*

Plugin Name: HID Exchange Manager
Plugin URI: https://github.com/chrishalogen
Version: 1.0
Description: This plugin will enable crypto exchangers to mount and manage their business on WordPress. Both the User area and the admin area.
Author: Christian Chi Nwikpo
Author URI: https://github.com/chrishalogen
License: GPU
Text Domain: hid-ex-m

*/

// Register Activation
register_activation_hook(
    __FILE__,
    'hid_ex_m_run_on_activation'
);


register_deactivation_hook(
    __FILE__,
    'hid_ex_m_run_on_deactivation'
);

// returns the root directory path of particular plugin
define('HID_EX_M_ROOTDIR', plugin_dir_path(__FILE__));
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_functions.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_database.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_general_settings.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_e_currency.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_crypto_currency.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_customers.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_buy_order.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_sell_order.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_announcements.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_ajax_functions.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_support.php');
require_once (HID_EX_M_ROOTDIR.'client/hid_ex_m_misc.php');
require_once (HID_EX_M_ROOTDIR.'hid_ex_m_wallet_transactions.php');