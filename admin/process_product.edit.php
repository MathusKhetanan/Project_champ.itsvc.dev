<?php
include('../config.php');
include('includes/header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = $conn->real_escape_string($_POST['product_id']);
  $category_id = $conn->real_escape_string($_POST['category_id']);
  $brand_id = $conn->real_escape_string($_POST['brand_id']);
  $product_name = $conn->real_escape_string($_POST['product_name']);
  $product_price = $conn->real_escape_string($_POST['product_price']);
  $product_qty = $conn->real_escape_string($_POST['product_qty']);
  $product_detail = $conn->real_escape_string($_POST['product_detail']);
  $product_use = $conn->real_escape_string($_POST['product_use']);

  $sql = "UPDATE product SET category_id = $category_id, brand_id = $brand_id, product_name = '$product_name', product_detail = '$product_detail', product_price = $product_price, product_qty = $product_qty, product_use = $product_use WHERE product_id = " . $product_id;
  if (file_exists($_FILES['product_image']['tmp_name']) || is_uploaded_file($_FILES['product_image']['tmp_name'])) {
    $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
    $pathImage = "images/" . md5(time()) . "." . $extension;
    if (move_uploaded_file($_FILES['product_image']['tmp_name'], "../" . $pathImage)) {
      $sql = "UPDATE product SET category_id = $category_id, brand_id = $brand_id, product_name = '$product_name', product_detail = '$product_detail', product_price = $product_price, product_qty = $product_qty, product_image = '$pathImage', product_use = $product_use WHERE product_id = " . $product_id;
    } else {
      echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'อัพโหลดรูปภาพสินค้าไม่สำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.history.back();
          });
        </script>";
      exit();
    }
  }
  if ($conn->query($sql)) {
    echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'แก้ไขข้อมูลสินค้าสำเร็จ',
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
          title: 'แก้ไขข้อมูลสินค้าไม่สำเร็จ',
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