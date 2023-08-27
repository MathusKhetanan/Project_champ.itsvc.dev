<?php
include('config.php');

// คำสั่ง SQL เพื่อดึงข้อมูลคงเหลือของสินค้า
$sql = "SELECT product_id, product_name, product_qty FROM product";
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // สร้างอาร์เรย์เพื่อเก็บข้อมูลคงเหลือของสินค้า
    $product_stock = array();

    while ($row = $result->fetch_assoc()) {
        // เพิ่มข้อมูลของแต่ละสินค้าลงในอาร์เรย์
        $product_stock[] = array(
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'product_qty' => $row['product_qty']
        );
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // แปลงอาร์เรย์เป็น JSON
    $json_response = json_encode($product_stock);

    // ส่งข้อมูล JSON กลับไปยังเว็บไซต์
    header('Content-Type: application/json');
    echo $json_response;
} else {
    // ถ้าไม่มีข้อมูลคงเหลือของสินค้า
    echo "ไม่พบข้อมูลคงเหลือของสินค้า";
}
?>