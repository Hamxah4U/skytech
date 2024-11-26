<?php
    require 'Database.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
      $caption = htmlspecialchars($_POST['caption']);
      $post = htmlspecialchars($_POST['post']);
      $category = htmlspecialchars($_POST['category']);

      $errors = [];
      $success = [];

      if(empty(trim($caption))){
        $errors['caption'] = 'Caption is required!';
      }

      if(empty(trim($post))){
        $errors['post'] = 'Post field is required!';
      }

      if($category == '--choose--'){
        $errors['category'] = 'Category is required!';
      }

      if(!empty($_FILES['picture']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['picture']['type'];
        $fileName = $_FILES['picture']['name'];
        $fileTmp = $_FILES['picture']['tmp_name'];
        // $uploadDir = 'uploads/';//
        $uploadDir = '../img/uploads/';

        $fileExtension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION); 
        $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension; 

        $filePath = $uploadDir . $uniqueFileName;

        //$filePath = $uploadDir . basename($fileName);
  
        if(in_array($fileType, $allowedTypes)){
         
          if(move_uploaded_file($fileTmp, $filePath)) {
            $success['picture'] = 'File uploaded successfully!';
          }else{
            $errors['picture'] = 'File upload failed!';
          }
        }else{
          $errors['picture'] = 'Invalid file type! Only JPG, PNG, and GIF are allowed.';
        }
      }
  
      if(empty($errors)){
        session_start();
        $user = $_SESSION['email'];
        $stmt = $db->checkExist('INSERT INTO `posts_tbl` (`picture`,`caption`, `post`, `category`,`postby`) VALUES (:picture, :caption, :post, :category, :postby) ', [
          ':picture' => !empty($uniqueFileName) ? $uniqueFileName : NULL,
          ':caption' => $caption,
          ':post' => $post,
          ':category' => $category,
          ':postby' => $user
        ]);

        if($stmt){
          $success['message'] = 'Post save successfully!';
        }
      }
      
      if(count($errors) > 0){
        echo json_encode([
          'status' => false,
          'errors' => $errors
        ]);
      }else{
        echo json_encode([
          'status' => true,
          'success' => $success
        ]);
      }

    }
?>