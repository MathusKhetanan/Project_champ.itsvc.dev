<?php
include('../config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $category_name = $conn->real_escape_string($_POST['category_name']);

    $sql = "UPDATE categories SET category_name = '$category_name' WHERE category_id = " . $category_id;
    if ($conn->query($sql)) {
      echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'แก้ไขข้อมูลประเภทสินค้าสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.href = 'categories.php';
          });
      </script>";
      exit();
    }
  } catch (\Throwable $th) {
    echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'แก้ไขข้อมูลประเภทสินค้าไม่สำเร็จ',
          text: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
        }).then(() => {
          window.history.back();
        });
    </script>";
    exit();
  }
}
?>
<?php include('includes/footer.php'); ?>