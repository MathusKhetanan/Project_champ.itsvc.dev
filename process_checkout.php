<?php
include('config.php');

try {
  $product_name = isset($_POST['product_name']) ? $conn->real_escape_string($_POST['product_name']) : '';
  $user_fullname = isset($_POST['user_fullname']) ? $conn->real_escape_string($_POST['user_fullname']) : '';
  $user_address = isset($_POST['user_address']) ? $conn->real_escape_string($_POST['user_address']) : '';
  $user_tel = isset($_POST['user_tel']) ? $conn->real_escape_string($_POST['user_tel']) : '';
  $order_bank = isset($_POST['order_bank']) ? $conn->real_escape_string($_POST['order_bank']) : '';
  $order_amount = isset($_POST['order_amount']) ? $conn->real_escape_string($_POST['order_amount']) : '';
  $datatimeorder = isset($_POST['datatimeorder']) ? $conn->real_escape_string($_POST['datatimeorder']) : '';
  $updatedatatimeorder = isset($_POST['updatedatatimeorder']) ? $conn->real_escape_string($_POST['updatedatatimeorder']) : '';
  $payment_slip = isset($_POST['payment_slip']) ? $conn->real_escape_string($_POST['payment_slip']) : '';

  $token = md5(rand() . time());

  // INSERT YOUR CODE HERE - Replace this line with your own password hashing logic
  $hashed_password = password_hash($seller_password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO orders (product_name, user_fullname, user_address, user_tel, order_bank, order_amount, datatimeorder, updatedatatimeorder, payment_slip)
          VALUES ('$product_name', '$user_fullname', '$user_address', '$user_tel', '$order_bank', '$order_amount', '$datatimeorder', '$updatedatatimeorder', '$payment_slip')";

  if ($conn->query($sql)) {
    echo "<script>
      alert('บันทึกข้อมูลสำเร็จ กรุณายืนยันอีเมลเพื่อยืนยันตัวตนอีกครั้ง');
      window.location.href = 'login.php';
    </script>";
  } else {
    echo "<script>
      alert('ชําระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง');
      window.history.back();
    </script>";
  }
} catch (Exception $e) {
  echo "<script>
    alert('เกิดข้อผิดพลาด: ' + " . $e->getMessage() . ");
    window.history.back();
  </script>";
}

?>
