<?php
    require 'Database.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $errors = [];
      $success = [];
      $fname = htmlspecialchars($_POST['fname']);
      $email = htmlspecialchars($_POST['email']);
      $phone = htmlspecialchars($_POST['phone']);
      $password = 'password';
      $pass = password_hash($password, PASSWORD_BCRYPT);

      if(empty(trim($fname))){
        $errors['fname'] = 'User fullname is required!';
      }

      if(empty(trim($email))){
        $errors['email'] = 'Email address is required!';
      }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Invalid email address!';
      }

      if(empty(trim($phone))){
        $errors['phone'] = 'Phone number is required!';
      }

      if(empty($errors)){
        $stmt = $db->checkExist('INSERT INTO `users_tbl` (`Fullname`, `Email`, `Phone`, `UserPassword`) VALUES (:Fullname, :Email, :Phone, :UserPassword) ', [
          ':Fullname' => $fname,
          ':Email' => $email,
          ':Phone' => $phone,
          ':UserPassword' => $pass
        ]);

        if($stmt){
          $success['message'] = 'Record save successfully!';
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
          'errors' => $success
        ]);
      }
    }
?>