  <!DOCTYPE html>
  <html lang="en">
  <head>
      <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
  </head>
  <body>
    <?php 
    include('../config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $seller_id = $_SESSION['seller_id'];
      $seller_fullname = $conn->real_escape_string($_POST['seller_fullname']);
      $seller_password = $conn->real_escape_string($_POST['seller_password']);
      $seller_password_confirm = $conn->real_escape_string($_POST['seller_password_confirm']);
      $seller_tel = $conn->real_escape_string($_POST['seller_tel']);
      $seller_bank_name = $conn->real_escape_string($_POST['seller_bank_name']);
      $seller_account_number = $conn->real_escape_string($_POST['seller_account_number']);
      
      $sql = "UPDATE seller SET seller_fullname = '$seller_fullname', seller_account_number = '$seller_account_number', seller_bank_name = '$seller_bank_name', seller_tel = '$seller_tel'";
      
      if ($seller_password != "" && $seller_password_confirm != "" && $seller_password == $seller_password_confirm) {
        $sql .= ", seller_password = MD5('$seller_password')";
      }
      
      $sql .= " WHERE seller_id = $seller_id";
      
      if ($conn->query($sql)) {
        $_SESSION['seller_fullname'] = $_POST['seller_fullname'];
        $_SESSION['seller_tel'] = $_POST['seller_tel'];
        $_SESSION['seller_bank_name'] = $_POST['seller_bank_name'];
        $_SESSION['seller_account_number'] = $_POST['seller_account_number'];

        // Display success message using SweetAlert
        echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลผู้ขายสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.href = 'profile.php';
          });
        </script>";
      } else {
        // Display error message using SweetAlert
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'บันทึกข้อมูลไม่สำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.history.back();
          });
        </script>";
      }
      exit();
    }
  ?>
  </body>
  </html>