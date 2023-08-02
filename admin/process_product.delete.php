<?php 
  include('../config.php');

  if(!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete"){
    try {
      $product_id = $conn->real_escape_string($_GET['id']);
      $sql = "SELECT * FROM product WHERE product_id = ".$product_id;
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      if ($row['brand_image'] != "" && !unlink("../".$row['product_image'])) { 
        echo "<script>
          alert('ลบรูปสินค้าไม่สำเร็จ');
          window.location.href = 'product.php';
        </script>";
        exit();
      }
      $sql = "DELETE FROM product WHERE product_id = ".$product_id;
      if($conn->query($sql)){
        echo "<script>
          alert('ลบข้อมูลสินค้าสำเร็จ');
          window.location.href = 'product.php';
        </script>";
      }
      exit();
    } catch (\Throwable $th) {
      echo "<script>
        alert('ลบข้อมูลสินค้าไม่สำเร็จ');
        window.location.href = 'product.php';
      </script>";
    }
  }
?>