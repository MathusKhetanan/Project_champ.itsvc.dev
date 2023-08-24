    <?php
    include('../config.php');
    include('includes/header.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $admin_username = $_POST['admin_username'];
      $admin_password = $_POST['admin_password'];

      // Prepare and execute the query
      $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_username = ?");
      $stmt->bind_param("s", $admin_username);
      $stmt->execute();

      // Get the result
      $result = $stmt->get_result();

      if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['admin_password'];

        // Verify the password
        if (password_verify($admin_password, $stored_password)) {
          // Start the session
          session_start();
          $_SESSION['admin_id'] = $row['admin_id'];
          $_SESSION['admin_shop'] = $row['admin_shop'];
          $_SESSION['admin_detail'] = $row['admin_detail'];
          $_SESSION['admin_username'] = $row['admin_username'];
          $_SESSION['admin_fullname'] = $row['admin_fullname'];
          $_SESSION['admin_email'] = $row['admin_email'];
          $_SESSION['admin_bank_name'] = $row['admin_bank_name'];
          $_SESSION['admin_address'] = $row['admin_address'];
          $_SESSION['admin_tel'] = $row['admin_tel'];
          $_SESSION['admin_account_number'] = $row['admin_account_number'];

          // Redirect with success message using SweetAlert
          echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'เข้าสู่ระบบสำเร็จ',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.href = 'index.php';
            });
          </script>";
          exit();
        }
      }

      // Display error message and redirect back using SweetAlert
      $error_message = "ชื่อผู้ใช้หรือรหัสผ่านผู้ขายไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'เข้าสู่ระบบไม่สำเร็จ',
          text: '$error_message'
        }).then(() => {
          window.location.href = 'login.php';
        });
      </script>";
      exit();
    }
    ?>
    <?php include('includes/footer.php'); ?>