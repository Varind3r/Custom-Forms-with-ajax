<?php
/* Template Name: Change Password */
get_header();
?>

<h2 class="title">Change your current password</h2>
<div>
    <form action="" id="change_pw_form" class="bank-details-page" onsubmit="event.preventDefault();">
        <div class="form-group">
            <label for="currentPassword" class="form-label">Current Password <span class="red_star">*</span></label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword">
        </div>
        <div class="form-group">
            <label for="newPassword" class="form-label">New Password <span class="red_star">*</span></label>
            <input type="password" class="form-control" id="newPassword" name="newPassword">
        </div>
        <div class="form-group">
            <label for="confirmPassword" class="form-label">Confirm Password <span class="red_star">*</span></label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
        </div>
        <div class="form-group">
            <button type="submit" class="btn-next">Change password</button>
        </div>
    </form>
</div>


<script>
/*------------------------------------------------------------------ 
                   Change Password Form - Start 
-------------------------------------------------------------------*/

jQuery.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "White Space not allowed.");



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

        let link = "<?php echo admin_url('admin-ajax.php')?>";

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
                        window.location.href = "<?php echo home_url(); ?>";
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


/*---------------------------------------------------------------------------
                      Change Password Form - End 
---------------------------------------------------------------------------*/
</script>

<?php
get_footer();
?>



/*----------------------------------------------------------------------------------------------------------------------------
                                       Change Password Form - Start
----------------------------------------------------------------------------------------------------------------------------*/
add_action('wp_ajax_change_pw_form_submit', 'change_pw_form_submit');
add_action('wp_ajax_nopriv_change_pw_form_submit', 'change_pw_form_submit');
   
function change_pw_form_submit() {
	
	$user_id = get_current_user_id();
	$user_data = get_userdata( $user_id );
	$pass_in_db = $user_data->data->user_pass;
	$current_pass = $_POST['current_password'];
	$new_password = $_POST['new_password'];

	$matched = wp_check_password( $current_pass, $pass_in_db, $user_id );

	if ( $matched ) {
		// wp_update_user(array('ID' => $user_id, 'user_pass' => $new_password));
		wp_set_password($new_password, $user_id);
		// // Get the user data
		// $user = get_user_by('ID', $user_id);

		// // Sign in the user again with the updated credentials
		// $credentials = array(
		// 	'user_login'    => $user->user_login,
		// 	'user_password' => $new_password,
		// 	'remember'      => true,
		// );

		// wp_signon($credentials);
		$response = array(
			'status'  => 'success',
			'message' => 'Password changed successfully. Please login with new password.'
		);
	} else {
		$response = array(
			'status'  => 'error',
			'message' => 'Current password is wrong.'
		);
	}
	wp_send_json( $response );
}
/*----------------------------------------------------------------------------------------------------------------------------
                                       Change Password Form - End
----------------------------------------------------------------------------------------------------------------------------*/