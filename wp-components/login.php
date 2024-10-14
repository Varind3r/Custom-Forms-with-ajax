<?php
   /* Template Name: Register */
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
               <form class="row" id="login_form" onsubmit="event.preventDefault();">
                  <div class="form-logo">
                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/black-logo.png" alt="">
                  </div>
                  <h4 class="margin-bottom-1x form-title mb-lg-4 mb-md-2">Login to your Account</h4>
                  <div class="col-md-12 mb-4">
                     <div class="form-group">
                        <label for="reg-fn">Email <span class="error">*</span></label>
                        <input class="form-control" type="email" name="login_email"
                           placeholder="Enter Your Email" id="login_email" value=""><span
                           class="input-group-addon">
                        </span>
                     </div>
                  </div>
                  <div class="col-md-12 mb-4">
                     <div class="form-group">
                        <label for="login_password">Password <span class="error">*</span></label>
                        <input class="form-control" type="password" name="login_password" id="login_pass"
                           placeholder="Enter Your Password">
                     </div>
                  </div>
                  <div class="condition-cls">
                     <label for="remember">
                     <input type="checkbox" id="remember" name="remember"> Remember Me
                     </label>
                     <div class="d-flex flex-wrap justify-content-between padding-bottom-1x">
                        <a class="navi-link" href="<?php echo home_url().'/forgot-password'?>">Forgot
                        password?</a>
                     </div>
                  </div>
                  <div class="col-12 text-center register_btn mt-4">
                     <button class="nav-link btn mb-2" type="submit" id="login_btn"><span>Login</span></button>
                  </div>
               </form>
               <div class="d-flex justify-content-center reg-link-txt">
                    <p>Not Registered Yet? <a class="text-blue" href="<?php echo home_url().'/register'?>">Create an account</a></p>
                </div>
            </div>
         </div>
      </div>
   </div>
</section>


<script>
/*----------------------------------------------------------------------------------------------------------------------------
                                                  Login -  Start
----------------------------------------------------------------------------------------------------------------------------*/
$('form[id="login_form"]').validate({
            rules: {
                login_email: {
                    required: true,
                    email: true,
                },
                login_password: {
                    required: true,
                    minlength: 6
                }
            },
            submitHandler: function() {
                document.getElementById("login_btn").disabled = true;
                
                let link ="<?php echo admin_url('admin-ajax.php')?>";

                var form = document.querySelector("#login_form");
                var formData = new FormData(form);
                formData.append('action' , 'login_form_submit');

                    jQuery.ajax({

                        type        : "POST",
                        url         : link,
                        async       : true,
                        data        : formData,
                        processData : false,
                        contentType : false,
                        cache       : false,

                        success:function(response){
                            document.getElementById("login_btn").disabled = false;

                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Great',
                                    text: response.message
                                }).then(function() {
                                    window.location.href = "<?php echo home_url();?>";
                                });
                            } 
                            else if (response.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                });
                            } 
                            else {
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
/*----------------------------------------------------------------------------------------------------------------------------
                                                  Login -  End
----------------------------------------------------------------------------------------------------------------------------*/
        </script>