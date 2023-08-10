<?php
include('../config.php');
include('includes/header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $seller_username =  $conn->real_escape_string($_POST['seller_username']);
    $seller_password =  $conn->real_escape_string($_POST['seller_password']);
    $seller_shop =  $conn->real_escape_string($_POST['seller_shop']);
    $seller_detail =  $conn->real_escape_string($_POST['seller_detail']);
    $seller_address =  $conn->real_escape_string($_POST['seller_address']);
    $seller_tel =  $conn->real_escape_string($_POST['seller_tel']);

    // seller_image seller_payment
    $sql = "UPDATE seller SET seller_shop = '$seller_shop', seller_detail = '$seller_detail', seller_username = '$seller_username', seller_password = MD5('$seller_password'), seller_address = '$seller_address', seller_tel = '$seller_tel', seller_status = 1, token = NULL WHERE seller_id = (SELECT seller_id FROM seller WHERE token = '" . $_GET['token'] . "')";
    if ($conn->query($sql)) {
      echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลผู้ขายสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.href = 'login.php';
          });
        </script>";
    }
  } catch (\Throwable $th) {
    echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'อาจมีชื่อบัญชีนี้ในระบบแล้ว บันทึกข้อมูลไม่สำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.history.back();
        });
      </script>";
  }
}
?>
<?php include('includes/footer.php'); ?>