<?php
  require 'model/Database.php';
	//require 'classes/Users.class.php';
  require './views/patialsAdmin/header.php';

?>
    <!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php require './views/patialsAdmin/sidebar.php';?>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

		<!-- Main Content -->
		<div id="content">

				<!-- Topbar -->
			
        <?php require './views/patialsAdmin/nav.php' ?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

						<!-- Page Heading -->
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
								<h1 class="h3 mb-0 text-gray-800"></h1>
							<button class="btn btn-primary" type="button" data-target="#modalUser" data-toggle="modal">Add Post</button>
						</div>

						<!-- Content Row -->
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Picture</th>
									<th>Caption</th>
									<th>Post</th>
                  <th>Category</th>
									<th>Status</th>
                  <th>PostBy</th>
									<th>Action</th>
								</tr>
							</thead>
							<?php
                $stmt = $db->query('SELECT * FROM `posts_tbl`');
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $i = 1;
                foreach ($posts as $post): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><img src="../../img/uploads/<?= $post['picture'] ?>" alt="" style="width: 50px; height: 50px"></td>
                  <td><?= htmlspecialchars($post['caption']) ?></td>
                  <td><?= htmlspecialchars($post['post']) ?></td>
                  <td><?= htmlspecialchars($post['category']) ?></td>
                  <td><?= htmlspecialchars($post['status']) ?></td>
                  <td><?= htmlspecialchars($post['postby']) ?></td>
                  <td>
                    <button type="button" class="btn btn-info"><span class="fas fa-fw fa-edit"></span></button>
                    <button type="button" class="btn btn-danger"><span class="fas fa-fw fa-trash"></span></button>
                  </td>
								</tr>
							<?php endforeach ?>
						</table>
						<!-- Content Row -->

				</div>
				<!-- /.container-fluid -->

		</div>
		<!-- End of Main Content -->
<?php require './views/patialsAdmin/footer.php' ?>

<!-- Modal -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary"><strong>User Registration Window</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-danger"><strong>&times;</strong></span>
					</button>
			</div>
			<div class="modal-body">
				<form id="postForm" enctype="multipart/form-data">

					<div class="form-group">
						<label for="my-input">Caption</label>
						<input id="fname" class="form-control" type="text" name="caption">
						<small class="text-danger" id="errorCaption"></small>
					</div>
					<div class="form-group">
						<label for="my-input">Post</label>
						<textarea name="post" id="" class="form-control"></textarea>
						<small class="text-danger" id="errorPost"></small>
					</div>
					<div class="form-group">
						<label for="my-input">Category</label>
						<select name="category" id="" class="form-control">
              <option value="--choose--">--choose--</option>
              <option>Home</option>
              <option>About</option>
              <option>Contact</option>
            </select>
						<small class="text-danger" id="errorCategory"></small>
					</div>

          <div class="form-group">
            <label for="my-input">Picture</label>
            <input id="my-input" class="form-control" type="file" name="picture">
            <small class="text-danger" id="im"></small>
            <img id="file-preview" src="" alt="Image Preview" style="display:none; width: 200px; height: auto;">
          </div>

					<button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
  $(document).ready(function(){
    $('#postForm').on('submit', function(e){
      e.preventDefault();
      var formdata = new FormData(this);
      $.ajax({
        url: 'model/post.form.php',
        data: formdata,//$(this).serialize(),
        dataType: 'JSON',
        type: 'POST',
        contentType: false,
        processData: false,
        success: function(response){
          if(!response.status){
            $('#errorCaption').text(response.errors.caption || '');
            $('#errorPost').text(response.errors.post || '');
            $('#errorCategory').text(response.errors.category || '');
          }else{
            // alert('yes');
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
						$('#errorCaption, #errorPost, #errorCategory').text('');
						$('#postForm')[0].reset();
						$('#modalUser').modal('hide');
          }
        },
        error: function(xhr, status, error){
          alert('error: ' + xhr + status + error);
        }
      });
    });

    $('#my-input').on('change', function(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#file-preview').attr('src', e.target.result);
                $('#file-preview').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });



  });
</script>

<script>
/* 	$(document).ready(function(){
    $('#userForm').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: 'model/user.form.php',
				dataType: 'JSON',
				data: $(this).serialize(),
				type: 'POST',
				success: function(response){
					if(!response.status){
						
					}else{
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
							title: response.success.success
						});
						$('#errorFname, #errorEmail, #errorPhone, #errorUnit, #errorRole, #errorEmail,  #errorPhone, #modalUser').text('');
						$('#modalUser').modal('hide');
						$('#userForm')[0].reset();
						setInterval(function(){
							location.reload();
						}, 2000);
					}
				},
					error: function(xhr, status, error){
						alert('Error: ' + xhr.status + ' - ' + error);
					}
			});
    });
}); */
</script>

