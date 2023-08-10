<?php 
include 'config.php';

// รับค่าตัวแปรจากแบบฟอร์ม
$name = $_POST['user_fullname'];
$email = $_POST['user_email'];
$username = $_POST['user_username'];
$password = $_POST['user_password'];

// ตรวจสอบความถูกต้องของข้อมูลที่รับเข้ามา
// ตัวอย่าง: ตรวจสอบว่าอีเมลมีรูปแบบที่ถูกต้องหรือไม่
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'รูปแบบอีเมลไม่ถูกต้อง',
      text: 'โปรดป้อนที่อยู่อีเมลที่ถูกต้อง'
    }).then(() => {
      window.history.back();
    });
  </script>";
  exit;
}

// ตัวอย่าง: ตรวจสอบว่ารหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร
if (strlen($password) < 6) {
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'รหัสผ่านสั้นเกินไป',
      text: 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'
    }).then(() => {
      window.history.back();
    });
  </script>";
  exit;
}

// แฮชรหัสผ่านโดยใช้ PASSWORD_ARGON2ID หากมีให้ใช้ มิเช่นนั้นใช้ PASSWORD_DEFAULT
if (defined('PASSWORD_ARGON2ID')) {
  $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
} else {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
}

$user_status = 1; // กำหนดค่าสถานะผู้ใช้เป็น 1

// ตรวจสอบว่าอีเมลมีอยู่ในฐานข้อมูลแล้วหรือไม่
$sql_check_email = "SELECT * FROM user WHERE user_email = ?";
$stmt_check_email = mysqli_prepare($conn, $sql_check_email);
mysqli_stmt_bind_param($stmt_check_email, "s", $email);
mysqli_stmt_execute($stmt_check_email);
$result_check_email = mysqli_stmt_get_result($stmt_check_email);

if (mysqli_num_rows($result_check_email) > 0) {
  echo "<script>
    Swal.fire({
      title: 'อีเมลนี้มีอยู่แล้ว',
      text: 'ที่อยู่อีเมลนี้ถูกลงทะเบียนแล้ว'
    }).then(() => {
      window.history.back();
    });
  </script>";
  exit;
}

// เตรียมคำสั่ง SQL โดยใช้การเตรียมคำสั่ง
$sql = "INSERT INTO user (user_fullname, user_email, user_username, user_password, user_status) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $username, $hashed_password, $user_status);

// Execute the prepared statement
$result = mysqli_stmt_execute($stmt);

if ($result) {
  echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'การสมัครสำเร็จ',
      text: 'คุณได้ทำการลงทะเบียนเรียบร้อยแล้ว'
    }).then(() => {
      window.location.href = 'login.php';
    });
  </script>";
} else {
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'การสมัครไม่สำเร็จ',
      text: 'เกิดข้อผิดพลาดขณะทำการลงทะเบียน'
    }).then(() => {
      window.history.back();
    });
  </script>";
}

// ปิดคำสั่งที่เตรียมไว้และปิดการเชื่อมต่อฐานข้อมูล
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
