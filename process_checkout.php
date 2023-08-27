<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once dirname(__FILE__) . '/Omise/lib/Omise.php';
        define('OMISE_API_VERSION', '2019-05-29');
        define('OMISE_PUBLIC_KEY', 'pkey_test_5r0gn5997jah59d6ns1');
        define('OMISE_SECRET_KEY', 'skey_test_5r0gn599f16unthb4cs');

        // ตรวจสอบการอัปโหลดสลิป
        if (isset($_FILES['slip']) && $_FILES['slip']['error'] === UPLOAD_ERR_OK) {
            $slipFileName = $_FILES['slip']['name'];
            $slipTempName = $_FILES['slip']['tmp_name'];
            $slipFileType = $_FILES['slip']['type'];
            $slipFileSize = $_FILES['slip']['size'];

            $allowedExtensions = array("pdf", "jpg", "png");
            $slipExtension = strtolower(pathinfo($slipFileName, PATHINFO_EXTENSION));

            if (in_array($slipExtension, $allowedExtensions)) {
                // ตรวจสอบไฟล์สลิปที่สามารถอัปโหลดได้

                // ตั้งค่าโฟลเดอร์สำหรับการอัปโหลดสลิป
                $slipUploadDirectory = "images/slip/";
                $ref = substr(md5(rand() . time()), 0, 8);
                $slip = $slipUploadDirectory . $ref . "." . $slipExtension;

                if (move_uploaded_file($slipTempName, $slip)) {
                    // อัปเดตคอลัมน์ slip_img ในตาราง order_detail
                    $slip_img = $conn->real_escape_string($slip);
                    $order_id = $_SESSION['user_id']; // รหัสการสั่งซื้อที่ต้องการอัปเดต
                    $sql = "UPDATE order_detail SET slip_img = '$slip_img' WHERE order_id = $order_id";
                    $conn->query($sql);

                    // เคลื่อนย้ายไฟล์สลิปไปยังโฟลเดอร์ 'slip'
                    $newSlipPath = $slipUploadDirectory . $ref . "." . $slipExtension;
                    if (!rename($slip, $newSlipPath)) {
                        throw new Exception("ไม่สามารถย้ายไฟล์สลิปไปยังโฟลเดอร์ 'slip' ได้");
                    }

                    // ทำสิ่งที่คุณต้องการกับสลิปที่อัปโหลดสำเร็จ

                    $conn->commit();
                    echo '<script>
                        window.location = "order.php";
                        localStorage.removeItem("items");
                        alert("บันทึกข้อมูลชำระเงินสำเร็จ");
                    </script>';
                } else {
                    throw new Exception("อัพโหลดสลิปไม่สำเร็จ");
                }
            } else {
                throw new Exception("สลิปที่อัปโหลดไม่รองรับนามสกุลนี้");
            }
        }

        // ตรวจสอบการชำระเงินด้วย Omise
        $charge = OmiseCharge::create(array(
            'amount' =>  $_POST['amount'],
            'currency' => 'thb',
            'card' => $_POST['omiseToken']
        ));

        if ($charge['status'] === "successful") {
            $ref = substr(md5(rand() . time()), 0, 8);
            $items = json_decode($_POST['items'], true);

            foreach ($items as $item) {
                $user_id = $_SESSION['user_id'];
                $admin_id = $conn->real_escape_string($item['key']);
                $sql = "INSERT INTO orders (user_id, admin_id, order_status, order_ref) VALUES ($user_id, $admin_id, 'paid', '$ref')";
                $conn->query($sql);
                $order_id = $conn->insert_id;
                $sumTotal = 0;

                foreach ($item['order'] as $order) {
                    $product_id = $conn->real_escape_string($order['id']);
                    $product_name = $conn->real_escape_string($order['name']);
                    $product_price = $conn->real_escape_string($order['price']);
                    $order_qty = $conn->real_escape_string($order['qty']);
                    $order_subtotal = (float) $product_price * (float) $order_qty;
                    $sumTotal += $order_subtotal;

                    $sql = "SELECT product_qty FROM product WHERE product_id = $product_id";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();

                    if ($row['product_qty'] < $order_qty) {
                        throw new Exception("สินค้า " . $product_name . " ไม่คงเหลือ " . $row['product_qty'] . " ชิ้น กรุณาอัพเดทตะกร้าของคุณ");
                    }

                    $order_total_free = ($sumTotal * $charge['transaction_fees']['fee_rate']) / 100;
                    $order_total_free_vat = ($order_total_free * $charge['transaction_fees']['vat_rate']) / 100;
                    $order_total_net = $sumTotal - ($order_total_free + $order_total_free_vat);

                    // บันทึก transaction_fees
                    $transaction_fees_fee_rate = $charge['transaction_fees']['fee_rate'];
                    $transaction_fees_vat_rate = $charge['transaction_fees']['vat_rate'];

                    // บันทึกข้อมูลลงในตาราง order_detail
                    $sql = "INSERT INTO order_detail (order_id, product_id, product_name, product_price, slip_img, order_qty, order_subtotal)
                            VALUES ($order_id, $product_id, '$product_name', $product_price, '$slip_img', $order_qty, $order_subtotal)";
                    $conn->query($sql);
                }

                $conn->commit();
                echo '<script>
                    window.location = "order.php";
                    localStorage.removeItem("items");
                    alert("บันทึกข้อมูลชำระเงินสำเร็จ");
                </script>';
            }
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo '<script>
            alert("' . $e->getMessage() . '");
            window.history.back();
        </script>';
    }
}
?>
