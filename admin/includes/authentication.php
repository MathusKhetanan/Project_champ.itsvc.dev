<?php
if (!isset($_SESSION)) {
  session_start();
}
if (empty($_SESSION['admin_id'])) {
  header('Location: ../login.php');
  exit();
}
