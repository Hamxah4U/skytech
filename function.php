<?php
    function dd($value){
      echo '<pre>';
        var_dump($value);
      echo '</pre>';
    }

    function urlis($value){
      return $_SERVER['REQUEST_METHOD'] === $value;
    }
?>