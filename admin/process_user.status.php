<?php
include('../config.php');
include('includes/header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
  $change_status = $conn->real_escape_string($_POST['change_status']);
  $sql = "UPDATE user SET user_status = IF(user_status = 1, 0, 1) WHERE user_id = " . $change_status;
  if ($conn->query($sql)) {
    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'ปรับสถานะสมาชิกสำเร็จ',
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
          title: 'ปรับสถานะสมาชิกไม่สำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'user.php';
        });
      </script>";
  }
  exit();
}
?>
<?php include('includes/footer.php'); ?>