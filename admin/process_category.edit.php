<?php 
  include('../config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      $category_id = $conn->real_escape_string($_POST['category_id']);
      $category_name = $conn->real_escape_string($_POST['category_name']);
  
      $sql = "UPDATE categories SET category_name = '$category_name' WHERE category_id = ".$category_id;
      if($conn->query($sql)){
        echo "<script>
          alert('แก้ไขข้อมูลประเภทสินค้าสำเร็จ');
          window.location.href = 'categories.php';
        </script>";
      }
    } catch (\Throwable $th) {
      echo "<script>
        alert('แก้ไขข้อมูลประเภทสินค้าไม่สำเร็จ');
        window.history.back();
      </script>";
    }
  }
?>