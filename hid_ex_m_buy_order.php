<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;


function hid_ex_m_buy_order_master_view(){

    if (isset( $_GET['tab']) && $_GET['tab'] == 'create-new'){

        hid_ex_m_buy_order_create_view();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'update-buy-order' )) {

        hid_ex_m_update_buy_order_view();

    } else{

        hid_ex_m_buy_order_archive();

    }
}

function hid_ex_m_buy_order_archive(){

    if ( isset($_GET['delete']) ) {

        $order_id = $_GET['delete'];

        hid_ex_m_delete_buy_order( $order_id );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=buy-orders-management');</script>";

    }


    ?>

        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Buy Orders Management</h2>
            <a href="<?php echo admin_url('admin.php?page=buy-orders-management&tab=create-new'); ?>" class="page-title-action">Create A New Buy Order</a>
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 10%>Customer Name</th>
                        <th width = 10%>Asset Type</th>
                        <th width = 20%>Asset</th>
                        <th width = 15%>Time</th>
                        <th width = 10%>Fee</th>
                        <th width = 10%>Quantity</th>
                        <th width = 10%>Order Status</th>
                        <th width = 15%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_orders = hid_ex_m_get_all_buy_orders();

                        if(! empty( $all_orders ) ){

                            foreach($all_orders as $order){

                                $update_url = admin_url("admin.php?page=buy-orders-management&tab=update-buy-order&id=$order->id");

                                $delete_url = admin_url("admin.php?page=buy-orders-management&delete=$order->id");

                                $customer_name = hid_ex_m_get_customer_data_name($order->customer_id);

                                $asset_type = hid_ex_m_get_asset_type($order->asset_type);

                                $order_status = hid_ex_m_get_order_status($order->order_status);

                                $asset_name = hid_ex_m_get_asset_name($order->asset_type,$order->asset_id);

                                $qty = floatval($order->quantity);

                                echo "<tr><td>$customer_name</td>";
                                echo "<td>$asset_type</td>";

                                echo "<td>$asset_name</td>";

                                echo "<td>$order->time_stamp</td>";

                                echo "<td>$order->fee</td>";

                                echo "<td>$qty</td>";

                                echo "<td>$order_status</td>";

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
                                <p>No Orders to display</p>
                            <?php
                        }
                    ?>
                </tbody>

            </table>
        </div>


    <?php
}

function hid_ex_m_buy_order_create_view(){

    if ( isset($_POST['new-submit']) ) {


        $data = array(
            'customer_id'           => $_POST['customer'],
            'asset_type'            => $_POST['asset-type'],
            'asset_id'              => $_POST['asset'],
            'quantity'              => (float)$_POST['quantity'],
            'fee'                   => (float)$_POST['hidden-fee'],
            'sending_instructions'   => $_POST['sending-instruction'],
            'proof_of_payment'      => $_POST['icon-media-id'],
            'order_status'          => $_POST['status']
        );


        hid_ex_m_create_new_buy_order( $data );



        echo "<script>location.replace('admin.php?page=buy-orders-management');</script>";

    }


    ?>
    <div class="create-new-assets-page wrap">

        <h1>Create New Buy Order</h1>

        <form action="" method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="name">Select Customer</label>
                        </th>
                        <td>


                            <?php
                                $all_customers = hid_ex_m_get_all_customers();


                                if(! empty( $all_customers ) ){

                                    $build_string = '<select name="customer" id="customer">';

                                    foreach($all_customers as $customer){

                                        $build_string .= '<option value=' . $customer->ID . ' >' . $customer->display_name . " " . ucfirst( $customer->user_nicename ) . '</option>';

                                    }

                                    $build_string .= '</select>';

                                    echo $build_string;

                                    ?>
                                        <p class="description">Who is making the order?</p>
                                    <?php

                                } else{
                                    ?>
                                    <p class="description">No Customers to Select From.<br>Create a new customer <a href="<?php echo admin_url('admin.php?page=customers-management&tab=create-new'); ?>">here</a></p>
                                    <?php
                                }

                            ?>
                        </td>
                    </tr>
                    <tr>

                        <th scope="row">
                            <label for="asset-type" class="seeat">Asset Type</label>
                        </th>
                        <td>

                        <label><input class="asset-btn-1" name="asset-type" type="radio" value="1"> eCurrency</label>
                        <br>
                        <br>
                        <label><input class="asset-btn-2" name="asset-type" type="radio" value="2"> Crypto Currency</label>
                        <br>
                        <br>
                        <p class="description">What type of currency is this order for?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="asset">Asset</label>
                        </th>
                        <td>
                        <select name="asset" id="select-asset">
                            <option value=0>Select Asset</option>
                        </select>
                        <input type="hidden" id="hidden-rate" name="hidden-rate" value=0>

                        <p class="description">What asset does the customer want to buy?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="quantity">Quantity</label>
                        </th>
                        <td>
                        <input name="quantity" type="text" id="quantity"  class="regular-text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" title="Only a decimal value is valid">
                        <p class="description">What quantity is the customer wiling to purchase?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="fee">Fee</label>
                        </th>
                        <td>
                        <p class="description" id="fee">0</p>
                        <input type="hidden" id="hidden-fee" name="hidden-fee">
                        <!-- <input name="fee" type="text" id="fee" value=0 class="regular-text" disabled> -->
                        <p class="description">The amount <strong>In Naira(#)</strong> at the rate of <strong><span id="rate-output">###</span></strong> the customer will pay. <br><strong>AutoUpdated</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="sending-instruction">Sending Instruction</label>
                        </th>
                        <td>
                            <textarea name="sending-instruction" class="regular-text" id="sending-instruction" cols="40" rows="5"></textarea>

                            <p class="description">How will your customer recieve the asset</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="icon">Proof of Payment</label>
                        </th>
                        <td>
                            <img id="asset-image-tag" style="display: block;">

                            <br>

                            <input type="hidden" id="icon-media-id" name="icon-media-id">
                            <input type="button" id="image-select-button" class="button" name="custom_image_data" value="Select Image">

                            <input type="button" id="image-delete-button" class="button" name="custom_image_data" value="Delete Image">

                            <p class="description">Proof of payment provided by customer</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="status">Status</label>
                        </th>
                        <td>
                            <select name="status" id="status">
                                <option value="0">Declined</option>
                                <option value="1" selected>Pending</option>
                                <option value="2">Completed</option>
                            </select>

                            <p class="description">Order Status</p>
                        </td>
                    </tr>



                </tbody>
            </table>
                <p class="submit">

                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Create New Order &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=buy-orders-management'); ?>" class="button">Cancel</a>

                </p>
        </form>


    </div>
    <?php
}

function hid_ex_m_update_buy_order_view(){

    if ( isset($_POST['new-submit']) ) {


        $data = array(
            'customer_id'           => $_POST['customer'],
            'asset_type'            => $_POST['asset-type'],
            'asset_id'              => $_POST['asset'],
            'quantity'              => (float)$_POST['quantity'],
            'fee'                   => (float)$_POST['hidden-fee'],
            'sending_instructions'   => $_POST['sending-instruction'],
            'proof_of_payment'      => $_POST['icon-media-id'],
            'order_status'          => $_POST['status']
        );

        $where = array(
            'id' => $_POST['id']
        );

        hid_ex_m_update_buy_order_data( $data, $where );


        echo "<script>location.replace('admin.php?page=buy-orders-management');</script>";

    }

    $order_id = $_GET['id'];

    $order_data = hid_ex_m_get_buy_order_data($order_id);

    $rate = $order_data->fee / $order_data->quantity;


    ?>
    <div class="create-new-assets-page wrap">

        <h1>Update Buy Order</h1>

        <form action="" method="post">
        <input type="hidden" id="id" name="id" value=<?php echo $order_data->id ?>>
        <input type="hidden" id="asset-type" name="asset-type" value=<?php echo $order_data->asset_type ?>>
        <input type="hidden" id="asset-id" name="asset-id" value=<?php echo $order_data->asset_id ?>>

            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="name">Select Customer</label>
                        </th>
                        <td>


                            <?php
                                $all_customers = hid_ex_m_get_all_customers();

                                if(! empty( $all_customers ) ){

                                    $build_string = '<select name="customer" id="customer">';

                                    foreach($all_customers as $customer){

                                        $build_string .= '<option value=' .$customer->ID;

                                        if ($customer->ID == $order_data->customer_id){
                                            $build_string .= " selected";
                                        }

                                        $build_string .= ' >' . $customer->display_name . " " . ucfirst( $customer->user_nicename ) . '</option>';

                                    }

                                    $build_string .= '</select>';

                                    echo $build_string;

                                    ?>
                                        <p class="description">Who is making the order?</p>
                                    <?php

                                } else{
                                    ?>
                                    <p class="description">No Customers to Select From.<br>Create a new customer <a href="<?php echo admin_url('admin.php?page=customers-management&tab=create-new'); ?>">here</a></p>
                                    <?php
                                }

                            ?>
                        </td>
                    </tr>
                    <tr>

                        <th scope="row">
                            <label for="asset-type" class="seeat">Asset Type</label>
                        </th>
                        <td>

                        <label><input class="asset-btn-1" name="asset-type" type="radio" value="1" <?php
                                if ($order_data->asset_type == 1){
                                    echo "checked";
                                }
                        ?>> eCurrency</label>
                        <br>
                        <br>
                        <label><input class="asset-btn-2" name="asset-type" type="radio" value="2" <?php
                                if ($order_data->asset_type == 2){
                                    echo "checked";
                                }
                        ?>> Crypto Currency</label>
                        <br>
                        <br>
                        <p class="description">What type of currency is this order for?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="asset">Asset</label>
                        </th>
                        <td>
                        <select name="asset" id="select-asset">
                            <option value=0>Select Asset</option>
                        </select>
                        <input type="hidden" id="hidden-rate" name="hidden-rate" value=<?php echo round($rate,2) ?>>

                        <p class="description">What asset does the customer want to buy?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="quantity">Quantity</label>
                        </th>
                        <td>
                        <input name="quantity" type="text" id="quantity"  class="regular-text" value=<?php echo $order_data->quantity ?> oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" title="Only a decimal value is valid">
                        <p class="description">What quantity is the customer wiling to purchase?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="fee">Fee</label>
                        </th>
                        <td>
                        <p class="description" id="fee"><?php echo $order_data->fee ?></p>
                        <input type="hidden" id="hidden-fee" name="hidden-fee" value=<?php echo round($order_data->fee, 2) ?>>

                        <p class="description">The amount <strong>In Naira(#)</strong> at the rate of <strong><span id="rate-output">###</span></strong> the customer will pay. <br><strong>AutoUpdated</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="sending-instruction">Sending Instruction</label>
                        </th>
                        <td>
                            <textarea name="sending-instruction" class="regular-text" id="sending-instruction" cols="40" rows="5"><?php echo str_replace('\\','', $order_data->sending_instructions) ?></textarea>
                            
                            <p class="description">How will your customer recieve the asset</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="icon">Proof of Payment</label>
                        </th>
                        <td>
                            <img id="asset-image-tag" style="display: block;max-width: 250px;max-height:250px" src="<?php echo wp_get_attachment_url($order_data->proof_of_payment) ?>">

                            <br>

                            <input type="hidden" id="icon-media-id" name="icon-media-id" value=<?php $order_data->proof_of_payment ?>>
                            <input type="button" id="image-select-button" class="button" name="custom_image_data" value="Select Image">

                            <input type="button" id="image-delete-button" class="button" name="custom_image_data" value="Delete Image">

                            <p class="description">Proof of payment provided by customer</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="status">Status</label>
                        </th>
                        <td>
                            <select name="status" id="status">
                                <option value="0" <?php
                                if ($order_data->order_status == 0){
                                    echo "selected";
                                }
                        ?>>Declined</option>
                                <option value="1" <?php
                                if ($order_data->order_status == 1){
                                    echo "selected";
                                }
                        ?>>Pending</option>
                                <option value="2" <?php
                                if ($order_data->order_status == 2){
                                    echo "selected";
                                }
                        ?>>Completed</option>
                            </select>

                            <p class="description">Order Status</p>
                        </td>
                    </tr>



                </tbody>
            </table>
                <p class="submit">

                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Update Order &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=buy-orders-management'); ?>" class="button">Cancel</a>

                </p>
        </form>


    </div>
    <?php
}
