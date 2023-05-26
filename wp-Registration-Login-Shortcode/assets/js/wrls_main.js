$(document).ready(function(){
 

    //Register Page JQuery
    $('#register_form').validate({
        rules: {
            full_name: {
                required:true,
                minlength: 5
            },
            Username: {
                required:true,
                minlength: 9  
            },
            Email: {
                required: true,
                email: true
            },
            Phone_Number: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 8
               
            },

            Confirm_Password: {
                equalTo: "#password"
            },
            
        },
        messages:{
            full_name: {
                required: "<strong>Opps!</strong> Full Name must be required !!",
                minlength:"must be 5 characters required"
            },
            Username: {
                required: "<strong>Opps!</strong> Username must be required !!",
                minlength:"must be 9 characters required"
            },
            Email: {
                required: "<strong>Opps!</strong> Email must be required !!",
                email:    "Please enter a valid email address"
            },
            Phone_Number: {
                required: "<strong>Opps!</strong> Phone Number must be required !!",
                digits:   "Please enter valid phone number",
                minlength:"Phone number field accept only 10 digits",
                maxlength:"Phone number field accept only 10 digits"
            },
            password: {
                required:"<strong>Opps!</strong> Password must be required !!",
                email:   "must be 8 characters required"
            },
        },
        submitHandler: function(){

            var full_name    = $('#full_name').val();      
            var Username     = $('#Username').val();  
            var Email        = $('#Email').val(); 
            var Phone_Number = $('#Phone_Number').val();  
            var password     = $('#password').val(); 
          
           
            var form_data = new FormData();                  
            form_data.append('full_name', full_name);
            form_data.append('Username', Username);
            form_data.append('Email', Email);
            form_data.append('Phone_Number', Phone_Number);
            form_data.append('password', password );
            form_data.append('action', "wrls_get_register_user");
                                  
             
            $.ajax({
                url: wpadmin.wpadmin_url, 
                dataType: 'json', 
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: "POST",
                success: function(response){
                    if(response.status == true){
                        Swal.fire({
                            title: "Success!",
                            text : response.message,
                            icon : "success",
                            allowOutsideClick: false,   
                            confirmButtonText: "Aww yiss!"
                        }).then(function(){
                            var home_url = $("#home_url").val();
                            window.location.href = home_url;  
                        });     
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            allowOutsideClick: false,   
                            html: response.message,
                            confirmButtonText: 'Okay'
                        }).then(function(){
                            location.reload(true); 
                        });  
                    }
                }      
           });
        }
    });



  // login page JQuery
  $('#login_form').validate({
    rules: {
        login_Username: {
            required: true
        },
        login_password: {
            required: true 
        },
    },
    messages:{
        login_Username: {
            required: "<strong>Opps!</strong> Username must be required !!"
        },
        login_password: {
            required:"<strong>Opps!</strong> Password must be required !!"
        },
    },
    submitHandler: function(){
        var login_Username=$("#login_Username").val();
        var login_password=$("#login_password").val();
    

        $.ajax({
            url: wpadmin.wpadmin_url, 
            type: "POST",
            dataType: 'json', 
            data:{
                action   :'wrls_get_login_user',
                login_Username:login_Username,
                login_password:login_password
            },                         
            success: function(response){ 
                if(response.status == true){
                    Swal.fire({
                        title: "Success!",
                        text:  response.message,
                        icon:  "success",
                        allowOutsideClick: false, 
                        confirmButtonText: "Aww yiss!"
                    }).then(function(){
                        var admin_url = $("#admin_url").val();
                        window.location.href = admin_url; 
                    });  
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        allowOutsideClick: false, 
                        html: response.message,
                        confirmButtonText: 'Okay',
                        showCloseButton: true
                      });
                }
            }
        });
    }
}); 
});