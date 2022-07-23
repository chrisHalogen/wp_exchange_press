<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;

    $page_name = get_query_var('authentication_page_name');

    if ( strtolower($page_name) == 'register' ){

        $page_data = array(
            'title'     => 'Customer Registration | Luxtrade'
        );

        hid_ex_m_customer_registration( $page_data['title'] );

    }  elseif ( strtolower($page_name) == 'sign-in' ) {
        
        $page_data = array(
            'title'     => 'Customer Sign In | Luxtrade'
        );

        hid_ex_m_customer_sign_in( $page_data['title'] );
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
                
                <form action="" method="post" id="register-form">
                    
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
                        <input type="tel" name="phone-number" id="phone-number">
                        <p class="description">Enter your main Phone Number</p>
                        <small>Error Message</small>
                    </div>

                    <div class="form-group">
                        <label for="email-address">Email Address</label>
                        <input type="tel" name="email-address" id="email-address">
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
                        <input type="text" name="username" id="username">
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
                    Forgotten your password, <a href="#">Recover your password</a>
                </p>
            </form>
        </div>
    </div>
    
    
    <?php

    hid_ex_m_exchange_footer();
}