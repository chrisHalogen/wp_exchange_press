<?php
    $page_name = get_query_var('customer_page_name');

    // Get user Details
    $current_user = wp_get_current_user();
    
    if ( strtolower($page_name) == 'dashboard' ){

        $page_data = array(
            'title'     => 'Dashboard | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_dashboard_data($current_user->ID)
        );

        hid_ex_m_customer_dashboard( $page_data );

    }  elseif ( strtolower($page_name) == 'sell-to-us' ) {
        
        $page_data = array(
            'title'     => 'Sell To Us | Luxtrade',
            'name'      => strtolower($page_name),
            'current_user_id'   => $current_user->ID,
            'current_user_display_name' => $current_user->display_name,
            'db_data'       => hid_ex_m_get_dashboard_data($current_user->ID)
        );

        hid_ex_m_customer_area_sell_to_us( $page_data );

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
                        <span>#<?php echo $page_data['db_data']['total_bought'] ?></span>
                        <p>Total Bought</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-rotate"></i>
                        <span><?php echo $page_data['db_data']['total_transactions'] ?></span>
                        <p>Total Transactions</p>
                    </div>
                    <div class="summary-card">
                        <i class="fa-solid fa-wallet"></i>
                        <span>#<?php echo $page_data['db_data']['pending_payments'] ?></span>
                        <p>Pending Payments</p>
                    </div>
                    
                </div>

                <h2 class="section-title">Quick Links</h2>

                <div class="quick-links">
                    <a href="<?php echo site_url('/customer-area/buy-from-us/') ?>">Buy Crypto</a>
                    <a href="<?php echo site_url('/customer-area/sell-to-us/') ?>">Sell Crypto</a>
                    <a href="<?php echo site_url('/customer-area/rates/') ?>">Check Rates</a>
                    <a href="<?php echo site_url('/customer-area/announcements/') ?>">Announcements</a>
                    <a href="<?php echo site_url('/privacy-policy/') ?>">Terms of Use</a>
                    
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
                            <textarea id="sending-instructions" name="" id="" cols="80" rows="5" disabled>-</textarea>
                            <p class="description">Follow this instructions to send us the Asset</p>
                        </div>

                    </div>

                    <div class="form-group" >
                        <p class="label-paragraph">Recieving Instructions</p>

                        <div>
                            <textarea id="recieving-instructions" name="" id="" cols="80" rows="5"></textarea>
                            <p class="description">Where should we credit you?</p>
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