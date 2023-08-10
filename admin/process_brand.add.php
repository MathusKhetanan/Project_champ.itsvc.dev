<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $brand_id = $conn->real_escape_string($_POST['brand_id']);
  $brand_name = $conn->real_escape_string($_POST['brand_name']);

  $sql = "INSERT INTO brands(brand_name) VALUE('$brand_name')";
  
  if (file_exists($_FILES['brand_image']['tmp_name']) || is_uploaded_file($_FILES['brand_image']['tmp_name'])) {
    $extension = pathinfo($_FILES['brand_image']['name'], PATHINFO_EXTENSION);
    $pathImage = "dist/img/brands/" . md5(time()) . "." . $extension;
    
    if (move_uploaded_file($_FILES['brand_image']['tmp_name'], "../" . $pathImage)) {
      $sql = "INSERT INTO brands(brand_name, brand_image) VALUE('$brand_name', '$pathImage')";
    } else {
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'อัพโหลดรูปภาพแบรนด์ไม่สำเร็จ',
          text: 'กรุณาลองใหม่อีกครั้ง',
        }).then(() => {
          window.history.back();
        });
      </script>";
      exit();
    }
  }

  if ($conn->query($sql)) {
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
  } else {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'เพิ่มข้อมูลแบรนด์ไม่สำเร็จ',
        text: 'กรุณาลองใหม่อีกครั้ง',
      }).then(() => {
        window.history.back();
      });
    </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- โค้ดส่วนหัวของหน้า HTML ตามปกติ -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js"></script>
</head>
<body>

<!-- โค้ดส่วนเนื้อหาของหน้า HTML ตามปกติ -->

<!-- ... ส่วนอื่น ๆ ในหน้า HTML ... -->

<?php include('includes/footer.php'); ?>
