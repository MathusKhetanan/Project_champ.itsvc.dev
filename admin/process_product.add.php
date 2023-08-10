<?php 
include('../config.php');
include('includes/header.php');

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
        $pathImage = "images/" . md5(time()) . "." . $extension;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], "../" . $pathImage)) {
            $sql = "INSERT INTO product(seller_id, category_id, brand_id, product_name, product_detail, product_price, product_qty, product_image, product_use) VALUE($seller_id, $category_id, $brand_id, '$product_name', '$product_detail', $product_price, $product_qty, '$pathImage', $product_use)";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'อัพโหลดรูปภาพสินค้าไม่สำเร็จ',
                    text: 'กรุณาลองใหม่อีกครั้ง'
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
                title: 'เพิ่มข้อมูลสินค้าสำเร็จ',
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
                title: 'เพิ่มข้อมูลสินค้าไม่สำเร็จ',
                text: 'กรุณาลองใหม่อีกครั้ง'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
}
?>
<?php include('includes/footer.php'); ?>