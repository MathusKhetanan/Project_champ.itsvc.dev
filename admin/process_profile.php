<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $seller_id = $_SESSION['seller_id'];
  $seller_fullname =  $conn->real_escape_string($_POST['seller_fullname']);
  $seller_password =  $conn->real_escape_string($_POST['seller_password']);
  $seller_password_confirm =  $conn->real_escape_string($_POST['seller_password_confirm']);
  $seller_tel =  $conn->real_escape_string($_POST['seller_tel']);
  $seller_bank_name =  $conn->real_escape_string($_POST['seller_bank_name']);
  $seller_account_number =  $conn->real_escape_string($_POST['seller_account_number']);
  $sql = "UPDATE seller SET seller_fullname = '$seller_fullname', seller_bank_name = '$seller_bank_name', seller_account_number = '$seller_account_number', seller_tel = '$seller_tel'";
  if ($seller_password != "" && $seller_password_confirm != "" && $seller_password == $seller_password_confirm) {
    $sql .= ", seller_password = MD5('$seller_password')";
  }
  $sql .= " WHERE seller_id = $seller_id";
  if ($conn->query($sql)) {
    $_SESSION['seller_fullname'] = $_POST['seller_fullname'];
    $_SESSION['seller_tel'] = $_POST['seller_tel'];
    $_SESSION['seller_bank_name'] = $_POST['seller_bank_name'];
    $_SESSION['seller_account_number'] = $_POST['seller_account_number'];
    echo "<script>
        alert('บันทึกข้อมูลผู้ขายสำเร็จ');
        window.location.href = 'profile.php';
      </script>";
  } else {
    echo "<script>
        alert('บันทึกข้อมูลขายไม่สำเร็จ');
        window.history.back();
      </script>";
  }
  exit();
}
