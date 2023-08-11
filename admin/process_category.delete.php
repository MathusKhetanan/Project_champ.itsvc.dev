<?php 
  include('../config.php');

  if(!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete"){
    $category_id = $conn->real_escape_string($_GET['id']);
    $sql = "DELETE FROM categories WHERE category_id = ".$category_id;
    if($conn->query($sql)){
      echo "<script>
        alert('ลบข้อมูลประเภทสินค้าสำเร็จ');
        window.location.href = 'categories.php';
      </script>";
    }else{
      echo "<script>
        alert('ลบข้อมูลประเภทสินค้าไม่สำเร็จ');
        window.location.href = 'categories.php';
      </script>";
    }
    exit();
  }
?>