<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;


function hid_ex_m_crypto_currency(){

    if ( isset($_GET['tab']) && ( $_GET['tab'] == 'create-new' )) {

        hid_ex_m_create_new_crypto_currency();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'update-crypto-currency' )) {

        hid_ex_m_update_crypto_currency();

    } else {

        hid_ex_m_crypto_assets_management();

    }
}


function hid_ex_m_crypto_assets_management(){

    if ( isset($_GET['delete']) ) {

        $asset_id = $_GET['delete'];

        hid_ex_m_delete_crypto_currency_asset( $asset_id );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=crypto-currency-management');</script>";

    }

    
    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Assets Management</h2>
            <a href="<?php echo admin_url('admin.php?page=crypto-currency-management&tab=create-new'); ?>" class="page-title-action">Add New Cryptocurrency Currency Asset</a>
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
                        <th width = 15%>Admin's Wallet</th>
                        <th width = 25%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_crypto_assets = hid_ex_m_get_all_crypto_currency_assets();

                        if(! empty( $all_crypto_assets ) ){

                            foreach($all_crypto_assets as $asset){

                                $update_url = admin_url("admin.php?page=crypto-currency-management&tab=update-crypto-currency&id=$asset->id");

                                $delete_url = admin_url("admin.php?page=crypto-currency-management&delete=$asset->id");

                                echo "<tr><td>$asset->name</td>";
                                echo "<td>$asset->short_name</td>";

                                echo "<td><img src='" . wp_get_attachment_url( $asset->icon ) . "' alt='' style='max-width: 50px; max-height: 50px;'></td>";
                                
                                echo "<td>$asset->buying_price</td>";

                                echo "<td>$asset->selling_price</td>";

                                echo "<td>" .  $asset->wallet_address . "</td>";

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

function hid_ex_m_create_new_crypto_currency(){

    if ( isset($_POST['new-asset-submit']) ) {

        $data = array(
            'name'                  => $_POST['name'],
            'short_name'            => $_POST['short-name'],
            'icon'                  => $_POST['icon-media-id'],
            'buying_price'          => (float)$_POST['buying-price'],
            'selling_price'         => (float)$_POST['selling-price'],
            'wallet_address'        => $_POST['wallet-address'],
            'associated_local_bank' => $_POST['local-bank']
        );

        hid_ex_m_create_new_crypto_currency_asset( $data );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=crypto-currency-management');</script>";

    }

    ?>
        <div class="create-new-assets-page wrap">
            <h1>Create New Cryptocurrency Asset</h1>

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
                                <label for="wallet-address">Associated Wallet Address</label>
                            </th>
                            <td>
                            <input name="wallet-address" type="text" id="wallet-address" class="regular-text" >    
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
                        </tr>
                    </tbody>
                </table>
            
                <p class="submit">
                    
                    <button type="submit" name="new-asset-submit" id="new-asset-submit" class="button button-primary">Publish New Asset &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=crypto-currency-management'); ?>" class="button">Cancel</a>
                    
                </p>
            </form>
        </div>
    <?php
}

function hid_ex_m_update_crypto_currency(){

    if ( isset($_POST['update-asset-submit']) ) {

        $data = array(
            'name'                  => $_POST['name'],
            'short_name'            => $_POST['short-name'],
            'icon'                  => $_POST['icon-media-id'],
            'buying_price'          => (float)$_POST['buying-price'],
            'selling_price'         => (float)$_POST['selling-price'],
            'wallet_address'        => $_POST['wallet-address']
        );

        $where = array(
            'id' => $_POST['asset-id']
        );

        hid_ex_m_update_crypto_currency_data( $data, $where );

        add_action('admin_notices','hid_ex_m_success_message');

        echo "<script>location.replace('admin.php?page=crypto-currency-management');</script>";

    }

    $asset_id = $_GET['id'];

    $asset_data = hid_ex_m_get_crypto_currency_data( $asset_id );

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
                        </tr>
                    </tbody>
                </table>
            
                <p class="submit">
                    
                    <button type="submit" name="update-asset-submit" id="update-asset-submit" class="button button-primary">Update Asset &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=crypto-currency-management'); ?>" class="button">Cancel</a>
                    
                </p>
            </form>
        </div>
    <?php
}