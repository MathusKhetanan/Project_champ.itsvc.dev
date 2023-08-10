<?php
include('../config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $change_status = $conn->real_escape_string($_POST['change_status']);
    $order_tracking = $conn->real_escape_string($_POST['order_tracking']); // เพิ่มการรับค่า order_tracking

    $sql = "UPDATE orders SET order_tracking = '$order_tracking' WHERE order_id = " . $change_status;
    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'ปรับสถานะออเดอร์สำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'order.detail.php?id=$change_status';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ปรับสถานะออเดอร์ไม่สำเร็จ',
                text: 'กรุณาลองใหม่อีกครั้ง'
            }).then(() => {
                window.location.href = 'order.detail.php?id=$change_status';
            });
        </script>";
    }
    exit();
}
?>
<?php include('includes/footer.php'); ?>