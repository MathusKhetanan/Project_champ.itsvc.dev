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
      $admin_id = $_SESSION['admin_id'];
      $admin_fullname = $conn->real_escape_string($_POST['admin_fullname']);
      $admin_password = $conn->real_escape_string($_POST['admin_password']);
      $admin_password_confirm = $conn->real_escape_string($_POST['admin_password_confirm']);
      $admin_tel = $conn->real_escape_string($_POST['admin_tel']);
      $admin_bank_name = $conn->real_escape_string($_POST['admin_bank_name']);
      $admin_account_number = $conn->real_escape_string($_POST['admin_account_number']);
      
      $sql = "UPDATE admin SET admin_fullname = '$admin_fullname', admin_account_number = '$admin_account_number', admin_bank_name = '$admin_bank_name', admin_tel = '$admin_tel'";
      
      if ($admin_password != "" && $admin_password_confirm != "" && $admin_password == $admin_password_confirm) {
        $sql .= ", admin_password = MD5('$admin_password')";
      }
      
      $sql .= " WHERE admin_id = $admin_id";
      
      if ($conn->query($sql)) {
        $_SESSION['admin_fullname'] = $_POST['admin_fullname'];
        $_SESSION['admin_tel'] = $_POST['admin_tel'];
        $_SESSION['admin_bank_name'] = $_POST['admin_bank_name'];
        $_SESSION['admin_account_number'] = $_POST['admin_account_number'];

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