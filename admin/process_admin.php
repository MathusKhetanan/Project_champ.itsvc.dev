<?php 
  include('../config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_username = $conn->real_escape_string($_POST['user_username']);
    $user_password = $conn->real_escape_string($_POST['user_password']);
    $user_fullname = $conn->real_escape_string($_POST['user_fullname']);
    $user_email = $conn->real_escape_string($_POST['user_email']);
    $user_address = $conn->real_escape_string($_POST['user_address']);

    // Use prepared statement with parameterized query
    $stmt = $conn->prepare("INSERT INTO user(user_username, user_password, user_fullname, user_email, user_address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $user_username, $user_password, $user_fullname, $user_email, $user_address);

    if ($stmt->execute()) {
      echo "<script>
        alert('เพิ่มข้อมูลสมาชิกสำเร็จ');
        window.location.href = 'user.php';
      </script>";
    } else {
      echo "<script>
        alert('เพิ่มข้อมูลสมาชิกไม่สำเร็จ');
        window.history.back();
      </script>";
    }
  }
?>
