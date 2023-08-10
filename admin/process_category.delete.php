<?php 
include('../config.php');

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete") {
  $category_id = $conn->real_escape_string($_GET['id']);
  $sql = "DELETE FROM categories WHERE category_id = ".$category_id;
  if ($conn->query($sql)) {
    $successMessage = "ลบข้อมูลประเภทสินค้าสำเร็จ";
  } else {
    $errorMessage = "ลบข้อมูลประเภทสินค้าไม่สำเร็จ";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- โค้ดส่วนหัวของหน้า HTML ตามปกติ -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js"></script>
</head>
<body>

<!-- โค้ดส่วนเนื้อหาของหน้า HTML ตามปกติ -->

<!-- ... ส่วนอื่น ๆ ในหน้า HTML ... -->

<?php include('includes/footer.php'); ?>

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
        window.location.href = 'categories.php';
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
        window.location.href = 'categories.php';
      }
    });
  <?php } ?>
});
</script>
</body>
</html>
