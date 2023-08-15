  <!DOCTYPE html>
  <html lang="en">

  <head>
    <!-- Include SweetAlert via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
  </head>

  <body>
    <?php
    include('config.php');

    // Function to remove all items from the cart
    function removeAllItems()
    {
      // Code to remove items from the cart, e.g., removing the variable that stores items in localStorage
      echo "<script>
        localStorage.removeItem('items');
      </script>";
    }

    try {
      // Validate and sanitize input data
      $order_fullname = isset($_POST['user_fullname']) ? $_POST['user_fullname'] : '';
      $order_address = isset($_POST['user_address']) ? $_POST['user_address'] : '';
      $order_tel = isset($_POST['user_tel']) ? $_POST['user_tel'] : '';
      $order_bank = isset($_POST['id']) ? $_POST['id'] : ''; // ตัวแปร id เป็นชื่อธนาคารที่ถูกส่งมา
      $order_amount = isset($_POST['amount']) ? $_POST['amount'] : '';
      $datatimeorder = date('Y-m-d H:i:s'); // แก้ไขรูปแบบของวันที่และเวลา
      $order_slip = isset($_FILES['slip']) ? $_FILES['slip'] : ''; // ตัวแปร slip เป็นไฟล์สลิปการโอนที่ถูกส่งมา
      $order_status = "Paid"; // Initial order status
      $product_name = isset($_POST['product_id']) ? $_POST['product_id'] : '';
      // Use prepared statements and parameterized queries to prevent SQL injection
      $stmt = $conn->prepare("INSERT INTO `orders` (order_fullname, order_address, order_tel, order_bank, order_amount, datatimeorder, order_slip, product_name, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssssss", $order_fullname, $order_address, $order_tel, $order_bank, $order_amount, $datatimeorder, $order_slip, $product_name, $order_status);

      if ($stmt->execute()) {
        // Perform actions after successful payment
        removeAllItems();

        echo '<script>
              Swal.fire({
                  title: "สำเร็จ!",
                  text: "บันทึกการชำระเงินสำเร็จ",
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
                  text: "บันทึกการชำระเงินไม่สำเร็จ โปรดทำรายการใหม่อีกครั้ง",
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
              title: "ผิดพลาด",
              text: "บันทึกการชำระเงินไม่สำเร็จ โปรดทำรายการใหม่อีกครั้ง",
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