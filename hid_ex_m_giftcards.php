<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

function hid_ex_m_giftcards_master_view(){

    if ( isset($_GET['tab']) && ( $_GET['tab'] == 'create-new' )) {

        hid_ex_m_create_new_giftcard_view();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'update-giftcard' )) {

        hid_ex_m_update_giftcard_view();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'giftcard-orders' )) {

        hid_ex_m_giftcard_orders_view();

    } else {

        hid_ex_m_giftcards_management();

    }
}

function hid_ex_m_giftcard_orders_view(){

    if ( isset($_GET['delete']) ) {

        $order_id = $_GET['delete'];

        hid_ex_m_delete_giftcard_order( $order_id );

        echo "<script>location.replace('admin.php?page=giftcard-management&tab=giftcard-orders');</script>";

    }

    if ( isset($_GET['decline']) ) {

        $order_id = $_GET['decline'];

        $transaction = hid_ex_m_get_giftcard_order_data( $order_id );

        $customer = $transaction->customer_id;

        $old_balance = hid_ex_m_get_account_balance($customer);

        $where = array(
            'id' => $_GET['decline']
        );

        if ( $transaction->order_status == 2 ){

            $new_balance = $old_balance - $transaction->price;

            update_user_meta($customer, 'account_balance',$new_balance);

            echo "<span><strong>User account debited successfully<br></strong></span>";

        }

        hid_ex_m_mark_giftcard_as_declined( $where );

        echo "<span><strong>Status Updated Successfully</strong></span>";

        echo "<script>location.replace('admin.php?page=giftcard-management&tab=giftcard-orders');</script>";

    }

    if ( isset($_GET['pending']) ) {

        $order_id = $_GET['pending'];

        $transaction = hid_ex_m_get_giftcard_order_data( $order_id );

        $customer = $transaction->customer_id;

        $old_balance = hid_ex_m_get_account_balance($customer);

        $where = array(
            'id' => $_GET['pending']
        );

        if ( $transaction->order_status == 2 ){

            $new_balance = $old_balance - $transaction->price;

            update_user_meta($customer, 'account_balance',$new_balance);

            echo "<span><strong>User account debited successfully<br></strong></span>";

        }

        hid_ex_m_mark_giftcard_as_pending( $where );

        echo "<span><strong>Status Updated Successfully</strong></span>";

        echo "<script>location.replace('admin.php?page=giftcard-management&tab=giftcard-orders');</script>";

    }

    if ( isset($_GET['approve']) ) {

        $order_id = $_GET['approve'];

        $transaction = hid_ex_m_get_giftcard_order_data( $order_id );

        $customer = $transaction->customer_id;

        $old_balance = hid_ex_m_get_account_balance($customer);

        $where = array(
            'id' => $_GET['approve']
        );

        if ( $transaction->order_status != 2 ){

            $new_balance = $old_balance + $transaction->price;

            update_user_meta($customer, 'account_balance',$new_balance);

            echo "<span><strong>User account credited successfully<br></strong></span>";

        }

        hid_ex_m_mark_giftcard_as_approve( $where );

        echo "<span><strong>Status Updated Successfully</strong></span>";

        echo "<script>location.replace('admin.php?page=giftcard-management&tab=giftcard-orders');</script>";

    }

    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Assets Management</h2>
            <a href="<?php echo admin_url('admin.php?page=giftcard-management&tab=create-new'); ?>" class="page-title-action">Add New Gift Card</a>
            <a href="<?php echo admin_url('admin.php?page=giftcard-management'); ?>" class="page-title-action">Manage Giftcards</a>
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 15%>Customer Name</th>
                        <th width = 15%>Time Stamp</th>
                        <th width = 10%>Asset Name</th>
                        <th width = 10%>Gift Card</th>
                        <th width = 7.5%>Quantity</th>
                        <th width = 7.5%>Price</th>
                        <th width = 7.5%>Proof</th>
                        <th width = 27.5%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_orders = hid_ex_m_get_all_giftcard_orders();

                        if(! empty( $all_orders ) ){

                            foreach($all_orders as $order){
                                write_log($order);

                                $delete_url = admin_url("admin.php?page=giftcard-management&tab=giftcard-orders&delete=$order->id");

                                $customer = hid_ex_m_get_customer_data_name($order->customer_id);

                                $asset = hid_ex_m_get_giftcard_data( $order->asset_id );

                                echo "<tr><td>$customer</td>";

                                echo "<td>$order->time_stamp</td>";

                                echo "<td>$asset->name</td>";

                                echo "<td><img src='" . wp_get_attachment_url( $asset->icon ) . "' alt='' style='max-width: 50px; max-height: 50px;'></td>";

                                $quantity = floatval($order->quantity);
                                
                                echo "<td>$quantity</td>";

                                $price = floatval($order->price);
                                
                                echo "<td>$price</td>";

                                $proof_url = wp_get_attachment_url( $order->card_picture );

                                echo "<td><a href='$proof_url' target='_blank'>View Card</a></td><td>";

                                $order_status = $order->order_status;

                                $mark_decline = admin_url("admin.php?page=giftcard-management&tab=giftcard-orders&decline=$order->id");

                                $mark_pending = admin_url("admin.php?page=giftcard-management&tab=giftcard-orders&pending=$order->id");

                                $mark_approved = admin_url("admin.php?page=giftcard-management&tab=giftcard-orders&approve=$order->id");

                                if (!($order_status == 0)){
                                    echo "<a href='$mark_decline' style='margin:4px'><button>Decline</button></a>";
                                }

                                if (!($order_status == 1)){
                                    echo "<a href='$mark_pending' style='margin:4px'><button>Mark as Pending</button></a>";
                                }

                                if (!($order_status == 2)){
                                    echo "<a href='$mark_approved'  style='margin:4px'><button>Approve</button></a>";
                                }

                                echo "<a href='$delete_url'><button>Delete</button></a>";
                                
                                echo "</td></tr>";
                            }

                        } else {
                            ?>
                                <p>No assets to display</p>
                            <?php
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>

    <?php
}


function hid_ex_m_giftcards_management(){

    if ( isset($_GET['delete']) ) {

        $asset_id = $_GET['delete'];

        hid_ex_m_delete_giftcard( $asset_id );

        echo "<script>location.replace('admin.php?page=giftcard-management');</script>";

    }

    
    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Assets Management</h2>
            <a href="<?php echo admin_url('admin.php?page=giftcard-management&tab=create-new'); ?>" class="page-title-action">Add New Gift Card</a>
            <a href="<?php echo admin_url('admin.php?page=giftcard-management&tab=giftcard-orders'); ?>" class="page-title-action">Manage Giftcard Orders</a>
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 30%>Asset Name</th>
                        <th width = 15%>Short Name</th>
                        <th width = 15%>Icon</th>
                        <th width = 15%>Buying Price</th>
                        <th width = 25%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_assets = hid_ex_m_get_all_giftcards();

                        if(! empty( $all_assets ) ){

                            foreach($all_assets as $asset){

                                $update_url = admin_url("admin.php?page=giftcard-management&tab=update-giftcard&id=$asset->id");

                                $delete_url = admin_url("admin.php?page=giftcard-management&delete=$asset->id");

                                echo "<tr><td>$asset->name</td>";
                                echo "<td>$asset->short_name</td>";

                                echo "<td><img src='" . wp_get_attachment_url( $asset->icon ) . "' alt='' style='max-width: 50px; max-height: 50px;'></td>";

                                $buying_price = floatval($asset->buying_price);
                                
                                echo "<td>$buying_price</td>";

                                echo "<td><a href='$update_url'>
                                            <button>Update</button>
                                        </a>
                                        <a href='$delete_url'>
                                            <button>Delete</button>
                                        </a>
                                    </td></tr>";
                            }

                        } else {
                            ?>
                                <p>No assets to display</p>
                            <?php
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>

    <?php
}

function hid_ex_m_create_new_giftcard_view(){

    if ( isset($_POST['new-asset-submit']) ) {

        $data = array(
            'name'                  => $_POST['name'],
            'short_name'            => $_POST['short-name'],
            'icon'                  => $_POST['icon-media-id'],
            'buying_price'          => (float)$_POST['buying-price'],
        );

        hid_ex_m_create_new_giftcard( $data );

        echo "<script>location.replace('admin.php?page=giftcard-management');</script>";

    }

    ?>
        <div class="create-new-assets-page wrap">
            <h1>Create New Giftcard</h1>

            <form action="" method="post">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="name">Name</label>
                            </th>
                            <td>
                            <input name="name" type="text" id="name" class="regular-text" >
                            <p class="description">This will be the full name of the asset</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="short-name">Short Name</label>
                            </th>
                            <td>
                            <input name="short-name" maxlength = "5" type="text" id="short-name" class="regular-text" >
                            <p class="description">This is the short abbrevation of the asset e.g USD, GBP</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="icon">Icon</label>
                            </th>
                            <td>
                                <img id="asset-image-tag" style="display: block;">
                                <br>
                                
                                <input type="hidden" id="icon-media-id" name="icon-media-id">
                                <input type="button" id="image-select-button" class="button" name="custom_image_data" value="Choose Icon"> 
                                
                                <input type="button" id="image-delete-button" class="button" name="custom_image_data" value="Delete Icon">

                                <p class="description">This will be the display Icon for this asset</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="buying-price">Buying Price</label>
                            </th>
                            <td>
                            <input name="buying-price" type="text" id="buying-price" class="regular-text"  pattern="[+-]?([1-9]\d*(\.\d*[1-9])?|0\.\d*[1-9]+)|\d+(\.\d*[1-9])?" title="Only a decimal value is valid">
                            <p class="description">How much are you willing to buy this asset from your customers?</p>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            
                <p class="submit">
                    
                    <button type="submit" name="new-asset-submit" id="new-asset-submit" class="button button-primary">Publish New Giftcard &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=giftcard-management'); ?>" class="button">Cancel</a>
                    
                </p>
            </form>
        </div>
    <?php
}

function hid_ex_m_update_giftcard_view(){

    if ( isset($_POST['update-asset-submit']) ) {

        $data = array(
            'name'                  => $_POST['name'],
            'short_name'            => $_POST['short-name'],
            'icon'                  => $_POST['icon-media-id'],
            'buying_price'          => (float)$_POST['buying-price'],
        );

        $where = array(
            'id' => $_POST['asset-id']
        );

        hid_ex_m_update_giftcard_data( $data, $where );

        echo "<script>location.replace('admin.php?page=giftcard-management');</script>";

    }

    $asset_id = $_GET['id'];

    $asset_data = hid_ex_m_get_giftcard_data( $asset_id );

    ?>
        <div class="create-new-assets-page wrap">
            <h1>Update <?php echo $asset_data->name ?></h1>

            <form action="" method="post">

                <input type="hidden" id="asset-id" name="asset-id" value=<?php echo $asset_data->id ?>>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="name">Name</label>
                            </th>
                            <td>
                            <input name="name" type="text" id="name" class="regular-text" value="<?php echo $asset_data->name ?>">
                            <p class="description">This will be the full name of the asset</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="short-name">Short Name</label>
                            </th>
                            <td>
                            <input name="short-name" maxlength = "5" type="text" id="short-name" class="regular-text" value="<?php echo $asset_data->short_name ?>">
                            <p class="description">This is the short abbrevation of the asset e.g USD, GBP</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="icon">Icon</label>
                            </th>
                            <td>
                                <img id="asset-image-tag" style="display: block;max-width:200px;max-height:200px;" src="<?php echo wp_get_attachment_url( $asset_data->icon ) ?>">
                                <br>
                                
                                <input type="hidden" id="icon-media-id" name="icon-media-id" value="<?php echo $asset_data->icon ?>">
                                <input type="button" id="image-select-button" class="button" name="custom_image_data" value="Choose Icon"> 
                                
                                <input type="button" id="image-delete-button" class="button" name="custom_image_data" value="Delete Icon">

                                <p class="description">This will be the display Icon for this asset</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="buying-price">Buying Price</label>
                            </th>
                            <td>
                            <input name="buying-price" type="text" id="buying-price" value="<?php echo $asset_data->buying_price ?>" class="regular-text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" title="Only a decimal value is valid">
                            <p class="description">How much are you willing to buy this asset from your customers?</p>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th scope="row">
                                <label for="selling-price">Selling Price</label>
                            </th>
                            <td>
                            <input name="selling-price" type="text" id="selling-price" value="<?php echo $asset_data->selling_price ?>" class="regular-text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" title="Only a decimal value is valid">
                            <p class="description">How much are you willing to buy this asset from your customers?</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="wallet-address">Associated Wallet Address</label>
                            </th>
                            <td>
                            <input name="wallet-address" type="text" id="wallet-address" class="regular-text" value="<?php echo $asset_data->wallet_address ?>" >    
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="local-bank">Associated Local Bank</label>
                            </th>
                            <td>
                            
                                <?php 
                                    $all_banks = hid_ex_m_get_all_banks();

                                    if(! empty( $all_banks ) ){
                                        echo '<select name="local-bank" id="local-bank">';

                                        foreach($all_banks as $bank){
                                            $build_option = "<option value='$bank->id'";

                                            if ($bank->id == $asset_data->associated_local_bank){
                                                $build_option .= " selected";
                                            }
                                            
                                            $build_option .= ' >' . $bank->display_name . '</option>';

                                            echo $build_option;
                                        }

                                        echo '</select>';

                                    } else {
                                        ?>
                                           <p>No local banks Available<a href="<?php echo admin_url('admin.php?page=e-currency-management&tab=local-banks'); ?>">Click Here</a> to add one</p> 
                                        <?php 
                                    }

                                ?>
                                </select>
                            <p class="description">Select the Local Bank Account that will be associated with this Crypto Currency</p>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            
                <p class="submit">
                    
                    <button type="submit" name="update-asset-submit" id="update-asset-submit" class="button button-primary">Update Asset &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=giftcard-management'); ?>" class="button">Cancel</a>
                    
                </p>
            </form>
        </div>
    <?php
}