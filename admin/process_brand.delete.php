<?php
include('../config.php');
include('includes/header.php');
if (!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete") {
  try {
    $brand_id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM brands WHERE brand_id = " . $brand_id;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $brand_image = $row['brand_image'];

      if ($brand_image != "" && file_exists("../" . $brand_image) && !unlink("../" . $brand_image)) {
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'ลบรูปแบรนด์ไม่สำเร็จ',
            text: 'กรุณาลองใหม่อีกครั้ง'
          }).then(() => {
            window.location.href = 'brands.php';
          });
        </script>";
        exit();
      }

      $delete_sql = "DELETE FROM brands WHERE brand_id = " . $brand_id;
      if ($conn->query($delete_sql)) {
        echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'ลบข้อมูลแบรนด์สำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.href = 'brands.php';
          });
        </script>";
      } else {
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'ลบข้อมูลแบรนด์ไม่สำเร็จ',
            text: 'กรุณาลองใหม่อีกครั้ง'
          }).then(() => {
            window.location.href = 'brands.php';
          });
        </script>";
      }
    } else {
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบแบรนด์ที่ต้องการลบ',
          text: 'กรุณาลองใหม่อีกครั้ง'
        }).then(() => {
          window.location.href = 'brands.php';
        });
      </script>";
    }
  } catch (\Throwable $th) {
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'ลบข้อมูลแบรนด์ไม่สำเร็จ',
        text: '" . $th->getMessage() . "'
      }).then(() => {
        window.location.href = 'brands.php';
      });
    </script>";
  }
}
?>
<?php include('includes/footer.php'); ?>