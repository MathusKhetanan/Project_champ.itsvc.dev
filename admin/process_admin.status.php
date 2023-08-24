<!DOCTYPE html>
<html lang="en">
<head>
    <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>
<body>
<?php 
  include('../config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $change_status = $conn->real_escape_string($_POST['change_status']);
    $sql = "UPDATE admin SET admin_status = IF(admin_status = 1, 0, 1) WHERE admin_id = " . $change_status;
    if ($conn->query($sql)) {
      echo "<script>
        Swal.fire({
          title: 'Success',
          text: 'ปรับสถานะร้านค้าสำเร็จ',
          icon: 'success'
        }).then(function() {
          window.location.href = 'admin.php';
        });
      </script>";
    } else {
      echo "<script>
        Swal.fire({
          title: 'Error',
          text: 'ปรับสถานะร้านค้าไม่สำเร็จ',
          icon: 'error'
        }).then(function() {
          window.location.href = 'admin.php';
        });
      </script>";
    }
    exit();
  }
?>

</body>
</html>