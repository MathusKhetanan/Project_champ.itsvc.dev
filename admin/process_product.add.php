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
    $admin_id = 13;
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $brand_id = $conn->real_escape_string($_POST['brand_id']);
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_price = $conn->real_escape_string($_POST['product_price']);
    $product_qty = $conn->real_escape_string($_POST['product_qty']);
    $product_detail = $conn->real_escape_string($_POST['product_detail']);
    $product_use = $conn->real_escape_string($_POST['product_use']);
    
    // ดึงข้อมูลของแอดมินที่เข้าสู่ระบบ
    $query = "SELECT admin_shop FROM admin WHERE admin_id = $admin_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $admin_shop = $row['admin_shop'];

        $sql = "INSERT INTO product(admin_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_use) VALUE($admin_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, $product_use)";

        // ตรวจสอบการอัพโหลดรูปภาพ
        if (file_exists($_FILES['product_image']['tmp_name']) || is_uploaded_file($_FILES['product_image']['tmp_name'])) {
            $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
            $pathImage = "uploads" . md5(time()) . "." . $extension;
            
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], "../" . $pathImage)) {
                $sql = "INSERT INTO product(admin_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_image, product_use, admin_shop) VALUE($admin_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, '$pathImage', $product_use, '$admin_shop')";
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
    } else {
        echo "<script>
            Swal.fire({
                title: 'ไม่พบข้อมูลแอดมิน',
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
