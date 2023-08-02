<?php 
  include('../config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $category_name = $conn->real_escape_string($_POST['category_name']);

    $sql = "INSERT INTO categories(category_name) VALUE('$category_name')";
    if($conn->query($sql)){
      echo "<script>
        alert('เพิ่มข้อมูลประเภทสินค้าสำเร็จ');
        window.location.href = 'categories.php';
      </script>";
    }else{
      echo "<script>
        alert('เพิ่มข้อมูลประเภทสินค้าไม่สำเร็จ');
        window.history.back();
      </script>";
    }
  }
?>