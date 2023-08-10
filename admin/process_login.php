<?php
include('../config.php');

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

      // Redirect to index.php
      header("Location: index.php");
      exit();
    }
  }

  // Display error message and redirect back
  $error_message = "ชื่อผู้ใช้หรือรหัสผ่านผู้ขายไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
  header("Location: login.php?error_message=" . urlencode($error_message));
  exit();
}
