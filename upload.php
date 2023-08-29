<?php
// เชื่อมต่อกับฐานข้อมูล
include('config.php');

// ตรวจสอบการอัปโหลดสลิป
if (isset($_FILES['slip']) && $_FILES['slip']['error'] === UPLOAD_ERR_OK) {
    // กำหนดตำแหน่งที่จะบันทึกไฟล์สลิป
    $uploadDir = 'images/';
    $slipPath = $uploadDir . basename($_FILES['slip']['name']);

    // ตรวจสอบประเภทของไฟล์ (เพื่อความปลอดภัย)
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($slipPath, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "อนุญาตให้อัปโหลดเฉพาะไฟล์รูปภาพเท่านั้น";
    } else {
        // ย้ายไฟล์สลิปไปยังตำแหน่งที่กำหนด
        if (move_uploaded_file($_FILES['slip']['tmp_name'], $slipPath)) {
            // รับค่า user_id จาก session หรือในการรับอื่น ๆ
            session_start(); // ตรวจสอบว่า session_start ถูกเรียกใช้หรือยัง
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];

                // เตรียมคำสั่ง SQL เพื่อบันทึกข้อมูลสลิป
                $sql = "INSERT INTO payment_slips (user_id, slip_path, order_id) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);

                // แทนค่า ? ด้วยค่าที่ต้องการบันทึก
                $order_id = $_POST['order_id']; // รับค่า order_id จากแบบฟอร์ม
                $stmt->bind_param("isi", $user_id, $slipPath, $order_id);

                // ทำการ execute คำสั่ง SQL
                if ($stmt->execute()) {
                    // บันทึกสลิปเรียบร้อย
                    echo "บันทึกสลิปเรียบร้อย";
                } else {
                    // ไม่สามารถบันทึกสลิปได้
                    echo "เกิดข้อผิดพลาดในการบันทึกสลิป";
                }
                $stmt->close();
            } else {
                echo "เกิดข้อผิดพลาดในการรับค่า user_id";
            }
        } else {
            // ไม่สามารถย้ายไฟล์สลิปไปยังตำแหน่งที่กำหนดได้
            echo "เกิดข้อผิดพลาดในการอัปโหลดสลิป";
        }
    }
} else {
    // ไม่มีการอัปโหลดสลิปหรือเกิดข้อผิดพลาด
    echo "กรุณาเลือกและอัปโหลดสลิปการชำระเงิน";
}
