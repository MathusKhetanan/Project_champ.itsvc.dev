<?php 
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['change_status']) && isset($_GET['action']) && $_GET['action'] === "update") {
    $order_id = $conn->real_escape_string($_GET['change_status']);

    $sql = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['user_id'] == $_SESSION['user_id']) {
        $sql = "SELECT *, (SELECT product_use FROM product WHERE product.product_id = order_detail.product_id)as product_use FROM order_detail WHERE order_id = $order_id";
        $result = $conn->query($sql);
        foreach ($result as $row) {
            $user_id = $_SESSION['user_id'];
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $product_use = $row['product_use'];
            $sql = "INSERT INTO notifications(user_id, product_id, product_name, show_notification) VALUE($user_id, $product_id, '$product_name', CURDATE() + INTERVAL $product_use DAY)";
            $conn->query($sql);
        }
        $sql = "UPDATE orders SET order_status = 'successful' WHERE order_id = $order_id";
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
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'order.php';
                });
            </script>";
        }
        exit();
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'คุณไม่ไช่เจ้าของออเดอร์นี้',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'order.php';
            });
        </script>";
    }
}
?>
