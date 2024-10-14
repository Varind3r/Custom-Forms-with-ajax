jQuery(document).ready(function(){

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return !value.indexOf(" ") == 0;
    }, "Space in starting are not allowed");
    
    jQuery.validator.addMethod("isValidEmailAddress", function(value, element) {
        var pattern =
            /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(value);
    }, "Please enter a valid email address.");

/*----------------------------------------------------------------------------------------------
                                     Registration -  Start
----------------------------------------------------------------------------------------------*/

$('form[id="registration_form"]').validate({
    rules: {
        full_name: {
            noSpace: true,
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        email: {
            noSpace: true,
            required: true,
            isValidEmailAddress: true,
        },
        address: {
            noSpace: true,
            required: true,
            minlength: 5,
            maxlength: 50,
        },
        // country: {
        //     noSpace: true,
        //     required: true,
        //     minlength: 3,
        //     maxlength: 20,
        // },
        // state: {
        //     noSpace: true,
        //     required: true,
        //     minlength: 3,
        //     maxlength: 20,
        // },
        // city: {
        //     noSpace: true,
        //     required: true,
        //     minlength: 3,
        //     maxlength: 20,
        // },
        // zip_code: {
        //     noSpace: true,
        //     required: true,
        //     minlength: 3,
        //     maxlength:8,
        // },
        
        password: {
            noSpace: true,
            required: true,
            minlength: 6
        },
        password_confirmation: {
            noSpace: true,
            required: true,
            minlength: 6,
            equalTo: "#reg-pass"
        },
    },

    submitHandler: function() {
        document.getElementById("reg_btn").disabled = true;

        // let link = "<?php echo admin_url('admin-ajax.php')?>";
        var link = admin_ajax.ajaxurl;
        var homeurl = admin_ajax.homeurl;
        var form = document.querySelector("#registration_form");
        var formData = new FormData(form);
        formData.append('action', 'registration_form_submit');

        jQuery.ajax({

            type: "POST",
            url: link,
            async: true,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,



            success: function(response) {
                document.getElementById("reg_btn").disabled = false;

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: response.message
                    }).then(function() {
                        window.location.href = homeurl+'/login';
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    }
});

/*----------------------------------------------------------------------------------------------
                                    Registration -  End
-----------------------------------------------------------------------------------------------*/



/*---------------------------------------------------------------------------------------------
                                    Login -  Start
----------------------------------------------------------------------------------------------*/

$('form[id="login_form"]').validate({
    rules: {
        login_email: {
            required: true,
            noSpace: true,
            isValidEmailAddress: true,
        },
        login_password: {
            required: true,
            noSpace: true,
            minlength: 6
        }
    },
    submitHandler: function() {
        document.getElementById("login_btn").disabled = true;
        var link = admin_ajax.ajaxurl;
        var homeurl = admin_ajax.homeurl;
        var form = document.querySelector("#login_form");
        var formData = new FormData(form);
        formData.append('action', 'login_form_submit');

        jQuery.ajax({

            type: "POST",
            // url: window.WordPress.AJAX_URL,
            url: link,
            async: true,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,

            success: function(response) {
                document.getElementById("login_btn").disabled = false;

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: response.message
                    }).then(function() {
                        window.location.href = homeurl;
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            }
        });
    }
});
/*-------------------------------------------------------------------------------------
                                    Login -  End
--------------------------------------------------------------------------------------*/



/*-------------------------------------------------------------------------------------
                                    Forget Password -  Start
-------------------------------------------------------------------------------------*/

$('form[id="forgot_password_form"]').validate({
    rules: {
        email: {
            required: true,
            isValidEmailAddress: true,
        },
    },

    submitHandler: function() {
        document.getElementById("forgot_submit_btn").disabled = true;
        document.getElementById("loader").style.display = "block";
        // document.getElementById("loading").style.display = "inline-block";
        var link = admin_ajax.ajaxurl;
        var homeurl = admin_ajax.homeurl;
        // let link = "<?php echo admin_url('admin-ajax.php') ?>";
        let email = document.querySelector('input[type="email"]').value;

        jQuery.ajax({

            type: "POST",
            url: link,
            async: true,
            data: {
                action: 'forgot_password_form_submit',
                email: email,
            },
            cache: false,

            success: function(response) {
                document.getElementById("forgot_submit_btn").disabled = false;
                document.getElementById("loader").style.display = "none";

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: response.message
                    }).then(function() {
                        window.location.href = homeurl;
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    }
});

/*------------------------------------------------------------------------------------
                                    Forget Password -  End
------------------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------------------------
                                    Reset Password -  Start
---------------------------------------------------------------------------------------------*/

$('form[id="reset_pass_form"]').validate({
    rules: {
        password: {
            noSpace: true,
            required: true,
            minlength: 6
        },
        confirm_password: {
            noSpace: true,
            required: true,
            minlength: 6,
            equalTo: "#password"
        },
    },

    submitHandler: function() {
        document.getElementById("reset_form_submit_btn").disabled = true;

        // let link = "<?php echo admin_url('admin-ajax.php') ?>";
        var link = admin_ajax.ajaxurl;
        var homeurl = admin_ajax.homeurl;
        let password = document.querySelector('#password').value;
        let user_id = document.querySelector('#user_id').value;

        jQuery.ajax({

            type: "POST",
            url: link,
            async: true,
            data: {
                action: 'reset_pass_form_submit',
                password: password,
                user_id: user_id,
            },
            cache: false,

            success: function(response) {
                document.getElementById("reset_form_submit_btn").disabled = false;

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: response.message
                    }).then(function() {
                        window.location.href = homeurl;
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    }
});

/*--------------------------------------------------------------------------------------------
                                     Reset Password -  End
---------------------------------------------------------------------------------------------*/


/*-------------------------------------------------------------------------------------------- 
                                Change-Password Form - Start 
---------------------------------------------------------------------------------------------*/

$('form[id="change_pw_form"]').validate({
    rules: {
        currentPassword: {
            required: true,
            minlength: 6,
            noSpace: true,
        },
        newPassword: {
            required: true,
            minlength: 6,
            noSpace: true,
        },
        confirmPassword: {
            required: true,
            minlength: 6,
            noSpace: true,
            equalTo: "#newPassword"
        }
    },
    submitHandler: function() {

        // let link = "<?php echo admin_url('admin-ajax.php')?>";
        var link = admin_ajax.ajaxurl;
        var homeurl = admin_ajax.homeurl;
        let current_password = $("#currentPassword").val();
        let new_password = $("#newPassword").val();
        var formData = new FormData();
        formData.append('action', 'change_pw_form_submit');
        formData.append('current_password', current_password);
        formData.append('new_password', new_password);

        jQuery.ajax({
            type: "POST",
            url: link,
            async: true,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,

            success: function(response) {

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: response.message
                    }).then(function() {
                        window.location.href = homeurl+'/login';
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    }
});

/*--------------------------------------------------------------------------------------------
                                Change-Password Form - End 
--------------------------------------------------------------------------------------------*/



/*--------------------------------------------------------------------------------
                                Contact us - Start
-----------------------------------------------------------------------------------*/

$('form[id="contact_form"]').validate({
    rules: {
        name: {
            noSpace: true,
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        email: {
            noSpace: true,
            required: true,
            isValidEmailAddress: true,
        },
        contact_number: {
            noSpace: true,
            required: true,
            minlength: 10,
            maxlength: 15,
        },
        message: {
            noSpace: true,
            required: true,
            minlength: 5,
            maxlength: 250,
        },

    },

    submitHandler: function() {
        document.getElementById("submit_btn").disabled = true;
        document.getElementById("loader").style.display = "block";

        var link = admin_ajax.ajaxurl;
        var homeurl = admin_ajax.homeurl;

        var form = document.querySelector("#contact_form");
        var formData = new FormData(form);
        formData.append('action', 'contact_form_submit');

        jQuery.ajax({

            type: "POST",
            url: link,
            async: true,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,

            success: function(response) {
                document.getElementById("submit_btn").disabled = false;
                document.getElementById("loader").style.display = "none";

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        text: response.message
                    }).then(function() {
                        window.location.href = homeurl;
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                alert('An error occurred.');
            }
        });
    }
});
/*-----------------------------------------------------------------------------------
                                Contact us - End
-------------------------------------------------------------------------------------*/



/*--------------------------------------------------------------------------------------------
                                Owl Carousel - Start 
--------------------------------------------------------------------------------------------*/
$(function() {
    var owl = $(".owl-carousel");
    owl.owlCarousel({
        margin: 10,
        loop: true,
        nav: true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:2,
                nav:false
            },
            1000:{
                items:3,
                nav:true,
                loop:false
            }
        }
        });
});
/*--------------------------------------------------------------------------------------------
                                Owl Carousel - End 
--------------------------------------------------------------------------------------------*/

});



/*--------------------------------------------------------------------------------------------
                                 Custom cart quantity - Start
--------------------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

    // Replace up arrow with plus sign
    $('.quantity .qty').replaceWith('<div class="quantity"><span class="minus">-</span><input type="text" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" /><span class="plus">+</span></div>');

    // Handle quantity increase/decrease
    $(document).on('click', '.plus, .minus', function() {
        // Get the quantity input field
        var $qty = $(this).closest('.quantity').find('.qty');

        // Get the current quantity value
        var currentVal = parseFloat($qty.val());

        // Check if the button clicked is plus or minus
        if ($(this).hasClass('plus')) {
            // Increase the quantity by 1
            $qty.val(currentVal + 1);
        } else {
            // Decrease the quantity by 1, but not below 1
            $qty.val(currentVal - 1 >= 1 ? currentVal - 1 : 1);
        }
    });   

});
/*--------------------------------------------------------------------------------------------
                                    Custom cart quantity - End
--------------------------------------------------------------------------------------------*/
