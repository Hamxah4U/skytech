    <!-- Navbar Start -->
    <?php 
        require 'partials/head.php';
        require 'partials/nav.php'
    ?>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Contact</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Home</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid bg-light overflow-hidden px-lg-0" style="margin: 6rem 0;">
        <div class="container contact px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 contact-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 ps-lg-0">
                        <h6 class="text-primary">Contact Us</h6>
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name">
                                        <label>Your Name</label>
																				<small class="text-danger" id="errorName"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email">
                                        <label> Your Email</label>
																				<small class="text-danger" id="erroremail"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                                        <label>Subject</label>
																				
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="message" class="form-control" placeholder="Leave a message here" style="height: 100px"></textarea>
                                        <label>Message</label>
																				<small class="text-danger" id="message"></small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <!-- <iframe class="position-absolute w-100 h-100" style="object-fit: cover;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                        frameborder="0" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <?php
        require 'partials/footer.php';
    ?>

		<script src="../js/jquery-3.4.1.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
      $(document).ready(function(){
				$('#contactForm').on('submit', function(e){
					e.preventDefault();
					$.ajax({
						url: 'model/contactus.php',
						data: $(this).serialize(),
						type: 'POST',
						dataType: 'JSON',
						success: function(response){
							if(!response.status){
								$('#errorName').text(response.errors.name || '');
								$('#message').text(response.errors.message || '');
								$('#erroremail').text(response.errors.email || '');
							}else{
								// alert('yes' + response.success.message);
								const Toast = Swal.mixin({
								toast: true,
								position: "top-end",
								showConfirmButton: false,
								timer: 2000,
								timerProgressBar: true,
								didOpen: (toast) => {
									toast.onmouseenter = Swal.stopTimer;
									toast.onmouseleave = Swal.resumeTimer;
								}
							});
								Toast.fire({
									icon: "success",
									title: response.success.message
								});

								$('#contactForm')[0].reset();
								$('#errorName, #message, #erroremail').text('');
						}
						},
						error: function(error){
							alert('Error:' + error)
						}
					});
				});
      });
    </script>