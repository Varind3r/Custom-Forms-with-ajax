<div class="tab-pane fade <?php echo $currentTab == 'register' ? 'show active': '' ?>" id="pills-profile" role="tabpanel"
aria-labelledby="pills-profile-tab">
<div class="card register-area">
    <div class="card-body">
        <h4 class="margin-bottom-1x text-center form-title">Create an account</h4>
        <form class="row" id="registration_form">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="reg-fn">First Name <span class="error">*</span></label>
                    <input class="form-control" type="text" name="first_name"
                        placeholder="Enter Your First Name" id="first_name" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reg-fn">Last Name <span class="error">*</span></label>
                    <input class="form-control" type="text" name="last_name"
                        placeholder="Enter Your Last Name" id="last_name" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reg-email">Email <span class="error">*</span></label>
                    <input class="form-control" type="email" name="email"
                        placeholder="Enter Your Email Address" id="email" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reg-ln">Contact Number <span class="error">*</span></label>
                    <input class="form-control" type="tel" name="contact_number"
                        placeholder="Enter Your Contact Number" id="contact_number"
                        value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reg-pass">Password <span class="error">*</span></label>
                    <input class="form-control toggle_pass" type="password" name="password"
                        placeholder="Enter Your Password" id="reg-pass">
                        <i class="fa-regular fa-eye-slash reg_pass_eye_off" onclick="showHidePass(this, '.reg_pass_eye_on', '#reg-pass', 'hide');"></i>
                        <i class="fa-regular fa-eye reg_pass_eye_on" style="display:none;" onclick="showHidePass(this, '.reg_pass_eye_off', '#reg-pass', 'show');"></i>
                    
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group">
                    <label for="reg-pass-confirm">Confirm Password <span
                            class="error">*</span></label>
                    <input class="form-control toggle_pass" type="password"
                        name="password_confirmation" placeholder="Confirm Your Password"
                        id="reg-pass-confirm">
                        <i class="fa-regular fa-eye-slash reg_pass_conf_eye_off" onclick="showHidePass(this, '.reg_pass_conf_eye_on','#reg-pass-confirm','hide');"></i>
                        <i class="fa-regular fa-eye reg_pass_conf_eye_on" style="display:none;" onclick="showHidePass(this, '.reg_pass_conf_eye_off','#reg-pass-confirm','show');"></i>
                </div>
            </div>


            <div class="col-12 text-center register_btn">
                <button class="nav-link btn" type="submit"
                    id="reg_btn"><span>Register</span></button>
            </div>
        </form>
    </div>
</div>
</div>




<script>

/*----------------------------------------------------------------------------------------------------------------------------
                                                  Registration -  Start
----------------------------------------------------------------------------------------------------------------------------*/
jQuery.validator.addMethod("noSpace", function(value, element) {
    return !value.indexOf(" ") == 0;
}, "Space in starting are not allowed");

$.validator.addMethod("customPhoneNumberValidation", function(value, element) {
    // Customize this regular expression to match your desired phone number format
    // This example matches a simple 10-digit US phone number format
    return this.optional(element) || /^\d{10}$/.test(value);
}, "Please enter a valid phone number");

$('form[id="registration_form"]').validate({
    rules: {
        first_name: {
            noSpace: true,
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        last_name: {
            noSpace: true,
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        email: {
            noSpace: true,
            required: true,
            email: true,
        },
        contact_number: {
            noSpace: true,
            required: true,
            minlength: 10,
            maxlength: 15,
            customPhoneNumberValidation: true,
        },
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

        let link = "<?php echo admin_url('admin-ajax.php')?>";

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
                        window.location.href = "<?php echo home_url();?>/login";
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
/*---------------------------------------------------------------------------------------------------------------------------
                                                  Registration -  End
----------------------------------------------------------------------------------------------------------------------------*/





/*---------------------------------------------------------------------------------------------------------------------------------- 
													Function to register student - start
---------------------------------------------------------------------------------------------------------------------------------- */
add_action("wp_ajax_registration_form_submit", "registration_form_submit");
add_action("wp_ajax_nopriv_registration_form_submit", "registration_form_submit");

function registration_form_submit() {

		$response = array();

		// Sanitize and validate input
		$first_name       = sanitize_text_field( $_POST['first_name'] );
		$last_name        = sanitize_text_field( $_POST['last_name'] );
		$email            = sanitize_email( $_POST['email'] );
		$password         = sanitize_text_field( $_POST['password'] );
		$contact_number   = sanitize_text_field( $_POST['contact_number'] );

		if ( email_exists( $email ) ) {
			$response['status'] = 'error';
			$response['message'] = 'Email already exists in our database. Please try with another one.';
		} else {
			// Create user data
			$userdata = array(
				'user_login' => $email,
				'user_pass' => $password,
				'user_email' => $email,
				'display_name' => $first_name.' '.$last_name,
			);
			$user_id = wp_insert_user( $userdata );

			if ( is_wp_error( $user_id ) ) {
				$response['status'] = 'error';
				$response['message'] = 'User registration failed. Please try again.';
			} else {
				// Add user meta data
				$user_meta = array(
					'first_name'     => $first_name,
					'last_name'      => $last_name,
					'contact_number' => $contact_number,
				);
				foreach ( $user_meta as $meta_key => $meta_value ) {
					update_user_meta( $user_id, $meta_key, $meta_value );
				}

				$response['status'] = 'success';
				$response['message'] = 'User registered successfully.';
			}
		}
	
	wp_send_json( $response );
}


/*---------------------------------------------------------------------------------------------------------------------------------- 
													Function to register student - end
---------------------------------------------------------------------------------------------------------------------------------- */


</script>