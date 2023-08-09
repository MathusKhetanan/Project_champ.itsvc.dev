<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลที่ส่งมาจากเครื่อง client
    $cartItems = json_decode(file_get_contents('php://input'), true);

    // ทำสิ่งที่คุณต้องการกับข้อมูลที่ได้รับจากตะกร้าสินค้า เช่น บันทึกข้อมูลลงในฐานข้อมูล
    // สร้างการสั่งซื้อ และอื่น ๆ

    // ตรวจสอบการดำเนินการชำระเงิน และส่งข้อความไปยัง JavaScript
    $paymentStatus = true; // เปลี่ยนเป็น false หากการชำระเงินไม่สำเร็จ
    if ($paymentStatus) {
        $response = [
            'status' => 'success',
            'message' => 'ชำระเงินสำเร็จ',
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'การชำระเงินไม่สำเร็จ',
        ];
    }

    // ส่งผลลัพธ์กลับเป็น JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
