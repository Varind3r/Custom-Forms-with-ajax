<?php
/* Template Name: Reset Password */
get_header('secondary');
?>

<?php
$id = $_GET['id'];
$key = $_GET['key'];
// echo date('Y-m-d h:i:s');
$user = get_user_by('ID', $id);

if ($user && !empty($user->user_activation_key)) {
    $valid = check_password_reset_key($key, $user->user_login);

    if ($valid instanceof WP_User) {
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
               <form class="row" id="reset_pass_form" onsubmit="event.preventDefault();">
                  <div class="form-logo">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/black-logo.png" alt="">
                  </div>
                  <h4 class="margin-bottom-1x form-title mb-lg-4 mb-md-2">Set your new password</h4>
                  <input type="hidden" class="form-control" name="id" id="user_id" value="<?php echo $id; ?>">
                  <div class="col-md-12">
                     <div class="form-group mb-4">
                       <label for="password" class="form-label">New Password <span class="red_star">*</span></label>
                       <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your New Password">
                        </span>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                     <label for="confirm_password" class="form-label">Confirm Password <span class="red_star">*</span></label>
                     <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Your Password">
                        </span>
                     </div>
                  </div>
                  
                  <div class="col-12 text-center register_btn mt-4">
                  <button type="submit" class="btn-process btn" name="submit" id="reset_form_submit_btn">Reset Password
                  <!-- <span class="loader"></span> -->
                  </button>
                      
                       </button>
                     
                        </div>
                    </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

<?php
    } else {
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
               <form class="row" id="reset_pass_form" onsubmit="event.preventDefault();">
                  <div class="form-logo">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/black-logo.png" alt="">
                  </div>
                  <h4 class="margin-bottom-1x form-title mb-lg-4 mb-md-2">Link is invalid or expired. Please request a new password reset link.</h4>
                  <a class="btn" href="<?php echo home_url() . '/forgot-password' ?>">Forgot Password</a>
                        </div>
                    </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

<?php
    } 
}
 else {
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
               <form class="row" id="reset_pass_form" onsubmit="event.preventDefault();">
                  <div class="form-logo">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/black-logo.png" alt="">
                  </div>
                  <h4 class="margin-bottom-1x form-title mb-lg-4 mb-md-2">Link is already used or expired. Please request a new password reset link.</h4>
                  <a class="btn" href="<?php echo home_url() . '/forgot-password' ?>">Forgot Password</a>
                        </div>
                    </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

<?php } ?>


/*-----------------------------------------------------------------------------------------------
                                               Reset Password Link Expire Function -  Start
------------------------------------------------------------------------------------------------*/
function custom_password_reset_expiration( $expiration ) {
	return 3600; // 1 hour
}
add_filter( 'password_reset_expiration', 'custom_password_reset_expiration' );
/*------------------------------------------------------------------------------------------------
                                               Reset Password Link Expire Function -  End
-------------------------------------------------------------------------------------------------*/

/*------------------------------------------------------------------------------------------------
                            Reset Password Function -  Start
--------------------------------------------------------------------------------------------------*/
add_action("wp_ajax_reset_pass_form_submit", "reset_pass_form_submit");
add_action("wp_ajax_nopriv_reset_pass_form_submit", "reset_pass_form_submit");

function reset_pass_form_submit() {
	
	$response = array();
	$password = sanitize_text_field( $_POST['password'] );
	$user_id = absint( $_POST['user_id'] );
	wp_set_password($password, $user_id);
	$response['status'] = 'success';
	$response['message'] = 'Password Reset Successfully.';
	
	wp_send_json( $response );

}

/*-----------------------------------------------------------------------------------------------
                                    Reset Password Function -  End
-------------------------------------------------------------------------------------------------*/
