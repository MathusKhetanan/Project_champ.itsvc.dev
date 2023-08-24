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

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $admin_id = $_SESSION['admin_id'];
    $admin_shop = $conn->real_escape_string($_POST['admin_shop']);
    $admin_detail = $conn->real_escape_string($_POST['admin_detail']);
    $admin_address = $conn->real_escape_string($_POST['admin_address']);

    $sql = "UPDATE admin SET admin_shop = '$admin_shop', admin_detail = '$admin_detail', admin_address = '$admin_address' WHERE admin_id = " . $admin_id;
    
    if($conn->query($sql)){
      $_SESSION['admin_shop'] = $admin_shop;
      $_SESSION['admin_detail'] = $admin_detail;
      $_SESSION['admin_address'] = $admin_address;
      
      // Display success message using SweetAlert
      echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'แก้ไขข้อมูลร้านสำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'profile.php';
        });
      </script>";
    }else{
      // Display error message using SweetAlert
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'แก้ไขข้อมูลร้านไม่สำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'profile.php';
        });
      </script>";
    }
    exit();
  }
?>
</body>
</html>