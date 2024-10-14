<?php
/* Template Name: Contact Us */
get_header();
?>

<section class="about-bnner" style="background-image:url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>')">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 hero-section">
                <h1 class="font-bold text-white text-center"> <?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>
<!-- form-section -->
<section>
    <div class="container">
        <div class="section-gap">
            <div class="row">
                <div class="col-12 col-md-8 m-auto">
                   <?php the_content(); ?>
                    <form id="contact_form" class="contact_us_form">
                        <div class="form-group mb-4">
                            <label for="name">Name <span class="red_star">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter your name here...">
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Email <span class="red_star">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email here...">
                        </div>
                        <div class="form-group mb-4">
                            <label for="contact_number">Contact Number <span class="red_star">*</span></label>
                            <input type="tel" class="form-control" id="contact_number" name="contact_number"
                                placeholder="Enter your contact number here...">
                        </div>
                        <div class="form-group mb-4">
                            <label for="message">Message <span class="red_star">*</span></label>
                            <textarea name="message" class="form-control" id="message" cols="30" rows="6"
                                placeholder="Enter your message here..."></textarea>
                        </div>
                        <div class="contact-us-btn d-flex justify-content-center">
                            <button type="submit" class="btn inr_btn" id="submit_btn">Send Now
                            <span class="loader" id="loader" style="display:none;"></span>
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>




/*---------------------------------------------------------------------------------------
								Contact Us - Start
------------------------------------------------------------------------------------------*/
add_action("wp_ajax_contact_form_submit", "contact_form_submit");
add_action("wp_ajax_nopriv_contact_form_submit", "contact_form_submit");

function contact_form_submit() {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$contact_number = $_POST['contact_number'];
		$contact_message = $_POST['message'];
        
        $to = 'ethan@yopmail.com';
        $subject = 'Contact Us';
        $fromname = 'Ethan';
        $fromemail = get_option( 'admin_email' ); 

        $message="<p>Hello Ethan,</p> "; 
        $message.="<p>A request has been received to contact the user.</p>"; 
        $message.="<p>The details of the user are as follows:</p>"; 
        $message.="<ul style='border: 1px solid;'> 
        <li><h4>Name: $name </h4></li>
        <li><h4>Email: $email </h4></li>
        <li><h4>Contact Number: $contact_number </h4></li> 
        <li><h4>Message: $contact_message </h4></li>
        </ul>";
        $message.="<p>Thanks</p>";

        $headers[] = 'MIME-Version: 1.0' . "\r\n";
        $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers[] = "X-Mailer: PHP \r\n";
        $headers[] = "From: ".$fromname." <".$fromemail.">";

        $sent = wp_mail( $to, $subject, $message , $headers );

		$response = array();

		if ($sent) {
			$response['status'] = 'success';
			$response['message'] = 'Thank you for contacting us. We will get back to you shortly.';
		} else {
			$response['status'] = 'error';
			$response['message'] = 'Error Occured, Please try after some time.';
		}

		wp_send_json($response);
}
/*------------------------------------------------------------------------------------------
								Contact Us - End
------------------------------------------------------------------------------------------*/
