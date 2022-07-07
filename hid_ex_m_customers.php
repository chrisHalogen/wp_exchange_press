<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;


function hid_ex_m_customers_management(){

    if ( isset($_GET['tab']) && ( $_GET['tab'] == 'create-new' )) {

        hid_ex_m_create_new_customer_view();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'update-customer' )) {

        hid_ex_m_update_customer_view();

    } else {

        hid_ex_m_customers_archive_management();

    }
}

function hid_ex_m_customers_archive_management(){

    if ( isset($_GET['delete']) ) {

        $customer_id = $_GET['delete'];

        hid_ex_m_delete_customer( $customer_id );

        echo "<script>location.replace('admin.php?page=customers-management');</script>";

    }


    ?>
        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Customers Management</h2>
            <a href="<?php echo admin_url('admin.php?page=customers-management&tab=create-new'); ?>" class="page-title-action">Create New Customer</a>
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 20%>First Name</th>
                        <th width = 20%>Last Name</th>
                        <th width = 20%>E-Mail</th>
                        <th width = 20%>Username</th>
                        <th width = 20%>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all_customers = hid_ex_m_get_all_customers();


                        if(! empty( $all_customers ) ){

                            foreach($all_customers as $customer){

                                $update_url = admin_url("admin.php?page=customers-management&tab=update-customer&id=$customer->ID");

                                $delete_url = admin_url("admin.php?page=customers-management&delete=$customer->ID");

                                $first_name = $customer->data->display_name;

                                $last_name = ucfirst( $customer->data->user_nicename );
                                $email = $customer->data->user_email;
                                $username = $customer->data->user_login;


                                echo "<tr><td>$first_name</td>";
                                echo "<td>$last_name</td>";

                                echo "<td>$email</td>";

                                echo "<td>$username</td>";

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
                                <p>No Customers to display</p>
                            <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>

    <?php
}

function hid_ex_m_create_new_customer_view(){

    if ( isset($_POST['new-customer-submit']) ) {

        hid_ex_m_create_new_customer(
            $_POST['first-name'],
            $_POST['last-name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['password'],
            $_POST['username']
         );

        echo "<script>location.replace('admin.php?page=customers-management');</script>";

    }

    ?>
        <div class="create-new-assets-page wrap">
            <h1>Create New Customer</h1>

            <form action="" method="post">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="first-name">First Name</label>
                            </th>
                            <td>
                            <input name="first-name" type="text" id="first-name" class="regular-text" >
                            <p class="description">The Customer's First Name</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="last-name">Last Name</label>
                            </th>
                            <td>
                            <input name="last-name" type="text" id="last-name" class="regular-text" >
                            <p class="description">The Customer's Last Name</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="email">Email Address</label>
                            </th>
                            <td>
                            <input name="email" type="email" id="email" class="regular-text" >
                            <p class="description">The Customer's eMail Address</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="phone">Phone</label>
                            </th>
                            <td>
                            <input name="phone" type="phone" id="phone" class="regular-text" >
                            <p class="description">The Customer's Phone Number</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="username">Username</label>
                            </th>
                            <td>
                            <input name="username" type="text" id="username" class="regular-text" >
                            <p class="description">The Customer's Prefered Username</p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="password">Password</label>
                            </th>
                            <td>
                            <input name="password" type="password" id="password" class="regular-text" >
                            <p class="description">The Customer's Password</p>
                            </td>
                        </tr>


                    </tbody>
                </table>

                <p class="submit">

                    <button type="submit" name="new-customer-submit" id="new-customer-submit" class="button button-primary">Create Customer &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=customers-management'); ?>" class="button">Cancel</a>

                </p>
            </form>
        </div>
    <?php
}

function hid_ex_m_update_customer_view(){

    if ( isset($_POST['update-customer-submit']) ) {

        hid_ex_m_update_customer_data(
            $_POST['first-name'],
            $_POST['last-name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['username'],
            $_POST['customer-id']
         );

        echo "<script>location.replace('admin.php?page=customers-management');</script>";

    }

    $customer_id = $_GET['id'];

    $customer_data = hid_ex_m_get_customer_data( $customer_id );


    ?>
        <div class="create-new-assets-page wrap">
            <h1>Update <?php echo $customer_data[0]->data->display_name ?>'s Customer Account</h1>

            <form action="" method="post">
            <input type="hidden" id="customer-id" name="customer-id" value=<?php echo $customer_id ?>>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="first-name">First Name</label>
                            </th>
                            <td>
                            <input name="first-name" type="text" id="first-name" class="regular-text" value="<?php echo $customer_data[0]->data->display_name ?>">
                            <p class="description">The Customer's First Name</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="last-name">Last Name</label>
                            </th>
                            <td>
                            <input name="last-name" type="text" id="last-name" value="<?php echo ucfirst( $customer_data[0]->data->user_nicename ) ?>" class="regular-text" >
                            <p class="description">The Customer's Last Name</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="email">Email Address</label>
                            </th>
                            <td>
                            <input name="email" type="email" id="email" class="regular-text" value="<?php echo $customer_data[0]->data->user_email ?>">
                            <p class="description">The Customer's eMail Address</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="phone">Phone</label>
                            </th>
                            <td>
                            <input name="phone" type="phone" id="phone" class="regular-text" value="<?php echo $customer_data[1][0] ?>">
                            <p class="description">The Customer's Phone Number</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="username">Username</label>
                            </th>
                            <td>
                            <input name="username" type="text" id="username" class="regular-text" value="<?php echo $customer_data[0]->data->user_login ?>">
                            <p class="description">The Customer's Prefered Username</p>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <p class="submit">

                    <button type="submit" name="update-customer-submit" id="update-customer-submit" class="button button-primary">Update Customer &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=customers-management'); ?>" class="button">Cancel</a>

                </p>
            </form>
        </div>
    <?php
}
