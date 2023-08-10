<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
  $change_status = $conn->real_escape_string($_POST['change_status']);

  $sql = "UPDATE orders SET order_status = CASE
      WHEN order_status = 'paid' THEN 'preparing'
      WHEN order_status = 'preparing' THEN 'shipping'
      ELSE 'failed'
    END";
  if (isset($_POST['order_tracking'])) {
    $order_tracking = $conn->real_escape_string($_POST['order_tracking']);
    $sql .= ", order_tracking = '$order_tracking'";
  }
  $sql .= " WHERE order_id = " . $change_status;
  if ($conn->query($sql)) {
    echo "<script>
        alert('ปรับสถานะออเดอร์สำเร็จ');
        window.location.href = 'order.php';
      </script>";
  } else {
    echo "<script>
        alert('ปรับสถานะออเดอร์ไม่สำเร็จ');
        window.location.href = 'order.php';
      </script>";
  }
  exit();
}
