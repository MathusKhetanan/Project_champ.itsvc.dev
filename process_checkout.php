<?php
// process_checkout.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลที่ถูกส่งมาจากฟอร์ม
    $itemsJson = $_POST['items'];
    $amount = $_POST['amount'];
    $omiseToken = $_POST['omiseToken'];

    // ทำการประมวลผลการชำระเงินและบันทึกข้อมูลลงฐานข้อมูล
    // ...

    // ส่งการตอบกลับเพื่อแสดงสถานะการทำงานหรือข้อผิดพลาด
    echo "Payment processed successfully"; // หรืออื่น ๆ ตามที่คุณต้องการ

} else {
    echo "Invalid request method";
}
?>
