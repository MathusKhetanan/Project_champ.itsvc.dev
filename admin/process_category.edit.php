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
    try {
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $category_name = $conn->real_escape_string($_POST['category_name']);

        $sql = "UPDATE categories SET category_name = '$category_name' WHERE category_id = ".$category_id;
        if($conn->query($sql)){
            echo "<script>
                Swal.fire({
                    title: 'แก้ไขข้อมูลสำเร็จ',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'categories.php';
                });
            </script>";
        }
    } catch (\Throwable $th) {
        echo "<script>
            Swal.fire({
                title: 'แก้ไขข้อมูลไม่สำเร็จ',
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