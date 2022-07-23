<?php

    // To deny anyone access to this file directly
    if ( ! defined( 'ABSPATH' ) ) exit;

function hid_ex_m_support_master_view(){

    if ( isset($_GET['tab']) && ( $_GET['tab'] == 'close' )) {

        $id = $_GET['id'];

        $where = array(
            'id' => $id
        );

        hid_ex_m_mark_support_ticket_as_close($where);
        

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'reopen' )) {

        $id = $_GET['id'];

        $where = array(
            'id' => $id
        );

        hid_ex_m_reopen_support_ticket( $where );

    } elseif ( isset($_GET['tab']) && ( $_GET['tab'] == 'delete' )) {

        $id = $_GET['id'];

        hid_ex_m_delete_support_ticket( $id );

    } elseif ( isset($_POST['new-submit']) ) {

        $data = array(
            'title'             => $_POST['support-title'],
            'details'           => $_POST['support-description'],
            'customer'          => $_POST['customer'],
            'ticket_status'     => 1,
            'requester'         => "Admin"
        );


        hid_ex_m_create_new_support_ticket( $data );

    }

    ?>

        <div class="support-admin-page wrap">
            <h2 class="pg-title">Support Area</h2>

            <div class="support-items-wrapper">

                <div class="tickets-area">

                    <?php hid_ex_m_support_ticket_form() ?>

                </div>

                <div class="existing-tickets-area">
                    <?php hid_ex_m_open_support_tickets() ?>
                </div>

                <div class="chats-area">
                <?php 
                if ( isset($_GET['tab']) && ( $_GET['tab'] == 'chat' )){

                    $id = $_GET['id'];

                    hid_ex_m_tickets_chat_area( $id );
                }

                ?>
                </div>
            </div>
        </div>
    <?php
}

function hid_ex_m_tickets_chat_area( $ticket_id ){

    $current_ticket = hid_ex_m_get_single_ticket_data( $ticket_id );

    $requester = ($current_ticket->requester == "Admin") ? "Admin" : "Customer";

    $current_chats = hid_ex_m_get_all_support_chat( $ticket_id );

    ?>
        <div class="chat-messages" id="chats-messagges-wrapper">

            <div class="first-message">
                <span class="ticket-title"><?php echo $current_ticket->title ?></span>
                <p><?php echo $current_ticket->details ?></p>
                <p class="ticket-details">Customer Name - <?php echo hid_ex_m_get_customer_data_name($current_ticket->customer) ?></p>
                <span class="ticket-details">Opened by <span class="ticket-requester"><?php echo $requester ?></span> | Last Activity - <?php echo $current_ticket->last_activity ?></span>
            </div>

            <?php
            
                if (empty($current_chats)){
                    ?>
                        <p class="zero-chats-notice" id="zero-chats-notice">No Chats On this Ticket</p>

                        <span class="time-sent" style="display: none;">0000-00-00 00:00:00</span>
                    <?php
                } else {

                    foreach($current_chats as $single_chat){
                        $sender_class = ($single_chat->sender == "Admin") ? "admin-chat" : "customer-chat";

                        $sender = ($single_chat->sender == "Admin") ? "Admin" : "Customer";

                        ?>
                        
                        <div class="single-chat-message <?php echo $sender_class ?>">
                            
                            <?php 
                            
                                if ($single_chat->message){
                                    
                                    echo "<p class='message-body'>" . str_replace('\\','',$single_chat->message) . "</p>";
                                } 
                            
                                if ($single_chat->attachment){
                                    echo '<a href="' . wp_get_attachment_url($single_chat->attachment) . '" target="_blank">Click Here to View Attachment</a>';
                                } 
                            
                            ?>
                            <span class="message-details">Sent by <span class="message-sender"><?php echo $sender ?></span> | <span class="time-sent"><?php echo $single_chat->time_stamp ?></span></span>
                        </div>
                        
                        <?php
                    }

                }
            
            ?>

           
        </div>

        <div class="chat-form">
            <form action="" id="new-admin-chat-form">
                <div>

                    <textarea name="" id="message-body" cols="30" rows="10"></textarea>

                    <input type="hidden" id="ticket-id" name="ticket-id" value="<?php echo $ticket_id ?>">

                    <input type="hidden" id="attachment-id" name="attachment-id">

                    <input type="button" id="attachment-select-button" class="button" name="attachment_data" value="Select Attachment"> 
                                    
                    <input type="button" id="attachment-delete-button" class="button" name="custom_attach_data" value="Delete Attachment">

                    <span id="attachment-name"></span>
                    <span id="empty-chat-error"></span>

                </div>

                <div class="submit">

                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Send</button>

                </div>
            </form>
            
        </div>
    <?php
}

function hid_ex_m_open_support_tickets(){

    $all_tickets = hid_ex_m_get_all_support_tickets();

    ?>
        <!-- <h3>Existing Tickets</h3> -->
        <div class="single-tickets-area">

            <?php
                if (empty( $all_tickets )){
                    ?>
                        <p style="text-align:center">No tickets Available</p>
                    <?php
                } else {

                    foreach($all_tickets as $single_ticket){

                        $ticket_title = $single_ticket -> title;

                        if ( strlen($ticket_title) > 28 ) {

                            $ticket_title = substr($ticket_title,0,28) . " ...";
                        }

                        $ticket_description = str_replace(PHP_EOL, '', $single_ticket -> details);

                        if ( strlen($ticket_description) > 50 ) {

                            $ticket_description = substr($ticket_description,0,150) . " ...";
                        }

                        $close_url = admin_url("admin.php?page=support&tab=close&id=$single_ticket->id");

                        $reopen_url = admin_url("admin.php?page=support&tab=reopen&id=$single_ticket->id");

                        $delete_url = admin_url("admin.php?page=support&tab=delete&id=$single_ticket->id");

                        $chat_url = admin_url("admin.php?page=support&tab=chat&id=$single_ticket->id");

                        $bg_color = ($single_ticket->ticket_status == 1) ? ("rgb(102, 255, 102);") : ("rgb(255, 170, 170)");

                        ?>

                            <div class="single-tickets" style="background-color:<?php echo $bg_color ?> ;">

                                <span class="single-tickets-title"><?php echo $ticket_title ?></span>
                                <p><?php echo $ticket_description ?></p>

                                <div class="ticket-ctas" >
                                    
                                    <?php 

                                        if ($single_ticket->ticket_status == 1){
                                            echo "<span><a href='" . $close_url . "'>Mark as Closed</a></span>";
                                        } else {
                                            echo "<span><a href='" . $reopen_url . "'>Reopen Ticket</a></span>";
                                        }

                                    ?>
                                    <span><a href="<?php echo $delete_url ?>">Closed and Delete Ticket</a></span>
                                    <span><a href="<?php echo $chat_url ?>">Open Chat</a></span>

                                </div>

                            </div>

                        <?php

                    }

                }
            ?>

           
        </div>

    <?php
}

function hid_ex_m_support_ticket_form(){
    ?>
        <h3>Open a new Support Ticket</h3>
        <div class="tickets-form">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="support-title">Ticket Title</label>
                    <input type="text" name="support-title" id="support-title">
                </div>
            
                <div class="form-group">
                    <label for="support-description">Ticket Description</label>
                    <textarea name="support-description" id="support-description" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label for="customer">Customer</label>

                    <?php
                        $all_customers = hid_ex_m_get_all_customers();


                        if(! empty( $all_customers ) ){

                            $build_string = '<select name="customer" id="customer">';

                            foreach($all_customers as $customer){

                                $build_string .= '<option value=' . $customer->ID . ' >' . $customer->display_name . " " . ucfirst( $customer->user_nicename ) . '</option>';


                            }

                            $build_string .= '</select>';

                            echo $build_string;

                        } else{
                            ?>
                            <p class="description">No Customers to Select From.<br>Create a new customer <a href="<?php echo admin_url('admin.php?page=customers-management&tab=create-new'); ?>">here</a></p>
                            <?php
                        }

                    ?>
                </div>

                <p class="submit">

                    <button type="submit" name="new-submit" id="new-submit" class="button button-primary">Open Ticket</button>

                </p>
            </form>
        </div>
    
    <?php
}