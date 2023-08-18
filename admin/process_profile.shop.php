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
    $seller_id = $_SESSION['seller_id'];
    $seller_shop = $conn->real_escape_string($_POST['seller_shop']);
    $seller_detail = $conn->real_escape_string($_POST['seller_detail']);
    $seller_address = $conn->real_escape_string($_POST['seller_address']);

    $sql = "UPDATE seller SET seller_shop = '$seller_shop', seller_detail = '$seller_detail', seller_address = '$seller_address' WHERE seller_id = " . $seller_id;
    
    if($conn->query($sql)){
      $_SESSION['seller_shop'] = $seller_shop;
      $_SESSION['seller_detail'] = $seller_detail;
      $_SESSION['seller_address'] = $seller_address;
      
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