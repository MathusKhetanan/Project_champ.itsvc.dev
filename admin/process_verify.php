<?php
include('../config.php');
include('includes/header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $admin_username =  $conn->real_escape_string($_POST['admin_username']);
    $admin_password =  $conn->real_escape_string($_POST['admin_password']);
    $admin_shop =  $conn->real_escape_string($_POST['admin_shop']);
    $admin_detail =  $conn->real_escape_string($_POST['admin_detail']);
    $admin_address =  $conn->real_escape_string($_POST['admin_address']);
    $admin_tel =  $conn->real_escape_string($_POST['admin_tel']);

    // admin_image admin_payment
    $sql = "UPDATE admin SET admin_shop = '$admin_shop', admin_detail = '$admin_detail', admin_username = '$admin_username', admin_password = MD5('$admin_password'), admin_address = '$admin_address', admin_tel = '$admin_tel', admin_status = 1, token = NULL WHERE admin_id = (SELECT admin_id FROM admin WHERE token = '" . $_GET['token'] . "')";
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