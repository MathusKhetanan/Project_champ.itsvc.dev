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
?>
<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = $conn->real_escape_string($_POST['brand_id']);
    $brand_name = $conn->real_escape_string($_POST['brand_name']);

    $sql = "INSERT INTO brands(brand_name) VALUE('$brand_name')";
    if(file_exists($_FILES['brand_image']['tmp_name']) || is_uploaded_file($_FILES['brand_image']['tmp_name'])) {
      $extension = pathinfo($_FILES['brand_image']['name'], PATHINFO_EXTENSION);
      $pathImage = "images/".md5(time()).".".$extension;
      if(move_uploaded_file($_FILES['brand_image']['tmp_name'], "../".$pathImage)){
        $sql = "INSERT INTO brands(brand_name, brand_image) VALUE('$brand_name', '$pathImage')";
      }else{
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'อัพโหลดรูปภาพแบรนด์ไม่สำเร็จ',
            showConfirmButton: false,
            timer: 2500
          }).then(() => {
            window.history.back();
          });
        </script>";
        exit();
      }
    }
    if($conn->query($sql)){
      echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'เพิ่มข้อมูลแบรนด์สำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'brands.php';
        });
      </script>";
    }else{
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'เพิ่มข้อมูลแบรนด์ไม่สำเร็จ',
          showConfirmButton: false,
          timer: 2500
        }).then(() => {
          window.history.back();
        });
      </script>";
    }
  }
?>
</body>
</html>