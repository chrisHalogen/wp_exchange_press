<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;

    $page_name = get_query_var('authentication_page_name');

    if ( strtolower($page_name) == 'register' ){

        $page_data = array(
            'title'     => 'Customer Registration | Luxtrade'
        );

        hid_ex_m_customer_registration( $page_data['title'] );

    } elseif ( strtolower($page_name) == 'sign-in' ) {
        
        $page_data = array(
            'title'     => 'Customer Sign In | Luxtrade'
        );

        hid_ex_m_customer_sign_in( $page_data['title'] );

    } elseif ( strtolower($page_name) == 'reset-password' ) {
        
        $page_data = array(
            'title'     => 'Reset Password | Luxtrade'
        );

        hid_ex_m_customer_password_reset( $page_data['title'] );
    }

function hid_ex_m_customer_password_reset( $page_title ){


    if ( isset($_POST['submit']) && (email_exists($_POST['email'])) ){

        hid_ex_m_password_reset_eMail( email_exists($_POST['email']), $_POST['email'] );

    }

    $updated_user_id = -1;

    if ( isset($_POST['update-customer-password']) && ($_POST['password'] == $_POST['password2']) && isset($_POST['user_id'])){

        $userdata = array(
            'ID'              => $_POST['user_id'],
            'user_pass'       => $_POST['password'],
        );
    
        $updated_user_id = wp_update_user($userdata);

    }

    hid_ex_m_exchange_header( $page_title );

    ?>
    
        <div class="ex-m-auth-page" id="hid_ex_m_customer_password_reset">
            <div class="ex-m-auth-wrapper">
                <h1 class="title-text">Reset Your Password</h1>
                <div class="divider-container">
                    <hr class="divider">
                </div>

                <?php if (!(isset($_GET['customer']) && isset($_GET['token']))) : ?>

                    <p style="text-align: center; font-size:1.1rem;">Forgot your password? Enter your registered eMail address below to start the password recovery process. If the eMail entered is registered with us, you will get a Password Reset eMail</p>
                
                    <?php
                    
                        if ( isset($_POST['submit']) && (email_exists($_POST['email'])) ){

                            ?>

                                <h2 style="text-align: center; font-weight:bold; color:#025e30;">Check your inbox</h2>
                            
                            <?php

                        } else {

                            ?>
                            
                                <form action="" method="post" autocomplete="off" id="hid_ex_m_customer_password_reset">
                            
                                    <div class="form-group">
                                        <label for="email">eMail Address</label>
                                        <input autocomplete="off" type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$">
                                        <p class="description">Enter your registered eMail Address</p>

                                        <?php if (isset($_POST['submit']) && !(email_exists($_POST['email']))) : ?>

                                            <span style="color: red; text-align:center;font-size:1rem;margin:0.25rem 0;display:block">The eMail address you entered is not registered</span>

                                        <?php endif; ?>

                                    </div>

                                    <div class="btn-wrapper">
                                        <button id="btn-login-submit" type="submit" name="submit">Reset My Password</button>
                                    </div>

                                </form>
                            
                            <?php

                        }
                    
                    ?>

                <?php endif; ?>

                <?php if (isset($_GET['customer']) && isset($_GET['token']) && ($updated_user_id == -1)) : ?>

                    <?php
                    
                        $token = $_GET['token'];
                        $customer = $_GET['customer'];
                        $the_user_id = -1;

                        $the_user = get_user_by('login', $customer);

                        $sign_in_url = site_url( '/authentication/sign-in/' );

                        if (!($the_user)){

                            echo "<script>location.replace('$sign_in_url');</script>";

                        } else {
                            $the_user_id = $the_user->ID;
                        }

                        if (hid_ex_m_check_token($the_user_id, $token) == 0){
                            echo "<script>location.replace('$sign_in_url');</script>";
                        }
                        
                    ?>

                    <p style="text-align: center; font-size:1.1rem;">Your eMail have been confirmed successfully. Now enter your desired password and submit the form below</p>

                    <form action="" method="post" autocomplete="off" id="hid_ex_m_customer_password_reset">

                        <input type="hidden" name="user_id" value="<?php echo $the_user_id ?>">

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input autocomplete="off" type="password" name="password" id="password">
                            <p class="description">Enter a secured Password</p>
                        </div>

                        <div class="form-group">
                            <label for="password2">Password</label>
                            <input autocomplete="off" type="password" name="password2" id="password2">
                            <p class="description">Re-enter secured Password</p>

                            <?php if (isset($_POST['update-customer-password']) && ($_POST['password'] != $_POST['password2'])) : ?>

                                <span style="color: red; text-align:center;font-size:1rem;margin:0.25rem 0;display:block">Your Passwords Don't match</span>

                            <?php endif; ?>

                        </div>

                        <div class="btn-wrapper">
                            <button id="btn-login-submit" type="submit" name="update-customer-password">Confirm Password</button>
                        </div>

                    </form>

                <?php endif; ?>

                <?php if ( $updated_user_id != -1 ) : ?>
                    <h2 style="text-align: center; font-weight:bold; color:#025e30;">Password Updated Successfully.</h2>

                    <?php

                        $sign_in_url = site_url( '/authentication/sign-in/' );

                        $command = "setInterval(function(){

                            location.replace('$sign_in_url');

                            },2000)";

                        echo "<script>$command</script>";
                    
                    ?>
                <?php endif; ?>

            </div>
        </div>
    
    <?php

    hid_ex_m_exchange_footer();
}

function hid_ex_m_customer_registration( $page_title ){

    hid_ex_m_exchange_header( $page_title );

    ?>

        <div class="ex-m-auth-page" id="hid_ex_m_customer_registration">
            <div class="ex-m-auth-wrapper">
                <h1 class="title-text">Create Account</h1>
                <div class="divider-container">
                    <hr class="divider">
                </div>
                
                <form action="" method="post" id="register-form" autocomplete="off" >
                    
                    <div class="form-group">
                        <label for="f-name">First Name</label>
                        <input type="text" name="f-name" id="f-name">
                        <p class="description">Enter your First Name</p>
                        <small>Error Message</small>
                    </div>

                    <div class="form-group">
                        <label for="l-name">Last Name</label>
                        <input type="text" name="l-name" id="l-name">
                        <p class="description">What's your last name?</p>
                        <small>Error Message</small>
                    </div>

                    <div class="form-group">
                        <label for="phone-number">Phone Number</label>
                        <input autocomplete="false" type="tel" name="phone-number" id="phone-number">
                        <p class="description">Enter your main Phone Number</p>
                        <small>Error Message</small>
                    </div>

                    <div class="form-group">
                        <label for="email-address">Email Address</label>
                        <input type="email" name="email-address" id="email-address" autocomplete="off">
                        <p class="description">Enter your main eMail Address</p>
                        <small>Error Message</small>
                    </div>

                

                    <div class="form-divider-container">
                        <hr class="form-divider">
                        <p class="divider-title">
                            Security Details
                        </p>
                        <hr class="form-divider">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" >
                        <p class="description">Enter your desired Username</p>
                        <small>Error Message</small>
                        
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                        <p class="description">Enter a secured Password</p>
                        <small>Error Message</small>
                    </div>

                    <div class="btn-wrapper">
                        <button id="register-submit" type="submit">Complete Registration</button>

                        
                    </div>

                    <p class="cta-description">
                        Already have an account,  <a href="<?php echo site_url( '/authentication/sign-in/' ) ?>">Sign in &#8594;</a>
                    </p>

                    <p class="cta-description" style="margin-top: 0.5rem;">
                        Forgotten your password, <a href="<?php echo site_url( '/authentication/reset-password/' ) ?>">Recover your password</a>
                    </p>
                </form>

                <div class="processing-registration" id="processing-registration">
                    <span id="processing-span">Processing Registration...</span>
                </div>

            </div>
        </div>
    
    <?php

    hid_ex_m_exchange_footer();
}

function hid_ex_m_customer_sign_in( $page_title ){

    hid_ex_m_exchange_header( $page_title );

    ?>
  
    <div class="ex-m-auth-page" id="hid_ex_m_customer_login">
        <div class="ex-m-auth-wrapper">
            <h1 class="title-text">Login to Luxtrade</h1>
            <div class="divider-container">
                <hr class="divider">
            </div>
            
            <form action="" method="post" id="hid_ex_m_customer_login">
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                    <p class="description">Enter your registered Username</p>
                    <small>Error Message</small>
                    
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <p class="description">Enter your Password</p>
                    <small>Error Message</small>
                </div>

                <div class="form-group remember-me-group">
                    <input type="checkbox" value="lsRememberMe" id="rememberMe"> 
                    <label id="remember-me-label" for="rememberMe">Remember me</label>
                </div>

                <div class="btn-wrapper">
                    <button id="btn-login-submit" type="submit">Login</button>

                    
                </div>

                <p class="cta-description">
                    Don't have an account, <a href="<?php echo site_url( '/authentication/register/' ) ?>">Sign up for one &#8594;</a>
                </p>

                <p class="cta-description" style="margin-top: 0.5rem;">
                    Forgotten your password, <a href="<?php echo site_url( '/authentication/reset-password/' ) ?>">Recover your password</a>
                </p>
            </form>
        </div>
    </div>
    
    
    <?php

    hid_ex_m_exchange_footer();
}
