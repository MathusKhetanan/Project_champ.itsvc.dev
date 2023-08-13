<!DOCTYPE html>
<html lang="en">

<head>
  <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>

<body>
  <?php
  include('config.php');

  // ฟังก์ชันสำหรับล้างรายการสินค้าทั้งหมดในตะกร้า
  function removeAllItems()
  {
    // โค้ดที่ลบรายการสินค้าทั้งหมดในตะกร้า
    // เช่น ลบตัวแปรที่เก็บรายการสินค้าใน localStorage
    echo "<script>
    localStorage.removeItem('items');
  </script>";
  }

  try {
    // Validate and sanitize input data
    $order_fullname = isset($_POST['user_fullname']) ? $_POST['user_fullname'] : '';
    $order_address = isset($_POST['user_address']) ? $_POST['user_address'] : '';
    $order_tel = isset($_POST['user_tel']) ? $_POST['user_tel'] : '';
    $order_bank = isset($_POST['order_bank']) ? $_POST['order_bank'] : '';
    $order_amount = isset($_POST['order_amount']) ? $_POST['order_amount'] : '';
    $datatimeorder = isset($_POST['datatimeorder']) ? $_POST['datatimeorder'] : '';
    $updatedatatimeorder = isset($_POST['updatedatatimeorder']) ? $_POST['updatedatatimeorder'] : '';
    $order_slip = isset($_POST['payment_slip']) ? $_POST['payment_slip'] : '';

    // Use prepared statements and parameterized queries to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO `order` (order_fullname, order_address, order_tel, order_bank, order_amount, datatimeorder, updatedatatimeorder, order_slip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $order_fullname, $order_address, $order_tel, $order_bank, $order_amount, $datatimeorder, $updatedatatimeorder, $order_slip);

    if ($stmt->execute()) {
      // Perform actions after successful payment
      removeAllItems();

      echo '<script>
      Swal.fire({
        title: "สำเร็จ!",
        text: "บันทึกข้อมูลการชำระเงินสำเร็จ",
        icon: "success",
        confirmButtonText: "ตกลง"
      }).then(() => {
        window.location.href = "index.php";
      });
    </script>';
    } else {
      echo '<script>
      Swal.fire({
        title: "ผิดพลาด",
        text: "ชำระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง",
        icon: "error",
        confirmButtonText: "ตกลง"
      }).then(() => {
        window.history.back();
      });
    </script>';
    }
  } catch (Exception $e) {
    // Log the error on the server
    error_log("Error: " . $e->getMessage());

    echo '<script>
    Swal.fire({
      title: "เกิดข้อผิดพลาด",
      text: "กรุณาลองใหม่อีกครั้ง",
      icon: "error",
      confirmButtonText: "ตกลง"
    }).then(() => {
      window.history.back();
    });
  </script>';
  }

  $conn->close();
  ?>
</body>

</html>