<!DOCTYPE html>
<html lang="en">
<head>
    <!-- เรียกใช้ไฟล์ SweetAlert ผ่าน CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</head>
<body>
  <?php 
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = $_SESSION['seller_id'];
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $brand_id = $conn->real_escape_string($_POST['brand_id']);
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_price = $conn->real_escape_string($_POST['product_price']);
    $product_qty = $conn->real_escape_string($_POST['product_qty']);
    $product_detail = $conn->real_escape_string($_POST['product_detail']);
    $product_use = $conn->real_escape_string($_POST['product_use']);

    $sql = "INSERT INTO product(seller_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_use) VALUE($seller_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, $product_use)";

    if (file_exists($_FILES['product_image']['tmp_name']) || is_uploaded_file($_FILES['product_image']['tmp_name'])) {
        $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $pathImage = "uploads" . md5(time()) . "." . $extension;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], "../" . $pathImage)) {
            $sql = "INSERT INTO product(seller_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_image, product_use) VALUE($seller_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, '$pathImage', $product_use)";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'อัพโหลดรูปภาพสินค้าไม่สำเร็จ',
                    icon: 'error'
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
                title: 'เพิ่มข้อมูลสินค้าสำเร็จ',
                icon: 'success'
            }).then(() => {
                window.location.href = 'product.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'เพิ่มข้อมูลสินค้าไม่สำเร็จ',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
}
?>
</body>
</html>