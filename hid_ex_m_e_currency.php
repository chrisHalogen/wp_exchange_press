<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

function hid_ex_m_e_currency_management(){

    if ( isset($_GET['tab']) && ( $_GET['tab'] == 'local-banks' )) {

        hid_ex_m_local_banks();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'create-new' )) {

        hid_ex_m_create_new_e_currency();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'update-e-currency' )) {

        hid_ex_m_update_e_currency();

    } else {

        hid_ex_m_assets_management();

    }
}

/* Local Bank Functions */
// Archive Function
function hid_ex_m_local_banks(){

    if ( isset($_POST['newsubmit']) ) {

        $data = array(
            'display_name'           => $_POST['new-display-name'],
            'bank_name'              => $_POST['new-bank-name'],
            'bank_account_name'      => $_POST['new-bank-account-name'],
            'bank_account_number'    => $_POST['new-bank-account-number']
        );

        hid_ex_m_create_new_local_bank( $data );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=e-currency-management&tab=local-banks');</script>";

    }


    if ( isset($_POST['uptsubmit']) ) {

        $data = array(
            'display_name'          =>  $_POST['upt-display-name'],
            'bank_name'             =>  $_POST['upt-bank-name'],
            'bank_account_name'     =>  $_POST['upt-bank-account-name'],
            'bank_account_number'   =>  $_POST['upt-bank-account-number']
        );

        
        $where = array( 'id'=>(int)$_POST['upt-id'] );       

        hid_ex_m_update_local_bank( $data, $where );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=e-currency-management&tab=local-banks');</script>";

    }

    if ( isset($_GET['delete']) ) {

        $bank_id = $_GET['delete'];

        hid_ex_m_delete_local_bank( $bank_id );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=e-currency-management&tab=local-banks');</script>";

    }


    ?>
        <div class="local-banks-page wrap">
            <h2>Local Banks</h2>
            <p class="cta"><a href="<?php echo admin_url('admin.php?page=e-currency-management'); ?>">Click Here</a> to go to eCurrency Management</p>
            <p class="cta"><a href="<?php echo admin_url('admin.php?page=crypto-currency-management'); ?>">Click Here</a> to go to Crypto Currency Management</p>

            <table class="wp-list-table widefat striped" >
                <thead>
                    <tr>
                        <th width = 20%>Display Name</th>
                        <th width = 20%>Bank Name</th>
                        <th width = 20%>Bank Account Name</th>
                        <th width = 20%>Bank Account Number</th>
                        <th width = 20%>Action</th>

                    </tr>
                </thead>

                <tbody>

                    <form action="" method="post">
                        <tr>
                            <td><input type="text" id="new-display-name" name="new-display-name"></td>

                            <td><input type="text" id="new-bank-name" name="new-bank-name"></td>

                            <td><input type="text" id="new-bank-account-name" name="new-bank-account-name"></td>

                            <td><input type="text" maxlength="11" pattern="\d*" id="new-bank-account-number" name="new-bank-account-number"></td>

                            <td>
                                <button id="newsubmit" name="newsubmit" type="submit" >Create Local Bank</button>
                            </td>

                        </tr>
                    </form>

                    <?php

                        $all_banks = hid_ex_m_get_all_banks();

                        if(! empty( $all_banks ) ){

                            foreach($all_banks as $bank){

                                $update_url = admin_url("admin.php?page=e-currency-management&tab=local-banks&upt=$bank->id");

                                $delete_url = admin_url("admin.php?page=e-currency-management&tab=local-banks&delete=$bank->id");

                                echo "<tr><td>$bank->display_name</td>";
                                echo "<td>$bank->bank_name</td>";
                                echo "<td>$bank->bank_account_name</td>";
                                echo "<td>$bank->bank_account_number</td>";
                                echo "<td><a href='$update_url'>
                                            <button>Update</button>
                                        </a>
                                        <a href='$delete_url'>
                                            <button>Delete</button>
                                        </a>
                                    </td></tr>";
                            }

                        }
                    ?>

                    <!-- <tr>
                        <td>BTC Account</td>
                        <td>FCMB</td>
                        <td>LuxTrade Ventures </td>
                        <td>8922517332</td>
                        <td><a href="#">Update</a><a href="#">Delete</a></td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    <?php

    if ( isset($_GET['upt']) ){

        $bank_id = $_GET['upt'];

        hid_ex_m_get_update_form( $bank_id );

    }
}

function hid_ex_m_get_update_form( $bank_id ){

    $bank_data = hid_ex_m_get_bank_data( $bank_id );

    ?>
        <div class="local-bank-update-form wrap">
        <table class="wp-list-table widefat striped" >
            <thead>
                <tr>
                    <th width = 20%>Display Name</th>
                    <th width = 20%>Bank Name</th>
                    <th width = 20%>Bank Account Name</th>
                    <th width = 20%>Bank Account Number</th>
                    <th width = 20%>Action</th>

                </tr>
            </thead>


            <tbody>
                <form action="" method="post">
                    <input type="hidden" id="upt-id" name="upt-id" value=<?php echo $bank_id ?>>
                    <tr>
                    <td><input type='text' id='upt-display-name' name='upt-display-name' value='<?php echo $bank_data['display_name']?>'></td>

                    <td><input type='text' id='upt-bank-name' name='upt-bank-name' value='<?php echo $bank_data['bank_name']?>'></td>

                    <td><input type='text' id='upt-bank-account-name' name='upt-bank-account-name' value='<?php echo $bank_data['bank_account_name']?>'></td>

                    <td><input type='text' maxlength='11' pattern='\d*' id='upt-bank-account-number' name='upt-bank-account-number' value='<?php echo $bank_data['bank_account_number']?>'></td>



                    <td>
                        <button id='uptsubmit' name='uptsubmit' type='submit' >Update</button>

                        <a class="button btn-cancel" href="<?php echo admin_url('admin.php?page=e-currency-management&tab=local-banks'); ?>">
                            Cancel
                        </a>

                    </td>

                    </tr>
                </form>

            </tbody>
        </table>
        </div>
    <?php

}


/* End of Local Banks Functions */

/* eCurrency Management */

// View all eCurrencies
function hid_ex_m_assets_management(){

    if ( isset($_GET['delete']) ) {

        $asset_id = $_GET['delete'];

        hid_ex_m_delete_e_currency_asset( $asset_id );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=e-currency-management');</script>";

    }

    
    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Assets Management</h2>
            <a href="<?php echo admin_url('admin.php?page=e-currency-management&tab=create-new'); ?>" class="page-title-action">Add New eCurrency Asset</a>
            <br>
            <p class="cta">Create Local Bank Accounts <a href="<?php echo admin_url('admin.php?page=e-currency-management&tab=local-banks'); ?>">Here</a></p>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 20%>Asset Name</th>
                        <th width = 10%>Short Name</th>
                        <th width = 10%>Icon</th>
                        <th width = 10%>Buying Price</th>
                        <th width = 10%>Selling Price</th>
                        <th width = 15%>Associated Local Bank</th>
                        <th width = 25%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_e_assets = hid_ex_m_get_all_e_currency_assets();;

                        if(! empty( $all_e_assets ) ){

                            foreach($all_e_assets as $asset){

                                $update_url = admin_url("admin.php?page=e-currency-management&tab=update-e-currency&id=$asset->id");

                                $delete_url = admin_url("admin.php?page=e-currency-management&delete=$asset->id");

                                

                                echo "<tr><td>$asset->name</td>";
                                echo "<td>$asset->short_name</td>";

                                echo "<td><img src='" . wp_get_attachment_url( $asset->icon ) . "' alt='' style='max-width: 50px; max-height: 50px;'></td>";
                                
                                echo "<td>$asset->buying_price</td>";
                                echo "<td>$asset->selling_price</td>";

                                echo "<td>" .  hid_ex_m_get_asset_display_name( $asset->associated_local_bank ) . "</td>";

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

// Create new eCurrency
function hid_ex_m_create_new_e_currency(){

    if ( isset($_POST['new-asset-submit']) ) {

        $data = array(
            'name'                  => $_POST['name'],
            'short_name'            => $_POST['short-name'],
            'icon'                  => $_POST['icon-media-id'],
            'buying_price'          => (float)$_POST['buying-price'],
            'selling_price'         => (float)$_POST['selling-price'],
            'associated_local_bank' => $_POST['local-bank'],
            'sending_instruction'   => $_POST['sending-instruction']
        );

        hid_ex_m_create_new_e_currency_asset( $data );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=e-currency-management');</script>";

    }

    ?>
        <div class="create-new-assets-page wrap">
            <h1>Create New eCurrency Aset</h1>

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
                        <tr>
                            <th scope="row">
                                <label for="selling-price">Selling Price</label>
                            </th>
                            <td>
                            <input name="selling-price" type="text" id="selling-price" class="regular-text"  pattern="[+-]?([1-9]\d*(\.\d*[1-9])?|0\.\d*[1-9]+)|\d+(\.\d*[1-9])?" title="Only a decimal value is valid">
                            <p class="description">How much are you willing to sell this asset to your customers?</p>
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

                                            echo '<option value=' . $bank->id . ' >' . $bank->display_name . '</option>';

                                            
                                        }

                                        echo '</select>';

                                    } else {
                                        ?>
                                           <p>No local banks Available<a href="<?php echo admin_url('admin.php?page=e-currency-management&tab=local-banks'); ?>">Click Here</a> to add one</p> 
                                        <?php 
                                    }

                                ?>
                                </select>
                            <p class="description">Select the Local Bank Account that will be associated with this eCurrency</p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="sending-instruction">Sending Instruction</label>
                            </th>
                            <td>
                                <textarea name="sending-instruction" class="regular-text" id="sending-instruction" cols="40" rows="5"></textarea>
                                
                                <p class="description">How should customers send in their eCurrency</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
                <p class="submit">
                    
                    <button type="submit" name="new-asset-submit" id="new-asset-submit" class="button button-primary">Publish New Asset &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=e-currency-management'); ?>" class="button">Cancel</a>
                    
                </p>
            </form>
        </div>
    <?php
}

// Create new eCurrency
function hid_ex_m_update_e_currency(){

    if ( isset($_POST['update-asset-submit']) ) {

        $data = array(
            'name'                  => $_POST['name'],
            'short_name'            => $_POST['short-name'],
            'icon'                  => $_POST['icon-media-id'],
            'buying_price'          => (float)$_POST['buying-price'],
            'selling_price'         => (float)$_POST['selling-price'],
            'associated_local_bank' => $_POST['local-bank'],
            'sending_instruction'   => $_POST['sending-instruction']

        );

        $where = array(
            'id' => $_POST['asset-id']
        );

        hid_ex_m_update_e_currency_data( $data, $where );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=e-currency-management');</script>";

    }

    $asset_id = $_GET['id'];

    $asset_data = hid_ex_m_get_e_currency_data( $asset_id );



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
                            <input name="name" type="text" id="name" class="regular-text" value="<?php echo $asset_data->name ?>" >
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
                                
                                <input type="hidden" id="icon-media-id" name="icon-media-id" value=<?php echo $asset_data->icon ?>>
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
                        <tr>
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
                            <p class="description">Select the Local Bank Account that will be associated with this eCurrency</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sending-instruction">Sending Instruction</label>
                            </th>
                            <td>
                                <textarea name="sending-instruction" class="regular-text" id="sending-instruction" cols="40" rows="5" ><?php echo $asset_data->sending_instruction ?></textarea>
                                
                                <p class="description">How should customers send in their eCurrency</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
                <p class="submit">
                    
                    <button type="submit" name="update-asset-submit" id="update-asset-submit" class="button button-primary">Update Asset &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=e-currency-management'); ?>" class="button">Cancel</a>
                    
                </p>
            </form>
        </div>
    <?php
}
