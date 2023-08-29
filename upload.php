<?php
// เชื่อมต่อกับฐานข้อมูล
include('config.php');

// ตรวจสอบการอัปโหลดสลิป
if (isset($_FILES['slip']) && $_FILES['slip']['error'] === UPLOAD_ERR_OK) {
    // กำหนดตำแหน่งที่จะบันทึกไฟล์สลิป
    $uploadDir = 'images/';
    $slipPath = $uploadDir . basename($_FILES['slip']['name']);

    // ย้ายไฟล์สลิปไปยังตำแหน่งที่กำหนด
    if (move_uploaded_file($_FILES['slip']['tmp_name'], $slipPath)) {
        // เชื่อมต่อกับฐานข้อมูล
        include('config.php');

        // รับค่า user_id และ order_id จาก $_POST
        $user_id = $_SESSION['user_id'];
        $order_id = $_POST['order_id']; // ใช้ $_POST หรือ $_GET ขึ้นอยู่กับวิธีการส่งค่ามา

        // เตรียมคำสั่ง SQL เพื่อบันทึกข้อมูลสลิป
        $sql = "INSERT INTO payment_slips (user_id, order_id, slip_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // แทนค่า ? ด้วยค่าที่ต้องการบันทึก
        $stmt->bind_param("iis", $user_id, $order_id, $slipPath);

        // ทำการ execute คำสั่ง SQL
        if ($stmt->execute()) {
            // บันทึกสลิปเรียบร้อย
            echo "บันทึกสลิปเรียบร้อยแล้ว";
        } else {
            // ไม่สามารถบันทึกสลิปได้
            echo "เกิดข้อผิดพลาดในการบันทึกสลิป: " . $stmt->error;
        }
        $stmt->close();
        
    } else {
        // ไม่สามารถย้ายไฟล์สลิปไปยังตำแหน่งที่กำหนดได้
        echo "เกิดข้อผิดพลาดในการอัปโหลดสลิป";
    }
} else {
    // ไม่มีการอัปโหลดสลิปหรือเกิดข้อผิดพลาด
    echo "กรุณาเลือกและอัปโหลดสลิปการชำระเงิน";
}
?>
