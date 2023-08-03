<?php
include('../config.php');

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete") {
  try {
    $product_id = $conn->real_escape_string($_GET['id']);

    // ไม่ต้องดึงข้อมูลแถวสำหรับ "product_image" หากไม่ได้ใช้งานในส่วนนี้

    $sql = "DELETE FROM product WHERE product_id = " . $product_id;
    if ($conn->query($sql)) {
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
