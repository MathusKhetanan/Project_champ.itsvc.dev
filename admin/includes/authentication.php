<?php
if (!isset($_SESSION)) {
  session_start();
}
if (empty($_SESSION['seller_id'])) {
  header('Location: ../login.php');
  exit();
}
