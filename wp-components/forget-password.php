<?php
/* Template Name: Forgot Password */
get_header('secondary');
?>

<section class="reg-form">
	<div class="row">
		<div class="col-md-6">
			<img class="img-size" src="<?php echo get_stylesheet_directory_uri(); ?>/images/register-form-img.png"
				alt="register-form-img">
		</div>
		<div class="col-md-6 d-flex align-items-center position-relative pt-3">
			<a class="home" href="<?php echo home_url(); ?>"> <i class="fa-solid fa-arrow-left-long text-blue"></i>
				&nbsp; Back To Home</a>
			<div class="card register-area">
				<div class="card-body">
					<form class="row" id="forgot_password_form" onsubmit="event.preventDefault();">
						<div class="form-logo">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/black-logo.png" alt="">
						</div>
						<h4 class="margin-bottom-1x form-title mb-lg-4 mb-md-2">Enter your email address to reset your
							password</h4>
						<div class="col-md-12">
							<div class="form-group">
								<label for="reg-fn">Email <span class="error">*</span></label>
								<input class="form-control" type="email" name="email" placeholder="Enter Your Email"
									id="email" value=""><span class="input-group-addon">
								</span>
							</div>
						</div>


						<div class="col-12 text-center register_btn mt-4">
							<button class="nav-link btn mb-2" type="submit" id="forgot_submit_btn"><span>Reset
									Password</span>
								<span class="loader" id="loader" style="display:none;"></span>
							</button>

						</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</section>




/*---------------------------------------------------------------------------------------------
Forgot Password Function - Start
---------------------------------------------------------------------------------------------*/
add_action("wp_ajax_forgot_password_form_submit", "forgot_password_form_submit");
add_action("wp_ajax_nopriv_forgot_password_form_submit", "forgot_password_form_submit");

function forgot_password_form_submit() {

$response = array();
$email = sanitize_email( $_POST['email'] );
$exists = email_exists( $email );

if ($exists) {

$user = get_user_by( 'email', $email );
$key = get_password_reset_key($user);

if(!is_wp_error($key)){
$to = $email;
$subject = 'Forget Password';
$fromname = 'Ethan';
$fromemail = get_option( 'admin_email' );

$home_url = home_url();
$myUrl = $home_url."/reset-password/?id=".$user->ID."&key=".$key."";

$message = "<p>Hello,</p> ";
$message.= "<p>A request has been received to reset the password for your account.</p>";
$message.= "<p><a href='".$myUrl."'>Click Here: Reset Password</a></p>";
$message.= "<p>Thanks</p>";

$headers[] = 'MIME-Version: 1.0' . "\r\n";
$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers[] = "X-Mailer: PHP \r\n";
$headers[] = "From: ".$fromname." <".$fromemail.">";

	$mail = wp_mail( $to, $subject, $message , $headers );

	if( $mail ) {
	$response['status'] = 'success';
	$response['message'] = 'A reset password link has been sent to your email address successfully. This link is valid
	only for an hour. ';
	}
	else {
	$response['status'] = 'error';
	$response['message'] = 'Error occured, Please try after some time.';
	}
	}else{
	$response['status'] = 'error';
	$response['message'] = 'Failed to generate the password reset key.';
	}
	} else {
	$response['status'] = 'error';
	$response['message'] = 'Email does not exist in our database. Please fill out your registered email.';
	}

	wp_send_json( $response );
	}

	/*----------------------------------------------------------------------------------------------
	Forgot Password Function - End
	-----------------------------------------------------------------------------------------------*/