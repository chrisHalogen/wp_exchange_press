<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;


function hid_ex_m_announcement_master_view(){

    if (isset( $_GET['tab']) && $_GET['tab'] == 'create-new'){

        hid_ex_m_announcement_create_view();

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'update-announcement' )) {

        hid_ex_m_announcement_update_view();

    } else{

        hid_ex_m_announcement_archive();

    }
}

function hid_ex_m_announcement_archive(){

    if ( isset($_GET['delete']) ) {

        $id = $_GET['delete'];

        hid_ex_m_delete_announcement( $id );

        echo "<script>location.replace('admin.php?page=announcements');</script>";

    }


    ?>

        <div class="ecurrency-assets-admin-page wrap">
            <h2 class="pg-title">Announcements</h2>
            <a href="<?php echo admin_url('admin.php?page=announcements&tab=create-new'); ?>" class="page-title-action">Make a New Announcement</a>
            <br>
            <br>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th width = 25%>Headline</th>
                        <th width = 30%>Body</th>
                        <th width = 20%>Time</th>
                        <th width = 25%>Action</th>
                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $all = hid_ex_m_get_all_announcements();
                        

                        if(! empty( $all ) ){

                            foreach($all as $single){

                                $update_url = admin_url("admin.php?page=announcements&tab=update-announcement&id=$single->id");

                                $delete_url = admin_url("admin.php?page=announcements&delete=$single->id");

                                $body_text = $single->body;

                                if (strlen($single->body) > 75){
                                    $body_text = substr($single->body , 0, 75) . " ...";
                                }

                                $headline = str_replace('\\','',$single->headline);

                                $body = str_replace('\\','',$body_text);

                                echo "<tr><td>$headline</td>";
                                echo "<td>$body</td>";

                                echo "<td>$single->time_stamp</td>";

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
                                <p>No announcements to display</p>
                            <?php
                        }
                    ?>
                </tbody>

            </table>
        </div>
    
    
    <?php
}

function hid_ex_m_announcement_create_view(){

    if ( isset($_POST['new-submit']) ) {

        $data = array(
            'headline'    => $_POST['headline'],
            'body'        => $_POST['body']
        );

        hid_ex_m_create_new_announcement( $data );
        
        $result = wp_mail(
            'christackoms@gmail.com',
            'LuxTrade Alert - New Announcement Published',
            "This is to notify you that a new alert was just published on your platform.\nDo well to check it out"
        );

        echo "<script>location.replace('admin.php?page=announcements');</script>";

    }

    ?>
    <div class="create-new-assets-page wrap">
            
        <h1>Make A New Announcement</h1>

        <form action="" method="post">
            <table class="form-table">
                <tbody>
                    
                    <tr>
                        <th scope="row">
                            <label for="headline">Headline</label>
                        </th>

                        <td>
                        <input name="headline" type="text" id="headline"  class="regular-text" >

                        <p class="description">What is the headline of this announcement?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="body">Details</label>
                        </th>
                        <td>
                            <textarea name="body" class="regular-text" id="body" cols="40" rows="5"></textarea>
                            
                            <p class="description">What are the details of the announcement?</p>
                        </td>
                    </tr>

                </tbody>
            </table>
                <p class="submit">
                    
                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Publish Announcement &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=announcements'); ?>" class="button">Cancel</a>
                    
                </p>
        </form>


    </div>
    <?php
}

function hid_ex_m_announcement_update_view(){

    if ( isset($_POST['new-submit']) ) {

        $data = array(
            'headline'    => $_POST['headline'],
            'body'        => $_POST['body']
        );

        $where = array(
            'id' => $_POST['id']
        );

        hid_ex_m_update_announcement_data( $data, $where );   

        echo "<script>location.replace('admin.php?page=announcements');</script>";

    }

    $id = $_GET['id'];

    $data = hid_ex_m_get_announcement_data($id);

    ?>
    <div class="create-new-assets-page wrap">
            
        <h1>Update Announcement</h1>

        <form action="" method="post">
            <input type="hidden" name="id" id="name" value=<?php echo $data->id ?>>
            <table class="form-table">
                <tbody>

                    
                    <tr>
                        <th scope="row">
                            <label for="headline">Headline</label>
                        </th>

                        <td>
                        <input name="headline" type="text" id="headline" value="<?php echo str_replace('\\','',$data->headline) ?>"  class="regular-text" >

                        <p class="description">What is the headline of this announcement?</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="body">Details</label>
                        </th>
                        <td>
                            <textarea name="body" class="regular-text" id="body" cols="40" rows="5"><?php echo str_replace('\\','',$data->body) ?></textarea>
                            
                            <p class="description">What are the details of the announcement?</p>
                        </td>
                    </tr>

                </tbody>
            </table>
                <p class="submit">
                    
                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Update Announcement &#10003;</button>

                    <a href="<?php echo admin_url('admin.php?page=announcements'); ?>" class="button">Cancel</a>
                    
                </p>
        </form>


    </div>
    <?php
}

