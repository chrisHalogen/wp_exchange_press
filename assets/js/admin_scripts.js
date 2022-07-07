jQuery(document).ready( function($){

    const string = window.location.href;

    const buy_order = 'admin.php?page=buy-orders-management&tab=create-new';
    const sell_order = 'admin.php?page=sell-orders-management&tab=create-new';

    
    const substring = 'admin.php?page=e-currency-management&tab=create-new';

    const substring2 = 'admin.php?page=crypto-currency-management&tab=create-new';

    const substring3 = 'admin.php?page=crypto-currency-management&tab=update-crypto-currency';

    const substring4 = 'admin.php?page=e-currency-management&tab=update-e-currency';

    let update_sell_order = 'admin.php?page=sell-orders-management&tab=update-sell-order';

    let update_buy_order = 'admin.php?page=buy-orders-management&tab=update-buy-order';

    let support_chat = 'admin.php?page=support&tab=chat';

    const condition = string.includes(substring) || string.includes(substring2) || string.includes(substring3) || string.includes(substring4) || string.includes(buy_order) || string.includes(update_buy_order) || string.includes(sell_order) || string.includes(update_sell_order);


    if (condition){

        let addButton = document.getElementById('image-select-button');
        let deleteButton = document.getElementById('image-delete-button');
        let img = document.getElementById('asset-image-tag');
        let hidden = document.getElementById('icon-media-id');
        

        let customUploader = wp.media(
            {
                title : 'Choose the Asset Icon',
                button : {
                    text : 'Use this Image'
                },
                multiple : false
            }
        );

        addButton.addEventListener( 'click', function(){
            if ( customUploader ) {
                customUploader.open();
            }
        });

        customUploader.on('select', function(){
            let attachment = customUploader.state().get('selection').first().toJSON();

            img.setAttribute( 'src', attachment.url );
            img.setAttribute('style' , 'max-width:200px');
            img.setAttribute('style' , 'max-height:200px');
            
            hidden.setAttribute( 'value', attachment.id );

        })

        deleteButton.addEventListener( 'click', function(){

            img.removeAttribute( 'src' );
            hidden.removeAttribute( 'value' );
        })
    }

    const condition2 = string.includes(buy_order) || string.includes(sell_order);

    if (condition2){

        let all_assets_rates = {};
        let current_rate = 0;
        let hidden_field = document.getElementById("hidden-rate");

        $.fn.retrieve_data_ajax = function(recipient){

            $.ajax({
                url: script_data.ajaxurl, // The wordpress Ajax URL echoed on line 4
                data: {
                    // The action is the WP function that'll handle this ajax request
                    'action' : recipient
                  },
                  success:function( data ) {
                    
                    if (data['data'].length > 0){

                        // console.log(data['data']);

                        let outputhtml = "";

                        data['data'].forEach(element => {
                            outputhtml += "<option rate=" + element['selling_price']+ " value=" + element['id'] +">"+ element['name'] + " | " + element['short_name'] + "</option>";

                            all_assets_rates[element['id']] = element['selling_price']

                        });

                    

                        $("#select-asset").html(outputhtml);

                        current_rate = all_assets_rates[select_field.value];

                        hidden_field.value = current_rate;

                        
                    }
                    
                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });
            
              
        }

        $.fn.update_select_input = function(result){ 

            if (result.length === 0){
                console.log(result);
            }
             
        }



        $(".asset-btn-1").click(function(){
            $.fn.retrieve_data_ajax('hid_ex_m_get_e_assets');
            
          });

        $(".asset-btn-2").click(function(){
            $.fn.retrieve_data_ajax('hid_ex_m_get_crypto_assets');
            
        });
        
        
        // Fee and quantity auto calculate
        let quantity_field = document.getElementById("quantity");

        // let fee_field = document.getElementById("fee");

        let select_field = document.getElementById("select-asset");

        let rate_output = document.getElementById("rate-output");

        let fee_hidden = document.getElementById("hidden-fee");

        let fee_output = document.getElementById("fee");
        

        select_field.addEventListener('change', function(){

            current_rate = all_assets_rates[select_field.value];
            hidden_field.value = current_rate;
            
            
        })

        quantity_field.addEventListener(
            'input', function(){

                fee_hidden.value = current_rate * quantity_field.value;

                fee_output.innerHTML = fee_hidden.value

                rate_output.innerHTML = current_rate;
            }
        )


        // console.log(hidden_field.value);
        // console.log(fee_field);
        // console.log(select_field);
        

    }

    
    const condition3 = string.includes(update_buy_order) || string.includes(update_sell_order);

    if (condition3){

        let all_assets_rates = {};
        let current_rate = 0;
        let hidden_field = document.getElementById("hidden-rate");
        let asset_type = document.getElementById("asset-type");
        let asset_id = document.getElementById("asset-id");


        $.fn.retrieve_data_ajax = function(recipient){

            $.ajax({
                url: script_data.ajaxurl, // The wordpress Ajax URL echoed on line 4
                data: {
                    // The action is the WP function that'll handle this ajax request
                    'action' : recipient
                  },
                  success:function( data ) {
                    
                    if (data['data'].length > 0){

                        // console.log(data['data']);

                        let outputhtml = "";

                        data['data'].forEach(element => {
                            let selects = element['id'] == asset_id.value ? " selected" : "";

                            outputhtml += "<option rate=" + element['selling_price']+ " value=" + element['id'] + selects +">"+ element['name'] + " | " + element['short_name'] + "</option>";

                            all_assets_rates[element['id']] = element['selling_price']

                        });

                    

                        $("#select-asset").html(outputhtml);

                        current_rate = all_assets_rates[select_field.value];

                        hidden_field.value = current_rate;

                        
                    }
                    
                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });
            
              
        }

        if (asset_type.value == 1){
            $.fn.retrieve_data_ajax('hid_ex_m_get_e_assets');
        } else if (asset_type.value == 2){
            $.fn.retrieve_data_ajax('hid_ex_m_get_crypto_assets');
        }



        $(".asset-btn-1").click(function(){
            $.fn.retrieve_data_ajax('hid_ex_m_get_e_assets');
            
          });

        $(".asset-btn-2").click(function(){
            $.fn.retrieve_data_ajax('hid_ex_m_get_crypto_assets');
            
        });
        
        
        // Fee and quantity auto calculate
        let quantity_field = document.getElementById("quantity");

        // let fee_field = document.getElementById("fee");

        let select_field = document.getElementById("select-asset");

        let rate_output = document.getElementById("rate-output");

        let fee_hidden = document.getElementById("hidden-fee");

        let fee_output = document.getElementById("fee");

        let fee_temp = fee_hidden.value / quantity_field.value;

        rate_output.innerHTML = fee_temp.toFixed(2);
        
        select_field.addEventListener('change', function(){

            current_rate = all_assets_rates[select_field.value];
            hidden_field.value = current_rate;
            
            
        })

        quantity_field.addEventListener(
            'input', function(){

                let price = current_rate * quantity_field.value;

                fee_hidden.value = price.toFixed(2)

                fee_output.innerHTML = fee_hidden.value

                rate_output.innerHTML = current_rate;
            }
        )

        // console.log(asset_type.value);
        // console.log(asset_id.value);
        

    }

    const condition4 = string.includes(support_chat);
    
    if (condition4){
        let addButton = document.getElementById('attachment-select-button');
        let deleteButton = document.getElementById('attachment-delete-button');
        let att_name = document.getElementById('attachment-name');
        let hidden = document.getElementById('attachment-id');
        

        let customUploader = wp.media(
            {
                title : 'Choose the File To Attach',
                button : {
                    text : 'Select Attachment'
                },
                multiple : false
            }
        );

        addButton.addEventListener( 'click', function(){
            if ( customUploader ) {
                customUploader.open();
            }
        });

        customUploader.on('select', function(){
            let attachment = customUploader.state().get('selection').first().toJSON();

            att_name.setAttribute( 'src', attachment.url );

            let file_name = attachment.filename;

            let display_file_name = (file_name.length >= 40) ? file_name.slice(0,15) + "..." + file_name.slice(-15) : file_name;

            att_name.innerHTML = display_file_name;
  
            hidden.setAttribute( 'value', attachment.id );

        })

        deleteButton.addEventListener( 'click', function(){

            att_name.innerHTML = "";
            hidden.removeAttribute( 'value' );
        })


        // Form Submission
        let chat_form = document.getElementById('new-admin-chat-form');

        chat_form.addEventListener('submit', function(e){

            e.preventDefault();

            let message_body = document.getElementById('message-body').value;

            let attachment_id = document.getElementById('attachment-id').value;

            let ticket_id = document.getElementById('ticket-id').value;

            let error_element = document.getElementById("empty-chat-error");

            if (!message_body){
                message_body = "";
            }

            if (!attachment_id){
                attachment_id = 0;
            }

            if (!message_body && ! attachment_id){
                error_element.innerHTML = "Cannot Send Empty Message";
                error_element.style.color = 'red';
                return;
            }

            error_element.innerHTML = "";

            // console.log(attachment,message_body,ticket_id);

            let data = {
                sender : "Admin",
                message : message_body,
                attachment : attachment_id,
                ticket : ticket_id,
            }

            $.ajax({

                url: script_data.ajaxurl, 
                
                data: {
                    
                    'action' : 'hid_ex_m_add_new_chat',
                    'data' : data
                  },

                  success:function( ) {
                    document.getElementById('message-body').value = "";

                    att_name.innerHTML = "";
                    hidden.removeAttribute( 'value' );

                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });
        
        
        })

        let chat_time_sent = document.getElementsByClassName('time-sent');
        

        setInterval(function(){ 
            
            let last_chat_time = chat_time_sent[chat_time_sent.length - 1].innerHTML;


            $.ajax({

                url: script_data.ajaxurl, 
                
                data: {
                    
                    'action' : 'hid_ex_m_get_recent_chats_view',
                    'time' : last_chat_time,
                    'ticket_id' : document.getElementById('ticket-id').value
                  },

                  success:function( data ) {

                    if (data['data'] != 0){

                        if (document.getElementById('zero-chats-notice')){
                            document.getElementById('zero-chats-notice').remove(); 
                        }

                        let chat_wrapper = document.getElementById('chats-messagges-wrapper');

                        let build_string = "";

                        data['data'].forEach(msg => {
                            let sender_class = (msg['sender'] == "Admin") ? "admin-chat" : "customer-chat";

                            let sender = (msg['sender'] == "Admin") ? "Admin" : "Customer";

                            build_string += '<div class="single-chat-message ' + sender_class + '">';

                            if (msg['message'] != ""){
                                build_string += '<p class="message-body">' + msg['message'] + '</p>';
                            }

                            if (msg['attachment'] != 0){
                                build_string += '<a href="' + msg['attachment_url'] + '" target="_blank">Click Here to View Attachment</a>';
                            }

                            build_string += '<span class="message-details">Sent by <span class="message-sender">' + sender + '</span> | <span class="time-sent">' + msg['time_stamp'] + '</span></span></div>';

                        });

                        chat_wrapper.innerHTML += build_string;

                    }

                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });
            
        }, 3000);
    }

});


