<?php
include('../config.php');
include('includes/header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
  $change_status = $conn->real_escape_string($_POST['change_status']);
  $sql = "UPDATE product SET product_status = IF(product_status = 1, 0, 1) WHERE product_id = " . $change_status;
  if ($conn->query($sql)) {
    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'ปรับสถานะสินค้าสำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'product.php';
        });
      </script>";
  } else {
    echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'ปรับสถานะสินค้าไม่สำเร็จ',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = 'product.php';
        });
      </script>";
  }
  exit();
}
?>
<?php include('includes/footer.php'); ?>