<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
  $change_status = $conn->real_escape_string($_POST['change_status']);
  $sql = "UPDATE user SET user_status = IF(user_status = 1, 0, 1) WHERE user_id = " . $change_status;
  if ($conn->query($sql)) {
    echo "<script>
        alert('ปรับสถานะสมาชิกสำเร็จ');
        window.location.href = 'user.php';
      </script>";
  } else {
    echo "<script>
        alert('ปรับสถานะสมาชิกไม่สำเร็จ');
        window.location.href = 'user.php';
      </script>";
  }
  exit();
}
