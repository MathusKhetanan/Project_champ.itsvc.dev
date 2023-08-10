<?php
include('config.php');

function removeAllItems() {
  echo "<script>
    localStorage.removeItem('items');
  </script>";
}

try {
  $order_fullname = isset($_POST['user_fullname']) ? $_POST['user_fullname'] : '';
  $order_address = isset($_POST['user_address']) ? $_POST['user_address'] : '';
  $order_tel = isset($_POST['user_tel']) ? $_POST['user_tel'] : '';
  $order_bank = isset($_POST['order_bank']) ? $_POST['order_bank'] : '';
  $order_amount = isset($_POST['order_amount']) ? $_POST['order_amount'] : '';
  $datatimeorder = isset($_POST['datatimeorder']) ? $_POST['datatimeorder'] : '';
  $updatedatatimeorder = isset($_POST['updatedatatimeorder']) ? $_POST['updatedatatimeorder'] : '';
  $order_slip = isset($_POST['payment_slip']) ? $_POST['payment_slip'] : '';

  $stmt = $conn->prepare("INSERT INTO `order` (order_fullname, order_address, order_tel, order_bank, order_amount, datatimeorder, updatedatatimeorder, order_slip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssss", $order_fullname, $order_address, $order_tel, $order_bank, $order_amount, $datatimeorder, $updatedatatimeorder, $order_slip);

  if ($stmt->execute()) {
    removeAllItems();
    
    // Success message with SweetAlert2
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js'></script>";
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'บันทึกข้อมูลการชำระเงินสำเร็จ',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ตกลง'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php';
        }
      });
    </script>";
  } else {
    // Error message with SweetAlert2
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js'></script>";
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'ชำระเงินไม่สำเร็จ',
        text: 'กรุณาลองใหม่อีกครั้ง',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ตกลง'
      }).then((result) => {
        if (result.isConfirmed) {
          window.history.back();
        }
      });
    </script>";
  }
} catch (Exception $e) {
  error_log("Error: " . $e->getMessage());

  // Error message with SweetAlert2
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js'></script>";
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'เกิดข้อผิดพลาด',
      text: 'กรุณาลองใหม่อีกครั้ง',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'ตกลง'
    }).then((result) => {
      if (result.isConfirmed) {
        window.history.back();
      }
    });
  </script>";
}

$conn->close();
?>
