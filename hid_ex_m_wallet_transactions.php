<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;

function hid_ex_m_wallet_master_view(){

    if ( isset($_GET['tab']) && ( $_GET['tab'] == 'customers' )) {

        hid_ex_m_customers_wallet_details();

    } else if ( isset($_GET['tab']) && ( $_GET['tab'] == 'withdrawals' )) {

        hid_ex_m_wallet_withdrawals();

    } else if ( isset($_GET['tab']) && ( $_GET['tab'] == 'deposits' )) {

        hid_ex_m_wallet_deposits();

    } else {

        hid_ex_m_wallet_master_home();

    }

}

function hid_ex_m_wallet_deposits(){

    if ( isset($_GET['action']) ) {

        $transaction_id = $_GET['id'];

        $action = $_GET['action'];

        $transaction = hid_ex_m_get_wallet_transaction_data( $transaction_id );

        $customer = $transaction->customer_id;

        $old_balance = hid_ex_m_get_account_balance($customer);

        echo "<br><br>";

        if ($action == $transaction->transaction_status){

            echo "<span><strong>Target transaction status same as old</strong></span>";

        } else if ($action == 2){

            $new_balance = $old_balance + $transaction->amount;

            update_user_meta($customer, 'account_balance',$new_balance);

            hid_ex_m_update_transaction_status( $action, $transaction_id );

            echo "<span><strong>Status Updated Successfully<br>Account Balance Updated successfully</strong></span>";

            

        } else if ($transaction->transaction_status == 2){

            $new_balance = $old_balance - $transaction->amount;

            update_user_meta($customer, 'account_balance',$new_balance);

            hid_ex_m_update_transaction_status( $action, $transaction_id );

            echo "<span><strong>Status Updated Successfully</strong></span>";

        } else {

            hid_ex_m_update_transaction_status( $action, $transaction_id );

            echo "<span><strong>Status Updated Successfully</strong></span>";
        }

        echo "<script>location.replace('admin.php?page=wallet-management&tab=deposits');</script>";

    }

    $all_deposits = hid_ex_m_get_all_deposits();

    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Deposit Requests</h2>
            
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 15%>Customer</th>
                        <th width = 15%>Time</th>
                        <th width = 10%>Amount</th>
                        <th width = 25%>Details</th>
                        <th width = 20%>Proof of Payment</th>
                        <th width = 15%>Change Status?</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                        if(! empty( $all_deposits ) ){

                            foreach($all_deposits as $transaction){

                                $customer = hid_ex_m_get_customer_data_name($transaction->customer_id);

                                $time = $transaction->time_stamp;

                                $amount = $transaction->amount;

                                $details = $transaction->details;

                                $cap = 55;

                                if ( strlen($details) > $cap ) {

                                    $details = substr($details,0,$cap) . " ...";
                                }

                                $proof_url = wp_get_attachment_url($transaction->proof_of_payment);
                                
                                $status = $transaction->transaction_status;

                                $decline_url = admin_url("admin.php?page=wallet-management&tab=deposits&action=0&id=$transaction->id");

                                $pending_url = admin_url("admin.php?page=wallet-management&tab=deposits&action=1&id=$transaction->id");

                                $completed_url = admin_url("admin.php?page=wallet-management&tab=deposits&action=2&id=$transaction->id");


                                echo "<tr><td>$customer</td>";

                                echo "<td>$time</td>";

                                echo "<td># $amount</td>";

                                echo "<td>$details</td>";

                                echo "<td><a href='$proof_url' target='_blank'>View Proof of Payment</a></td>";

                                echo "<td>";

                                if ($status != 0){
                                    echo "<a href='$decline_url'> <button>Decline</button></a>";
                                }

                                if ($status != 1){
                                    echo "<a href='$pending_url'> <button>Pending</button></a>";
                                }

                                if ($status != 2){
                                    echo "<a href='$completed_url'> <button>Approved</button></a>";
                                }

                                echo "</td>";

                                
                            }

                        } else {
                            ?>
                                <p>No Deposit Transactions to display</p>
                            <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>

    <?php
}

function hid_ex_m_wallet_withdrawals(){

    if ( isset($_GET['action']) ) {

        $transaction_id = $_GET['id'];

        $action = $_GET['action'];

        $transaction = hid_ex_m_get_wallet_transaction_data( $transaction_id );

        $customer = $transaction->customer_id;

        $old_balance = hid_ex_m_get_account_balance($customer);

        echo "<br><br>";

        if ($action == $transaction->transaction_status){

            echo "<span><strong>Target transaction status same as old</strong></span>";

        } else if ($action == 2){

            if ($old_balance > $transaction->amount){

                $new_balance = $old_balance - $transaction->amount;

                update_user_meta($customer, 'account_balance',$new_balance);

                hid_ex_m_update_transaction_status( $action, $transaction_id );

                echo "<span><strong>Status Updated Successfully<br>Account Balance Updated successfully</strong></span>";

            } else {

                echo "<span><strong>Insufficient Balance</strong></span>";

            }

        } else if ($transaction->transaction_status == 2){

            $new_balance = $old_balance + $transaction->amount;

            update_user_meta($customer, 'account_balance',$new_balance);

            hid_ex_m_update_transaction_status( $action, $transaction_id );

            echo "<span><strong>Status Updated Successfully</strong></span>";

        } else {

            hid_ex_m_update_transaction_status( $action, $transaction_id );

            echo "<span><strong>Status Updated Successfully</strong></span>";
        }

        // update_user_meta($customer_id, 'can_withdraw', 1 );

        echo "<script>location.replace('admin.php?page=wallet-management&tab=withdrawals');</script>";

    }

    $all_withdrawals = hid_ex_m_get_all_withdrawals();

    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Withdrawal Requests</h2>
            
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 15%>Customer</th>
                        <th width = 15%>Time</th>
                        <th width = 10%>Amount</th>
                        <th width = 20%>Details</th>
                        <th width = 25%>Instructions</th>
                        <th width = 15%>Change Status?</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                        if(! empty( $all_withdrawals ) ){

                            foreach($all_withdrawals as $transaction){

                                $customer = hid_ex_m_get_customer_data_name($transaction->customer_id);

                                $time = $transaction->time_stamp;

                                $amount = $transaction->amount;

                                $details = $transaction->details;

                                $cap = 55;

                                if ( strlen($details) > $cap ) {

                                    $details = substr($details,0,$cap) . " ...";
                                }

                                $instruction = $transaction->sending_instructions;

                                $status = $transaction->transaction_status;

                                $decline_url = admin_url("admin.php?page=wallet-management&tab=withdrawals&action=0&id=$transaction->id");

                                $pending_url = admin_url("admin.php?page=wallet-management&tab=withdrawals&action=1&id=$transaction->id");

                                $completed_url = admin_url("admin.php?page=wallet-management&tab=withdrawals&action=2&id=$transaction->id");


                                echo "<tr><td>$customer</td>";
                                echo "<td>$time</td>";

                                echo "<td># $amount</td>";

                                echo "<td>$details</td>";

                                echo "<td>$instruction</td>";

                                echo "<td>";

                                if ($status != 0){
                                    echo "<a href='$decline_url'> <button>Decline</button></a>";
                                }

                                if ($status != 1){
                                    echo "<a href='$pending_url'> <button>Pending</button></a>";
                                }

                                if ($status != 2){
                                    echo "<a href='$completed_url'> <button>Approved</button></a>";
                                }

                                echo "</td>";

                                
                            }

                        } else {
                            ?>
                                <p>No Withdrawals Transactions to display</p>
                            <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>

    <?php
}

function hid_ex_m_wallet_master_home(){

    if ( isset($_POST['submit-bank']) ) {

        hid_ex_m_update_wallet_bank( $_POST['local-bank'] );

    }

    $page_data = hid_ex_m_get_admin_wallet_page_data();

    ?>
    
        <div class="wrap wallets-management">
            <h2>Wallets Management</h2>

            <div class="head-info-area">
                <div class="info-card">
                    <span class="figure"><?php echo $page_data['total_customers'] ?></span>
                    <span class="figure-description">Registered Customers</span>
                </div>
                <div class="info-card">
                    <span class="figure"><?php echo $page_data['total_pending'] ?></span>
                    <span class="figure-description">Pending Transactions</span>
                </div>
                <div class="info-card">
                    <span class="figure"><?php echo $page_data['total_declined'] ?></span>
                    <span class="figure-description">Declined Transactions</span>
                </div>
                <div class="info-card">
                    <span class="figure"><?php echo $page_data['percentage_completed'] ?></span>
                    <span class="figure-description">% Completed Transactions</span>
                </div>
            </div>

            <div class="cta-section">

                <?php
                
                    $all_banks = hid_ex_m_get_all_banks();

                    if ( empty($all_banks) ){
                        ?>
                            <center>
                                <span>There are no local bank accounts to choose from.<br>Create Local Bank Accounts <a href="<?php echo admin_url('admin.php?page=e-currency-management&tab=local-banks'); ?>">Here</a></span>
                            </center>
                        <?php

                    } else {
                        ?>
                            
                            <div class="select-bank">
                                <p>Select the Local Bank account to be used for funding wallets</p>
                                <form action="" method="POST">
                                    <select name="local-bank" id="local-bank">

                                        <?php
                                        
                                            foreach ($all_banks as $bank){

                                                $bank_id = $bank->id;
                                                $bank_display_name = $bank->display_name;

                                                $selected = "";

                                                if (get_option('wallet_local_bank')){

                                                    $prev = get_option('wallet_local_bank');

                                                    if ($prev == $bank_id){
                                                        $selected = "selected";
                                                    }

                                                }

                                                echo "<option value=$bank_id $selected>$bank_display_name</option>";
                                            }
                                        
                                        ?>

                                    </select>

                                    <input class="button button-primary" type="submit" value="Submit" name="submit-bank" id="submit-bank">
                                </form>
                            </div>
                        
                        <?php
                    }
                
                ?>
                
                
                <div class="withdrawal-deposit-btn">
                    <a class="button button-primary" href="<?php echo admin_url("admin.php?page=wallet-management&tab=customers"); ?>">View all Customers</a>
                    <a class="button button-primary" href="<?php echo admin_url("admin.php?page=wallet-management&tab=withdrawals"); ?>">View all Withdrawals</a>
                    <a class="button button-primary" href="<?php echo admin_url("admin.php?page=wallet-management&tab=deposits"); ?>">View all Deposits</a>
                </div>
            </div>

            <div class="customers-info-section">
                <div class="customers-section">

                    <?php

                        $top_10_customers = $page_data['top_10_customers'];
                    
                        if (empty($top_10_customers)){


                            ?>
                            
                                <span class="customers-info-title">No Customers Found</span>
                                <hr>
                            
                            <?php


                        } else {

                            ?>
                            
                            <span class="customers-info-title">Top 10 Customers</span>

                            <hr>

                            <?php
                            
                                foreach ($top_10_customers as $customer) {

                                    $first_name = $customer->data->display_name;

                                    $last_name = ucfirst( $customer->data->user_nicename );

                                    $account_balance = $customer->data->account_balance;

                                    echo "<div class='user-balance'><p>$first_name $last_name</p><p>#$account_balance</p></div>";
                                    
                                }
                            
                            ?>

                            
                            <?php

                        }
                    
                    ?>
                    

                </div>

                <div class="customers-section">
                    <span class="customers-info-title">General Wallet Info</span>

                    <hr>

                    <div class="user-balance">
                        <p>Total amount in all Wallets</p>
                        <p>#<?php echo $page_data['total_in_wallet'] ?></p>
                    </div>
                    <div class="user-balance">
                        <p>Total Approved Deposit - last 30 days</p>
                        <p>#<?php echo $page_data['credit_30_days'] ?></p>
                    </div>
                    <div class="user-balance">
                        <p>Total Approved Withdrawal - last 30 days</p>
                        <p>#<?php echo $page_data['debit_30_days'] ?></p>
                    </div>
                    <div class="user-balance">
                        <p>All time Total Approved Withdrawal</p>
                        <p>#<?php echo $page_data['total_approved_credit'] ?></p>
                    </div>
                    <div class="user-balance">
                        <p>All time Total Approved Deposits</p>
                        <p>#<?php echo $page_data['total_approved_debit'] ?></p>
                    </div>
                    
                </div>
            </div>

        </div>
    
    <?php

}

function hid_ex_m_customers_wallet_details(){

    if ( isset($_GET['enable-withdrawal']) ) {

        $customer_id = $_GET['enable-withdrawal'];

        update_user_meta($customer_id, 'can_withdraw', 1 );

        echo "<script>location.replace('admin.php?page=wallet-management&tab=customers');</script>";

    }

    if ( isset($_GET['disable-withdrawal']) ) {

        $customer_id = $_GET['disable-withdrawal'];

        update_user_meta($customer_id, 'can_withdraw', 0 );

        echo "<script>location.replace('admin.php?page=wallet-management&tab=customers');</script>";

    }


    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Customers Wallet Management</h2>
            
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 30%>Full Name</th>
                        <th width = 15%>Account Balance</th>
                        <th width = 15%>Approved Deposits</th>
                        <th width = 15%>Approved Withdrawals</th>
                        <th width = 25%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_customers = hid_ex_m_get_all_customers();


                        if(! empty( $all_customers ) ){

                            foreach($all_customers as $customer){

                                $bal = hid_ex_m_get_account_balance($customer->ID);

                                $deposits = hid_ex_m_get_customer_approved_transactions($customer->ID, 1);

                                $withdrawals = hid_ex_m_get_customer_approved_transactions($customer->ID, 2);

                                $can_withdraw = hid_ex_m_get_withdrawal_status($customer->ID);

                                $enable_url = admin_url("admin.php?page=wallet-management&tab=customers&enable-withdrawal=$customer->ID");

                                $disable_url = admin_url("admin.php?page=wallet-management&tab=customers&disable-withdrawal=$customer->ID");

                                $first_name = $customer->data->display_name;

                                $last_name = ucfirst( $customer->data->user_nicename );


                                echo "<tr><td>$first_name $last_name</td>";
                                echo "<td># $bal</td>";

                                echo "<td># $deposits</td>";

                                echo "<td># $withdrawals</td>";

                                if ($can_withdraw == 1){

                                    echo "<td><a href='$disable_url'> <button>Disable Withdrawals</button></a></td></tr>";

                                } else {

                                    echo "<td><a href='$enable_url'> <button>Enable Withdrawals</button></a></td></tr>";

                                }

                                
                            }

                        } else {
                            ?>
                                <p>No Customers to display</p>
                            <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>

    <?php
}