<?php
include('config.php');
include('includes/authentication.php');

if (move_uploaded_file($_FILES['slip']['tmp_name'], $slipPath)) {
    // เชื่อมต่อกับฐานข้อมูล
    include('config.php');

    // รับค่า user_id จาก session หรือในการรับอื่น ๆ
    $user_id = $_SESSION['user_id'];

    // รับค่าจากฟอร์มเพื่อบันทึกข้อมูลการชำระเงิน
    $bank_id = $_POST['bank']; // รหัสธนาคารที่เลือก
    $payment_amount = $_POST['amount']; // จำนวนเงิน
    $cardHolder = $_POST['cardHolder']; // ชื่อบนบัตร (กรณีการชำระเงินด้วยบัตรเครดิต)
    $cardNumber = $_POST['cardNumber']; // หมายเลขบัตร (กรณีการชำระเงินด้วยบัตรเครดิต)
    $mm = $_POST['mm']; // เดือนหมดอายุ (กรณีการชำระเงินด้วยบัตรเครดิต)
    $yy = $_POST['yy']; // ปีหมดอายุ (กรณีการชำระเงินด้วยบัตรเครดิต)
    $number = $_POST['number']; // รหัสความปลอดภัย CSC (กรณีการชำระเงินด้วยบัตรเครดิต)

    // เตรียมคำสั่ง SQL เพื่อบันทึกข้อมูลการชำระเงิน
    $sql = "INSERT INTO payments (user_id, bank_id, payment_amount, cardHolder, cardNumber, mm, yy, number, slip_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // แทนค่า ? ด้วยค่าที่ต้องการบันทึก
    $stmt->bind_param("iisssssss", $user_id, $bank_id, $payment_amount, $cardHolder, $cardNumber, $mm, $yy, $number, $slipPath);

    // ทำการ execute คำสั่ง SQL
    if ($stmt->execute()) {
        // บันทึกข้อมูลการชำระเงินเรียบร้อย
        echo "บันทึกข้อมูลการชำระเงินเรียบร้อยและอัปโหลดสลิปเรียบร้อย";

        // เพิ่มโค้ดที่คุณต้องการสำหรับการทำงานต่อไป หลังจากบันทึกข้อมูลลงในฐานข้อมูล
    } else {
        // ไม่สามารถบันทึกข้อมูลการชำระเงินได้
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูลการชำระเงิน";
    }
    $stmt->close();


    } else {
        // ไม่มีการอัปโหลดสลิปหรือเกิดข้อผิดพลาด
    }


try {
    // ทำงานกับ Omise
    try {
        // เรียกใช้ Omise SDK หรือโค้ดที่ใช้ในการเรียก API ของ Omise
        // เพื่อทำการชำระเงินด้วย Omise

        // ตัวอย่างโค้ดการชำระเงินด้วย Omise
        /*
        $charge = OmiseCharge::create(array(
            'amount' =>  $_POST['amount'],
            'currency' => 'thb',
            'card' => $_POST['omiseToken']
        ));

        if ($charge['status'] === "successful") {
            // ทำงานเพิ่มเติมหลังจากการชำระเงินสำเร็จ
        } else {
            // ไม่สามารถชำระเงินได้
            echo "เกิดข้อผิดพลาดในการชำระเงินด้วย Omise";
        }
        */
    } catch (Exception $e) {
        echo "เกิดข้อผิดพลาดในการชำระเงินด้วย Omise: " . $e->getMessage();
    }

    // เรียกใช้ Omise หลังการชำระเงิน
    $ref = substr(md5(rand() . time()), 0, 8);
    $items = json_decode($_POST['items'], true);

    foreach ($items as $item) {
        $user_id = $_SESSION['user_id'];
        $admin_id = $conn->real_escape_string($item['key']);
        $sql = "INSERT INTO orders (user_id, admin_id, order_status, order_ref) VALUES (?, ?, 'paid', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $user_id, $admin_id, $ref);
        $stmt->execute();
        $order_id = $conn->insert_id;
        $sumTotal = 0;

        foreach ($item['order'] as $order) {
            $product_id = $conn->real_escape_string($order['id']);
            $product_name = $conn->real_escape_string($order['name']);
            $product_price = $conn->real_escape_string($order['price']);
            $order_qty = $conn->real_escape_string($order['qty']);
            $order_subtotal = (float) $product_price * (float) $order_qty;
            $sumTotal += $order_subtotal;

            $sql = "SELECT product_qty FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['product_qty'] < $order_qty) {
                throw new Exception("สินค้า " . $product_name . " ไม่คงเหลือ " . $row['product_qty'] . " ชิ้น กรุณาอัพเดทตะกร้าของคุณ");
            }

            $free = ($sumTotal * $charge['transaction_fees']['fee_rate']) / 100;
            $free_vat = ($free * $charge['transaction_fees']['vat_rate']) / 100;
            $order_total_free = number_format($free, 2);
            $order_total_free_vat = number_format($free_vat, 2);
            $order_total_net = $sumTotal - ($order_total_free + $order_total_free_vat);

            $sql = "UPDATE orders SET order_total = ?, order_total_net = ?, order_total_free = ?, order_total_free_vat = ? WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ddddi", $sumTotal, $order_total_net, $order_total_free, $order_total_free_vat, $order_id);
            $stmt->execute();

            $sql = "UPDATE product SET product_qty = product_qty - ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $order_qty, $product_id);
            $stmt->execute();

            $sql = "INSERT INTO order_detail (order_id, product_id, product_name, product_price, order_qty, order_subtotal) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisddd", $order_id, $product_id, $product_name, $product_price, $order_qty, $order_subtotal);
            $stmt->execute();
        }

        $conn->commit();
        echo '<script>
            window.location = "order.php";
            localStorage.removeItem("items");
            alert("บันทึกข้อมูลชำระเงินสำเร็จ");
        </script>';
    }
} catch (Exception $e) {
    $conn->rollback();
    echo '<script>
        alert("' . $e->getMessage() . '");
        window.history.back();
    </script>';
}
