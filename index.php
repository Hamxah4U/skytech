<?php

session_start();

$uri = $_SERVER['REQUEST_URI'];
 
    require 'function.php';

    $uri = $_SERVER['REQUEST_URI'];

    if($uri == '/'){
      require 'controllers/index.php';
    }elseif($uri == '/about'){
      require 'controllers/about.php';
    }elseif($uri == '/service'){
      require 'controllers/service.php';
    }elseif($uri == '/project'){
      require 'controllers/project.php';
    }elseif($uri == '/contact'){
      require 'controllers/contact.php';
    }elseif($uri == '/dashboard'){
      if(! isset($_SESSION['userID'])){
        header('location: /');
        exit();
      }
      require 'controllers/Admin/dashboard.php';
    }elseif($uri == '/users'){
      if(! isset($_SESSION['userID'])){
        header('location: /');
        exit();
      }
      require 'controllers/Admin/users.php';
    }elseif($uri == '/post'){
      if(! isset($_SESSION['userID'])){
        header('location: /');
        exit();
      }
      require 'controllers/Admin/post.php';
    }
?>