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
    $category_id = $conn->real_escape_string($_POST['category_id']);
    $category_name = $conn->real_escape_string($_POST['category_name']);

    $sql = "INSERT INTO categories(category_name) VALUE('$category_name')";
    if($conn->query($sql)){
        echo "<script>
            Swal.fire({
                title: 'เพิ่มข้อมูลสำเร็จ',
                icon: 'success'
            }).then(() => {
                window.location.href = 'categories.php';
            });
        </script>";
    }else{
        echo "<script>
            Swal.fire({
                title: 'เพิ่มข้อมูลไม่สำเร็จ',
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