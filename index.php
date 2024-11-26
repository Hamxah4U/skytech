<?php

session_start();

$uri = $_SERVER['REQUEST_URI'];

    // if(!isset($_SESSION['userID']) && $uri != '/' && $uri != '/login') {
    //   header('Location: /');
    //   exit();
    // }

    if(! isset($_SESSION['userID']) && $uri != '/'){
      header('Location: /');
    }

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
      require 'controllers/Admin/dashboard.php';
    }elseif($uri == '/users'){
      require 'controllers/Admin/users.php';
    }elseif($uri == '/post'){
      require 'controllers/Admin/post.php';
    }
?>