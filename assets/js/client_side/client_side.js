jQuery(document).ready( function($){

    let exist = {};
    let password_match = false;

    function log_the_user_in( username, password){

        return new Promise( function( resolve , reject ){
            let rmCheck = document.getElementById("rememberMe");

            let rememberMe = 0;

            if (rmCheck.checked){
                rememberMe = 1;
            } else {
                rememberMe = 0;
            }
            
            $.ajax({

                url: script_data.ajaxurl, 
                
                data: {
                    
                    'action' : 'hid_ex_m_log_the_user_in',
                    'username' : username,
                    'password' : password,
                    'rememberMe' : rememberMe

                  },

                  success:function( data ) {

                    if (data['data'] === 1){

                        window.location.href = script_data.dashboard_url;
                    } else {
                        
                        setErrorInput(username,"Error Logging in");
                        setErrorInput(password,"Error Logging in");
                    }

                    resolve();

                  },
                  error: function( errorThrown ){
                    reject();
                    window.alert( errorThrown );
                  }
            });    

        })

        
    }

    function checkIfPasswordMatches( username, password){

        return new Promise( function( resolve , reject ){
            
            $.ajax({

                url: script_data.ajaxurl, 
                
                data: {
                    
                    'action' : 'hid_ex_m_check_if_user_password_matches',
                    'username' : username,
                    'password' : password

                  },

                  success:function( data ) {

                    if (data['data'] === 1){
                        
                        password_match = true;
                    } else {
                        
                        password_match = false;
                    }

                    setSuccessInput(document.getElementById('password'));

                    resolve();

                  },
                  error: function( errorThrown ){
                    reject();
                    window.alert( errorThrown );
                  }
            });    

        })

        
    }

    function checkIfUserExists( field, value){

        return new Promise( function( resolve , reject ){
            
            $.ajax({

                url: script_data.ajaxurl, 
                
                data: {
                    
                    'action' : 'hid_ex_m_check_if_user_exists',
                    'field' : field,
                    'value' : value

                  },

                  success:function( data ) {
                    
                    exist[field] = data['data'];

                    resolve();

                  },
                  error: function( errorThrown ){
                    reject();
                    window.alert( errorThrown );
                  }
            });    

        })

        
    }

    function setErrorInput( input , message ){

        // Select input Parent Element
        let form_group = input.parentElement;

        // Select the small tag of the form Group
        let small_tag = form_group.querySelector( 'small' );

        // Add the Error Message
        small_tag.innerText = message;

        // Add the Error Class to the form Group
        form_group.className = 'form-group input-error';
    }

    function setSuccessInput( input ){

        // Select input Parent Element
        let form_group = input.parentElement;

        // Add the Error Class to the form Group
        form_group.className = 'form-group input-success';
    }
    
    // Scripts to load on Registration page
    
    if (document.getElementById('hid_ex_m_customer_registration')){
        
        let registeration_form = document.getElementById('hid_ex_m_customer_registration');

        let first_name = document.getElementById('f-name');
        let last_name = document.getElementById('l-name');
        let phone_number = document.getElementById('phone-number');
        let email = document.getElementById('email-address');
        let username = document.getElementById('username');
        let password = document.getElementById('password');

        
        let result = true;

        registeration_form.addEventListener( 'submit' , function(e){

            e.preventDefault();

            verify_user_existence(
                email.value.trim(),
                username.value.trim()
            );

        });

        function registration_success(){
            
            document.getElementById('processing-span').innerHTML = "Registration Successful. Redirecting to Login";

            window.location.href = script_data.sign_in_url;
        }

        async function create_new_user(){

            await create_new_customer_account();
            
        }

        function create_new_customer_account() {

            return new Promise( function( resolve , reject ){
                let fname_value = first_name.value.trim();
                let lname_value = last_name.value.trim();
                let phone_value = phone_number.value.trim();
                let email_value = email.value.trim();
                let username_value =  username.value.trim();
                let password_value =  password.value.trim();

                data = {
                    first_name : fname_value,
                    last_name : lname_value,
                    phone_number : phone_value,
                    email : email_value,
                    username : username_value,
                    password : password_value
                }

                $.ajax({

                    url: script_data.ajaxurl, 
                    
                    data: {
                        
                        'action' : 'hid_ex_m_complete_user_registration',
                        'data' : data

                    },

                    success:function( data ) {

                        registration_success();

                        resolve();
                    },
                    error: function( errorThrown ){
                        window.alert( errorThrown );
                        reject();
                    }
                });

            });
            
        }
  

        function verify_all_input(){

            let fname_value = first_name.value.trim();
            let lname_value = last_name.value.trim();
            let phone_value = phone_number.value.trim();
            let email_value = email.value.trim();
            let username_value =  username.value.trim();
            let password_value =  password.value.trim();

            let f_check = true;
            let l_check = true;
            let p_check = true;
            let e_check = true;
            let u_check = true;
            let pw_check = true;

            // Check First Name

            if (fname_value.length < 3){
                
                setErrorInput( first_name, "Minumum of 4 Characters Required" );

                f_check = false;

            } else {

                // Add Success Class
                setSuccessInput( first_name );
                f_check = true;

            }

            // Check Last Name
            if (lname_value.length < 3){

                setErrorInput( last_name, "Minumum of 4 Characters Required" );

                l_check = false;

            } else {

                setSuccessInput( last_name );
                l_check = true;

            }

            // Check Phone
            if (phone_value === ""){

                setErrorInput( phone_number, "Phone Number Cannot be empty" );

                p_check = false;

            } else if ( !isPhoneNumber( phone_value ) ){
                
                setErrorInput( phone_number, "Invalid Phone Number" );

                p_check = false;

            } else {

                setSuccessInput( phone_number );
                p_check = true;

            }

            // Check Email
            if (email_value === ""){

                setErrorInput( email, "Email Address cannot be empty" );

                e_check = false;

            } else if ( !isEmail( email_value ) ){
                
                setErrorInput( email, "Invalid eMail Address" );

                e_check = false;

            } else if ( exist['email'] == 1 ){
                
                setErrorInput( email, "This eMail have been used by someone else" );

                e_check = false;

            } else {

                setSuccessInput( email );
                e_check = true;

            }

            // Check Username
            if (username_value.length < 6){
                
                setErrorInput( username, "Minumum of 6 Characters Required" );

                u_check = false;

            }  else if ( exist['login'] == 1 ){
                
                setErrorInput( username, "Username Already In Use" );

                u_check = false;

            }  else {

                // Add Success Class
                setSuccessInput( username );
                u_check = true;

            }

            // Check Password
            if (password_value.length < 6){
                
                setErrorInput( password, "Minumum of 6 Characters Required" );

                pw_check = false;

            } else {

                // Add Success Class
                setSuccessInput( password );
                pw_check = true

            }

            result = f_check && l_check && p_check && e_check && u_check && pw_check;

            if (result){
                
                document.getElementById('register-form').style.display = 'none';
                
                document.getElementById('processing-registration').style.display = 'flex';

                create_new_user();
            }

        }

        function isEmail(email) {
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
        }

        function isPhoneNumber(number) {

            const regex = new RegExp('^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,8}$');

            return regex.test(number);
        }

        async function verify_user_existence(email_value, username_value){
            await checkIfUserExists( 'email', email_value );
            await checkIfUserExists( 'login', username_value );

            verify_all_input();
        }
        
    }

    // Scripts to load on Registration page
    if (document.getElementById('hid_ex_m_customer_login')){
        
        let login_form = document.getElementById('hid_ex_m_customer_login');

        let username = document.getElementById('username');

        let password = document.getElementById('password');

        login_form.addEventListener( 'submit' , function(e){

            e.preventDefault();

            document.getElementById("btn-login-submit").innerHTML = "Loading ...";

            user_exists_check(username.value.trim());

        });

        async function user_exists_check(username_value){

            await checkIfUserExists( 'login', username_value );

            verify_username()

        };

        function verify_username(){
            
            let username_value =  username.value.trim();
            let password_value =  password.value.trim();

            

            if (exist['login'] == 1){

                setSuccessInput( username );

                verify_password_match( username_value, password_value );

            } else if (exist['login'] == 0){

                setErrorInput( username , "User doesn't exist" ); 

                // Check Password
                if (password_value.length < 6){
                    
                    setErrorInput( password, "Minumum of 6 Characters Required" );

                } else {

                    setErrorInput( password, "Wrong User password" );

                }

            }
        }

        async function authenticate_user(username, password){

            await log_the_user_in( username, password);

            if (2+2 != 4){
                console("Logging In")
            }

        };

        async function verify_password_match(username, password){

            await checkIfPasswordMatches( username, password);

            if (password_match){
                authenticate_user(

                    document.getElementById('username').value.trim(), 
                    document.getElementById('password').value.trim() 
                    
                );
            } else {
                null;
            }

        };


    }

    if (document.getElementById('navbar-wrapper')){
        let menu_btn = document.getElementById('menu-toggle-icon');
        menu_btn.addEventListener('click', function(){
            
            let menu_wrapper = document.getElementById('navbar-wrapper');
            menu_wrapper.style.left = '0';
        })

        let times_btn = document.getElementById('mobile-menu-cancel-icon');
        times_btn.addEventListener('click', function(){
            
            let menu_wrapper = document.getElementById('navbar-wrapper');
            menu_wrapper.style.left = '-275px';
        });

        
    }

    if (document.getElementById('hid_ex_m_sell_to_us')){

        let ecurrency_asset = document.getElementById("asset-btn-1");
        let crypto_asset = document.getElementById("asset-btn-2");

        let assets_select_menu = document.querySelector("#selected-asset");

        let rate_output = document.getElementById('rate-value');

        let quantity_element = document.getElementById("quantity");

        let fee_element = document.getElementById("total-fee");

        let asset_radio = document.getElementsByName("asset-type");

        let asset_radio_selected = Array.from(asset_radio).find(radio => radio.checked);

        let asset_number = 0;
        

        let selected_rate = 0;

        ecurrency_asset.addEventListener('click', function(){
            asset_number = 1;
            retrieve_currency_assets( 'hid_ex_m_get_e_assets' );
        });

        crypto_asset.addEventListener('click', function(){
            asset_number = 2;
            retrieve_currency_assets( 'hid_ex_m_get_crypto_assets' )
        });

        function retrieve_currency_assets(recipient){

            $.ajax({
                url: script_data.ajaxurl, // The wordpress Ajax URL echoed on line 4
                data: {
                    // The action is the WP function that'll handle this ajax request
                    'action' : recipient
                  },
                  success:function( data ) {
                    
                    if (data['data'].length > 0){

                        // console.log(data['data']);

                        let asset_radio = document.getElementsByName("asset-type");

                        let asset_radio_selected = Array.from(asset_radio).find(radio => radio.checked);

                        let instructions = "";

                        let outputhtml = "";

                        data['data'].forEach(element => {
                            
                            // let selects = element['id'] == asset_id.value ? " selected" : "";

                            if (asset_radio_selected.value == 1){
                                instructions = element['sending_instruction'];
                            } else {
                                instructions = element['wallet_address']

                            }

                            outputhtml += "<option send='" + instructions.replace('\\','') + "' rate=" + element['buying_price']+ " value=" + element['id'] +">"+ element['name'] + " | " + element['short_name'] + "</option>";

                            // all_assets_rates[element['id']] = element['buying_price']

                        });

                        selected_rate = data['data'][0]['buying_price']

                        assets_select_menu.innerHTML = outputhtml;

                        rate_output.innerHTML = selected_rate;

                        

                        if (asset_radio_selected.value == 1){
                            instructions = data['data'][0]['sending_instruction'];
                        } else {
                            instructions = data['data'][0]['wallet_address']
                        }

                        document.getElementById("sending-instructions").innerHTML = instructions;

                        // current_rate = all_assets_rates[select_field.value];

                        // hidden_field.value = current_rate;

                        
                    }
                    
                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });

        }

        assets_select_menu.addEventListener("change", function(){
            selected_rate = assets_select_menu.options[assets_select_menu.selectedIndex].getAttribute('rate');

            let sending = assets_select_menu.options[assets_select_menu.selectedIndex].getAttribute('send');

            rate_output.innerHTML = selected_rate;

            document.getElementById("sending-instructions").innerHTML = sending;
        })

        function isNumberOrFloat(number){

            return /^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/.test(number);
            
        }

        quantity_element.addEventListener('input',function(){
            
            if (!isNumberOrFloat(quantity_element.value)){
                quantity_element.value = quantity_element.value.slice(0,-1)
            } else{

                let fee_ = quantity_element.value * selected_rate;

                fee_element.innerHTML = fee_.toFixed(2);
                
            }
        })

        // Image Selection
        let screenshot_upload = document.getElementById('upload-img');

        let image_input = document.getElementById('custom-file-input');

        screenshot_upload.addEventListener('click',function(e){
            e.preventDefault();
            $("input[type='file']").trigger('click');
        })

        $("input[type='file']").change(function(e){
            e.preventDefault();
            $('#image-name').text(this.value.replace(/C:\\fakepath\\/i, ''))

            // console.log(image_input.files[0]);
        }) 

        let recieving = document.getElementById('recieving-instructions');

        function isRecieving(data){

            return /^[0-9A-Za-z\s\-]+$/.test(data);
            
        }

        recieving.addEventListener('input',function(){
            if (!isRecieving(recieving.value)){
                recieving.value = recieving.value.slice(0,-1)
            } else{

                null;
                
            }
        })

        let order_form = document.getElementById('order-form');

        order_form.addEventListener('submit',function(e){

            e.preventDefault();

            let formData = new FormData(e.target);

            let error_message = "";

            let check_asset = false;
            let check_quantity = false;
            let check_proof = false;
            let check_recieving = false;

            // asset_radio_selected.value == 1

            if (assets_select_menu.value == 0 ){
                check_asset = false;
                error_message += "No Assets Selected<br>";
            } else {
                check_asset = true;
            }

            if (quantity_element.value == 0 || quantity_element.value == "" ){
                check_quantity = false;
                error_message += "Empty Quantity<br>";
            } else {
                check_quantity = true;
            }

            if (!image_input.value){
                check_proof = false;
                error_message += "No Image Selected<br>";
            } else {
                check_proof = true;
            }

            if (recieving.value.length < 6){
                check_recieving = false;
                error_message += "Invalid Recieving Instructions<br>";
            } else {
                check_recieving = true;
            }

            if (check_asset && check_quantity && check_proof && check_recieving){

                document.getElementById('error-message').style.display = 'none';

                let price = selected_rate * quantity_element.value;

                // let data = {
                //     action : 'hid_ex_m_submit_sell_order',
                //     asset_type : asset_number,
                //     asset_id : assets_select_menu.value,
                //     quantity_sold : quantity_element.value,
                //     amount_to_recieve : price.toFixed(2),
                //     file_data : image_input.files[0],
                //     action : 'file_upload',
                //     security : script_data.security

                // }

                formData.append('file', image_input.files[0]);
                formData.append('amount_to_recieve',price.toFixed(2));
                formData.append('chosen_asset_type', asset_number);
                formData.append('sending', recieving.value);
                formData.append('chosen_asset_id', assets_select_menu.value);
                formData.append('entered_quantity', quantity_element.value);
                formData.append('action', 'hid_ex_m_submit_sell_order');
                formData.append('security', script_data.security);

            $.ajax({
                type: 'POST',
                url: script_data.ajaxurl,
                data: formData,
                dataType: 'json',
                contentType: false,
                processData:false,

                success:function( data ) {

                    if (data['data'] == 1){

                        document.getElementById('error-message').innerHTML = "Success";
                        document.getElementById('error-message').style.display = "block";
                        document.getElementById('error-message').style.color = "green";

                        setInterval(function(){

                            location.reload();

                        },3000)

                    } else if (data['data'] == 0) {
                        
                        document.getElementById('error-message').innerHTML = "Order Unsuccessful";
                        document.getElementById('error-message').style.display = "block";
                        document.getElementById('error-message').style.color = "red";

                    }

                },
                error: function( errorThrown ){
                window.alert( errorThrown );
                }
            });
            } else {

                document.getElementById('error-message').innerHTML = error_message;

                document.getElementById('error-message').style.display = 'block';
            }
            
        })


    }

    if (document.getElementById('hid_ex_m_buy_from_us')){
        
        let ecurrency_asset = document.getElementById("asset-btn-1");
        let crypto_asset = document.getElementById("asset-btn-2");

        let assets_select_menu = document.querySelector("#selected-asset");

        let rate_output = document.getElementById('rate-value');

        let quantity_element = document.getElementById("quantity");

        let fee_element = document.getElementById("total-fee");

        let asset_radio = document.getElementsByName("asset-type");

        let asset_radio_selected = Array.from(asset_radio).find(radio => radio.checked);

        // Image Selection
        let screenshot_upload = document.getElementById('upload-img');

        let image_input = document.getElementById('custom-file-input');

        let order_form = document.getElementById('order-form');

        let asset_number = 0;
        

        let selected_rate = 0;

        ecurrency_asset.addEventListener('click', function(){
            asset_number = 1;
            retrieve_currency_assets_with_local_bank( 'hid_ex_m_get_e_assets_with_local_bank' );
        });

        crypto_asset.addEventListener('click', function(){
            asset_number = 2;
            retrieve_currency_assets_with_local_bank( 'hid_ex_m_get_crypto_assets_with_local_bank' )
        });

        function retrieve_currency_assets_with_local_bank(recipient){

            $.ajax({
                url: script_data.ajaxurl, // The wordpress Ajax URL echoed on line 4
                data: {
                    // The action is the WP function that'll handle this ajax request
                    'action' : recipient
                  },
                  success:function( data ) {
                    
                    if (data['data'].length > 0){

                        let instructions = "";

                        let outputhtml = "";

                        data['data'].forEach(element => {

                            let bank_name = element['bank']['bank_name'];
                            let bank_account_name = element['bank']['bank_account_name'];
                            let bank_account_number = element['bank']['bank_account_number'];

                            instructions = "Send to this account number ==> Bank Name - " + bank_name + " | Bank Account Name - " + bank_account_name + " | Bank Account Number - " + bank_account_number;

                            outputhtml += "<option send='" + instructions.replace('\\','') + "' rate=" + element['selling_price']+ " value=" + element['id'] +">"+ element['name'] + " | " + element['short_name'] + "</option>";

                        });

                        selected_rate = data['data'][0]['selling_price']

                        assets_select_menu.innerHTML = outputhtml;

                        rate_output.innerHTML = selected_rate;

                        let bank_name = data['data'][0]['bank']['bank_name'];
                        let bank_account_name = data['data'][0]['bank']['bank_account_name'];
                        let bank_account_number = data['data'][0]['bank']['bank_account_number'];
                        

                        instructions = "Send to this account number ==> Bank Name - " + bank_name + " | Bank Account Name - " + bank_account_name + " | Bank Account Number - " + bank_account_number;

                        document.getElementById("sending-instructions").innerHTML = instructions;
                        
                    }
                    
                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });

        }

        assets_select_menu.addEventListener("change", function(){
            selected_rate = assets_select_menu.options[assets_select_menu.selectedIndex].getAttribute('rate');

            let sending = assets_select_menu.options[assets_select_menu.selectedIndex].getAttribute('send');

            rate_output.innerHTML = selected_rate;

            document.getElementById("sending-instructions").innerHTML = sending;
        })

        function isNumberOrFloat(number){

            return /^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/.test(number);
            
        }

        quantity_element.addEventListener('input',function(){
            
            if (!isNumberOrFloat(quantity_element.value)){
                quantity_element.value = quantity_element.value.slice(0,-1)
            } else{

                let fee_ = quantity_element.value * selected_rate;

                fee_element.innerHTML = fee_.toFixed(2);
                
            }
        })

        let recieving = document.getElementById('recieving-instructions');

        function isRecieving(data){

            return /^[0-9A-Za-z\s\-]+$/.test(data);
            
        }

        recieving.addEventListener('input',function(){

            if (!isRecieving(recieving.value)){

                recieving.value = recieving.value.slice(0,-1);

            } else{

                null;
                
            }
        })

        screenshot_upload.addEventListener('click',function(e){
            e.preventDefault();
            $("input[type='file']").trigger('click');
        })

        $("input[type='file']").change(function(e){
            e.preventDefault();
            $('#image-name').text(this.value.replace(/C:\\fakepath\\/i, ''))

            // console.log(image_input.files[0]);
        }) 

        order_form.addEventListener('submit',function(e){

            e.preventDefault();

            let formData = new FormData(e.target);

            let error_message = "";

            let check_asset = false;
            let check_quantity = false;
            let check_proof = false;
            let check_recieving = false;

            // asset_radio_selected.value == 1

            if (assets_select_menu.value == 0 ){
                check_asset = false;
                error_message += "No Assets Selected<br>";
            } else {
                check_asset = true;
            }

            if (quantity_element.value == 0 || quantity_element.value == "" ){
                check_quantity = false;
                error_message += "Empty Quantity<br>";
            } else {
                check_quantity = true;
            }

            if (!image_input.value){
                check_proof = false;
                error_message += "No Image Selected<br>";
            } else {
                check_proof = true;
            }

            if (recieving.value.length < 6){
                check_recieving = false;
                error_message += "Invalid Recieving Instructions<br>";
            } else {
                check_recieving = true;
            }

            if (check_asset && check_quantity && check_proof && check_recieving){

                document.getElementById('error-message').style.display = 'none';

                let price = selected_rate * quantity_element.value;

                formData.append('file', image_input.files[0]);
                formData.append('amount_to_recieve',price.toFixed(2));
                formData.append('chosen_asset_type', asset_number);
                formData.append('sending', recieving.value);
                formData.append('chosen_asset_id', assets_select_menu.value);
                formData.append('entered_quantity', quantity_element.value);
                formData.append('action', 'hid_ex_m_submit_buy_order');
                formData.append('security', script_data.security);

            $.ajax({
                type: 'POST',
                url: script_data.ajaxurl,
                data: formData,
                dataType: 'json',
                contentType: false,
                processData:false,

                success:function( data ) {

                    if (data['data'] == 1){

                        document.getElementById('error-message').innerHTML = "Success";
                        document.getElementById('error-message').style.display = "block";
                        document.getElementById('error-message').style.color = "green";

                        setInterval(function(){

                            location.reload();

                        },3000)

                    } else if (data['data'] == 0) {
                        
                        document.getElementById('error-message').innerHTML = "Order Unsuccessful";
                        document.getElementById('error-message').style.display = "block";
                        document.getElementById('error-message').style.color = "red";

                    }

                },
                error: function( errorThrown ){
                window.alert( errorThrown );
                }
            });
            } else {

                document.getElementById('error-message').innerHTML = error_message;

                document.getElementById('error-message').style.display = 'block';
            }
            
        })


    }

    if (document.getElementById('hid_ex_m_settings')){
        function isAlphaSpace(data){

            return /^[A-Za-z\s\-]+$/.test(data);
            
        };

        function isPhoneNumber(number) {

            const regex = new RegExp('^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,8}$');

            return regex.test(number);
        }

        function isNumberOrFloat(number){

            return /^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/.test(number);
            
        }

        function isEmail(email) {
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
        }

        let first_name = document.getElementById('first-name');

        let last_name = document.getElementById('last-name');

        let phone = document.getElementById('phone-number');

        let email = document.getElementById('email');

        let password = document.getElementById('password');

        let re_password = document.getElementById('re-password');

        let profile_form = document.getElementById('order-form');

        first_name.addEventListener('input', function(){

            if (!isAlphaSpace(first_name.value)){
                first_name.value = first_name.value.slice(0,-1)

            } else{

                null;
                
            }
        });

        last_name.addEventListener('input', function(){

            if (!isAlphaSpace(last_name.value)){
                last_name.value = last_name.value.slice(0,-1)

            } else{

                null;
                
            }
        });

        phone.addEventListener('input', function(){

            if (!isPhoneNumber(phone.value)){
                phone.value = phone.value.slice(0,-1)

            } else{

                null;
                
            }
        });

        email.addEventListener('input', function(){

            if (!isEmail(email.value)){
                email.value = email.value.slice(0,-1)

            } else{

                null;
                
            }
        });

        profile_form.addEventListener('submit', function(e){
            e.preventDefault();

            let event = e.target

            let formData = new FormData(event);

            let error_item = document.getElementById('error-message');
            let success_item = document.getElementById('success-message');

            if (!(password.value == re_password.value)){
                error_item.innerHTML = "Password MisMatch";
                error_item.style.display = "block";
                error_item.style.color = "red";
                
                return;
            }

            error_item.style.display = "none";

            formData.append('action','hid_ex_m_update_customer');

            // for (let key of formData.keys()){
            //     console.log(key,formData.get(key));
            // }

            $.ajax({
                type: 'POST',
                url: script_data.ajaxurl,
                data: formData,
                dataType: 'json',
                contentType: false,
                processData:false,//this is a must

                success:function( data ) {

                    if (data['data'] == 0){
                        error_item.innerHTML = "Incorrect Password";
                        error_item.style.display = "block";
                        error_item.style.color = "red";
                    } else if (data['data'] == 1){
                        success_item.innerHTML = "User Profile Updated Successfully.<br>Refreshing Profile Details...";
                        
                        error_item.style.display = 'none';

                        success_item.style.display = "block";

                        setTimeout(function(){
                            location.reload();
                        }, 3000)
                    }

                },
                error: function( errorThrown ){
                window.alert( errorThrown );
                }
            });

        });


    }

    if (document.getElementById('hid_ex_m_support')){
        function isAlphaSpaceNum(data){

            return /^[0-9A-Za-z\s\-]+$/.test(data);
            
        };

        let title = document.getElementById('ticket-title');

        let body = document.getElementById('ticket-details');

        let open_ticket_form = document.getElementById('ticket-open-form');

        let current_ticket_id = 0;

        title.addEventListener('input', function(){

            if (!isAlphaSpaceNum(title.value)){
                title.value = title.value.slice(0,-1)

            } else{

                null;
                
            }
        });

        body.addEventListener('input', function(){

            if (!isAlphaSpaceNum(body.value)){
                body.value = body.value.slice(0,-1)

            } else{

                null;
                
            }
        });

        open_ticket_form.addEventListener('submit', function(ev){

            ev.preventDefault();

            let event = ev.target;
            let ticket_data = new FormData(event);

            let check_title = false;
            let check_body = false;
            let error_msg = '';

            if (title.value.length < 10 ){
                check_title = false;
                error_msg += "Title requires a minimum of 10 Characters<br>";
            } else {
                check_title = true;
            }

            if (body.value.length < 30 ){
                check_body = false;
                error_msg += "Ticket's Description requires a minimum of 30 Characters";
            } else {
                check_body = true;
            }

            if (!(check_title && check_body)){

                document.getElementById('error-msg').innerHTML = error_msg;

                document.getElementById('error-msg').style.display = 'block';

                error_msg = '';

                return;

            } else {
                document.getElementById('error-msg').style.display = 'none';
                
            }

            ticket_data.append('action','hid_ex_m_customer_open_new_support_ticket');

            $.ajax({
                type: 'POST',
                url: script_data.ajaxurl,
                data: ticket_data,
                dataType: 'json',
                contentType: false,
                processData:false,

                success:function( data ) {

                    if (data['data'] == 0){

                        document.getElementById('error-msg').innerHTML = "Ticket Submission Unsuccessful";
                        document.getElementById('error-msg').style.display = "block";
                        document.getElementById('error-msg').style.color = "red";

                    } else if (data['data'] == 1){

                        document.getElementById('error-msg').style.display = 'none';

                        document.getElementById('success-msg').innerHTML = "Ticket Submission Successful.<br>Refreshing ...";
                        
                        document.getElementById('success-msg').style.display = "block";

                        setTimeout(function(){
                            location.reload();
                        }, 3000)
                    }

                },
                error: function( errorThrown ){
                window.alert( errorThrown );
                }
            });


        });

        // Open support chat
        let open_chat_btns = document.getElementsByClassName('open-support-chat');

        for (let index = 0; index < open_chat_btns.length; index++) {
            let current_btn = open_chat_btns[index];

            let ticket_id = current_btn.getAttribute('ticket');
            let chats_area = document.getElementById('chats-area-box');

            let chat_box = document.getElementById('chat-box');

            current_btn.addEventListener('click',function(){
                
                current_ticket_id = ticket_id;
                chats_area.style.display = 'none';
                chat_box.innerHTML = '';

                id_data = new FormData();
                id_data.append('ticket-id' , ticket_id );
                id_data.append('action' , 'hid_ex_m_retrieve_ticket_chats' );

                $.ajax({
                    type: 'POST',
                    url: script_data.ajaxurl,
                    data: id_data,
                    dataType: 'json',
                    contentType: false,
                    processData:false,
    
                    success:function( data ) {
    
                        if (data['data'].length == 0){

                            chat_box.innerHTML = "<center><p id='no-chat-item'>No Chats Available on this ticket</p><span class='time-sent' style='display: none;'>0000-00-00 00:00:00</span></center>";

                            chats_area.style.display = 'block';
                            

                        } else {

                            let build_string = "";

                            data['data'].forEach(element => {

                                build_string += '<div class="single-chat ';

                                build_string += (element['sender'] == "Admin") ? 'admin-chat">' : 'user-chat">';

                                if (element['message'] != ""){
                                    build_string += '<p>' + element['message'] +'</p>';
                                }

                                if (element['attachment'] != 0){
                                    build_string += '<a href="' + element['attachment_url'] +'" target="_blank">Click Here to view attachment</a></br>'
                                }

                                build_string += '<span class="time-sent">' + element['time_stamp'] + '</span></div>'
                                
                            });

                            chat_box.innerHTML = build_string;

                            chats_area.style.display = 'block';

                            

                        }
    
                    },
                    error: function( errorThrown ){
                    window.alert( errorThrown );
                    }
                });

                let chat_time_sent = document.getElementsByClassName('time-sent');

                setInterval(function(){ 
            
                    let last_chat_time = chat_time_sent[chat_time_sent.length - 1].innerHTML;
        
                    $.ajax({
        
                        url: script_data.ajaxurl, 
                        
                        data: {
                            
                            'action' : 'hid_ex_m_get_recent_chats_view',
                            'time' : last_chat_time,
                            'ticket_id' : current_ticket_id
                        },
        
                        success:function( data ) {
        
                            if (data['data'] != 0){
        
                                if (document.getElementById('no-chat-item')){
                                    document.getElementById('no-chat-item').remove(); 
                                }
        
                                let build_string = "";
        
                                data['data'].forEach(element => {
        
                                    build_string += '<div class="single-chat ';
        
                                    build_string += (element['sender'] == "Admin") ? 'admin-chat">' : 'user-chat">';
        
                                    if (element['message'] != ""){
                                        build_string += '<p>' + element['message'] +'</p>';
                                    }
        
                                    if (element['attachment'] != 0){
                                        build_string += '<a href="' + element['attachment_url'] +'" target="_blank">Click Here to view attachment</a></br>'
                                    }
        
                                    build_string += '<span class="time-sent">' + element['time_stamp'] + '</span></div>'
                                    
                                });
        
        
                                chat_box.innerHTML += build_string;
        
                            }
        
                        },
                        error: function( errorThrown ){
                            window.alert( errorThrown );
                        }
                    });
                    
                }, 3000);

            })
            
        }

        // Image Selection
        let attach_upload = document.getElementById('new-chat-attach');

        let image_input = document.getElementById('custom-file-input');

        attach_upload.addEventListener('click',function(e){
            e.preventDefault();
            $("input[type='file']").trigger('click');
        })

        $("input[type='file']").change(function(e){
            e.preventDefault();
            $('#custom-file-input').text(this.value.replace(/C:\\fakepath\\/i, ''))

            let output_name = "";

            output_name = image_input.files[0].name;

            if (image_input.files[0].name.length > 40){
                output_name = "..." + image_input.files[0].name.slice(-40);

            }

            output_span.innerHTML = output_name;

            output_span.className = 'success-file';

            output_span.style.display = 'block';

            // console.log(image_input.files[0]);
        })

        let chat_form_customer = document.getElementById('send-new-chat');

        let output_span = document.getElementById('attach-name');

        chat_form_customer.addEventListener('submit', function(ev){

            ev.preventDefault()

            let event = ev.target;
            let formData = new FormData(event);

            let check_text = false;
            let check_attach = false;

            let textbox = document.getElementById('new-chat-text');

            let text = textbox.value;

            if (text.length === 0 && !(image_input.files[0])){

                output_span.innerHTML = "No Texts entered - No Image selected";

                output_span.className = 'fail-file';

                output_span.style.display = 'block';

                return;

            }

            formData.append('ticket', current_ticket_id);
            formData.append('file', image_input.files[0]);
            formData.append('action', 'hid_ex_m_create_a_new_chat');
            formData.append('security', script_data.security);



            $.ajax({
                type: 'POST',
                url: script_data.ajaxurl,
                data: formData,
                dataType: 'json',
                contentType: false,
                processData:false,

                success:function( data ) {

                    if (data['data'] == -1){
                        output_span.innerHTML = "Error Sending message";

                        output_span.className = 'fail-file';

                        output_span.style.display = 'block';
                    } else {

                        output_span.style.display = 'none';
                        chat_form_customer.reset();
                        

                    }

                },
                error: function( errorThrown ){
                window.alert( errorThrown );
                }
            });



        });

    }

    if (document.getElementById('hid_ex_m_currency-calculator')){

        let ecurrency_asset = document.getElementById('asset-btn-1');

        let crypto_asset = document.getElementById('asset-btn-2');

        let select_input_wrapper = document.getElementById('asset-selection');

        let out_buy = document.getElementById('output-buying');

        let out_sell = document.getElementById('output-selling');

        let out_buy_q = document.getElementById('output-buying-q');

        let out_sell_q = document.getElementById('output-selling-q');

        let quantity_element = document.getElementById('item-quantity');

        let calculator_close_btn = document.getElementById('close-rate-calculator');

        let buying_price = 0;
        let selling_price = 0;

        function isNumberOrFloat(number){

            return /^[+-]?([0-9]+\.?[0-9]*|\.[0-9]+)$/.test(number);
            
        }

        calculator_close_btn.addEventListener('click', function(){
            document.getElementById('hid_ex_m_currency-calculator').style.display = 'none';
        });

        ecurrency_asset.addEventListener('click', function(){
            retrieve_currency_assets( 'hid_ex_m_get_e_assets' );
        });

        crypto_asset.addEventListener('click', function(){
            retrieve_currency_assets( 'hid_ex_m_get_crypto_assets' )
        });

        function retrieve_currency_assets(recipient){

            $.ajax({
                url: script_data.ajaxurl, // The wordpress Ajax URL echoed on line 4
                data: {
                    // The action is the WP function that'll handle this ajax request
                    'action' : recipient
                  },
                  success:function( data ) {
                    
                    if (data['data'].length > 0){

                        let outputhtml = "";

                        data['data'].forEach(element => {

                            outputhtml += "<option selling='" + element['selling_price'] + "' buying='" + element['buying_price'] + "' value=" + element['id'] + ">" +element['name'] + " | " + element['short_name'] + "</option>"

                        });

                        buying_price = data['data'][0]['buying_price'];

                        selling_price = data['data'][0]['selling_price'];

                        select_input_wrapper.innerHTML = outputhtml;

                        update_output();
                    }
                    
                  },
                  error: function( errorThrown ){
                      window.alert( errorThrown );
                  }
              });

        }

        quantity_element.addEventListener('input',function(){
            
            if (!isNumberOrFloat(quantity_element.value)){
                quantity_element.value = quantity_element.value.slice(0,-1)
            } else{

                update_output();
                
            }
        })

        function update_output(){

            if (!quantity_element.value){
                qty = 0;
            }

            out_buy.innerHTML = buying_price;

            out_sell.innerHTML = selling_price;

            let buy_temp = quantity_element.value * buying_price;

            out_buy_q.innerHTML = buy_temp.toFixed(2);

            let sell_temp = quantity_element.value * selling_price;

            out_sell_q.innerHTML = sell_temp.toFixed(2);
        }

        select_input_wrapper.addEventListener("change", function(){
            buying_price = select_input_wrapper.options[select_input_wrapper.selectedIndex].getAttribute('buying');

            selling_price = select_input_wrapper.options[select_input_wrapper.selectedIndex].getAttribute('selling');

            update_output()
        })

    }

    if (document.getElementsByClassName('open-calculator')){

        let calculator_open_btns = document.getElementsByClassName('open-calculator');

        for (let index = 0; index < calculator_open_btns.length; index++) {
            const element = calculator_open_btns[index];

            element.addEventListener('click',function(){
                document.getElementById('hid_ex_m_currency-calculator').style.display = 'flex';
            })
            
        }
    }



});
