<?php
    require 'Database.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Capture form data
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $subject = htmlspecialchars(trim($_POST['subject']));
        $message = htmlspecialchars(trim($_POST['message']));
        
        $errors = [];
        $success = [];
    
        if(empty(trim($name))) {
          $errors['name'] = 'Fullname is required!';
        }
    
        if(empty(trim($email))) {
          $errors['email'] = 'Email address is required!';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = 'Invalid email format!';
        }
    
        if(empty(trim($message))) {
          $errors['message'] = 'Message is required!';
        }

        if(empty($errors)){
          $stmt = $db->checkExist('INSERT INTO `contactus_tbl` (`Fullname`,`Email`,`subject`,`Message`) VALUES (:Fullname, :Email, :subject, :Message)', [
            ':Fullname' => $name,
            ':Email' => $email,
            ':subject' => $subject,
            ':Message' => $message
          ]);

          if($stmt){
            $success['message'] = "Message sent successfully!";
          }

          /* $to = "hamxah4u@gmail.com";
            $headers = "From: " . $email . "\r\n" .
                       "Reply-To: " . $email . "\r\n" .
                       "Content-type: text/html; charset=UTF-8";
            
            $email_subject = "Contact Form: " . $subject;
            $email_message = "
                <html>
                <head>
                    <title>$subject</title>
                </head>
                <body>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Message:</strong> $message</p>
                </body>
                </html>
            ";

            if(mail($to, $email_subject, $email_message, $headers)) {
              $success['message'] = "Message sent successfully!";
          }else{
            $errors['emailfail'] = "Failed to send the message!";
          } */
    
        }

        if(count($errors) > 0) {
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