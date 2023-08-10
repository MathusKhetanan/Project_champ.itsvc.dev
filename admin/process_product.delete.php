<?php
include('../config.php');

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete") {
  try {
    $product_id = $conn->real_escape_string($_GET['id']);
    
    $sql = "DELETE FROM product WHERE product_id = " . $product_id;
    if ($conn->query($sql)) {
      $successMessage = "ลบข้อมูลสินค้าสำเร็จ";
    } else {
      $errorMessage = "ลบข้อมูลสินค้าไม่สำเร็จ";
    }
  } catch (\Throwable $th) {
    $errorMessage = "ลบข้อมูลสินค้าไม่สำเร็จ";
  }
}
?>

<!-- ... ส่วนอื่น ๆ ในหน้า HTML ... -->

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  <?php if (isset($successMessage)) { ?>
    Swal.fire({
      title: '<?= $successMessage ?>',
      icon: 'success',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'ตกลง'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'product.php';
      }
    });
  <?php } elseif (isset($errorMessage)) { ?>
    Swal.fire({
      title: '<?= $errorMessage ?>',
      icon: 'error',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'ตกลง'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'product.php';
      }
    });
  <?php } ?>
});
</script>
