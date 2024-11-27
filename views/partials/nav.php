<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
  <a href="/" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
      <h2 class="m-0 text-primary">SKY-TECH NETWORK</h2>
  </a>
  <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="/" class="nav-item nav-link active">Home</a>
        <a href="/about" class="nav-item nav-link">About</a>
        <!-- <a href="/service" class="nav-item nav-link">Service</a> -->
        <a href="/project" class="nav-item nav-link">Project</a>

        <!-- <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
            <div class="dropdown-menu bg-light m-0">
                <a href="feature.html" class="dropdown-item">Feature</a>
                <a href="quote.html" class="dropdown-item">Free Quote</a>
                <a href="team.html" class="dropdown-item">Our Team</a>
                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                <a href="404.html" class="dropdown-item">404 Page</a>
            </div>
        </div> -->
        <a href="/contact" class="nav-item nav-link">Contact</a>
        <a href="" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#login">Login</a>
    </div>
    <!-- <a href="" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Get A Quote<i class="fa fa-arrow-right ms-3"></i></a> -->
  </div>
</nav>

<!-- The Modal -->
<div class="modal" id="login">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">User Login</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="loginForm">
            <div class="form-group">
                <label for="">Email/Phone</label>
                <input id="email" class="form-control" type="text" name="username">
                <small class="text-danger" id="errorEmail"></small>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input id="password" class="form-control" type="password" name="password">
                <small class="text-danger" id="errorPassword"></small>
            </div>
            <button class="btn btn-primary mt-3">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script>
  $(document).ready(function(){
		$('#loginForm').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: 'model/user.login.php',
				data: $(this).serialize(),
				dataType: 'JSON',
				type: 'POST',
				success: function(response){
					if(!response.status){
						$('#errorEmail').text(response.errors.email || response.errors.emailPhone || '');
						$('#errorPassword').text(response.errors.password || response.errors.invalidpass || '')
					}else{
						 //alert('success:' + response.success.message);
            const Toast = Swal.mixin({
								toast: true,
								position: "top-end",
								showConfirmButton: false,
								timer: 1000,
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

            $('#errorEmail, #errorPassword').text('');
            setTimeout(function(){
              window.location.href = response.success.redirect;
            }, 1000)
					}
				},
				error: function(xhr, status, error){
					alert('error' + xhr + status + error);
				}
			});
		});
	});
</script>