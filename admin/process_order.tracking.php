<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
  $change_status = $conn->real_escape_string($_POST['change_status']);

  $sql = "UPDATE orders SET order_tracking = '$order_tracking' WHERE order_id = " . $change_status;
  if ($conn->query($sql)) {
    echo "<script>
        alert('ปรับสถานะออเดอร์สำเร็จ');
        window.location.href = 'order.detail.php?id=$change_status';
      </script>";
  } else {
    echo "<script>
        alert('ปรับสถานะออเดอร์ไม่สำเร็จ');
        window.location.href = 'order.detail.php?id=$change_status';
      </script>";
  }
  exit();
}
