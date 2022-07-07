<?php

function hid_ex_m_exchange_header($page_title){

    ?>
    
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $page_title ?></title>

            <style>
                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Thin.ttf' ?>') format('truetype');
                    font-weight: 100;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Ultralight.ttf' ?>') format('truetype');
                    font-weight: 200;
                    font-style: normal;
                }
                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Light.ttf' ?>') format('truetype');
                    font-weight: 300;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Regular.ttf' ?>') format('truetype');
                    font-weight: 400;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Medium.ttf' ?>') format('truetype');
                    font-weight: 500;
                    font-style: normal;
                }
                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Semibold.ttf' ?>') format('truetype');
                    font-weight: 600;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Bold.ttf' ?>') format('truetype');
                    font-weight: 700;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>') format('truetype');
                    font-weight: 800;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>') format('truetype');
                    font-weight: 900;
                    font-style: normal;
                }

            </style>
            
            <?php wp_head() ?>

        </head>
        <body>
    
    <?php

}


function hid_ex_m_exchange_footer(){

    ?>
                <?php wp_footer() ?>
            </body>
        </html>

    <?php

}


function hid_ex_m_exchange_client_area_header($page_data){

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page_data['title'] ?></title>

        
        <style>
                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Thin.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Thin.ttf' ?>') format('truetype');
                    font-weight: 100;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Ultralight.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Ultralight.ttf' ?>') format('truetype');
                    font-weight: 200;
                    font-style: normal;
                }
                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Light.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Light.ttf' ?>') format('truetype');
                    font-weight: 300;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Regular.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Regular.ttf' ?>') format('truetype');
                    font-weight: 400;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Medium.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Medium.ttf' ?>') format('truetype');
                    font-weight: 500;
                    font-style: normal;
                }
                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Semibold.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Semibold.ttf' ?>') format('truetype');
                    font-weight: 600;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Bold.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Bold.ttf' ?>') format('truetype');
                    font-weight: 700;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>') format('truetype');
                    font-weight: 800;
                    font-style: normal;
                }

                @font-face {
                    font-family: "SF Pro";
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>');
                    src: url('<?php echo plugin_dir_url( __DIR__ ) . 'assets/font-dir/FontsFree-Net-SFProDisplay-Heavy-1.ttf' ?>') format('truetype');
                    font-weight: 900;
                    font-style: normal;
                }

            </style>
            

        <?php wp_head() ?>

    </head>
    <body>
        <div class="dashboard-wrapper">

            <div class="mobile-menu-div">
                <img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/media/logo-edited.png' ?>" alt="...">
                
                <i class="fa-solid fa-bars" id="menu-toggle-icon"></i>
            </div>

            <div class="navbar-container" id="navbar-wrapper">
                

                <div class="nav-bar">

                    <div class="cancel-icon-wrapper">
                        <i class="fa-solid fa-xmark" id="mobile-menu-cancel-icon"></i>
                    </div>

                    <div class="img-wrapper">
                        <img src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/media/logo-edited.png' ?>" alt="...">
        
                    </div>
        
                    <div class="navigation-menu">
                        <ul>
                            <li>
                                <a href="<?php echo site_url('/customer-area/dashboard/') ?>" <?php 
                                    if ($page_data['name'] == 'dashboard'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-house-user">
                                    </i><span>Overview</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/rates/') ?>" <?php 
                                    if ($page_data['name'] == 'rates'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-chart-bar"></i>
                                    </i><span>Today Rates</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/sell-to-us/') ?>" <?php 
                                    if ($page_data['name'] == 'sell-to-us'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-tags"></i>
                                    </i><span>Sell To Us</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/buy-from-us/') ?>" <?php 
                                    if ($page_data['name'] == 'buy-from-us'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    </i><span>Buy From Us</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/history/') ?>" <?php 
                                    if ($page_data['name'] == 'history'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    </i><span>History</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/announcements/') ?>" <?php 
                                    if ($page_data['name'] == 'announcements'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-bullhorn"></i>
                                    </i><span>Announcements</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/settings/') ?>" <?php 
                                    if ($page_data['name'] == 'settings'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-gear"></i>
                                    </i><span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/support/') ?>" <?php 
                                    if ($page_data['name'] == 'support'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-gear"></i>
                                    </i><span>Support</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/customer-area/logout/') ?>" <?php 
                                    if ($page_data['name'] == 'logout'){
                                        echo 'class="active-link"';
                                    }
                                ?>>
                                    <i class="fa-solid fa-power-off"></i>
                                    </i><span>Logout</span>
                                </a>
                            </li>
                            
                            
                        </ul>
                    </div>
        
                </div>

            </div>

<?php

}

function hid_ex_m_exchange_client_area_footer(){

    ?>
                </div>

            </body>
        </html>

    <?php

}