<?php 
  include('config.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $order_id = $conn->real_escape_string($_GET['id']);
    $new_status = $conn->real_escape_string($_POST['change_status']);

        $sql = "UPDATE orders SET order_status = 'successful' WHERE order_id = $order_id";

        if ($conn->query($sql)) {
            // ดำเนินการเพิ่มการแจ้งเตือนหาผู้ใช้งาน (คุณสามารถเพิ่มเงื่อนไขตรวจสอบและรายละเอียดตามความต้องการของคุณ)
            $user_id = $_SESSION['user_id'];
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];

            $sql = "INSERT INTO notifications (user_id, product_id, product_name, show_notification) VALUES ($user_id, $product_id, '$product_name', CURDATE() + INTERVAL $product_use DAY)";
            $conn->query($sql);

            // ส่งกลับไปยังหน้า order.php
            header("Location: order.php");
            exit();
        } else {
            echo "<script>
                alert('ปรับสถานะออเดอร์ไม่สำเร็จ');
                window.location.href = 'order.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('คุณไม่ไช่เจ้าของออเดอร์นี้');
            window.location.href = 'order.php';
        </script>";
        exit();
    }
?>