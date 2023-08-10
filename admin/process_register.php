<?php
  include('../config.php');
  include('includes/header.php');
  try {
    $seller_fullname = $conn->real_escape_string($_POST['seller_fullname']);
    $seller_email = $conn->real_escape_string($_POST['seller_email']);
    $seller_username = $conn->real_escape_string($_POST['seller_username']);
    $seller_password = $conn->real_escape_string($_POST['seller_password']);
    $token = md5(rand() . time());

    // INSERT YOUR CODE HERE - Replace this line with your own password hashing logic
    $hashed_password = password_hash($seller_password, PASSWORD_DEFAULT);

    // INSERT YOUR CODE HERE - Replace this line with your own SQL query to insert data into the database
    $sql = "INSERT INTO seller (seller_fullname, seller_email, seller_username, seller_password, token) VALUES ('$seller_fullname', '$seller_email', '$seller_username', '$hashed_password', '$token')";

    if ($conn->query($sql)) {
      echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'บันทึกข้อมูลการสมัครสำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'login.php';
        });
      </script>";
    } else {
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'บันทึกข้อมูลการสมัครไม่สำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.history.back();
        });
      </script>";
    }
  } catch (Exception $e) {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด: ' + " . json_encode($e->getMessage()) . ",
        showConfirmButton: false,
        timer: 1500
      }).then(() => {
        window.history.back();
      });
    </script>";
  }
  ?>
  <?php include('includes/footer.php'); ?>