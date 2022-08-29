<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;

    $page_name = get_query_var('customer_page_name');

    // Get user Details
    $current_user = wp_get_current_user();
    
    if ( strtolower($page_name) == 'dashboard' ){

        // write_log(hid_ex_m_get_dashboard_data($current_user->ID));

        $page_data = array(
            'title'     => 'Dashboard | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_dashboard_data($current_user->ID),
            'account_balance'   => hid_ex_m_get_account_balance($current_user->ID) 
        );

        hid_ex_m_customer_dashboard( $page_data );

    }  elseif ( strtolower($page_name) == 'sell-to-us' ) {
        
        $page_data = array(
            'title'     => 'Sell To Us | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name
        );

        hid_ex_m_customer_area_sell_to_us( $page_data );

    }  elseif ( strtolower($page_name) == 'buy-from-us' ) {
        
        $page_data = array(
            'title'     => 'Buy From Us | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            // 'db_data'       => hid_ex_m_get_dashboard_data($current_user->ID)
        );

        hid_ex_m_customer_area_buy_from_us( $page_data );

    } elseif ( strtolower($page_name) == 'history' ) {
        
        $page_data = array(
            'title'     => 'History | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_user_history_data($current_user->ID)
        );

        hid_ex_m_customer_area_history( $page_data );

    } elseif ( strtolower($page_name) == 'announcements' ) {
        
        $page_data = array(
            'title'     => 'Announcements | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_all_announcements()
        );

        hid_ex_m_customer_area_announcements( $page_data );

    } elseif ( strtolower($page_name) == 'settings' ) {
        
        $page_data = array(
            'title'     => 'Settings | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_username' => $current_user->user_login,
            'current_first_name' => $current_user->display_name,
            'current_last_name' => $current_user->last_name,
            'current_email' => $current_user->user_email,
            'current_user_phone' => get_user_meta($current_user->ID, 'phone_number')[0]
            
        );

        hid_ex_m_customer_area_settings( $page_data );

    } elseif ( strtolower($page_name) == 'support' ) {
        
        $page_data = array(
            'title'     => 'Support | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_customer_support_tickets($current_user->ID)
        );

        hid_ex_m_customer_area_support( $page_data );

    } elseif ( strtolower($page_name) == 'logout' ) {

        wp_logout($current_user->ID);
        wp_redirect(site_url( '/authentication/sign-in/' ));

    } elseif ( strtolower($page_name) == 'rates' ) {
        
        $page_data = array(
            'title'     => 'Rates | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_customer_support_tickets($current_user->ID)
        );

        hid_ex_m_customer_area_rates( $page_data );

    } elseif ( strtolower($page_name) == 'wallet' ) {
        
        $page_data = array(
            'title'     => 'Wallet | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_wallet_page_data($current_user->ID)
        );

        hid_ex_m_customer_area_wallet( $page_data );

    }

function hid_ex_m_customer_area_wallet( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        <div class="content-area" id="hid_ex_m_wallet">

            <div class="inner-content-area">
                <h1 class="tab-title">My Wallet</h1>

                <div class="account-summary">
                    <div class="summary-card">
                        <i class="fa-solid fa-money-check-dollar"></i>
                        <span><?php echo $page_data['db_data']['account_balance'] ?></span>
                        <p>Total Wallet Balance</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-rotate"></i>
                        <span><?php echo $page_data['db_data']['total_transactions'] ?></span>
                        <p>Total Wallet Transactions</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-wallet"></i>
                        <span><?php echo $page_data['db_data']['pending_payments'] ?></span>
                        <p>Pending Wallet Payments</p>
                    </div>
                    
                </div>

                <div class="wallet-details-container">

                    <div class="ctas">
                        <button id="fund-wallet-btn">Fund my Wallet</button>
                        <!-- <button>Request Withdrawal</button> -->
                        <?php
                        
                            if ($page_data['db_data']['can_withdraw'] == 0){
                                
                                echo '<span>You cannot withdraw at the moment</span>';

                            } elseif (($page_data['db_data']['can_withdraw'] == 1)){
                                
                                echo "<button id='withdrawal-wallet-btn'>Request Withdrawal</button>";

                            }
                        
                        ?>
                    </div>

                    <div class="wallet-request-form" id="wallet-request-modal">

                        <div class="inner-div-fund">
                            <i class="fa-solid fa-xmark" id="close-wallet-request"></i>

                            <form action="" id="wallet-form" class="wallet-transaction-form">
                                <h2>Fund Your Wallet</h2>
                                <hr class="section-divider">
                                <div class="form-group">
                                    
                                    <p class="label-paragraph">Funding Mode</p>
                                    <div class="mode-radio-buttons">
                                        <label>
                                            <input class="mode-btn-0" name="mode" type="radio" value="0"> Local Bank Transfer
                                        </label>

                                        <label>
                                            <input class="mode-btn-1" name="mode" type="radio" id="mode-btn-1" value="1"> eCurrency
                                        </label>

                                        <label>
                                            <input class="mode-btn-2" id="mode-btn-2" name="mode" type="radio" value="2"> Crypto Currency
                                        </label>
                                        <p class="description">How do you want to fund your account?</p>
            
                                    </div>
                                </div>
                                <div style="align-items: center;" class="form-group">
                                    
                                    <p class="label-paragraph">Select Asset</p>
            
                                    <div id="select-input-wrapper">
                                        <select name="selected-asset" id="selected-asset" class="selected-asset">
                                            <option value="0">Select Asset</option>
                                            
                                        </select>
                                        <p class="description">Select the asset to buy</p>
                                    </div>
            
                                </div>
            
                                <h2>Amount</h2>
                                <hr class="section-divider">
                                <div class="form-group" style="align-items: center;">
                                    <p class="label-paragraph">Amount</p>
            
                                    <div id="amount_wrapper">
                                        <input type="text" name="amount" id="amount">
                                        <p class="description">How much do you wish to credit your wallet?</p>
                                    </div>
            
                                </div>

                                <div class="form-group" style="align-items: center;">
                                    <p class="label-paragraph">Quantity</p>
            
                                    <div id="quantity_wrapper">
                                        <input type="text" name="quantity" id="quantity">
                                        <p class="description">What quantity do you want to send in?</p>
                                    </div>
                                    
            
                                </div>
            
                                <div class="form-group" style="align-items: center;">
                                    <p class="label-paragraph">Amount</p>
            
                                    <div id="fee_wrapper">
                                        <p class="label-paragraph"><span id="amount-output"></span> </p>
                                        <p class="description">Exchange Rate - <span id="rate_output">0</span><br>This amount will be added to your wallet balance</p>
                                    </div>
                                </div>
            
                                <h2>Payment</h2>
                                <hr class="section-divider">
                                <div class="form-group" >
                                    <p class="label-paragraph">Sending Instructions</p>
            
                                    <div>
                                        <textarea placeholder="e.g Wallet Address, eMail Address..." name="" id="sending-instructions" cols="80" rows="5" disabled>-</textarea>
                                        <p class="description">Follow these instructions to send in your asset.</p>
                                    </div>
            
                                </div>
            
                                <div class="form-group" >
                                    <p class="label-paragraph">Proof of payment</p>
            
                                    <div>
                                        <div class="proof-upload">
                                            <button id="image_upload_btn">Upload Image</button>
                                            <input type="file" name="screenshot" class="custom-file-input" id="custom-file-input" accept="image/png, image/jpg, image/jpeg"/>
                                            <span id="image_name">-</span>
                                        </div>
                                        <p class="description">Upload a screenshot of proof of payment</p>
                                    </div>
            
                                </div>

                                <span id="message" class="message-output">-</span>
            
                                <input type="submit" name="submit" value="Submit">
                                
            
                            </form>

                            <form action="" id="wallet-form-withdrawal" class="wallet-transaction-form">
                                <input type="hidden" name="balance" id="account_balance" value="<?php echo $page_data['db_data']['account_balance'] ?>">
                                <h2>Request for Withdrawal</h2>
                                <hr class="section-divider">
                                <div class="form-group">
                                    
                                    <p class="label-paragraph">Withdrawal Mode</p>
                                    <div class="mode-radio-buttons">
                                        <label>
                                            <input class="mode-btn-0" name="mode_w" type="radio" value="0" checked> Local Bank Transfer
                                        </label>

                                        <p class="description">How do you want to process your Withdrawal?<br>Only Local Bank Withdrawals are available at the moment<br><span style="color:red">You must have a minimum of <strong>#100<strong>  left<span></p>
            
                                    </div>
                                </div>
                                
            
                                <h2>Amount</h2>
                                <hr class="section-divider">
                                <div class="form-group" style="align-items: center;">
                                    <p class="label-paragraph">Amount</p>
            
                                    <div id="amount_wrapper_w">
                                        <input type="text" name="amount" id="amount_w">
                                        <p class="description">How much do you wish to withdraw from your wallet?</p>
                                    </div>
            
                                </div>

                                
            
                                <h2>Payment</h2>
                                <hr class="section-divider">
                                <div class="form-group" >
                                    <p class="label-paragraph">Sending Instructions</p>
            
                                    <div>
                                        <textarea placeholder="Enter your Local Bank Account Details" name="" id="sending-instructions_w" cols="80" rows="5"></textarea>
                                        <p class="description">Where should we send your withdrawal to?</p>
                                    </div>
            
                                </div>

                                <span id="message-w" class="message-output">-</span>
            
                                <input type="submit" name="submit" value="Submit">
                                
            
                            </form>
                        
                        </div>
                        
                    </div>

                </div>

                <h2 style="text-align:center">Previous Wallet Transactions</h2>
                <div class="wallet-wrapper">
                    
                    <div class="table-container">

                        <?php
                        
                            if (empty($page_data['db_data']['all_transactions'])){
                                
                                echo "<center><p>You haven't made any transactions</p></center>";

                            } else {

                                ?>
                                
                                <table>
                                    <thead>
                                        <tr>
                                            <td style="width: 10%;">Type</td>
                                            <td style="width: 10%;">Amount</td>
                                            <td style="width: 10%;">Balance</td>
                                            <td style="width: 10%;">Mode</td>
                                            <td style="width: 10%;">Time</td>
                                            <td style="width: 40%;">Details</td>
                                            <td style="width: 10%;">Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            $build_string = "";

                                            $account_balance = $page_data['db_data']['account_balance'];
                                        
                                            foreach($page_data['db_data']['all_transactions'] as $transaction){

                                                $type = "";
                                                $amount = $transaction->amount;
                                                $mode = "";
                                                $time = $transaction->time_stamp;
                                                $details = $transaction->details;
                                                $status = 0;
                                                
                                                if ($transaction->transaction_type == 1){
                                                    $type = "Credit"; 
                                                } else {
                                                    $type = "Withdrawal";
                                                }

                                                if ($transaction->mode == 0){
                                                    $mode = "Local Bank";
                                                } elseif ($transaction->mode == 1){
                                                    $mode = "eCurr.";
                                                } elseif ($transaction->mode == 2){
                                                    $mode = "Crypto";
                                                }

                                                if ($transaction->transaction_status == 0){
                                                    $status = "Declined";
                                                } elseif ($transaction->transaction_status == 1){
                                                    $status = "Pending";
                                                } elseif ($transaction->transaction_status == 2){
                                                    $status = "Completed";
                                                }

                                                $build_string .= "<tr><td>$type</td>";

                                                $build_string .= "<td>$amount</td>";

                                                $build_string .= "<td>$account_balance</td>";

                                                $build_string .= "<td>$mode</td>";

                                                $build_string .= "<td>$time</td>";

                                                $build_string .= "<td>$details</td>";

                                                $build_string .= "<td>$status</td></tr>";

                                                if ($transaction->transaction_type == 1 && $transaction->transaction_status == 2){
                                                    $account_balance -= $transaction->amount; 
                                                } else if ($transaction->transaction_type == 2 && $transaction->transaction_status == 2) {
                                                    $account_balance += $transaction->amount;
                                                }
                                                
                                            }

                                            echo $build_string;
                                        
                                        ?>
                                        
                                    </tbody>
                                </table>
                                
                                <?php

                            }
                        
                        ?>

                    </div>
                </div>

                
            </div>
            <!-- End of Wallet content area -->
        </div> 

    <?php

    hid_ex_m_exchange_client_area_footer();
}

function hid_ex_m_customer_area_buy_from_us( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        
        <div class="content-area">

            <div class="inner-content-area" id="hid_ex_m_buy_from_us">
                <h1 class="tab-title">Place a Buy Order</h1>

                <div class="order-wrapper">
                    <form action="" id="order-form">
                    <h2>Asset Details</h2>
                    <hr class="section-divider">
                    <div class="form-group">
                        <!-- <label for="asset-type">Asset Type</label> -->
                        <p class="label-paragraph">Asset Type</p>
                        <div class="asset-radio-buttons">
                            <label>
                                <input id="asset-btn-1" class="asset-btn-1" name="asset-type" type="radio" value="1"> eCurrency
                            </label>
                            <br>
                            <br>
                            <label>
                                <input id="asset-btn-2" class="asset-btn-2" name="asset-type" type="radio" value="2"> Crypto Currency
                            </label>
                            <p class="description">What type of asset do you want to buy?</p>

                        </div>
                    </div>
                    <div class="form-group" style="align-items: center;">
                        <!-- <label for="asset-type">Asset Type</label> -->
                        <p class="label-paragraph">Select Asset</p>

                        <div>
                            <select name="selected-asset" id="selected-asset">
                                <option rate="0" value="0">Select Asset</option>
                                <!-- <option value="2">Ethereum | ETH</option>
                                <option value="3">Payoneer | PNR</option> -->
                            </select>
                            <p class="description">Select the asset to buy</p>
                        </div>

                        

                    </div>

                    <h2>Amount</h2>
                    <hr class="section-divider">
                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Quantity</p>

                        <div>
                            <input type="text" name="quantity" id="quantity" >
                            <p class="description">What quantity do you want to purchase?</p>
                        </div>
                        

                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Fee</p>

                        <div>
                            <p class="label-paragraph" id="total-fee">0</p>
                            <p class="description">Exchange Rate - <span id="rate-value">0</span></p>
                        </div>
                    </div>

                    <h2>Payment</h2>
                    <hr class="section-divider">
                    <div class="form-group" >
                        <p class="label-paragraph">Sending Instructions</p>

                        <div>
                            <textarea id="sending-instructions" name="" id="" cols="80" rows="5" disabled>-</textarea>
                            <p class="description">Follow this instructions to send us credit</p>
                        </div>

                    </div>

                    <div class="form-group" >
                        <p class="label-paragraph">Recieving Instructions</p>

                        <div>
                            <textarea id="recieving-instructions" name="" id="" cols="80" rows="5"></textarea>
                            <p class="description">Where should we send your asset?</p>
                        </div>

                    </div>

                    <div class="form-group" >
                        <p class="label-paragraph">Proof of payment</p>

                        <div>
                            <div class="proof-upload">
                                <input type="file" name="screenshot" class="custom-file-input" id="custom-file-input" accept="image/png, image/jpg, image/jpeg"/>
                                <button id="upload-img">Upload Image</button>
                                <p id="image-name">-</p>
                            </div>
                            <p class="description">Upload a screenshot of proof of credit sent</p>
                        </div>

                    </div>

                    <input type="submit" name="submit" value="Place My Order">
                    <p id="error-message">Error</p>

                    </form>
                    
                </div>

                
            </div>
            <!-- End of History content area -->
        </div> 


    
    <?php

    hid_ex_m_exchange_client_area_footer();
}


function hid_ex_m_customer_area_rates( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>

        <div class="content-area" id="hid_ex_m_rates">

            <div class="inner-content-area">
                <h1 class="tab-title">Today Rates</h1>

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
                                <h2 class="section-title main-head-title">Crypto Currency Rates</h2>
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
            <!-- End of Rates content area -->
        </div> 

   
    <?php

    hid_ex_m_exchange_client_area_footer();
}

function hid_ex_m_customer_dashboard( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    // write_log($page_data);

    ?>
        
        <div class="content-area">
            <!-- <div class="top-panel">top</div> -->
            <!-- Dashboard Content Area -->
            <div class="inner-content-area">
                <h1 class="tab-title">Dashboard</h1>
                <p class="tab-sub-title">Hello, <?php echo $page_data['current_user_display_name'] ?> :)</p>

                <h2 class="section-title main-head-title">Account Summary</h2>

                <div class="account-summary">
                    <div class="summary-card">
                        <i class="fa-solid fa-money-check-dollar"></i>
                        <span>#<?php echo $page_data['db_data']['total_sold'] ?></span>
                        <p>Total Sold</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-sack-dollar"></i>
                        <span>#<?php echo $page_data['db_data']['pending_payments'] ?></span>
                        <p>Pending Payments</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-rotate"></i>
                        <span><?php echo $page_data['db_data']['total_transactions'] ?></span>
                        <p>Total Transactions</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-wallet"></i>
                        <span>#<?php echo $page_data['account_balance'] ?></span>
                        <p>Wallet Balance</p>
                    </div>
                    
                </div>

                <h2 class="section-title">Quick Links</h2>

                <div class="quick-links">
                    <a href="<?php echo site_url('/customer-area/wallet/') ?>">My Wallet</a>
                    <a href="<?php echo site_url('/customer-area/buy-from-us/') ?>">Buy Crypto</a>
                    <a href="<?php echo site_url('/customer-area/sell-to-us/') ?>">Sell Crypto</a>
                    <a href="<?php echo site_url('/customer-area/rates/') ?>">Check Rates</a>
                    <a href="<?php echo site_url('/customer-area/announcements/') ?>">Announcements</a>
                    <a href="<?php echo esc_attr( esc_url( get_privacy_policy_url() ) ); ?>">Terms of Use</a>
                    
                </div>

                
                <div class="history-announcements-wrapper">

                    <div class="history-wrapper">
                        <h2 class="section-title">History</h2>

                        <div class="table-container">

                            <?php

                                if (empty($page_data['db_data']['orders'])){
                                    echo "<p>You haven't made any orders</p>"; 
                                } else {

                                    ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td>Type</td>
                                                    <td>Order</td>
                                                    <td>Asset</td>
                                                    <td>Quantity</td>
                                                    <td>Status</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    <?php

                                    foreach($page_data['db_data']['orders'] as $order){

                                        $asset_type = "eCurr.";

                                        if ($order->asset_type == 2){
                                            $asset_type = "Crypto";
                                        }

                                        $order_type = "Buy";

                                        if (isset($order->amount_to_recieve)){
                                            $order_type = "Sell";
                                        }

                                        $order_quantity = 0;

                                        if (isset($order->amount_to_recieve)){
                                            $order_quantity = $order->quantity_sold;
                                        } elseif (isset($order->fee)){
                                            $order_quantity = $order->quantity;
                                        }

                                        $order_status = "Pending";

                                        if ($order->order_status == 0){

                                            $order_status = "Declined";

                                        } elseif ($order->order_status == 2){

                                            $order_status = "Completed";

                                        }

                                        ?>

                                            <tr>
                                                <td><?php echo $asset_type ?></td>
                                                <td><?php echo $order_type ?></td>
                                                <td><?php echo hid_ex_m_get_asset_short_name($order->asset_type,$order->asset_id) ?></td>
                                                <td><?php echo number_format($order_quantity, 2) ?></td>
                                                <td><?php echo $order_status ?></td>
                                            </tr>

                                        <?php

                                    }

                                    ?>
                                        </tbody>
                                    </table>
                                    <a href="<?php echo site_url('/customer-area/history/') ?>"><span>Click Here to View Full History &#8594;</span></a>
                                    <?php

                                }
                            
                            ?>
                            
                        </div>

                    </div>

                    <div class="latest-announcements">
                        <h2 class="section-title">Latest Announcements</h2>

                        <div class="announcements-wrapper">

                            <?php
                                

                                if (empty($page_data['db_data']['announcements'])){
                                    echo "<p>No Announcements at this moment</p>";
                                } else {

                                    foreach($page_data['db_data']['announcements'] as $announcement){

                                        $body_text = $announcement->body;

                                        if (strlen($announcement->body) > 70){
                                            $body_text = substr($announcement->body , 0, 70) . " ...";
                                        }

                                        $headline = str_replace('\\','',$announcement->headline);

                                        $body = str_replace('\\','',$body_text);

                                        ?>
                                        
                                            <div class="single-announcement">
                                                <i class="fa-solid fa-bullhorn"></i>

                                                <div class="title-sub">
                                                    <h2><?php echo $headline ?></h2>
                                                    <span><?php echo $body ?>.</span>
                                                </div>

                                                <span class="announcement-CTA"><a href="<?php echo site_url('/customer-area/announcements/') ?>" style="text-decoration:none" >View &#8594;</a></span>
                                            </div>

                                        <?php

                                    }

                                    
                                }
                            ?>

                        
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Dashboard content area -->
        </div> 
    
    <?php

    hid_ex_m_exchange_client_area_footer();
}

function hid_ex_m_customer_area_sell_to_us( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        
        <div class="content-area">

            <div class="inner-content-area" id="hid_ex_m_sell_to_us">
                <h1 class="tab-title">Place a Sell Order</h1>

                <div class="order-wrapper">
                   <form action="" id="order-form">
                    <h2>Asset Details</h2>
                    <hr class="section-divider">
                    <div class="form-group">
                        <!-- <label for="asset-type">Asset Type</label> -->
                        <p class="label-paragraph">Asset Type</p>
                        <div class="asset-radio-buttons">
                            <label>
                                <input id="asset-btn-1" class="asset-btn-1" name="asset-type" type="radio" value="1"> eCurrency
                            </label>
                            <br>
                            <br>
                            <label>
                                <input id="asset-btn-2" class="asset-btn-2" name="asset-type" type="radio" value="2"> Crypto Currency
                            </label>
                            <p class="description">What type of asset do you want to sell?</p>

                        </div>
                    </div>
                    <div class="form-group" style="align-items: center;">
                        <!-- <label for="asset-type">Asset Type</label> -->
                        <p class="label-paragraph">Select Asset</p>

                        <div>
                            <select name="selected-asset" id="selected-asset">
                                <option rate="0" value="0">Select Asset</option>
                                <!-- <option value="2">Ethereum | ETH</option>
                                <option value="3">Payoneer | PNR</option> -->
                            </select>
                            <p class="description">Select the asset to sell</p>
                        </div>

                        

                    </div>

                    <h2>Amount</h2>
                    <hr class="section-divider">
                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Quantity</p>

                        <div>
                            <input type="text" name="quantity" id="quantity" >
                            <p class="description">What quantity do you want to purchase?</p>
                        </div>
                        

                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Fee</p>

                        <div>
                            <p class="label-paragraph" id="total-fee">0</p>
                            <p class="description">Exchange Rate - <span id="rate-value">0</span></p>
                        </div>
                    </div>

                    <h2>Payment</h2>
                    <hr class="section-divider">
                    <div class="form-group" >
                        <p class="label-paragraph">Sending Instructions</p>

                        <div>
                            <textarea id="sending-instructions" name="" cols="80" rows="5" disabled>-</textarea>
                            <p class="description">Follow this instructions to send us the Asset</p>
                        </div>

                    </div>

                    <!-- <div class="form-group" >
                        <p class="label-paragraph">Recieving Instructions</p>

                        <div>
                            <textarea id="recieving-instructions" name="" id="" cols="80" rows="5"></textarea>
                            <p class="description">Where should we credit you?</p>
                        </div>

                    </div> -->

                    <div class="form-group" >
                        <p class="label-paragraph">Proof of payment</p>

                        <div>
                            <div class="proof-upload">
                                <input type="file" name="screenshot" class="custom-file-input" id="custom-file-input" accept="image/png, image/jpg, image/jpeg"/>
                                <button id="upload-img">Upload Image</button>
                                <p id="image-name">-</p>
                            </div>
                            <p class="description">Upload a screenshot of proof of credit sent</p>
                        </div>

                    </div>

                    <input type="submit" name="submit" value="Place My Order">
                    <p id="error-message">Error</p>

                   </form>
                    
                </div>

                
            </div>
            <!-- End of History content area -->
        </div> 


    
    <?php

    hid_ex_m_exchange_client_area_footer();
}

function hid_ex_m_customer_area_history( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        
        <div class="content-area">

            <div class="inner-content-area">
                <h1 class="tab-title">Transactions History</h1>

                <div class="currency-rates-wrapper">

                    <?php
                        if (empty($page_data['db_data'])){
                            echo "<center><p>You haven't made any transactions</p></center>"; 
                        } else {
                            
                            ?>
                                <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <td style="width: 10%;">Order Type</td>
                                    <td style="width:15%;">Asset Type</td>
                                    <td style="width: 15%;">Asset</td>
                                    <td style="width: 15%;">Quantity</td>
                                    <td style="width: 15%;">Fee</td>
                                    <td style="width: 15%;">Rate</td>
                                    <td style="width: 15%;">Status</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                    foreach($page_data['db_data'] as $order){

                                        $asset_type = "eCurr.";

                                        if ($order->asset_type == 2){
                                            $asset_type = "Crypto";
                                        }

                                        $order_type = "Buy";

                                        if (isset($order->amount_to_recieve)){
                                            $order_type = "Sell";
                                        }

                                        $order_quantity = 0;
                                        $rate = 0;
                                        $money = 0;

                                        if (isset($order->amount_to_recieve)){

                                            $order_quantity = $order->quantity_sold;
                                            $rate = $order->amount_to_recieve / $order_quantity;
                                            $money = $order->amount_to_recieve;

                                        } elseif (isset($order->fee)){

                                            $order_quantity = $order->quantity;
                                            $rate = $order->fee / $order_quantity;
                                            $money = $order->fee;

                                        }

                                        $asset_display_name = hid_ex_m_get_asset_full_name($order->asset_type,$order->asset_id);

                                        $rate = round($rate, 2 );
                                        $money = round( $money, 2);

                                        $order_status = "Pending";

                                        if ($order->order_status == 0){

                                            $order_status = "Declined";

                                        } elseif ($order->order_status == 2){

                                            $order_status = "Completed";

                                        }

                                        $build_string = "<tr>";
                                        $build_string .= "<td>$order_type</td>";
                                        $build_string .= "<td>$asset_type</td>";
                                        $build_string .= "<td>$asset_display_name</td>";
                                        $build_string .= "<td>$order_quantity</td>";
                                        $build_string .= "<td>$money</td>";
                                        $build_string .= "<td>$rate</td>";
                                        $build_string .= "<td>$order_status</td>";
                                        $build_string .= "</tr>";

                                        echo $build_string;
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
            <!-- End of History content area -->
        </div> 


    
    <?php

    hid_ex_m_exchange_client_area_footer();
}

function hid_ex_m_customer_area_announcements( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        
        <div class="content-area">

            <div class="inner-content-area">
                <h1 class="tab-title">Announcements</h1>

                <div class="announcement-wrapper">

                    <?php
                        if (empty($page_data['db_data'])){
                            echo "<p>No Announcements at this moment</p>";
                        } else {

                            foreach($page_data['db_data'] as $announcement){

                                $headline = str_replace('\\','',$announcement->headline);

                                $body = str_replace('\\','',$announcement->body);

                                ?>
                                    <div class="single-anouncement">

                                        <h2 class="announcement-title"><?php echo $headline ?></h2>
                                        <span class="announcement-timestamp"><?php echo $announcement->headline ?></span>
                                        <p class="announcement-body"><?php echo $body ?></p>

                                        <p class="announcement-source">Announcement Published by <span>Admin</span></p>

                                    </div>

                                <?php

                            }

                            
                        }
                    ?>
                    
                </div>
                
            </div>
            <!-- End of Announcements content area -->
        </div> 
    
    <?php

    hid_ex_m_exchange_client_area_footer();
}

function hid_ex_m_customer_area_settings( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        <div class="content-area" id="hid_ex_m_settings">

            <div class="inner-content-area">
                <h1 class="tab-title">Settings</h1>

                <div class="order-wrapper">
                   <form class="user-profile-form" action="" id="order-form" method="POST">
                    <h2>User Profile</h2>
                    <hr class="section-divider">
                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">First Name</p>

                        <div>
                            <input type="hidden" name="user-id" value="<?php echo $page_data['current_user_id'] ?>">

                            <input type="text" name="first-name" id="first-name" value="<?php echo $page_data['current_first_name'] ?>">
                            <p class="description">Correct First Name?</p>
                        </div>
                        

                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Last Name</p>

                        <div>
                            <input type="text" name="last-name" id="last-name" value="<?php echo $page_data['current_last_name'] ?>">
                            <p class="description">Correct Last Name?</p>
                        </div>
                        

                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Phone Number</p>

                        <div>
                            <input type="text" name="phone-number" id="phone-number" value="<?php echo $page_data['current_user_phone'] ?>">
                            <p class="description">Phone Number</p>
                        </div>
                        

                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Email Address</p>

                        <div>
                            <input type="text" name="email" id="email" value="<?php echo $page_data['current_email'] ?>">
                            <p class="description">Enter correct eMail Address</p>
                        </div>
                        
                    </div>

                    <h2>Security Details</h2>
                    <hr class="section-divider">
                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Username</p>

                        <div>
                            <p class="label-paragraph"><?php echo $page_data['current_username'] ?></p>
                            <input type="hidden" name="username" value="<?php echo $page_data['current_username'] ?>">
                            <p class="description">Cannot Be Changed</p>
                        </div>
                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Password</p>

                        <div>
                            <input type="text" name="password" id="password">
                            <p class="description">Enter correct Password</p>
                        </div>
                        
                    </div>

                    <div class="form-group" style="align-items: center;">
                        <p class="label-paragraph">Re-Enter Password</p>

                        <div>
                            <input type="text" name="re-password" id="re-password">
                            <p class="description">Enter Password Again</p>
                        </div>
                        
                    </div>

                    <input type="submit" name="submit" value="Save">
                    <p id="error-message">Error</p>
                    <p id="success-message">Error</p>
                   </form>
                    
                </div>

                
            </div>
            <!-- End of History content area -->
        </div> 
    
    <?php

    hid_ex_m_exchange_client_area_footer();
}


function hid_ex_m_customer_area_support( $page_data ){

    hid_ex_m_exchange_client_area_header($page_data);

    ?>
        
        <div class="content-area">

            <div class="inner-content-area">
                <h1 class="tab-title">Support</h1>

                <div class="support-wrapper" id="hid_ex_m_support">

                    <div class="tickets-area">
                        <div class="tickets-div">
                            <div class="ticket-form">
                                <h2>Open a support ticket</h2>
                                <form method="post" action="" id="ticket-open-form">
                                    <input type="hidden" name="customer" value="<?php echo $page_data['current_user_id'] ?>">
                                    <input type="hidden" name="customer-name" value="<?php echo $page_data['current_user_display_name'] ?>">

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input id="ticket-title" name="ticket-title" type="text" for="title"> 
                                    </div>

                                    <div class="form-group" style="margin-top: 1rem;">
                                        <label for="details">Details</label>
                                        <textarea name="ticket-details" id="ticket-details" cols="30" rows="10"></textarea> 
                                    </div>

                                    <input type="submit" value="Open Ticket">
                                    <span id="error-msg">Error</span>
                                    <span id="success-msg">Error</span>
                                </form>

                            </div>

                            <div class="active-tickets">
                                <h2>Existing Tickets</h2>

                                <?php
                                    if (empty($page_data['db_data'])){
                                        echo "<p>You don't have any opened tickets at the moment</p>";
                                    } else {

                                        foreach($page_data['db_data'] as $ticket){

                                            $ticket_title = $ticket->title;
                                            
                                            $ticket_title = str_replace('\\','',$ticket_title);

                                            if (strlen($ticket_title) > 40){
                                                $ticket_title = substr($ticket_title , 0, 40) . " ...";
                                            }

                                            $ticket_details = $ticket->details;
                                            
                                            $ticket_details = str_replace('\\','',$ticket_details);

                                            if (strlen($ticket_details) > 100){
                                                $ticket_details = substr($ticket_details , 0, 100) . " ...";
                                            }

                                            $chat_url = site_url("/customer-area/support&tab=chat&id=$ticket->id");
                                            
                                            ?>
                                                <div class="single-active-ticket">
                                                    <h3><?php echo $ticket_title ?></h3>
                                                    <p><?php echo $ticket_details ?></p>
                                                    <span class="msg-open">
                                                        <span ticket='<?php echo $ticket->id ?>' class="open-support-chat"> Open Ticket &#8594;</span> | Requested by <?php echo $ticket->requester ?></span>
                                                </div>
                                            
                                            <?php
                                        }
                                    }
                                ?>                                

                            </div>
                            

                        </div>
                    </div>

                    <div class="chats-area" id="chats-area-box">
                        <div class="cancel-chat-icon">
                            <i class="fa-solid fa-xmark" id="chat-cancel-icon"></i>
                        </div>

                        <div class="chats-container">
                            <div class="chat-box" id="chat-box">
                                
                            </div>
                            
                        </div>

                        <div class="chat-form">
                            <form action="" id="send-new-chat">
                                <textarea name="new-chat-text" id="new-chat-text" cols="30" rows="10"></textarea>
                                <input type="hidden" name="sender" value="<?php echo $page_data['current_user_display_name'] ?>">

                                <div>
                                    <input type="submit" value="Send">
                                    <br>
                                    <input type="file" name="attach" class="custom-file-input" id="custom-file-input" accept="image/png, image/jpg, image/jpeg"/>
                                    <center><i style="margin-top: 0.5rem" class="fa-solid fa-file-arrow-up" id="new-chat-attach"></i></center>
                                    
                                </div>
                            </form>
                            <span id="attach-name" class=""></span>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <!-- End of Announcements content area -->
        </div> 


    <?php

    hid_ex_m_exchange_client_area_footer();
}