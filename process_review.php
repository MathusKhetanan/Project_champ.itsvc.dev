<?php 
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $review_title = $conn->real_escape_string($_POST['review_title']);
    $review_message = $conn->real_escape_string($_POST['review_message']);
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $product_id = $conn->real_escape_string($_POST['product_id']);
    
    $sql = "SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id AND order_status = 'successful'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $sql = "INSERT INTO product_review (product_id, user_id, review_title, review_message, order_id) 
                VALUES ($product_id, $user_id, '$review_title', '$review_message', $order_id)";
        
        if ($conn->query($sql)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกข้อมูลรีวิวสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'product_detail.php?id=$product_id';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'บันทึกข้อมูลรีวิวไม่สำเร็จ',
                    text: 'คุณอาจจะเคยรีวิวสินค้านี้ไปแล้ว'
                }).then(() => {
                    window.location.href = 'product_detail.php?id=$product_id';
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'คุณไม่ได้ซื้อสินค้านี้',
                text: 'กรุณาซื้อสินค้าก่อนที่จะทำการรีวิว'
            }).then(() => {
                window.location.href = 'product_detail.php?id=$product_id';
            });
        </script>";
    }
}
?>
