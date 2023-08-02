<?php 
  include('../config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = $conn->real_escape_string($_POST['brand_id']);
    $brand_name = $conn->real_escape_string($_POST['brand_name']);

    $sql = "INSERT INTO brands(brand_name) VALUE('$brand_name')";
    if(file_exists($_FILES['brand_image']['tmp_name']) || is_uploaded_file($_FILES['brand_image']['tmp_name'])) {
      $extension = pathinfo($_FILES['brand_image']['name'], PATHINFO_EXTENSION);
      $pathImage = "dist/img/brands/".md5(time()).".".$extension;
      if(move_uploaded_file($_FILES['brand_image']['tmp_name'], "../".$pathImage)){
        $sql = "INSERT INTO brands(brand_name, brand_image) VALUE('$brand_name', '$pathImage')";
      }else{
        echo "<script>
          alert('อัพโหลดรูปภาพแบรนด์ไม่สำเร็จ');
          window.history.back();
        </script>";
        exit();
      }
    }
    if($conn->query($sql)){
      echo "<script>
        alert('เพิ่มข้อมูลแบรนด์สำเร็จ');
        window.location.href = 'brands.php';
      </script>";
    }else{
      echo "<script>
        alert('เพิ่มข้อมูลแบรนด์ไม่สำเร็จ');
        window.history.back();
      </script>";
    }
  }
?>