<?php 
  include('../config.php');
  include('includes/header.php');
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
        Swal.fire({
          icon: 'success',
          title: 'เพิ่มข้อมูลสมาชิกสำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'user.php';
        });
      </script>";
    } else {
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'เพิ่มข้อมูลสมาชิกไม่สำเร็จ',
          text: 'กรุณาลองใหม่อีกครั้ง',
        }).then(() => {
          window.history.back();
        });
      </script>";
    }
  }
?>
<?php include('includes/footer.php'); ?>