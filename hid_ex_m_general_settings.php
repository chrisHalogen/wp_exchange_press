<?php

// To deny anyone access to this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

function hid_ex_m_exchange_manager_settings(){

    if (isset($_POST['new-submit'])){

        if ($_POST['email']){

            hid_ex_m_update_wp_option( 'business_email', $_POST['email'] );

        }

        if ($_POST['host']){

            hid_ex_m_update_wp_option( 'smtp_host', $_POST['host'] );

        }

        if ($_POST['port']){

            hid_ex_m_update_wp_option( 'smtp_port', $_POST['port'] );

        }

        if ($_POST['username']){

            hid_ex_m_update_wp_option( 'smtp_username', $_POST['username'] );

        }

        if ($_POST['password']){

            hid_ex_m_update_wp_option( 'smtp_password', $_POST['password'] );

        }

        if ($_POST['encryption']){

            hid_ex_m_update_wp_option( 'smtp_encryption', $_POST['encryption'] );

        }

        echo '<span><strong>Updated Successfully</strong></span>';

        echo "<script>location.replace('admin.php?page=exchange-manager');</script>";

    }

?>
    <div class="wrap">
        <h2>General Settings</h2>
        <p>Welcome to the exchange manager general settings.</p>
        <form action="" method="post">
            <table class="form-table">
                <tbody>
                    
                    <tr>
                        <th scope="row">
                            <label for="email">Primary eMail Address</label>
                        </th>

                        <td>
                        <input name="email" type="email" id="email"  class="regular-text" value="<?php if (get_option('business_email')) echo get_option('business_email') ?>">

                        <p class="description">Enter the business main eMail Address</p>
                        </td>
                    </tr>

                    <hr>

                    <tr>
                        <th scope="row">
                            <label for="host">SMTP Host</label>
                        </th>

                        <td>
                        <input name="host" type="text" id="host"  class="regular-text" value="<?php if (get_option('smtp_host')) echo get_option('smtp_host') ?>">

                        <p class="description">Where is your SMTP server hosted?<br>
                        Gmail's default : smtp.gmail.com</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="port">SMTP Port</label>
                        </th>

                        <td>
                        <input name="port" type="text" id="port"  class="regular-text" value="<?php if (get_option('smtp_port')) echo get_option('smtp_port') ?>">

                        <p class="description">What is the port of your SMTP Server?<br>Gmail's default : 465</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="encryption">SMTP Encryption Type</label>
                        </th>

                        <td>
                        <input name="encryption" type="text" id="encryption"  class="regular-text" value="<?php if (get_option('smtp_encryption')) echo get_option('smtp_encryption') ?>">

                        <p class="description">What is the port of your SMTP Server?<br>Gmail's default : ssl</p>
                        </td>
                    </tr>


                    <tr>
                        <th scope="row">
                            <label for="username">Username</label>
                        </th>

                        <td>
                        <input name="username" type="text" id="username"  class="regular-text" value="<?php if (get_option('smtp_username')) echo get_option('smtp_username') ?>">

                        <p class="description">What is the username of your SMTP Server?<br>Gmail's default : Your gMail address</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="password">Password</label>
                        </th>

                        <td>
                        <input name="password" type="password" id="password"  class="regular-text" value="<?php if (get_option('smtp_password')) echo get_option('smtp_password') ?>">

                        <p class="description">What is the password of your SMTP Server?<br>Gmail's default : Your gMail password</p>
                        </td>
                    </tr>

                </tbody>
            </table>
                <p class="submit">
                    
                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Publish Settings &#10003;</button>
                    
                </p>
        </form>
    </div>

<?php
}