<?php
session_start();
session_unset();
session_destroy();

$successMessage = "ออกจากระบบสำเร็จ";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- โค้ดส่วนหัวของหน้า HTML ตามปกติ -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.21/dist/sweetalert2.min.js"></script>
</head>
<body>

<!-- โค้ดส่วนเนื้อหาของหน้า HTML ตามปกติ -->

<script>
document.addEventListener("DOMContentLoaded", function() {
  Swal.fire({
    title: '<?= $successMessage ?>',
    icon: 'success',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'index.php';
    }
  });
});
</script>

<!-- ... ส่วนอื่น ๆ ในหน้า HTML ... -->

</body>
</html>
