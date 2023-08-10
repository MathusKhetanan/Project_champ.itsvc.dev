<?php
include('../config.php');
include('includes/header.php');

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
            Swal.fire({
                icon: 'success',
                title: 'ปรับสถานะออเดอร์สำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'order.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ปรับสถานะออเดอร์ไม่สำเร็จ',
                text: 'กรุณาลองใหม่อีกครั้ง'
            }).then(() => {
                window.location.href = 'order.php';
            });
        </script>";
    }
    exit();
}
?>
<?php include('includes/footer.php'); ?>