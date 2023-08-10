<?php
include('../config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $seller_username = $_POST['seller_username'];
  $seller_password = $_POST['seller_password'];

  // Prepare and execute the query
  $stmt = $conn->prepare("SELECT * FROM seller WHERE seller_username = ?");
  $stmt->bind_param("s", $seller_username);
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $stored_password = $row['seller_password'];

    // Verify the password
    if (password_verify($seller_password, $stored_password)) {
      // Start the session
      session_start();
      $_SESSION['seller_id'] = $row['seller_id'];
      $_SESSION['seller_shop'] = $row['seller_shop'];
      $_SESSION['seller_detail'] = $row['seller_detail'];
      $_SESSION['seller_username'] = $row['seller_username'];
      $_SESSION['seller_fullname'] = $row['seller_fullname'];
      $_SESSION['seller_email'] = $row['seller_email'];
      $_SESSION['seller_bank_name'] = $row['seller_bank_name'];
      $_SESSION['seller_address'] = $row['seller_address'];
      $_SESSION['seller_tel'] = $row['seller_tel'];
      $_SESSION['seller_account_number'] = $row['seller_account_number'];

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