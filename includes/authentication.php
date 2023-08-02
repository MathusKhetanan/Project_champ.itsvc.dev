<?php
  if (!isset($_SESSION)){
    session_start();
  }
  if(empty($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
  }
?>