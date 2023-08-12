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

if(!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "delete"){
    $category_id = $conn->real_escape_string($_GET['id']);
    $sql = "DELETE FROM categories WHERE category_id = ".$category_id;
    if($conn->query($sql)){
        echo "<script>
            Swal.fire({
                title: 'ลบข้อมูลสำเร็จ',
                icon: 'success'
            }).then(() => {
                window.location.href = 'categories.php';
            });
        </script>";
    }else{
        echo "<script>
            Swal.fire({
                title: 'ลบข้อมูลไม่สำเร็จ',
                icon: 'error'
            }).then(() => {
                window.location.href = 'categories.php';
            });
        </script>";
    }
    exit();
}
?>
</body>
</html>