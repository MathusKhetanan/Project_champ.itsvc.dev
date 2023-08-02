<?php
include('../config.php');

try {
  $seller_fullname = $conn->real_escape_string($_POST['seller_fullname']);
  $seller_email = $conn->real_escape_string($_POST['seller_email']);
  $seller_username = $conn->real_escape_string($_POST['seller_username']);
  $seller_password = $conn->real_escape_string($_POST['seller_password']);
  $token = md5(rand().time());

  // INSERT YOUR CODE HERE - Replace this line with your own password hashing logic
  $hashed_password = password_hash($seller_password, PASSWORD_DEFAULT);

  // INSERT YOUR CODE HERE - Replace this line with your own SQL query to insert data into the database
  $sql = "INSERT INTO seller (seller_fullname, seller_email, seller_username, seller_password, token) VALUES ('$seller_fullname', '$seller_email', '$seller_username', '$hashed_password', '$token')";

  if($conn->query($sql)){
    echo "<script>
      alert('บันทึกข้อมูลการสมัครสำเร็จ กรุณายืนยันอีเมลเพื่อยืนยันตัวตนอีกครั้ง');
      window.location.href = 'login.php';
    </script>";
  } else {
    echo "<script>
      alert('บันทึกข้อมูลการสมัครไม่สำเร็จ กรุณาลองใหม่อีกครั้ง');
      window.history.back();
    </script>";
  }
} catch (Exception $e) {
  echo "<script>
    alert('เกิดข้อผิดพลาด: ' + " . $e->getMessage() . ");
    window.history.back();
  </script>";
}
?>
